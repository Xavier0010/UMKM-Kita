<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $carts = Auth::user()->carts()
            ->with(['product.store'])
            ->get()
            ->groupBy(function ($cart) {
                return $cart->product->store->name;
            });

        return view('cart.index', compact('carts'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity'   => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($request->product_id);

        if ($request->quantity > $product->stock) {
            return back()->with('error', 'Kuantitas melebihi stok yang tersedia.');
        }

        $cart = Cart::firstOrNew([
            'user_id'    => Auth::id(),
            'product_id' => $request->product_id,
        ]);

        $newQuantity = $cart->exists ? $cart->quantity + $request->quantity : $request->quantity;

        if ($newQuantity > $product->stock) {
            return back()->with('error', 'Kuantitas melebihi stok yang tersedia.');
        }

        $cart->quantity = $newQuantity;
        $cart->save();

        return redirect()->back()->with('success', 'Produk ditambahkan ke keranjang.');
    }

    public function update(Request $request, Cart $cart)
    {
        if ($cart->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        if ($request->quantity > $cart->product->stock) {
            return back()->with('error', 'Kuantitas melebihi stok yang tersedia.');
        }

        $cart->update(['quantity' => $request->quantity]);

        return back()->with('success', 'Keranjang diperbarui.');
    }

    public function destroy(Cart $cart)
    {
        if ($cart->user_id !== Auth::id()) {
            abort(403);
        }

        $cart->delete();

        return back()->with('success', 'Produk dihapus dari keranjang.');
    }
}
