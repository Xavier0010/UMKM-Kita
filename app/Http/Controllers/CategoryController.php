<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function show($slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();
        $categories = Category::all();
        
        $products = Product::with(['store', 'category'])
            ->where('category_id', $category->id)
            ->active()
            ->inStock()
            ->latest()
            ->paginate(12);

        return view('categories.show', compact('category', 'categories', 'products'));
    }
}
