<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Chat;
use Illuminate\Http\Request;

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
            }
        }

        return redirect()->back()->with('success', 'Status aktualisiert');
    }
}
