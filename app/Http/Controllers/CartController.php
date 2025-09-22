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
        session()->forget('buy_now_cart_item_id');

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
        $validated = $request->validate([
            'product_variant_id' => ['required', 'exists:product_variants,id'],
            'quantity' => ['required', 'integer', 'min:1'],
            'action' => ['required', 'string', 'in:add_to_cart,buy_now'],
        ]);

        $variant = ProductVariant::findOrFail($validated['product_variant_id']);
        $user = $request->user();

        $cartItem = $user->cartItems()
            ->where('product_variant_id', $variant->id)
            ->first();

        $totalQuantity = ($cartItem->quantity ?? 0) + $validated['quantity'];
        if ($totalQuantity > $variant->stock) {
            return back()->with('error', 'Jumlah produk di keranjang melebihi stok yang tersedia.');
        }

        $cartItem = $user->cartItems()->updateOrCreate(
            [
                'product_variant_id' => $variant->id,
            ],
            [
                'quantity' => $totalQuantity,
                'selected' => true,
            ]
        );

        if ($validated['action'] === 'buy_now') {
            session(['buy_now_cart_item_id' => $cartItem->id]);
            return redirect()->route('checkout.index');
        }

        return back()->with('success', 'Produk berhasil ditambahkan ke keranjang!');
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