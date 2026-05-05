<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $store = Auth::user()->store;
        $query = $store->orders()->with('user')->latest();

        if ($request->status) {
            $query->where('status', $request->status);
        }

        $orders = $query->paginate(10);
        return view('seller.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        if ($order->store_id !== Auth::user()->store->id) {
            abort(403);
        }

        $order->load(['user', 'items.product']);
        return view('seller.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        if ($order->store_id !== Auth::user()->store->id) {
            abort(403);
        }

        $request->validate([
            'status' => 'required|in:pending,confirmed,processing,shipped,completed,cancelled'
        ]);

        $order->update(['status' => $request->status]);

        return back()->with('success', 'Status pesanan berhasil diperbarui!');
    }
}
