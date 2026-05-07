<?php

use Illuminate\Support\Facades\Route;

Route::get('/', \App\Livewire\Catalog::class)->name('home');

require __DIR__.'/auth.php';
