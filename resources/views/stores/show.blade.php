<x-app-layout>
    <x-slot name="title">Toko {{ $store->name }}</x-slot>

    {{-- Store Banner & Profile --}}
    <div class="bg-white border-b border-gray-100">
        <div class="h-48 md:h-64 w-full bg-gray-200 relative">
            @if($store->banner)
                <img src="{{ $store->banner_url }}" alt="Banner {{ $store->name }}" class="w-full h-full object-cover">
            @else
                <div class="w-full h-full bg-gradient-to-r from-emerald-500 to-emerald-700"></div>
            @endif
            <div class="absolute inset-0 bg-black/20"></div>
        </div>
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="relative -mt-16 sm:-mt-20 pb-8 flex flex-col sm:flex-row gap-6 items-center sm:items-end">
                <div class="w-32 h-32 sm:w-40 sm:h-40 bg-white p-2 rounded-full shadow-lg relative z-10">
                    <img src="{{ $store->logo_url }}" alt="Logo {{ $store->name }}" class="w-full h-full object-cover rounded-full">
                </div>
                
                <div class="flex-1 text-center sm:text-left mb-2">
                    <h1 class="text-3xl font-bold font-heading text-gray-900">{{ $store->name }}</h1>
                    <p class="text-gray-500 mt-1 flex items-center justify-center sm:justify-start gap-2">
                        <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        {{ $store->city }}
                    </p>
                </div>

                <div class="flex gap-3 mb-2">
                    <a href="{{ $store->whatsapp_url }}" target="_blank" class="btn-primary bg-[#25D366] hover:bg-[#1da851] border-none">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51a12.8 12.8 0 00-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/></svg>
                        Hubungi Penjual
                    </a>
                </div>
            </div>
            
            @if($store->description)
            <div class="pb-8 max-w-3xl border-t border-gray-100 pt-6 mt-2">
                <h3 class="font-bold text-gray-900 mb-2">Tentang Toko</h3>
                <p class="text-gray-600 leading-relaxed text-sm">{!! nl2br(e($store->description)) !!}</p>
            </div>
            @endif
        </div>
    </div>

    {{-- Store Products --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <h2 class="text-2xl font-bold font-heading text-gray-900 mb-8">Produk dari {{ $store->name }}</h2>
        
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 sm:gap-6">
            @forelse($products as $product)
            <div class="product-card bg-white rounded-2xl shadow-sm border border-gray-100">
                <a href="{{ route('products.show', $product->slug) }}">
                    <div class="relative overflow-hidden rounded-t-2xl">
                        <img src="{{ $product->main_image_url }}" alt="{{ $product->name }}" class="product-card-img w-full h-48 object-cover">
                        <div class="absolute top-2 left-2">
                            <span class="badge badge-emerald bg-white/90 backdrop-blur-sm">{{ $product->category->name ?? 'Lainnya' }}</span>
                        </div>
                    </div>
                    <div class="p-4">
                        <h3 class="font-semibold text-gray-900 mb-2 line-clamp-2" title="{{ $product->name }}">{{ $product->name }}</h3>
                        <div class="font-bold text-emerald-600">{{ $product->formatted_price }}</div>
                    </div>
                </a>
            </div>
            @empty
            <div class="col-span-full empty-state">
                <div class="empty-state-icon">🛍️</div>
                <h3 class="empty-state-title">Belum ada produk</h3>
                <p class="empty-state-subtitle">Toko ini belum menambahkan produk yang tersedia.</p>
            </div>
            @endforelse
        </div>

        <div class="mt-8">
            {{ $products->links() }}
        </div>
    </div>
</x-app-layout>
