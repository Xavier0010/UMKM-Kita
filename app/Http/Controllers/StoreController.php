<?php

namespace App\Http\Controllers;

use App\Models\Store;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    public function show($slug)
    {
        $store = Store::where('slug', $slug)
            ->where('status', 'approved')
            ->firstOrFail();

        $products = $store->products()
            ->active()
            ->inStock()
            ->latest()
            ->paginate(12);

        return view('stores.show', compact('store', 'products'));
    }
}
