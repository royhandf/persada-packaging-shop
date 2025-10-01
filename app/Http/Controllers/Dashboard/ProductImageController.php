<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

class ProductImageController extends Controller
{
    public function store(Request $request, Product $product)
    {
        $validated = $request->validate([
            'image'      => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'is_primary' => 'nullable|boolean',
        ]);

        $path = $validated['image']->store('products', 'public');

        if ($validated['is_primary'] ?? false) {
            $product->images()->update(['is_primary' => false]);
        }

        $product->images()->create([
            'image_path' => $path,
            'is_primary' => $validated['is_primary'] ?? false,
        ]);

        return redirect()->route('master.products.detail', $product->id)
            ->with('success', 'Gambar produk berhasil ditambahkan.');
    }

    public function destroy(Product $product, ProductImage $image)
    {
        Storage::disk('public')->delete($image->image_path);
        $image->delete();

        return redirect()->route('master.products.detail', $product->id)
            ->with('success', 'Gambar produk berhasil dihapus.');
    }
}
