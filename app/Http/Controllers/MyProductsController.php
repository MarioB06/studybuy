<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Chat;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Transfer;

class MyProductsController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->get('filter', 'all'); // all, purchases, sales
        $userId = auth()->id();

        $query = Product::query();

        if ($filter === 'purchases') {
            // Only purchases
            $query->where('buyer_id', $userId)
                ->with(['user', 'category', 'mainImage']);
        } elseif ($filter === 'sales') {
            // Only sales
            $query->where('user_id', $userId)
                ->with(['buyer', 'category', 'mainImage']);
        } else {
            // Both purchases and sales
            $query->where(function($q) use ($userId) {
                $q->where('buyer_id', $userId)
                  ->orWhere('user_id', $userId);
            })->with(['user', 'buyer', 'category', 'mainImage']);
        }

        $products = $query->orderBy('created_at', 'desc')->paginate(12);

        // Get chats for the products
        $productIds = $products->pluck('id');
        $chats = Chat::whereIn('product_id', $productIds)
            ->where(function($q) use ($userId) {
                $q->where('user1_id', $userId)
                  ->orWhere('user2_id', $userId);
            })
            ->get()
            ->keyBy('product_id');

        return view('my-products.index', compact('products', 'filter', 'chats'));
    }

    public function purchases()
    {
        $purchases = Product::where('buyer_id', auth()->id())
            ->with(['user', 'category', 'mainImage'])
            ->orderBy('sold_at', 'desc')
            ->paginate(12);

        return view('my-products.purchases', compact('purchases'));
    }

    public function sales()
    {
        $sales = Product::where('user_id', auth()->id())
            ->with(['buyer', 'category', 'mainImage'])
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        return view('my-products.sales', compact('sales'));
    }

    public function updateStatus(Product $product, Request $request)
    {
        $userId = auth()->id();

        // Check if user is buyer or seller
        if ($product->buyer_id !== $userId && $product->user_id !== $userId) {
            abort(403, 'Nicht autorisiert');
        }

        $status = $request->input('status');

        if (in_array($status, ['erhalten', 'uebergeben'])) {
            $product->update([$status => true]);

            // Check if both statuses are now true, then mark as abgeschlossen
            $product->refresh();
            if ($product->erhalten && $product->uebergeben) {
                $product->update(['abgeschlossen' => true]);

                // Trigger automatic payout to seller
                $this->processAutomaticPayout($product);
            }
        }

        return redirect()->back()->with('success', 'Status aktualisiert');
    }

    /**
     * Process automatic payout to seller via Stripe Connect
     */
    private function processAutomaticPayout(Product $product)
    {
        $seller = $product->user;

        // Check if seller has Stripe Connect enabled
        if (!$seller->stripe_connect_enabled || !$seller->stripe_connect_id) {
            \Log::warning("Seller {$seller->id} has no Stripe Connect account. Payout for product {$product->id} skipped.");
            return;
        }

        try {
            Stripe::setApiKey(env('STRIPE_SECRET'));

            // Calculate amounts
            $totalAmount = $product->price; // CHF
            $platformFeePercentage = env('PLATFORM_FEE_PERCENTAGE', 10); // Default 10%
            $platformFee = $totalAmount * ($platformFeePercentage / 100);
            $sellerAmount = $totalAmount - $platformFee;

            // Create transfer to seller's Stripe Connect account
            $transfer = Transfer::create([
                'amount' => intval($sellerAmount * 100), // Convert to cents
                'currency' => 'chf',
                'destination' => $seller->stripe_connect_id,
                'description' => "Verkauf: {$product->title} (Produkt ID: {$product->id})",
                'metadata' => [
                    'product_id' => $product->id,
                    'seller_id' => $seller->id,
                    'buyer_id' => $product->buyer_id,
                    'total_amount' => $totalAmount,
                    'platform_fee' => $platformFee,
                    'seller_amount' => $sellerAmount,
                ],
            ]);

            \Log::info("Automatic payout successful for product {$product->id}. Transfer ID: {$transfer->id}, Amount: CHF {$sellerAmount}");

        } catch (\Exception $e) {
            \Log::error("Automatic payout failed for product {$product->id}: " . $e->getMessage());
            // Don't throw exception - just log it. The product is still marked as completed.
        }
    }
}
