<?php

use Illuminate\Support\Facades\Route;

Route::get('/', \App\Livewire\Catalog::class)->name('home');

Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', \App\Livewire\Admin\Dashboard::class)->name('admin.dashboard');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/wishlist', \App\Livewire\WishlistPage::class)->name('wishlist.index');
});

Route::middleware(['auth', 'seller'])->group(function () {
    Route::get('/seller', \App\Livewire\Seller\Dashboard::class)->name('seller.dashboard');
});

require __DIR__.'/auth.php';
