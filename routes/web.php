<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }

    $categories = App\Models\ProductCategory::inRandomOrder()->take(4)->get();
    $products = App\Models\Product::with(['mainImage', 'category', 'school'])
        ->where('is_active', true)
        ->latest()
        ->take(8)
        ->get();

    return view('welcome', compact('categories', 'products'));
});

Route::get('/dashboard', function () {
    $categories = App\Models\ProductCategory::inRandomOrder()->take(4)->get();
    $products = App\Models\Product::with(['mainImage', 'category', 'school'])
        ->where('is_active', true)
        ->latest()
        ->take(8)
        ->get();

    return view('dashboard', compact('categories', 'products'));
})->middleware(['auth', 'verified'])->name('dashboard');

// Public Product Routes (no login required)
Route::get('/products', [App\Http\Controllers\ProductController::class, 'index'])->name('products.index');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Protected Product Routes (login required)
    Route::get('/products/create', [App\Http\Controllers\ProductController::class, 'create'])->name('products.create');
    Route::post('/products', [App\Http\Controllers\ProductController::class, 'store'])->name('products.store');
    Route::get('/products/{product}/edit', [App\Http\Controllers\ProductController::class, 'edit'])->name('products.edit');
    Route::patch('/products/{product}', [App\Http\Controllers\ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{product}', [App\Http\Controllers\ProductController::class, 'destroy'])->name('products.destroy');
});

// Public Product Show Route (must be after /products/create to avoid route collision)
Route::get('/products/{product}', [App\Http\Controllers\ProductController::class, 'show'])->name('products.show');

// Product Forum Messages (auth required to post)
Route::post('/products/{product}/forum', [App\Http\Controllers\ProductController::class, 'storeForumMessage'])
    ->middleware('auth')
    ->name('products.forum.store');

// Stripe Checkout Routes (auth required)
Route::middleware('auth')->group(function () {
    Route::post('/products/{product}/checkout', [App\Http\Controllers\ProductController::class, 'createCheckoutSession'])
        ->name('products.checkout.create');
    Route::get('/products/{product}/checkout/success', [App\Http\Controllers\ProductController::class, 'checkoutSuccess'])
        ->name('products.checkout.success');
    Route::get('/products/{product}/checkout/cancel', [App\Http\Controllers\ProductController::class, 'checkoutCancel'])
        ->name('products.checkout.cancel');
});

// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
    Route::resource('categories', App\Http\Controllers\Admin\CategoryController::class);
    Route::resource('schools', App\Http\Controllers\Admin\SchoolController::class);
    Route::get('/email-logs', [App\Http\Controllers\Admin\EmailLogController::class, 'index'])->name('email-logs.index');
    Route::delete('/email-logs/clear', [App\Http\Controllers\Admin\EmailLogController::class, 'clear'])->name('email-logs.clear');
});

require __DIR__.'/auth.php';
