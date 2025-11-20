<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function index(): View
    {
        $categories = ProductCategory::withCount('products')->get();
        return view('admin.categories.index', compact('categories'));
    }

    public function create(): View
    {
        return view('admin.categories.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:product_categories',
            'icon' => 'nullable|string|max:255',
        ]);

        ProductCategory::create($validated);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Kategorie erfolgreich erstellt!');
    }

    public function edit(ProductCategory $category): View
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, ProductCategory $category): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:product_categories,name,' . $category->id,
            'icon' => 'nullable|string|max:255',
        ]);

        $category->update($validated);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Kategorie erfolgreich aktualisiert!');
    }

    public function destroy(ProductCategory $category): RedirectResponse
    {
        if ($category->products()->count() > 0) {
            return redirect()->route('admin.categories.index')
                ->with('error', 'Kategorie kann nicht gelöscht werden, da sie noch Produkte enthält.');
        }

        $category->delete();

        return redirect()->route('admin.categories.index')
            ->with('success', 'Kategorie erfolgreich gelöscht!');
    }
}
