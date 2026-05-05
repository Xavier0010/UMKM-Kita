<x-seller-layout>
    <x-slot name="title">Kelola Produk</x-slot>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
            <h2 class="text-xl font-bold font-heading text-gray-900">Daftar Produk</h2>
            
            <div class="flex items-center gap-3 w-full sm:w-auto">
                <form action="{{ route('seller.products.index') }}" method="GET" class="flex-1 sm:w-64">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari produk..." class="form-input text-sm py-2">
                </form>
                <a href="{{ route('seller.products.create') }}" class="btn-primary py-2 shrink-0">
                    + Tambah
                </a>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wider">
                        <th class="p-4 font-semibold rounded-tl-xl">Produk</th>
                        <th class="p-4 font-semibold">Kategori</th>
                        <th class="p-4 font-semibold">Harga</th>
                        <th class="p-4 font-semibold">Stok</th>
                        <th class="p-4 font-semibold">Status</th>
                        <th class="p-4 font-semibold rounded-tr-xl">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($products as $product)
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="p-4">
                            <div class="flex items-center gap-3">
                                <img src="{{ $product->main_image_url }}" alt="{{ $product->name }}" class="w-12 h-12 rounded-lg object-cover border border-gray-100">
                                <div>
                                    <p class="font-bold text-gray-900 line-clamp-1">{{ $product->name }}</p>
                                    <a href="{{ route('products.show', $product->slug) }}" target="_blank" class="text-xs text-emerald-600 hover:underline">Lihat di toko</a>
                                </div>
                            </div>
                        </td>
                        <td class="p-4 text-sm text-gray-600">{{ $product->category->name ?? '-' }}</td>
                        <td class="p-4 text-sm font-semibold text-gray-900">{{ $product->formatted_price }}</td>
                        <td class="p-4 text-sm text-gray-600">
                            @if($product->stock <= 5)
                                <span class="text-red-600 font-bold">{{ $product->stock }}</span>
                            @else
                                {{ $product->stock }}
                            @endif
                        </td>
                        <td class="p-4">
                            @if($product->is_active)
                                <span class="badge badge-emerald">Aktif</span>
                            @else
                                <span class="badge badge-gray">Nonaktif</span>
                            @endif
                        </td>
                        <td class="p-4">
                            <div class="flex items-center gap-2">
                                <a href="{{ route('seller.products.edit', $product->id) }}" class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors" title="Edit">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                </a>
                                <form action="{{ route('seller.products.destroy', $product->id) }}" method="POST" class="inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="Hapus" onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini?')">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="p-8 text-center text-gray-500">
                            Belum ada produk. Silakan tambahkan produk pertama Anda.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $products->links() }}
        </div>
    </div>
</x-seller-layout>
