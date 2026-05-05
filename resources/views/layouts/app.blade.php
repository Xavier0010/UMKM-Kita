<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'UMKM Kita' }} - Marketplace UMKM Indonesia</title>
    <meta name="description" content="{{ $description ?? 'UMKM Kita – Platform katalog dan pemesanan produk UMKM Indonesia.' }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="min-h-screen flex flex-col bg-gray-50" x-data="{ mobileMenu: false, userMenu: false, cartCount: {{ auth()->check() ? auth()->user()->carts()->count() : 0 }} }">

{{-- ── NAVBAR ── --}}
<header class="bg-white border-b border-gray-100 sticky top-0 z-40 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">

            {{-- Logo --}}
            <a href="{{ route('home') }}" class="flex items-center gap-2 flex-shrink-0">
                <div class="w-8 h-8 bg-emerald-600 rounded-lg flex items-center justify-center">
                    <span class="text-white font-bold text-sm">U</span>
                </div>
                <span class="font-heading font-bold text-lg text-gray-900">UMKM <span class="text-emerald-600">Kita</span></span>
            </a>

            {{-- Search Bar (desktop) --}}
            <div class="hidden md:flex flex-1 max-w-xl mx-6">
                <form action="{{ route('products.index') }}" method="GET" class="w-full">
                    <div class="relative">
                        <input type="text" name="search" value="{{ request('search') }}"
                               placeholder="Cari produk, toko, atau kategori..."
                               class="w-full pl-10 pr-4 py-2 rounded-xl border border-gray-200 bg-gray-50
                                      text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent
                                      transition-all duration-150">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </span>
                    </div>
                </form>
            </div>

            {{-- Right side --}}
            <div class="flex items-center gap-2">
                @auth
                    {{-- Cart (buyers only) --}}
                    @if(auth()->user()->isBuyer())
                    <a href="{{ route('cart.index') }}" class="relative p-2 rounded-xl hover:bg-gray-100 transition-colors">
                        <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                        @php $cartCount = auth()->user()->carts()->count(); @endphp
                        @if($cartCount > 0)
                        <span class="absolute -top-0.5 -right-0.5 w-4 h-4 bg-emerald-600 text-white text-[10px] font-bold rounded-full flex items-center justify-center">
                            {{ $cartCount > 9 ? '9+' : $cartCount }}
                        </span>
                        @endif
                    </a>
                    @endif

                    {{-- User menu --}}
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open"
                                class="flex items-center gap-2 p-1.5 rounded-xl hover:bg-gray-100 transition-colors">
                            <div class="w-8 h-8 bg-emerald-100 rounded-full flex items-center justify-center">
                                <span class="text-emerald-700 font-bold text-sm">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                            </div>
                            <span class="hidden sm:block text-sm font-medium text-gray-700 max-w-24 truncate">{{ auth()->user()->name }}</span>
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>

                        <div x-show="open" @click.outside="open = false" x-cloak
                             class="absolute right-0 mt-2 w-52 bg-white rounded-2xl shadow-xl border border-gray-100 py-1 z-50">
                            <div class="px-4 py-2.5 border-b border-gray-100">
                                <p class="text-sm font-semibold text-gray-900 truncate">{{ auth()->user()->name }}</p>
                                <p class="text-xs text-gray-400 truncate">{{ auth()->user()->email }}</p>
                                <span class="badge {{ auth()->user()->isAdmin() ? 'badge-violet' : (auth()->user()->isSeller() ? 'badge-amber' : 'badge-emerald') }} mt-1">
                                    {{ auth()->user()->isAdmin() ? 'Admin' : (auth()->user()->isSeller() ? 'Penjual' : 'Pembeli') }}
                                </span>
                            </div>

                            @if(auth()->user()->isAdmin())
                                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                                    <span>⚙️</span> Dashboard Admin
                                </a>
                            @elseif(auth()->user()->isSeller())
                                <a href="{{ route('seller.dashboard') }}" class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                                    <span>🏪</span> Dashboard Penjual
                                </a>
                            @else
                                <a href="{{ route('orders.index') }}" class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                                    <span>📦</span> Pesanan Saya
                                </a>
                            @endif

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="flex items-center gap-2 w-full px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                                    <span>🚪</span> Keluar
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="btn-outline btn-sm hidden sm:inline-flex">Masuk</a>
                    <a href="{{ route('register') }}" class="btn-primary btn-sm">Daftar</a>
                @endauth

                {{-- Mobile menu toggle --}}
                <button @click="mobileMenu = !mobileMenu" class="md:hidden p-2 rounded-xl hover:bg-gray-100">
                    <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
            </div>
        </div>

        {{-- Category nav --}}
        <div class="hidden md:flex items-center gap-6 pb-2 overflow-x-auto scrollbar-none">
            <a href="{{ route('products.index') }}" class="nav-link whitespace-nowrap {{ request()->routeIs('products.index') && !request('category') ? 'nav-link-active' : '' }}">
                Semua Produk
            </a>
            @foreach(\App\Models\Category::all() as $cat)
            <a href="{{ route('categories.show', $cat->slug) }}"
               class="nav-link whitespace-nowrap flex items-center gap-1 {{ request()->is('kategori/'.$cat->slug) ? 'nav-link-active' : '' }}">
                <span>{{ $cat->icon }}</span> {{ $cat->name }}
            </a>
            @endforeach
        </div>
    </div>

    {{-- Mobile menu --}}
    <div x-show="mobileMenu" x-cloak class="md:hidden border-t border-gray-100 bg-white px-4 pb-4">
        <form action="{{ route('products.index') }}" method="GET" class="mt-3">
            <input type="text" name="search" placeholder="Cari produk..."
                   class="form-input">
        </form>
        <div class="mt-3 space-y-1">
            <a href="{{ route('products.index') }}" class="block sidebar-link">🛍️ Semua Produk</a>
            @foreach(\App\Models\Category::all() as $cat)
            <a href="{{ route('categories.show', $cat->slug) }}" class="block sidebar-link">
                {{ $cat->icon }} {{ $cat->name }}
            </a>
            @endforeach
        </div>
    </div>
</header>

{{-- ── FLASH MESSAGES ── --}}
@if(session('success'))
<div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)"
     class="fixed bottom-5 right-5 z-50 toast border-emerald-100 animate-slide-up">
    <span class="text-emerald-500 text-lg">✅</span>
    <span class="text-gray-800">{{ session('success') }}</span>
    <button @click="show = false" class="text-gray-400 hover:text-gray-600 ml-2">✕</button>
</div>
@endif

@if(session('error'))
<div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)"
     class="fixed bottom-5 right-5 z-50 toast border-red-100 animate-slide-up">
    <span class="text-red-500 text-lg">❌</span>
    <span class="text-gray-800">{{ session('error') }}</span>
    <button @click="show = false" class="text-gray-400 hover:text-gray-600 ml-2">✕</button>
</div>
@endif

{{-- ── MAIN ── --}}
<main class="flex-1 animate-fade-in">
    {{ $slot }}
</main>

{{-- ── FOOTER ── --}}
<footer class="bg-gray-900 text-gray-300 mt-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <div class="md:col-span-2">
                <div class="flex items-center gap-2 mb-3">
                    <div class="w-8 h-8 bg-emerald-500 rounded-lg flex items-center justify-center">
                        <span class="text-white font-bold text-sm">U</span>
                    </div>
                    <span class="font-heading font-bold text-lg text-white">UMKM Kita</span>
                </div>
                <p class="text-sm leading-relaxed text-gray-400 max-w-xs">
                    Platform katalog dan pemesanan produk UMKM Indonesia. Dukung produk lokal, dukung UMKM bangsa.
                </p>
            </div>
            <div>
                <h4 class="font-semibold text-white mb-3 text-sm">Jelajahi</h4>
                <ul class="space-y-2 text-sm">
                    <li><a href="{{ route('home') }}" class="hover:text-emerald-400 transition-colors">Beranda</a></li>
                    <li><a href="{{ route('products.index') }}" class="hover:text-emerald-400 transition-colors">Katalog Produk</a></li>
                    @foreach(\App\Models\Category::take(4)->get() as $cat)
                    <li><a href="{{ route('categories.show', $cat->slug) }}" class="hover:text-emerald-400 transition-colors">{{ $cat->name }}</a></li>
                    @endforeach
                </ul>
            </div>
            <div>
                <h4 class="font-semibold text-white mb-3 text-sm">Penjual</h4>
                <ul class="space-y-2 text-sm">
                    <li><a href="{{ route('register') }}" class="hover:text-emerald-400 transition-colors">Daftar Toko</a></li>
                    @auth
                    @if(auth()->user()->isSeller())
                    <li><a href="{{ route('seller.dashboard') }}" class="hover:text-emerald-400 transition-colors">Dashboard</a></li>
                    @endif
                    @endauth
                </ul>
            </div>
        </div>
        <div class="border-t border-gray-800 mt-10 pt-6 flex flex-col sm:flex-row justify-between items-center gap-3">
            <p class="text-xs text-gray-500">© {{ date('Y') }} UMKM Kita. Dibuat dengan ❤️ untuk UMKM Indonesia.</p>
            <p class="text-xs text-gray-500">Proyek Service Design SMK Telkom Sidoarjo</p>
        </div>
    </div>
</footer>

</body>
</html>
