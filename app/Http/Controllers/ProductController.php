<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::with(['category', 'variants', 'images'])
            ->latest()
            ->paginate(10);
        $categories = Category::all();
        return view('pages.dashboard.product', compact('products', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255|unique:products,name',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string',
            'status'      => 'required|in:active,inactive',
        ]);

        $validated['slug'] = Str::slug($validated['name']);

        Product::create($validated);

        return redirect()->route('master.products.index')->with('success', 'Produk berhasil ditambahkan.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name'        => [
                'required',
                'string',
                'max:255',
                Rule::unique('products', 'name')->ignore($product->id),
            ],
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string',
            'status'      => 'required|in:active,inactive',
        ]);

        $validated['slug'] = Str::slug($validated['name']);

        $product->update($validated);

        return redirect()->route('master.products.index')->with('success', 'Produk berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('master.products.index')->with('success', 'Produk berhasil dihapus.');
    }

    public function detail(Product $product)
    {
        $product->load(['variants', 'images', 'category']);
        return view('pages.dashboard.product-detail', compact('product'));
    }
}
