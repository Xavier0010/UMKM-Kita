<?php

use Illuminate\Support\Facades\Route;

Route::get('/', \App\Livewire\Landing::class)->name('home');
Route::get('/catalog', \App\Livewire\Catalog::class)->name('catalog');

require __DIR__.'/auth.php';
