<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductImage;
use App\Models\School;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        $product->load(['mainImage', 'images', 'category', 'school', 'user']);

        return view('products.show', compact('product'));
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
}
