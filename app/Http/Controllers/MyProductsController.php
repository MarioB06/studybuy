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
     * Process automatic payout to seller via Stripe Connect OR add to wallet
     */
    private function processAutomaticPayout(Product $product)
    {
        $seller = $product->user;
        $totalAmount = $product->price;

        // Calculate platform fee (Stripe Connect fee is lower)
        $platformFeePercentage = env('PLATFORM_FEE_PERCENTAGE', 7); // 7% for Stripe
        $platformFee = $totalAmount * ($platformFeePercentage / 100);
        $sellerAmount = $totalAmount - $platformFee;

        // Check if seller has Stripe Connect enabled
        if ($seller->stripe_connect_enabled && $seller->stripe_connect_id) {
            // OPTION 1: Pay directly via Stripe Connect
            try {
                Stripe::setApiKey(env('STRIPE_SECRET'));

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

                \Log::info("Automatic Stripe payout successful for product {$product->id}. Transfer ID: {$transfer->id}, Amount: CHF {$sellerAmount}");

            } catch (\Exception $e) {
                \Log::error("Stripe payout failed for product {$product->id}: " . $e->getMessage());
                // Fallback to wallet if Stripe fails
                $this->addToWallet($seller, $sellerAmount, $product);
            }
        } else {
            // OPTION 2: Add to user's wallet
            $this->addToWallet($seller, $sellerAmount, $product);
        }
    }

    /**
     * Add sale amount to seller's wallet
     */
    private function addToWallet($seller, float $amount, Product $product)
    {
        try {
            $wallet = $seller->wallet()->firstOrCreate(
                ['user_id' => $seller->id],
                ['balance' => 0, 'currency' => 'CHF']
            );

            $wallet->credit(
                $amount,
                "Verkauf: {$product->title}",
                'Product',
                $product->id
            );

            \Log::info("Amount CHF {$amount} added to wallet for seller {$seller->id} (Product {$product->id})");

        } catch (\Exception $e) {
            \Log::error("Failed to add amount to wallet for seller {$seller->id}: " . $e->getMessage());
        }
    }
}
