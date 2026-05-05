<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Admin Dashboard' }} - UMKM Kita</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-gray-50 min-h-screen flex flex-col md:flex-row" x-data="{ mobileSidebar: false }">

{{-- Sidebar --}}
<aside class="w-64 bg-slate-900 border-r border-slate-800 hidden md:flex flex-col fixed inset-y-0 z-10 text-slate-300">
    <div class="h-16 flex items-center px-6 border-b border-slate-800 flex-shrink-0">
        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2 text-white">
            <div class="w-8 h-8 bg-violet-600 rounded-lg flex items-center justify-center">
                <span class="text-white font-bold text-sm">A</span>
            </div>
            <span class="font-heading font-bold text-lg text-white">UMKM <span class="text-violet-400">Admin</span></span>
        </a>
    </div>

    <div class="p-4 flex-1 overflow-y-auto">
        <div class="space-y-1">
            <a href="{{ route('admin.dashboard') }}" class="sidebar-link hover:bg-slate-800 hover:text-white {{ request()->routeIs('admin.dashboard') ? 'bg-violet-600/20 text-violet-400 font-semibold' : 'text-slate-400' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                Dashboard
            </a>
            <a href="{{ route('admin.stores.index') }}" class="sidebar-link hover:bg-slate-800 hover:text-white {{ request()->routeIs('admin.stores.*') ? 'bg-violet-600/20 text-violet-400 font-semibold' : 'text-slate-400' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m3-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                Kelola Toko
            </a>
            <a href="{{ route('admin.categories.index') }}" class="sidebar-link hover:bg-slate-800 hover:text-white {{ request()->routeIs('admin.categories.*') ? 'bg-violet-600/20 text-violet-400 font-semibold' : 'text-slate-400' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                Kategori
            </a>
            <a href="{{ route('admin.users.index') }}" class="sidebar-link hover:bg-slate-800 hover:text-white {{ request()->routeIs('admin.users.*') ? 'bg-violet-600/20 text-violet-400 font-semibold' : 'text-slate-400' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                Pengguna
            </a>
        </div>
    </div>
    
    <div class="p-4 border-t border-slate-800 flex-shrink-0">
        <a href="{{ route('home') }}" class="sidebar-link mb-2 text-sm hover:bg-slate-800 hover:text-white text-slate-400">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Ke Website Publik
        </a>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="sidebar-link w-full text-red-400 hover:text-red-300 hover:bg-red-400/10">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                Keluar
            </button>
        </form>
    </div>
</aside>

{{-- Mobile Header --}}
<div class="md:hidden bg-slate-900 border-b border-slate-800 h-16 flex items-center justify-between px-4 sticky top-0 z-30">
    <a href="{{ route('admin.dashboard') }}" class="font-heading font-bold text-lg text-white">UMKM <span class="text-violet-400">Admin</span></a>
    <button @click="mobileSidebar = !mobileSidebar" class="p-2 rounded-xl bg-slate-800 text-slate-300">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
    </button>
</div>

{{-- Main Content --}}
<div class="flex-1 md:ml-64 flex flex-col min-h-screen">
    
    <header class="h-16 bg-white border-b border-gray-100 flex items-center justify-between px-6 hidden md:flex sticky top-0 z-20">
        <h1 class="text-xl font-bold font-heading text-gray-800">{{ $title ?? 'Admin Panel' }}</h1>
        <div class="flex items-center gap-4">
            <span class="text-sm font-medium text-gray-600">Admin</span>
            <div class="w-10 h-10 bg-violet-100 rounded-full flex items-center justify-center border-2 border-white shadow-sm">
                <span class="text-violet-700 font-bold">A</span>
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
