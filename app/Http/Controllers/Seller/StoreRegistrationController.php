<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StoreRegistrationController extends Controller
{
    public function index()
    {
        // If already has store, redirect to dashboard
        if (Auth::user()->store) {
            return redirect()->route('seller.dashboard');
        }

        return view('seller.register');
    }

    public function store(Request $request)
    {
        if (Auth::user()->store) {
            return redirect()->route('seller.dashboard');
        }

        $request->validate([
            'name'        => 'required|string|max:255|unique:stores,name',
            'description' => 'required|string',
            'address'     => 'required|string',
            'city'        => 'required|string|max:100',
            'whatsapp'    => 'required|string|max:20',
            'logo'        => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $logoPath = null;
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('stores/logos', 'public');
        }

        Store::create([
            'user_id'     => Auth::id(),
            'name'        => $request->name,
            'slug'        => \Illuminate\Support\Str::slug($request->name),
            'description' => $request->description,
            'address'     => $request->address,
            'city'        => $request->city,
            'whatsapp'    => $request->whatsapp,
            'logo'        => $logoPath,
            'status'      => 'pending', // Requires admin approval
        ]);

        return redirect()->route('seller.dashboard')->with('success', 'Toko berhasil didaftarkan! Menunggu persetujuan Admin.');
    }
}
