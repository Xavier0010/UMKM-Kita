<x-app-layout>
    <x-slot name="title">Beranda</x-slot>

    {{-- Hero Section --}}
    <div class="hero-gradient text-white pt-20 pb-28 px-4 relative overflow-hidden">
        <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-10"></div>
        <div class="max-w-7xl mx-auto text-center relative z-10">
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold font-heading mb-6 tracking-tight">
                Dukung UMKM,<br class="hidden md:block"> Majukan Ekonomi Bangsa
            </h1>
            <p class="text-lg md:text-xl text-emerald-100 max-w-2xl mx-auto mb-10 leading-relaxed">
                Temukan ribuan produk lokal berkualitas dari berbagai toko UMKM di sekitarmu. Belanja aman, mudah, dan memberdayakan.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('products.index') }}" class="bg-white text-emerald-700 px-8 py-3.5 rounded-2xl font-semibold hover:bg-emerald-50 transition-colors shadow-lg">
                    Mulai Belanja
                </a>
                @guest
                <a href="{{ route('register') }}" class="bg-emerald-800 text-white px-8 py-3.5 rounded-2xl font-semibold hover:bg-emerald-900 transition-colors border border-emerald-700">
                    Buka Toko
                </a>
                @endguest
            </div>
        </div>
    </div>

    {{-- Kategori Section --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-12 relative z-20">
        <div class="glass rounded-3xl p-6 sm:p-8 shadow-xl">
            <h2 class="section-title mb-6">Kategori Pilihan</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-7 gap-4">
                @foreach($categories as $category)
                <a href="{{ route('categories.show', $category->slug) }}" class="flex flex-col items-center p-4 rounded-2xl hover:bg-gray-50 transition-colors border border-transparent hover:border-gray-100">
                    <div class="w-16 h-16 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center text-3xl mb-3 shadow-inner">
                        {{ $category->icon }}
                    </div>
                    <span class="text-sm font-medium text-gray-700 text-center">{{ $category->name }}</span>
                </a>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Produk Terbaru --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
        <div class="flex justify-between items-end mb-8">
            <div>
                <h2 class="section-title">Produk Terbaru</h2>
                <p class="section-subtitle">Koleksi produk teranyar dari mitra UMKM kami.</p>
            </div>
            <a href="{{ route('products.index') }}" class="text-emerald-600 hover:text-emerald-700 font-medium text-sm flex items-center gap-1 hidden sm:flex">
                Lihat Semua <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </a>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @forelse($latestProducts as $product)
            <div class="product-card">
                <a href="{{ route('products.show', $product->slug) }}">
                    <div class="relative">
                        <img src="{{ $product->main_image_url }}" alt="{{ $product->name }}" class="product-card-img">
                        <div class="absolute top-3 left-3 flex gap-2">
                            <span class="badge badge-emerald shadow-sm">{{ $product->category->name }}</span>
                        </div>
                    </div>
                    <div class="p-4 border-t border-gray-100">
                        <div class="text-xs text-gray-500 mb-1 flex items-center gap-1">
                            <span>🏪</span> {{ $product->store->name }}
                        </div>
                        <h3 class="font-semibold text-gray-900 mb-2 truncate" title="{{ $product->name }}">{{ $product->name }}</h3>
                        <div class="flex justify-between items-center mt-3">
                            <span class="font-bold text-emerald-600">{{ $product->formatted_price }}</span>
                        </div>
                    </div>
                </a>
            </div>
            @empty
            <div class="col-span-full empty-state">
                <div class="empty-state-icon">🛍️</div>
                <h3 class="empty-state-title">Belum ada produk</h3>
                <p class="empty-state-subtitle">Mitra UMKM kami sedang menyiapkan produk terbaik mereka.</p>
            </div>
            @endforelse
        </div>
        
        <div class="mt-8 text-center sm:hidden">
             <a href="{{ route('products.index') }}" class="btn-outline w-full">Lihat Semua Produk</a>
        </div>
    </div>

    {{-- Toko Populer --}}
    <div class="bg-white border-y border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
            <h2 class="section-title text-center mb-2">Toko Terpopuler</h2>
            <p class="section-subtitle text-center mb-10">Kunjungi toko UMKM dengan koleksi terbanyak.</p>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($popularStores as $store)
                <a href="{{ route('stores.show', $store->slug) }}" class="card p-5 hover:-translate-y-1 transition-transform group text-center block">
                    <img src="{{ $store->logo_url }}" alt="{{ $store->name }}" class="w-20 h-20 rounded-full mx-auto mb-4 border-4 border-emerald-50 object-cover shadow-sm group-hover:scale-105 transition-transform">
                    <h3 class="font-bold text-gray-900 truncate">{{ $store->name }}</h3>
                    <p class="text-sm text-gray-500 mt-1 flex items-center justify-center gap-1">
                        <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        {{ $store->city }}
                    </p>
                    <div class="mt-4 pt-4 border-t border-gray-100 flex justify-between text-xs font-medium">
                        <span class="text-emerald-600 bg-emerald-50 px-3 py-1 rounded-full">{{ $store->products_count }} Produk</span>
                        <span class="text-amber-600 bg-amber-50 px-3 py-1 rounded-full text-center flex items-center gap-1">
                            Kunjungi <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </span>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
    </div>

</x-app-layout>
