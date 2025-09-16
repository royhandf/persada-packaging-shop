<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\ProductVariant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cartItems = CartItem::where('user_id', Auth::id())
            ->with('productVariant.product.primaryImage')
            ->latest()
            ->get();

        return view('pages.home.cart', compact('cartItems'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_variant_id' => 'required|exists:product_variants,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $variant = ProductVariant::findOrFail($request->product_variant_id);
        $user = Auth::user();

        if ($request->quantity > $variant->stock) {
            return back()->with('error', 'Stok tidak mencukupi.');
        }

        $cartItem = CartItem::where('user_id', $user->id)
            ->where('product_variant_id', $variant->id)
            ->first();

        if ($cartItem) {
            $newQuantity = $cartItem->quantity + $request->quantity;
            if ($newQuantity > $variant->stock) {
                return back()->with('error', 'Jumlah produk di keranjang melebihi stok yang tersedia.');
            }
            $cartItem->quantity = $newQuantity;
            $cartItem->save();
        } else {
            CartItem::create([
                'user_id' => $user->id,
                'product_variant_id' => $variant->id,
                'quantity' => $request->quantity,
                'selected' => true,
            ]);
        }

        return redirect()->route('cart.index')->with('success', 'Produk berhasil ditambahkan ke keranjang.');
    }

    /**
     * Update the specified resource in storage.
     */

    public function update(Request $request, CartItem $cartItem)
    {
        $request->validate([
            'quantity' => 'required|integer|min:' . $cartItem->productVariant->moq,
        ]);

        if ($request->quantity > $cartItem->productVariant->stock) {
            if ($request->expectsJson()) {
                return response()->json(['error' => 'Stok tidak mencukupi.'], 422);
            }
            return back()->with('error', "Stok untuk produk ini hanya tersisa {$cartItem->productVariant->stock}.");
        }

        $cartItem->update(['quantity' => $request->quantity]);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => 'Kuantitas diperbarui.',
                'newTotal' => $cartItem->quantity * $cartItem->productVariant->price
            ]);
        }

        return back()->with('success', 'Kuantitas produk berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CartItem $cartItem)
    {
        $cartItem->delete();
        return back()->with('success', 'Produk berhasil dihapus dari keranjang.');
    }

    public function updateSelection(Request $request)
    {
        $request->validate([
            'selections' => 'required|array',
            'selections.*.id' => 'required|exists:cart_items,id',
            'selections.*.selected' => 'required|boolean',
        ]);

        foreach ($request->selections as $selection) {
            CartItem::where('id', $selection['id'])
                ->where('user_id', Auth::id())
                ->update(['selected' => $selection['selected']]);
        }

        return response()->json(['message' => 'Seleksi berhasil diperbarui.']);
    }
}
