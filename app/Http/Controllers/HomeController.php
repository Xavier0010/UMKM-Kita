<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Store;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        $latestProducts = Product::with(['store', 'category'])
            ->active()
            ->inStock()
            ->latest()
            ->take(8)
            ->get();
            
        $popularStores = Store::where('status', 'approved')
            ->withCount('products')
            ->orderBy('products_count', 'desc')
            ->take(4)
            ->get();

        return view('home', compact('categories', 'latestProducts', 'popularStores'));
    }
}
