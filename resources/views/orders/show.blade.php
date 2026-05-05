<x-app-layout>
    <x-slot name="title">Detail Pesanan {{ $order->order_number }}</x-slot>

    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8 md:py-12">
        
        <div class="flex items-center gap-4 mb-6">
            <a href="{{ route('orders.index') }}" class="text-gray-400 hover:text-emerald-600 transition-colors p-2 -ml-2 rounded-xl hover:bg-emerald-50">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            </a>
            <h1 class="text-2xl sm:text-3xl font-bold font-heading text-gray-900">Detail Pesanan</h1>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2 space-y-6">
                
                {{-- Status Card --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                        <div>
                            <span class="text-sm text-gray-500 block mb-1">Nomor Pesanan</span>
                            <span class="text-xl font-bold text-gray-900">{{ $order->order_number }}</span>
                        </div>
                        <div class="text-left sm:text-right">
                            <span class="text-sm text-gray-500 block mb-1">Status Pesanan</span>
                            <span class="badge badge-{{ $order->status_color }} text-sm px-3 py-1">{{ $order->status_label }}</span>
                        </div>
                    </div>
                    <div class="mt-4 pt-4 border-t border-gray-100 text-sm text-gray-500 flex gap-4">
                        <div><span class="font-medium text-gray-700">Tanggal:</span> {{ $order->created_at->format('d M Y, H:i') }}</div>
                    </div>
                </div>

                {{-- Product List --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="bg-gray-50 px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <span>🏪</span>
                            <h3 class="font-bold text-gray-900">{{ $order->store->name }}</h3>
                        </div>
                        <a href="{{ route('stores.show', $order->store->slug) }}" class="text-sm font-medium text-emerald-600 hover:text-emerald-700">Kunjungi Toko</a>
                    </div>
                    
                    <div class="divide-y divide-gray-100">
                        @foreach($order->items as $item)
                        <div class="p-6 flex flex-col sm:flex-row gap-4">
                            <img src="{{ $item->product->main_image_url }}" alt="{{ $item->product_name }}" class="w-20 h-20 rounded-xl object-cover border border-gray-100">
                            <div class="flex-1">
                                <h4 class="font-bold text-gray-900">{{ $item->product_name }}</h4>
                                <p class="text-sm text-gray-500 mt-1">{{ $item->quantity }} x {{ $item->formatted_price }}</p>
                            </div>
                            <div class="text-right">
                                <span class="text-xs text-gray-500 block mb-1">Subtotal</span>
                                <span class="font-bold text-gray-900">{{ $item->formatted_subtotal }}</span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    
                    <div class="bg-gray-50 p-6 border-t border-gray-100">
                        <div class="flex justify-between items-center">
                            <span class="font-bold text-gray-700">Total Tagihan</span>
                            <span class="text-2xl font-bold text-emerald-600">{{ $order->formatted_total }}</span>
                        </div>
                    </div>
                </div>

            </div>

            <div class="space-y-6">
                
                {{-- Shipping Info --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <h3 class="font-bold text-gray-900 mb-4 pb-3 border-b border-gray-100 flex items-center gap-2">
                        <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        Info Pengiriman
                    </h3>
                    <div class="space-y-3 text-sm">
                        <div>
                            <span class="text-gray-500 block mb-0.5">Nama Penerima</span>
                            <span class="font-medium text-gray-900">{{ $order->shipping_name }}</span>
                        </div>
                        <div>
                            <span class="text-gray-500 block mb-0.5">Nomor HP/WA</span>
                            <span class="font-medium text-gray-900">{{ $order->shipping_phone }}</span>
                        </div>
                        <div>
                            <span class="text-gray-500 block mb-0.5">Alamat</span>
                            <span class="font-medium text-gray-900 leading-relaxed block">{{ $order->shipping_address }}</span>
                        </div>
                        @if($order->notes)
                        <div class="pt-2">
                            <span class="text-gray-500 block mb-0.5">Catatan</span>
                            <span class="font-medium text-gray-900 italic">"{{ $order->notes }}"</span>
                        </div>
                        @endif
                    </div>
                </div>

                {{-- Payment Info --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <h3 class="font-bold text-gray-900 mb-4 pb-3 border-b border-gray-100 flex items-center gap-2">
                        <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                        Info Pembayaran
                    </h3>
                    
                    <div class="mb-4">
                        <span class="text-gray-500 block text-sm mb-1">Metode Pembayaran</span>
                        <div class="font-bold text-gray-900 flex items-center gap-2">
                            @if($order->payment_method === 'qris')
                                <span class="badge badge-blue">QRIS</span>
                            @else
                                <span class="badge badge-emerald">Manual / WhatsApp</span>
                            @endif
                        </div>
                    </div>

                    @if($order->payment_proof)
                        <div class="mt-4">
                            <span class="text-gray-500 block text-sm mb-2">Bukti Pembayaran</span>
                            <a href="{{ asset('storage/' . $order->payment_proof) }}" target="_blank" class="block border border-gray-200 rounded-xl overflow-hidden hover:opacity-90 transition-opacity">
                                <img src="{{ asset('storage/' . $order->payment_proof) }}" class="w-full h-32 object-cover">
                            </a>
                        </div>
                    @endif

                    @if($order->payment_method === 'whatsapp' && in_array($order->status, ['pending', 'confirmed']))
                        @php
                            $waText = "Halo, saya menanyakan status pesanan di UMKM Kita.%0A%0A";
                            $waText .= "*No Pesanan:* {$order->order_number}%0A";
                            
                            $number = preg_replace('/[^0-9]/', '', $order->store->whatsapp);
                            if (str_starts_with($number, '0')) $number = '62' . substr($number, 1);
                            $waLink = "https://wa.me/{$number}?text={$waText}";
                        @endphp
                        <a href="{{ $waLink }}" target="_blank" class="btn-primary w-full mt-6 bg-[#25D366] hover:bg-[#1da851] border-none shadow-sm flex justify-center">
                            Chat Penjual via WA
                        </a>
                    @endif
                </div>

            </div>
        </div>

    </div>
</x-app-layout>
