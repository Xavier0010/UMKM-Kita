<x-app-layout>
    <x-slot name="title">Keranjang Belanja</x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 md:py-12">
        <h1 class="text-3xl font-bold font-heading text-gray-900 mb-8">Keranjang Belanja</h1>

        @if($carts->isEmpty())
            <div class="bg-white rounded-3xl p-12 text-center border border-gray-100 shadow-sm max-w-2xl mx-auto">
                <div class="text-6xl mb-6">🛒</div>
                <h3 class="text-2xl font-bold text-gray-900 font-heading mb-2">Keranjangmu masih kosong</h3>
                <p class="text-gray-500 mb-8">Yuk, cari produk UMKM incaranmu sekarang!</p>
                <a href="{{ route('products.index') }}" class="btn-primary btn-lg">Mulai Belanja</a>
            </div>
        @else
            <div class="flex flex-col lg:flex-row gap-8 items-start">
                
                {{-- Daftar Keranjang --}}
                <div class="w-full lg:w-2/3 space-y-6">
                    @php $grandTotal = 0; @endphp
                    @foreach($carts as $storeName => $items)
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                            <div class="bg-gray-50 px-6 py-4 border-b border-gray-100 flex items-center gap-3">
                                <span>🏪</span>
                                <h3 class="font-bold text-gray-900 text-lg">{{ $storeName }}</h3>
                            </div>
                            
                            <div class="divide-y divide-gray-100">
                                @foreach($items as $item)
                                    @php $grandTotal += $item->subtotal; @endphp
                                    <div class="p-6 flex flex-col sm:flex-row gap-6">
                                        <div class="w-24 h-24 rounded-xl overflow-hidden flex-shrink-0 border border-gray-100">
                                            <img src="{{ $item->product->main_image_url }}" alt="{{ $item->product->name }}" class="w-full h-full object-cover">
                                        </div>
                                        
                                        <div class="flex-1">
                                            <a href="{{ route('products.show', $item->product->slug) }}" class="font-bold text-lg text-gray-900 hover:text-emerald-600 transition-colors line-clamp-2">
                                                {{ $item->product->name }}
                                            </a>
                                            <div class="font-bold text-emerald-600 mt-1 mb-4">{{ $item->product->formatted_price }}</div>
                                            
                                            <div class="flex items-center justify-between">
                                                <form action="{{ route('cart.update', $item->id) }}" method="POST" class="flex items-center border border-gray-200 rounded-xl bg-white shadow-sm h-10 w-32" x-data="{ qty: {{ $item->quantity }} }">
                                                    @csrf @method('PUT')
                                                    <button type="button" @click="if(qty > 1) { qty--; $el.form.submit() }" class="w-10 h-full text-gray-500 hover:text-emerald-600 focus:outline-none flex items-center justify-center font-bold text-lg hover:bg-gray-50 rounded-l-xl transition-colors">-</button>
                                                    <input type="number" name="quantity" x-model="qty" min="1" max="{{ $item->product->stock }}" class="w-full text-center border-none focus:ring-0 text-gray-900 font-semibold p-0 h-full bg-transparent" readonly>
                                                    <button type="button" @click="if(qty < {{ $item->product->stock }}) { qty++; $el.form.submit() }" class="w-10 h-full text-gray-500 hover:text-emerald-600 focus:outline-none flex items-center justify-center font-bold text-lg hover:bg-gray-50 rounded-r-xl transition-colors">+</button>
                                                </form>

                                                <form action="{{ route('cart.destroy', $item->id) }}" method="POST">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="text-red-500 hover:text-red-600 p-2 rounded-lg hover:bg-red-50 transition-colors" onclick="return confirm('Hapus produk dari keranjang?')">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Ringkasan Belanja --}}
                <div class="w-full lg:w-1/3">
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sticky top-24">
                        <h3 class="font-bold text-gray-900 text-lg mb-6 pb-4 border-b border-gray-100">Ringkasan Belanja</h3>
                        
                        <div class="space-y-4 mb-6">
                            <div class="flex justify-between text-gray-600">
                                <span>Total Belanja ({{ auth()->user()->carts->sum('quantity') }} produk)</span>
                                <span class="font-semibold text-gray-900">Rp {{ number_format($grandTotal, 0, ',', '.') }}</span>
                            </div>
                        </div>
                        
                        <div class="divider border-dashed mb-4"></div>
                        
                        <div class="flex justify-between items-center mb-8">
                            <span class="font-bold text-gray-900">Total Tagihan</span>
                            <span class="font-bold text-xl text-emerald-600">Rp {{ number_format($grandTotal, 0, ',', '.') }}</span>
                        </div>

                        <a href="{{ route('checkout.index') }}" class="btn-primary w-full h-12 text-base shadow-md">
                            Lanjut ke Checkout
                        </a>
                        
                        <div class="mt-4 text-xs text-gray-500 flex items-center gap-2 justify-center bg-gray-50 py-2 rounded-xl">
                            <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                            Transaksi aman & terenkripsi
                        </div>
                    </div>
                </div>

            </div>
        @endif
    </div>
</x-app-layout>
