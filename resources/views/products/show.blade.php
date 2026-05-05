<x-app-layout>
    <x-slot name="title">{{ $product->name }}</x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 md:py-12" x-data="{ mainImage: '{{ $product->main_image_url }}', qty: 1 }">
        
        {{-- Breadcrumb --}}
        <nav class="flex text-sm text-gray-500 mb-6" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="{{ route('home') }}" class="hover:text-emerald-600 transition-colors">Beranda</a>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="w-4 h-4 mx-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                        <a href="{{ route('products.index') }}" class="hover:text-emerald-600 transition-colors">Produk</a>
                    </div>
                </li>
                @if($product->category)
                <li>
                    <div class="flex items-center">
                        <svg class="w-4 h-4 mx-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                        <a href="{{ route('categories.show', $product->category->slug) }}" class="hover:text-emerald-600 transition-colors">{{ $product->category->name }}</a>
                    </div>
                </li>
                @endif
                <li aria-current="page">
                    <div class="flex items-center">
                        <svg class="w-4 h-4 mx-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                        <span class="text-gray-400 font-medium truncate max-w-[150px] sm:max-w-xs">{{ $product->name }}</span>
                    </div>
                </li>
            </ol>
        </nav>

        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="flex flex-col lg:flex-row">
                
                {{-- Product Images --}}
                <div class="w-full lg:w-5/12 p-6 md:p-8 bg-gray-50/50">
                    {{-- Main Image --}}
                    <div class="aspect-square bg-white rounded-2xl overflow-hidden shadow-sm border border-gray-100 mb-4 group relative">
                        <img :src="mainImage" alt="{{ $product->name }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                    </div>
                    
                    {{-- Gallery --}}
                    <div class="grid grid-cols-5 gap-2 sm:gap-3">
                        <button @click="mainImage = '{{ $product->main_image_url }}'" class="aspect-square rounded-xl overflow-hidden border-2 transition-all focus:outline-none" :class="mainImage === '{{ $product->main_image_url }}' ? 'border-emerald-500 shadow-md' : 'border-transparent hover:border-gray-300 opacity-70 hover:opacity-100'">
                            <img src="{{ $product->main_image_url }}" class="w-full h-full object-cover">
                        </button>
                        
                        @foreach($product->gallery_urls as $imgUrl)
                        <button @click="mainImage = '{{ $imgUrl }}'" class="aspect-square rounded-xl overflow-hidden border-2 transition-all focus:outline-none" :class="mainImage === '{{ $imgUrl }}' ? 'border-emerald-500 shadow-md' : 'border-transparent hover:border-gray-300 opacity-70 hover:opacity-100'">
                            <img src="{{ $imgUrl }}" class="w-full h-full object-cover">
                        </button>
                        @endforeach
                    </div>
                </div>

                {{-- Product Info --}}
                <div class="w-full lg:w-7/12 p-6 md:p-10 flex flex-col">
                    <div class="mb-4">
                        @if($product->category)
                        <a href="{{ route('categories.show', $product->category->slug) }}" class="badge badge-emerald mb-3">{{ $product->category->name }}</a>
                        @endif
                        <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 font-heading leading-tight">{{ $product->name }}</h1>
                    </div>

                    <div class="text-3xl font-bold text-emerald-600 mb-6 font-heading tracking-tight">
                        {{ $product->formatted_price }}
                    </div>

                    <div class="divider"></div>

                    <div class="prose prose-sm sm:prose text-gray-600 mb-8 max-w-none">
                        {!! nl2br(e($product->description)) !!}
                    </div>

                    <div class="mt-auto">
                        <div class="bg-gray-50 rounded-2xl p-5 border border-gray-100 mb-6">
                            <h3 class="text-sm font-semibold text-gray-900 mb-4 flex items-center gap-2">
                                <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m3-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                                Informasi Toko
                            </h3>
                            <div class="flex items-center gap-4">
                                <img src="{{ $product->store->logo_url }}" alt="Logo" class="w-14 h-14 rounded-full border border-gray-200 object-cover bg-white shadow-sm">
                                <div class="flex-1">
                                    <h4 class="font-bold text-gray-900">{{ $product->store->name }}</h4>
                                    <p class="text-sm text-gray-500 flex items-center gap-1 mt-0.5">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                        {{ $product->store->city }}
                                    </p>
                                </div>
                                <a href="{{ route('stores.show', $product->store->slug) }}" class="btn-outline btn-sm">Kunjungi Toko</a>
                            </div>
                        </div>

                        {{-- Action Buttons --}}
                        <div class="flex flex-col sm:flex-row gap-4 items-end sm:items-center">
                            @auth
                                @if(auth()->user()->isBuyer())
                                    <form action="{{ route('cart.add') }}" method="POST" class="flex flex-col sm:flex-row gap-4 w-full">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                        
                                        <div class="flex items-center border border-gray-300 rounded-xl h-12 w-full sm:w-32 bg-white">
                                            <button type="button" @click="if(qty > 1) qty--" class="w-10 h-full text-gray-500 hover:text-emerald-600 focus:outline-none flex items-center justify-center font-bold text-lg hover:bg-gray-50 rounded-l-xl transition-colors">-</button>
                                            <input type="number" name="quantity" x-model="qty" min="1" max="{{ $product->stock }}" class="w-full text-center border-none focus:ring-0 text-gray-900 font-semibold p-0 h-full bg-transparent" readonly>
                                            <button type="button" @click="if(qty < {{ $product->stock }}) qty++" class="w-10 h-full text-gray-500 hover:text-emerald-600 focus:outline-none flex items-center justify-center font-bold text-lg hover:bg-gray-50 rounded-r-xl transition-colors">+</button>
                                        </div>
                                        
                                        <button type="submit" class="btn-primary h-12 flex-1 shadow-md hover:shadow-lg text-base">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                                            Tambah ke Keranjang
                                        </button>
                                    </form>
                                @else
                                    <div class="w-full bg-amber-50 text-amber-700 p-4 rounded-xl text-sm border border-amber-200 font-medium">
                                        Hanya akun pembeli yang dapat menambahkan ke keranjang.
                                    </div>
                                @endif
                            @else
                                <a href="{{ route('login') }}" class="btn-primary w-full h-12 text-base">
                                    Masuk untuk Membeli
                                </a>
                            @endauth
                        </div>
                        
                        <div class="mt-4 flex items-center gap-2 text-sm text-gray-500">
                            Stok Tersedia: <strong class="text-gray-900">{{ $product->stock }}</strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Related Products --}}
        @if($relatedProducts->count() > 0)
        <div class="mt-16">
            <h2 class="text-2xl font-bold font-heading text-gray-900 mb-6">Produk Serupa</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 sm:gap-6">
                @foreach($relatedProducts as $related)
                <div class="product-card bg-white rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
                    <a href="{{ route('products.show', $related->slug) }}">
                        <div class="relative overflow-hidden rounded-t-2xl">
                            <img src="{{ $related->main_image_url }}" alt="{{ $related->name }}" class="product-card-img w-full h-48 object-cover">
                        </div>
                        <div class="p-4">
                            <div class="text-xs text-gray-500 mb-1.5">{{ $related->store->name }}</div>
                            <h3 class="font-semibold text-gray-900 mb-2 truncate" title="{{ $related->name }}">{{ $related->name }}</h3>
                            <div class="font-bold text-emerald-600">{{ $related->formatted_price }}</div>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
        </div>
        @endif

    </div>
</x-app-layout>
