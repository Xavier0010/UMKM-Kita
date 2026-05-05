<x-seller-layout>
    <x-slot name="title">Dashboard</x-slot>

    @if($store->status === 'pending')
        <div class="bg-blue-50 border border-blue-200 text-blue-800 rounded-2xl p-6 mb-8 flex items-start gap-4">
            <div class="text-3xl">⏳</div>
            <div>
                <h3 class="font-bold text-lg mb-1">Toko Sedang Ditinjau</h3>
                <p class="text-sm">Terima kasih telah mendaftar. Toko Anda sedang dalam tahap peninjauan oleh tim admin. Anda dapat menambahkan produk sambil menunggu persetujuan, namun produk belum akan tampil di halaman publik sampai toko disetujui.</p>
            </div>
        </div>
    @elseif($store->status === 'rejected')
        <div class="bg-red-50 border border-red-200 text-red-800 rounded-2xl p-6 mb-8 flex items-start gap-4">
            <div class="text-3xl">❌</div>
            <div>
                <h3 class="font-bold text-lg mb-1">Toko Ditolak</h3>
                <p class="text-sm">Maaf, pendaftaran toko Anda ditolak. Silakan hubungi admin untuk informasi lebih lanjut.</p>
            </div>
        </div>
    @endif

    {{-- Stats Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-4">
            <div class="w-12 h-12 bg-amber-100 text-amber-600 rounded-full flex items-center justify-center text-2xl">
                💰
            </div>
            <div>
                <p class="text-sm text-gray-500 font-medium">Total Pendapatan</p>
                <h4 class="text-xl font-bold text-gray-900 mt-1">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h4>
            </div>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-4">
            <div class="w-12 h-12 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center text-2xl">
                📦
            </div>
            <div>
                <p class="text-sm text-gray-500 font-medium">Pesanan Baru</p>
                <h4 class="text-xl font-bold text-gray-900 mt-1">{{ $pendingOrders }}</h4>
            </div>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-4">
            <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center text-2xl">
                🛍️
            </div>
            <div>
                <p class="text-sm text-gray-500 font-medium">Total Produk</p>
                <h4 class="text-xl font-bold text-gray-900 mt-1">{{ $totalProducts }}</h4>
            </div>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-4">
            <div class="w-12 h-12 bg-violet-100 text-violet-600 rounded-full flex items-center justify-center text-2xl">
                📊
            </div>
            <div>
                <p class="text-sm text-gray-500 font-medium">Total Pesanan</p>
                <h4 class="text-xl font-bold text-gray-900 mt-1">{{ $totalOrders }}</h4>
            </div>
        </div>

    </div>

    {{-- Recent Orders & Quick Actions --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-gray-100">
            <div class="p-6 border-b border-gray-100 flex justify-between items-center">
                <h3 class="font-bold text-gray-900">Pesanan Terbaru</h3>
                <a href="{{ route('seller.orders.index') }}" class="text-sm text-amber-600 hover:text-amber-700 font-medium">Lihat Semua</a>
            </div>
            
            <div class="overflow-x-auto">
                @if($recentOrders->isEmpty())
                    <div class="p-8 text-center text-gray-500">
                        Belum ada pesanan terbaru.
                    </div>
                @else
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wider">
                                <th class="p-4 font-semibold">No Pesanan</th>
                                <th class="p-4 font-semibold">Pembeli</th>
                                <th class="p-4 font-semibold">Total</th>
                                <th class="p-4 font-semibold">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($recentOrders as $order)
                            <tr class="hover:bg-gray-50/50 transition-colors">
                                <td class="p-4">
                                    <a href="{{ route('seller.orders.show', $order->id) }}" class="font-medium text-amber-600 hover:underline">
                                        {{ $order->order_number }}
                                    </a>
                                </td>
                                <td class="p-4 text-sm text-gray-900">{{ $order->user->name }}</td>
                                <td class="p-4 text-sm font-semibold text-gray-900">{{ $order->formatted_total }}</td>
                                <td class="p-4">
                                    <span class="badge badge-{{ $order->status_color }}">{{ $order->status_label }}</span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>

        <div class="space-y-6">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h3 class="font-bold text-gray-900 mb-4">Profil Toko</h3>
                <div class="flex items-center gap-4 mb-6">
                    <img src="{{ $store->logo_url }}" class="w-16 h-16 rounded-full border-2 border-amber-100 object-cover">
                    <div>
                        <h4 class="font-bold text-gray-900">{{ $store->name }}</h4>
                        <p class="text-sm text-gray-500 flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            {{ $store->city }}
                        </p>
                    </div>
                </div>
                <div class="space-y-2">
                    <a href="{{ route('seller.settings.index') }}" class="btn-outline w-full justify-center">Edit Profil Toko</a>
                    <a href="{{ route('stores.show', $store->slug) }}" target="_blank" class="w-full justify-center py-2 px-4 rounded-xl font-semibold transition-all duration-200 flex items-center gap-2 bg-gray-50 text-gray-700 hover:bg-gray-100">Lihat Halaman Publik</a>
                </div>
            </div>

            <div class="bg-amber-50 rounded-2xl border border-amber-100 p-6">
                <h3 class="font-bold text-amber-900 mb-2">Tindakan Cepat</h3>
                <p class="text-sm text-amber-700 mb-4">Tambahkan produk baru ke etalase toko Anda untuk menarik lebih banyak pembeli.</p>
                <a href="{{ route('seller.products.create') }}" class="btn-primary w-full bg-amber-500 hover:bg-amber-600 border-none justify-center">
                    + Tambah Produk Baru
                </a>
            </div>
        </div>

    </div>

</x-seller-layout>
