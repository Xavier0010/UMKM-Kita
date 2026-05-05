<x-app-layout>
    <x-slot name="title">Kategori: {{ $category->name }}</x-slot>

    {{-- Category Header --}}
    <div class="bg-emerald-600 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <div class="w-20 h-20 bg-white/20 rounded-2xl flex items-center justify-center text-4xl mx-auto mb-4 backdrop-blur-sm border border-white/30">
                {{ $category->icon }}
            </div>
            <h1 class="text-3xl font-bold font-heading">{{ $category->name }}</h1>
            <p class="text-emerald-100 mt-2">Jelajahi produk UMKM terbaik di kategori {{ $category->name }}</p>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="flex flex-col md:flex-row gap-8">
            {{-- Sidebar Categories --}}
            <aside class="w-full md:w-64 flex-shrink-0">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 sticky top-24">
                    <h3 class="font-bold text-gray-900 mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                        Kategori Lainnya
                    </h3>
                    
                    <div class="space-y-1">
                        @foreach($categories as $cat)
                        <a href="{{ route('categories.show', $cat->slug) }}" 
                           class="flex items-center gap-3 px-3 py-2 rounded-xl transition-colors {{ $category->id === $cat->id ? 'bg-emerald-50 text-emerald-700 font-semibold' : 'text-gray-600 hover:bg-gray-50' }}">
                            <span class="text-xl">{{ $cat->icon }}</span>
                            <span class="text-sm">{{ $cat->name }}</span>
                        </a>
                        @endforeach
                    </div>
                </div>
            </aside>

            {{-- Product Grid --}}
            <div class="flex-1">
                <div class="grid grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 sm:gap-6">
                    @forelse($products as $product)
                    <div class="product-card bg-white rounded-2xl shadow-sm border border-gray-100">
                        <a href="{{ route('products.show', $product->slug) }}">
                            <div class="relative overflow-hidden rounded-t-2xl">
                                <img src="{{ $product->main_image_url }}" alt="{{ $product->name }}" class="product-card-img w-full h-48 object-cover">
                            </div>
                            <div class="p-4">
                                <div class="text-xs text-gray-500 mb-1.5 flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m3-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                                    {{ $product->store->name }}
                                </div>
                                <h3 class="font-semibold text-gray-900 mb-2 line-clamp-2" title="{{ $product->name }}">{{ $product->name }}</h3>
                                <div class="font-bold text-emerald-600">{{ $product->formatted_price }}</div>
                            </div>
                        </a>
                    </div>
                    @empty
                    <div class="col-span-full empty-state">
                        <div class="empty-state-icon text-gray-300">{{ $category->icon }}</div>
                        <h3 class="empty-state-title">Belum ada produk</h3>
                        <p class="empty-state-subtitle">Belum ada produk dalam kategori ini.</p>
                        <a href="{{ route('products.index') }}" class="btn-outline mt-4">Lihat Semua Produk</a>
                    </div>
                    @endforelse
                </div>

                <div class="mt-8">
                    {{ $products->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
