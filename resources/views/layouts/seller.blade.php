<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Dashboard Penjual' }} - UMKM Kita</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-gray-50 min-h-screen flex flex-col md:flex-row" x-data="{ mobileSidebar: false, storePending: {{ auth()->user()->store && auth()->user()->store->isPending() ? 'true' : 'false' }} }">

{{-- Sidebar --}}
<aside class="w-64 bg-white border-r border-gray-100 hidden md:flex flex-col fixed inset-y-0 z-10">
    <div class="h-16 flex items-center px-6 border-b border-gray-100 flex-shrink-0">
        <a href="{{ route('seller.dashboard') }}" class="flex items-center gap-2">
            <div class="w-8 h-8 bg-amber-500 rounded-lg flex items-center justify-center">
                <span class="text-white font-bold text-sm">🏪</span>
            </div>
            <span class="font-heading font-bold text-lg text-gray-900">Seller<span class="text-amber-500">Center</span></span>
        </a>
    </div>

    <div class="p-4 flex-1 overflow-y-auto">
        <div class="space-y-1">
            <a href="{{ route('seller.dashboard') }}" class="sidebar-link {{ request()->routeIs('seller.dashboard') ? 'sidebar-link-active' : '' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                Dashboard
            </a>
            
            <template x-if="!storePending">
                <div class="space-y-1">
                    <a href="{{ route('seller.products.index') }}" class="sidebar-link {{ request()->routeIs('seller.products.*') ? 'sidebar-link-active' : '' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                        Produk Saya
                    </a>
                    <a href="{{ route('seller.orders.index') }}" class="sidebar-link {{ request()->routeIs('seller.orders.*') ? 'sidebar-link-active' : '' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
                        Pesanan
                    </a>
                    <a href="{{ route('seller.settings.index') }}" class="sidebar-link {{ request()->routeIs('seller.settings.*') ? 'sidebar-link-active' : '' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        Pengaturan Toko
                    </a>
                </div>
            </template>
        </div>
    </div>
    
    <div class="p-4 border-t border-gray-100 flex-shrink-0">
        <a href="{{ route('home') }}" class="sidebar-link mb-2 text-sm">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Kembali ke Beranda
        </a>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="sidebar-link w-full text-red-600 hover:text-red-700 hover:bg-red-50">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                Keluar
            </button>
        </form>
    </div>
</aside>

{{-- Mobile Header --}}
<div class="md:hidden bg-white border-b border-gray-100 h-16 flex items-center justify-between px-4 sticky top-0 z-30">
    <a href="{{ route('seller.dashboard') }}" class="font-heading font-bold text-lg text-gray-900">Seller<span class="text-amber-500">Center</span></a>
    <button @click="mobileSidebar = !mobileSidebar" class="p-2 rounded-xl bg-gray-50 text-gray-600">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
    </button>
</div>

{{-- Main Content --}}
<div class="flex-1 md:ml-64 flex flex-col min-h-screen">
    
    <header class="h-16 bg-white border-b border-gray-100 flex items-center justify-between px-6 hidden md:flex sticky top-0 z-20">
        <h1 class="text-xl font-bold font-heading text-gray-800">{{ $title ?? 'Dashboard' }}</h1>
        <div class="flex items-center gap-4">
            <span class="text-sm font-medium text-gray-600">{{ auth()->user()->store->name ?? auth()->user()->name }}</span>
            <div class="w-10 h-10 bg-amber-100 rounded-full flex items-center justify-center border-2 border-white shadow-sm">
                <span class="text-amber-700 font-bold">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
            </div>
        </div>
    </header>

    {{-- Flash Messages --}}
    @if(session('success'))
    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)"
         class="fixed top-20 right-5 z-50 toast border-emerald-100 animate-slide-up bg-white">
        <span class="text-emerald-500 text-lg">✅</span>
        <span class="text-gray-800">{{ session('success') }}</span>
    </div>
    @endif

    <main class="flex-1 p-4 sm:p-6 lg:p-8 animate-fade-in">
        {{ $slot }}
    </main>
</div>

</body>
</html>
