<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $store = Auth::user()->store;
        
        // If they don't have a store yet, redirect to registration
        if (!$store) {
            return redirect()->route('seller.store.register');
        }

        // Stats
        $totalProducts = $store->products()->count();
        $totalOrders = $store->orders()->count();
        $pendingOrders = $store->orders()->where('status', 'pending')->count();
        $totalRevenue = $store->orders()->where('status', 'completed')->sum('total_amount');

        $recentOrders = $store->orders()->with('user')->latest()->take(5)->get();

        return view('seller.dashboard', compact('store', 'totalProducts', 'totalOrders', 'pendingOrders', 'totalRevenue', 'recentOrders'));
    }
}
