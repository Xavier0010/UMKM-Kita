<x-app-layout>
    <x-slot name="title">Katalog Produk</x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 md:py-12">
        
        <div class="flex flex-col md:flex-row gap-8">
            {{-- Sidebar Filters --}}
            <aside class="w-full md:w-64 flex-shrink-0">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 sticky top-24">
                    <h3 class="font-bold text-gray-900 mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/></svg>
                        Filter Produk
                    </h3>
                    
                    <form action="{{ route('products.index') }}" method="GET">
                        @if(request('search'))
                            <input type="hidden" name="search" value="{{ request('search') }}">
                        @endif

                        <div class="mb-6">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Kategori</label>
                            <div class="space-y-2">
                                <label class="flex items-center gap-2 cursor-pointer group">
                                    <input type="radio" name="category" value="" onchange="this.form.submit()" 
                                           class="text-emerald-600 focus:ring-emerald-500 rounded-full"
                                           {{ !request('category') ? 'checked' : '' }}>
                                    <span class="text-sm text-gray-600 group-hover:text-emerald-600 transition-colors">Semua Kategori</span>
                                </label>
                                @foreach($categories as $cat)
                                <label class="flex items-center gap-2 cursor-pointer group">
                                    <input type="radio" name="category" value="{{ $cat->slug }}" onchange="this.form.submit()"
                                           class="text-emerald-600 focus:ring-emerald-500 rounded-full"
                                           {{ request('category') == $cat->slug ? 'checked' : '' }}>
                                    <span class="text-sm text-gray-600 group-hover:text-emerald-600 transition-colors">{{ $cat->name }}</span>
                                </label>
                                @endforeach
                            </div>
                        </div>

                        <div class="mb-6">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Urutkan</label>
                            <select name="sort" onchange="this.form.submit()" class="form-select text-sm w-full">
                                <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Terbaru</option>
                                <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Harga: Rendah ke Tinggi</option>
                                <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Harga: Tinggi ke Rendah</option>
                            </select>
                        </div>
                        
                        <noscript>
                            <button type="submit" class="btn-primary w-full text-center mt-4">Terapkan Filter</button>
                        </noscript>
                    </form>
                </div>
            </aside>

            {{-- Product Grid --}}
            <div class="flex-1">
                @if(request('search') || request('category'))
                <div class="mb-6 flex items-center justify-between bg-white px-4 py-3 rounded-xl border border-gray-100 shadow-sm">
                    <div class="text-sm text-gray-600">
                        Menampilkan hasil untuk: 
                        @if(request('search')) <span class="font-semibold text-gray-900">"{{ request('search') }}"</span> @endif
                        @if(request('search') && request('category')) dan @endif
                        @if(request('category')) <span class="font-semibold text-emerald-600">{{ $categories->where('slug', request('category'))->first()->name ?? request('category') }}</span> @endif
                    </div>
                    <a href="{{ route('products.index') }}" class="text-xs text-red-500 hover:text-red-600 font-medium bg-red-50 px-2 py-1 rounded-lg">Reset Filter</a>
                </div>
                @endif

                <div class="grid grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 sm:gap-6">
                    @forelse($products as $product)
                    <div class="product-card bg-white rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
                        <a href="{{ route('products.show', $product->slug) }}">
                            <div class="relative overflow-hidden rounded-t-2xl">
                                <img src="{{ $product->main_image_url }}" alt="{{ $product->name }}" class="product-card-img w-full h-48 object-cover">
                                <div class="absolute top-2 left-2 flex gap-1 flex-col">
                                    <span class="badge badge-emerald bg-white/90 backdrop-blur-sm">{{ $product->category->name ?? 'Lainnya' }}</span>
                                </div>
                            </div>
                            <div class="p-4">
                                <div class="text-xs text-gray-500 mb-1.5 flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m3-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                                    {{ $product->store->name }}
                                </div>
                                <h3 class="font-semibold text-gray-900 mb-2 line-clamp-2 leading-tight" title="{{ $product->name }}">{{ $product->name }}</h3>
                                <div class="flex justify-between items-center mt-3 pt-3 border-t border-gray-50">
                                    <span class="font-bold text-emerald-600">{{ $product->formatted_price }}</span>
                                    @if($product->stock <= 5)
                                        <span class="text-[10px] font-bold text-red-500 bg-red-50 px-2 py-0.5 rounded-md">Sisa {{ $product->stock }}</span>
                                    @endif
                                </div>
                            </div>
                        </a>
                    </div>
                    @empty
                    <div class="col-span-full py-20 text-center bg-white rounded-2xl border border-gray-100 border-dashed">
                        <div class="text-6xl mb-4">🔍</div>
                        <h3 class="text-lg font-bold text-gray-900">Produk tidak ditemukan</h3>
                        <p class="text-gray-500 mt-1 max-w-md mx-auto">Maaf, kami tidak dapat menemukan produk yang sesuai dengan filter Anda. Coba ubah kata kunci atau hapus filter.</p>
                        <a href="{{ route('products.index') }}" class="btn-primary mt-6">Lihat Semua Produk</a>
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
