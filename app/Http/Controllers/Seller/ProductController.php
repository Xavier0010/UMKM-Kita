<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $store = Auth::user()->store;
        $query = $store->products()->latest();

        if ($request->search) {
            $query->where('name', 'like', "%{$request->search}%");
        }

        $products = $query->paginate(10);
        return view('seller.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('seller.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $store = Auth::user()->store;

        $request->validate([
            'name'        => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|string',
            'price'       => 'required|numeric|min:0',
            'stock'       => 'required|integer|min:0',
            'is_active'   => 'boolean',
            'main_image'  => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'gallery.*'   => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $mainImagePath = $request->file('main_image')->store('products/main', 'public');

        $galleryPaths = [];
        if ($request->hasFile('gallery')) {
            foreach ($request->file('gallery') as $image) {
                $galleryPaths[] = $image->store('products/gallery', 'public');
            }
        }

        $product = Product::create([
            'store_id'    => $store->id,
            'category_id' => $request->category_id,
            'name'        => $request->name,
            'slug'        => Str::slug($request->name) . '-' . Str::random(5),
            'description' => $request->description,
            'price'       => $request->price,
            'stock'       => $request->stock,
            'is_active'   => $request->boolean('is_active', true),
            'main_image'  => $mainImagePath,
            'gallery'     => json_encode($galleryPaths),
        ]);

        return redirect()->route('seller.products.index')->with('success', 'Produk berhasil ditambahkan!');
    }

    public function edit(Product $product)
    {
        if ($product->store_id !== Auth::user()->store->id) {
            abort(403);
        }

        $categories = Category::all();
        return view('seller.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        if ($product->store_id !== Auth::user()->store->id) {
            abort(403);
        }

        $request->validate([
            'name'        => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|string',
            'price'       => 'required|numeric|min:0',
            'stock'       => 'required|integer|min:0',
            'is_active'   => 'boolean',
            'main_image'  => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'gallery.*'   => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $mainImagePath = $product->main_image;
        if ($request->hasFile('main_image')) {
            if ($mainImagePath) Storage::disk('public')->delete($mainImagePath);
            $mainImagePath = $request->file('main_image')->store('products/main', 'public');
        }

        $galleryPaths = json_decode($product->gallery, true) ?? [];
        if ($request->hasFile('gallery')) {
            // Delete old gallery
            foreach ($galleryPaths as $oldImage) {
                Storage::disk('public')->delete($oldImage);
            }
            $galleryPaths = [];
            foreach ($request->file('gallery') as $image) {
                $galleryPaths[] = $image->store('products/gallery', 'public');
            }
        }

        $product->update([
            'category_id' => $request->category_id,
            'name'        => $request->name,
            'slug'        => Str::slug($request->name) . '-' . Str::random(5),
            'description' => $request->description,
            'price'       => $request->price,
            'stock'       => $request->stock,
            'is_active'   => $request->boolean('is_active', false),
            'main_image'  => $mainImagePath,
            'gallery'     => json_encode($galleryPaths),
        ]);

        return redirect()->route('seller.products.index')->with('success', 'Produk berhasil diperbarui!');
    }

    public function destroy(Product $product)
    {
        if ($product->store_id !== Auth::user()->store->id) {
            abort(403);
        }

        if ($product->main_image) Storage::disk('public')->delete($product->main_image);
        $galleryPaths = json_decode($product->gallery, true) ?? [];
        foreach ($galleryPaths as $oldImage) {
            Storage::disk('public')->delete($oldImage);
        }

        $product->delete();

        return redirect()->route('seller.products.index')->with('success', 'Produk berhasil dihapus!');
    }
}
