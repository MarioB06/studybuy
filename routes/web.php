<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }

    $categories = App\Models\ProductCategory::all();
    $products = App\Models\Product::with(['mainImage', 'category', 'school'])
        ->where('is_active', true)
        ->latest()
        ->take(8)
        ->get();

    return view('welcome', compact('categories', 'products'));
});

Route::get('/dashboard', function () {
    $categories = App\Models\ProductCategory::all();
    $products = App\Models\Product::with(['mainImage', 'category', 'school'])
        ->where('is_active', true)
        ->latest()
        ->take(8)
        ->get();

    return view('dashboard', compact('categories', 'products'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Product Routes
    Route::resource('products', App\Http\Controllers\ProductController::class);
});

// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
    Route::resource('categories', App\Http\Controllers\Admin\CategoryController::class);
    Route::resource('schools', App\Http\Controllers\Admin\SchoolController::class);
});

require __DIR__.'/auth.php';
