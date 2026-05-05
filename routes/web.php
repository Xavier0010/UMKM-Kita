<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/produk', [ProductController::class, 'index'])->name('products.index');
Route::get('/produk/{slug}', [ProductController::class, 'show'])->name('products.show');
Route::get('/toko/{slug}', [StoreController::class, 'show'])->name('stores.show');
Route::get('/kategori/{slug}', [CategoryController::class, 'show'])->name('categories.show');

// Buyer Routes
Route::middleware(['auth', 'role:buyer'])->group(function () {
    Route::get('/keranjang', [CartController::class, 'index'])->name('cart.index');
    Route::post('/keranjang/tambah', [CartController::class, 'add'])->name('cart.add');
    Route::put('/keranjang/{cart}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/keranjang/{cart}', [CartController::class, 'destroy'])->name('cart.destroy');

    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'process'])->name('checkout.process');
    
    Route::get('/pesanan', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/pesanan/{order:order_number}', [OrderController::class, 'show'])->name('orders.show');
    Route::get('/pesanan/sukses/{order:order_number}', [OrderController::class, 'success'])->name('orders.success');
});

// Admin Routes Placeholder
Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/', function () { return view('admin.dashboard', ['title' => 'Admin Dashboard']); })->name('dashboard');
    Route::get('/stores', function () { return view('admin.stores.index', ['title' => 'Kelola Toko']); })->name('stores.index');
    Route::get('/categories', function () { return view('admin.categories.index', ['title' => 'Kelola Kategori']); })->name('categories.index');
    Route::get('/users', function () { return view('admin.users.index', ['title' => 'Kelola Pengguna']); })->name('users.index');
});

// Seller Routes
Route::prefix('penjual')->name('seller.')->middleware(['auth', 'role:seller'])->group(function () {
    Route::get('/daftar-toko', [\App\Http\Controllers\Seller\StoreRegistrationController::class, 'index'])->name('store.register');
    Route::post('/daftar-toko', [\App\Http\Controllers\Seller\StoreRegistrationController::class, 'store'])->name('store.store');
    
    // Protected by store approval check (middleware can be added later, for now we handle in controllers if needed, but dashboard shows pending status)
    Route::get('/', [\App\Http\Controllers\Seller\DashboardController::class, 'index'])->name('dashboard');
    
    Route::resource('produk', \App\Http\Controllers\Seller\ProductController::class)->names('products');
    
    Route::get('/pesanan', [\App\Http\Controllers\Seller\OrderController::class, 'index'])->name('orders.index');
    Route::get('/pesanan/{order}', [\App\Http\Controllers\Seller\OrderController::class, 'show'])->name('orders.show');
    Route::patch('/pesanan/{order}/status', [\App\Http\Controllers\Seller\OrderController::class, 'updateStatus'])->name('orders.update-status');
    
    Route::get('/pengaturan', [\App\Http\Controllers\Seller\SettingsController::class, 'index'])->name('settings.index');
    Route::put('/pengaturan', [\App\Http\Controllers\Seller\SettingsController::class, 'update'])->name('settings.update');
});

require __DIR__.'/auth.php';
