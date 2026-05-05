<x-app-layout>
    <x-slot name="title">Pesanan Saya</x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 md:py-12">
        <h1 class="text-3xl font-bold font-heading text-gray-900 mb-8">Pesanan Saya</h1>

        @if($orders->isEmpty())
            <div class="bg-white rounded-3xl p-12 text-center border border-gray-100 shadow-sm max-w-2xl mx-auto">
                <div class="text-6xl mb-6">📦</div>
                <h3 class="text-2xl font-bold text-gray-900 font-heading mb-2">Belum ada pesanan</h3>
                <p class="text-gray-500 mb-8">Anda belum membuat pesanan sama sekali.</p>
                <a href="{{ route('products.index') }}" class="btn-primary btn-lg">Mulai Belanja</a>
            </div>
        @else
            <div class="space-y-6">
                @foreach($orders as $order)
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-shadow">
                        <div class="bg-gray-50 px-6 py-4 border-b border-gray-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                            <div class="flex items-center gap-4">
                                <div>
                                    <span class="text-xs text-gray-500 block mb-1">Toko</span>
                                    <div class="flex items-center gap-2">
                                        <span>🏪</span>
                                        <h3 class="font-bold text-gray-900">{{ $order->store->name }}</h3>
                                    </div>
                                </div>
                                <div class="hidden sm:block h-8 w-px bg-gray-200"></div>
                                <div class="hidden sm:block">
                                    <span class="text-xs text-gray-500 block mb-1">Tanggal Pesanan</span>
                                    <span class="text-sm font-medium text-gray-900">{{ $order->created_at->format('d M Y, H:i') }}</span>
                                </div>
                            </div>
                            <div class="flex items-center justify-between sm:justify-end gap-4 w-full sm:w-auto">
                                <span class="badge badge-{{ $order->status_color }}">{{ $order->status_label }}</span>
                                <span class="text-sm font-bold text-gray-900 sm:hidden">{{ $order->order_number }}</span>
                            </div>
                        </div>
                        
                        <div class="p-6">
                            <div class="flex flex-col md:flex-row gap-6">
                                <div class="flex-1 space-y-4">
                                    @foreach($order->items->take(2) as $item)
                                        <div class="flex gap-4">
                                            <div class="w-16 h-16 rounded-xl overflow-hidden flex-shrink-0 border border-gray-100">
                                                <img src="{{ $item->product->main_image_url }}" alt="{{ $item->product_name }}" class="w-full h-full object-cover">
                                            </div>
                                            <div>
                                                <h4 class="font-bold text-gray-900 line-clamp-1">{{ $item->product_name }}</h4>
                                                <p class="text-sm text-gray-500">{{ $item->quantity }} x {{ $item->formatted_price }}</p>
                                            </div>
                                        </div>
                                    @endforeach
                                    
                                    @if($order->items->count() > 2)
                                        <div class="text-sm text-gray-500 italic mt-2">
                                            + {{ $order->items->count() - 2 }} produk lainnya
                                        </div>
                                    @endif
                                </div>
                                
                                <div class="hidden md:block w-px bg-gray-100"></div>
                                
                                <div class="md:w-48 flex flex-col justify-between pt-4 md:pt-0 border-t md:border-t-0 border-gray-100">
                                    <div>
                                        <span class="text-xs text-gray-500 block mb-1">Total Tagihan</span>
                                        <span class="text-lg font-bold text-emerald-600">{{ $order->formatted_total }}</span>
                                    </div>
                                    <div class="mt-4 flex flex-col gap-2">
                                        <a href="{{ route('orders.show', $order->order_number) }}" class="btn-primary w-full shadow-sm">Detail Pesanan</a>
                                    </div>
                                </div>
                            </div>
                            
                            {{-- Mobile Total & Action --}}
                            <div class="md:hidden mt-4 pt-4 border-t border-gray-100 flex items-center justify-between">
                                <div>
                                    <span class="text-xs text-gray-500 block">Total Tagihan</span>
                                    <span class="font-bold text-emerald-600">{{ $order->formatted_total }}</span>
                                </div>
                                <a href="{{ route('orders.show', $order->order_number) }}" class="btn-primary btn-sm">Detail</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-8">
                {{ $orders->links() }}
            </div>
        @endif
    </div>
</x-app-layout>
