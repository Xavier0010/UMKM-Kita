<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class SellerMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check() || Auth::user()->role !== 'seller') {
            return redirect()->route('home');
        }

        $store = Auth::user()->store;

        if (!$store || $store->status !== 'approved') {
            return redirect()->route('home')->with('error', 'Akun penjual Anda sedang menunggu persetujuan admin.');
        }

        return $next($request);
    }
}
