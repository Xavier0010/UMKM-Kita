<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/products', function() {
    return response()->json(DB::table('products')->get());
});

Route::get('/products/{id}', function($id) {
    return response()->json(DB::table('products')->where('id', $id)->first());
});

Route::get('/categories', function() {
    return response()->json(DB::table('categories')->get());
});
