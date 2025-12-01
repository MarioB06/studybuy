<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class MyProductsController extends Controller
{
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
}
