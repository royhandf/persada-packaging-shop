<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Http\Request;

class ProductVariantController extends Controller
{
    public function store(Request $request, Product $product)
    {
        $validated = $request->validate([
            'sku' => 'nullable|string|max:100|unique:product_variants,sku',
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'moq' => 'required|integer|min:1',
            'weight_in_grams' => 'nullable|integer|min:0',
            'length_in_cm' => 'nullable|integer|min:0',
            'width_in_cm' => 'nullable|integer|min:0',
            'height_in_cm' => 'nullable|integer|min:0',
        ]);

        $product->variants()->create($validated);

        return redirect()->route('master.products.detail', $product->id)
            ->with('success', 'Varian produk berhasil ditambahkan.');
    }

    public function update(Request $request, Product $product, ProductVariant $variant)
    {
        $validated = $request->validate([
            'sku' => 'nullable|string|max:100|unique:product_variants,sku,' . $variant->id,
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'moq' => 'required|integer|min:1',
            'weight_in_grams' => 'required|integer|min:0',
            'length_in_cm' => 'nullable|integer|min:0',
            'width_in_cm' => 'nullable|integer|min:0',
            'height_in_cm' => 'nullable|integer|min:0',
        ]);

        $variant->update($validated);

        return redirect()->route('master.products.detail', $product->id)
            ->with('success', 'Varian produk berhasil diperbarui.');
    }

    public function destroy(Product $product, ProductVariant $variant)
    {
        $variant->delete();

        return redirect()->route('master.products.detail', $product->id)
            ->with('success', 'Varian produk berhasil dihapus.');
    }
}
