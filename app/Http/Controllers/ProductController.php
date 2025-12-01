<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductImage;
use App\Models\School;
use App\Models\ProductCategory;
use App\Models\ProductForumMessage;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Stripe\Stripe;
use Stripe\Checkout\Session as StripeSession;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $categories = ProductCategory::all();
        $schools = School::all();

        // Build query
        $query = Product::with(['mainImage', 'category', 'school'])
            ->where('is_active', true)
            ->whereNull('buyer_id');

        // Search functionality
        if ($request->has('search') && !empty($request->search)) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('title', 'like', '%' . $searchTerm . '%')
                  ->orWhere('description', 'like', '%' . $searchTerm . '%');
            });
        }

        // Filter by categories
        if ($request->has('categories') && !empty($request->categories)) {
            $query->whereIn('product_category_id', $request->categories);
        }

        // Filter by schools
        if ($request->has('schools') && !empty($request->schools)) {
            $query->whereIn('school_id', $request->schools);
        }

        // Sorting
        $sortBy = $request->get('sort', 'latest');
        switch ($sortBy) {
            case 'price_asc':
                $query->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;
            case 'oldest':
                $query->oldest();
                break;
            case 'latest':
            default:
                $query->latest();
                break;
        }

        $products = $query->get();

        return view('products.index', compact('categories', 'schools', 'products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $schools = School::all();
        $categories = ProductCategory::all();

        return view('products.create', compact('schools', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'school_id' => 'required|exists:schools,id',
            'product_category_id' => 'required|exists:product_categories,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'expires_at' => 'nullable|date',
            'images' => 'required|array|min:1|max:5',
            'images.*' => 'image|mimes:jpeg,jpg,png,webp|max:5120', // Max 5MB per image
        ], [
            'images.required' => 'Bitte laden Sie mindestens ein Foto hoch.',
            'images.min' => 'Bitte laden Sie mindestens ein Foto hoch.',
            'images.max' => 'Sie können maximal 5 Fotos hochladen.',
            'images.*.image' => 'Die Datei muss ein Bild sein.',
            'images.*.mimes' => 'Erlaubte Bildformate: JPEG, JPG, PNG, WEBP.',
            'images.*.max' => 'Jedes Bild darf maximal 5MB groß sein.',
        ]);

        $validated['user_id'] = auth()->id();
        $validated['is_active'] = true;

        // Create the product (without images field)
        $productData = collect($validated)->except('images')->toArray();
        $product = Product::create($productData);

        // Handle image uploads
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                // Generate unique filename
                $filename = time() . '_' . $index . '_' . uniqid() . '.' . $image->getClientOriginalExtension();

                // Store in public/storage/products/{product_id}/
                $path = $image->storeAs(
                    'products/' . $product->id,
                    $filename,
                    'public'
                );

                // Create product image record
                ProductImage::create([
                    'product_id' => $product->id,
                    'file_path' => $path,
                    'is_main' => $index === 0, // First image is the main image
                    'sort_order' => $index,
                ]);
            }
        }

        return redirect()->route('dashboard')->with('success', 'Produkt erfolgreich erstellt!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product): View
    {
        $product->load(['mainImage', 'images', 'category', 'school', 'user', 'forumMessages']);

        return view('products.show', compact('product'));
    }

    public function storeForumMessage(Request $request, Product $product): RedirectResponse
    {
        $validated = $request->validate([
            'message' => 'required|string|max:2000',
            'parent_id' => 'nullable|exists:product_forum_messages,id',
        ]);

        $isOfficial = auth()->id() === $product->user_id;

        ProductForumMessage::create([
            'product_id' => $product->id,
            'user_id' => auth()->id(),
            'parent_id' => $validated['parent_id'] ?? null,
            'message' => $validated['message'],
            'is_official' => $isOfficial,
        ]);

        return redirect()->route('products.show', $product)->with('success', 'Nachricht wurde gepostet!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    /**
     * Create Stripe Checkout Session
     */
    public function createCheckoutSession(Product $product): RedirectResponse
    {
        // Check if product is still available
        if (!$product->is_active || $product->buyer_id !== null) {
            return redirect()->route('products.show', $product)
                ->with('error', 'Dieses Produkt ist nicht mehr verfügbar.');
        }

        // Check if user is not buying their own product
        if (auth()->id() === $product->user_id) {
            return redirect()->route('products.show', $product)
                ->with('error', 'Du kannst dein eigenes Produkt nicht kaufen.');
        }

        Stripe::setApiKey(env('STRIPE_SECRET'));

        try {
            $session = StripeSession::create([
                'payment_method_types' => ['card'],
                'line_items' => [[
                    'price_data' => [
                        'currency' => 'chf',
                        'product_data' => [
                            'name' => $product->title,
                            'description' => $product->description ? substr($product->description, 0, 500) : '',
                            'images' => $product->mainImage
                                ? [asset('storage/' . $product->mainImage->file_path)]
                                : [],
                        ],
                        'unit_amount' => intval($product->price * 100), // Convert to cents
                    ],
                    'quantity' => 1,
                ]],
                'mode' => 'payment',
                'success_url' => route('products.checkout.success', ['product' => $product->id]) . '?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => route('products.checkout.cancel', ['product' => $product->id]),
                'metadata' => [
                    'product_id' => $product->id,
                    'buyer_id' => auth()->id(),
                    'seller_id' => $product->user_id,
                ],
            ]);

            return redirect($session->url);
        } catch (\Exception $e) {
            return redirect()->route('products.show', $product)
                ->with('error', 'Fehler beim Erstellen der Checkout-Session: ' . $e->getMessage());
        }
    }

    /**
     * Handle successful payment
     */
    public function checkoutSuccess(Request $request, Product $product): View
    {
        $sessionId = $request->get('session_id');

        if (!$sessionId) {
            abort(404);
        }

        Stripe::setApiKey(env('STRIPE_SECRET'));

        try {
            $session = StripeSession::retrieve($sessionId);

            // Verify payment was successful
            if ($session->payment_status === 'paid') {
                // Mark product as sold and set buyer
                $product->update([
                    'is_active' => false,
                    'buyer_id' => auth()->id(),
                    'sold_at' => now(),
                ]);

                return view('products.checkout-success', compact('product', 'session'));
            }
        } catch (\Exception $e) {
            return view('products.checkout-success', [
                'product' => $product,
                'error' => 'Fehler beim Abrufen der Zahlungsinformationen.'
            ]);
        }

        return view('products.checkout-success', compact('product'));
    }

    /**
     * Handle cancelled payment
     */
    public function checkoutCancel(Product $product): View
    {
        return view('products.checkout-cancel', compact('product'));
    }
}
