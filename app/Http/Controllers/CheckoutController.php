<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function index()
    {
        $carts = Auth::user()->carts()->with('product.store')->get();

        if ($carts->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang Anda kosong.');
        }

        $cartsByStore = $carts->groupBy(function ($cart) {
            return $cart->product->store_id;
        });

        return view('checkout.index', compact('cartsByStore'));
    }

    public function process(Request $request)
    {
        $carts = Auth::user()->carts()->with('product.store')->get();

        if ($carts->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang Anda kosong.');
        }

        $request->validate([
            'shipping_name'    => 'required|string|max:255',
            'shipping_phone'   => 'required|string|max:20',
            'shipping_address' => 'required|string',
            'payment_method'   => 'required|in:qris,whatsapp',
            'payment_proof'    => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'notes'            => 'nullable|string',
        ]);

        $paymentProofPath = null;
        if ($request->hasFile('payment_proof')) {
            $paymentProofPath = $request->file('payment_proof')->store('payments', 'public');
        } elseif ($request->payment_method === 'qris') {
            return back()->with('error', 'Bukti pembayaran wajib diunggah untuk metode QRIS.');
        }

        $cartsByStore = $carts->groupBy(function ($cart) {
            return $cart->product->store_id;
        });

        DB::beginTransaction();

        try {
            $orderNumbers = [];

            foreach ($cartsByStore as $storeId => $storeCarts) {
                // Check stock
                foreach ($storeCarts as $cart) {
                    if ($cart->quantity > $cart->product->stock) {
                        throw new \Exception("Stok tidak mencukupi untuk {$cart->product->name}");
                    }
                }

                $storeTotal = $storeCarts->sum(fn($c) => $c->subtotal);
                $orderNumber = 'ORD-' . strtoupper(Str::random(10));

                $order = Order::create([
                    'user_id'          => Auth::id(),
                    'store_id'         => $storeId,
                    'order_number'     => $orderNumber,
                    'status'           => 'pending',
                    'payment_method'   => $request->payment_method,
                    'payment_proof'    => $paymentProofPath,
                    'total_amount'     => $storeTotal,
                    'shipping_name'    => $request->shipping_name,
                    'shipping_phone'   => $request->shipping_phone,
                    'shipping_address' => $request->shipping_address,
                    'notes'            => $request->notes,
                ]);

                foreach ($storeCarts as $cart) {
                    OrderItem::create([
                        'order_id'      => $order->id,
                        'product_id'    => $cart->product_id,
                        'product_name'  => $cart->product->name,
                        'product_price' => $cart->product->price,
                        'quantity'      => $cart->quantity,
                        'subtotal'      => $cart->subtotal,
                    ]);

                    // Reduce stock
                    $cart->product->decrement('stock', $cart->quantity);
                }

                $orderNumbers[] = $orderNumber;
            }

            // Clear cart
            Auth::user()->carts()->delete();

            DB::commit();

            // Redirect to success page (just taking the first order number to show success, since multiple might be created)
            return redirect()->route('orders.success', $orderNumbers[0]);

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal memproses pesanan: ' . $e->getMessage());
        }
    }
}
