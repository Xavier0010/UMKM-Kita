<x-app-layout>
    <x-slot name="title">Checkout</x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 md:py-12">
        <h1 class="text-3xl font-bold font-heading text-gray-900 mb-8">Checkout</h1>

        <form action="{{ route('checkout.process') }}" method="POST" enctype="multipart/form-data" class="flex flex-col lg:flex-row gap-8 items-start" x-data="{ paymentMethod: 'whatsapp' }">
            @csrf

            <div class="w-full lg:w-2/3 space-y-6">
                {{-- Alamat Pengiriman --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sm:p-8">
                    <h3 class="font-bold text-gray-900 text-lg mb-6 flex items-center gap-2">
                        <span class="w-8 h-8 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center text-sm font-bold">1</span>
                        Informasi Pengiriman
                    </h3>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <label class="form-label">Nama Penerima</label>
                            <input type="text" name="shipping_name" value="{{ auth()->user()->name }}" required class="form-input">
                        </div>
                        <div>
                            <label class="form-label">Nomor Telepon / WA</label>
                            <input type="text" name="shipping_phone" value="{{ auth()->user()->phone }}" required class="form-input">
                        </div>
                        <div class="sm:col-span-2">
                            <label class="form-label">Alamat Lengkap</label>
                            <textarea name="shipping_address" rows="3" required class="form-input">{{ auth()->user()->address }}</textarea>
                            <p class="text-xs text-gray-500 mt-1">Mohon sertakan nama jalan, nomor rumah, RT/RW, kecamatan, dan kota/kabupaten.</p>
                        </div>
                        <div class="sm:col-span-2">
                            <label class="form-label">Catatan Pesanan (Opsional)</label>
                            <textarea name="notes" rows="2" class="form-input" placeholder="Contoh: Tolong packing kayu, warna merah ya kak..."></textarea>
                        </div>
                    </div>
                </div>

                {{-- Metode Pembayaran --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sm:p-8">
                    <h3 class="font-bold text-gray-900 text-lg mb-6 flex items-center gap-2">
                        <span class="w-8 h-8 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center text-sm font-bold">2</span>
                        Metode Pembayaran
                    </h3>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6">
                        <label class="relative cursor-pointer">
                            <input type="radio" name="payment_method" value="whatsapp" x-model="paymentMethod" class="peer sr-only">
                            <div class="p-4 rounded-xl border-2 peer-checked:border-emerald-500 peer-checked:bg-emerald-50 bg-white hover:bg-gray-50 transition-all flex items-center gap-3">
                                <div class="w-10 h-10 bg-[#25D366]/20 rounded-full flex items-center justify-center text-[#25D366]">
                                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51a12.8 12.8 0 00-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/></svg>
                                </div>
                                <div>
                                    <h4 class="font-bold text-gray-900 text-sm">Transfer Manual / WhatsApp</h4>
                                    <p class="text-xs text-gray-500">Hubungi penjual setelah checkout</p>
                                </div>
                            </div>
                        </label>
                        
                        <label class="relative cursor-pointer">
                            <input type="radio" name="payment_method" value="qris" x-model="paymentMethod" class="peer sr-only">
                            <div class="p-4 rounded-xl border-2 peer-checked:border-emerald-500 peer-checked:bg-emerald-50 bg-white hover:bg-gray-50 transition-all flex items-center gap-3">
                                <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 font-bold font-heading text-sm">
                                    QRIS
                                </div>
                                <div>
                                    <h4 class="font-bold text-gray-900 text-sm">QRIS</h4>
                                    <p class="text-xs text-gray-500">Upload bukti transfer</p>
                                </div>
                            </div>
                        </label>
                    </div>

                    {{-- QRIS Section --}}
                    <div x-show="paymentMethod === 'qris'" x-cloak class="bg-blue-50 border border-blue-100 rounded-xl p-5 mb-4 animate-fade-in">
                        <div class="flex flex-col sm:flex-row gap-6">
                            <div class="flex-1 space-y-4">
                                <h4 class="font-bold text-blue-900">Pembayaran QRIS</h4>
                                <p class="text-sm text-blue-800">Scan kode QR yang tersedia di masing-masing toko. Kemudian upload bukti pembayaran di bawah ini.</p>
                                <div>
                                    <label class="form-label text-blue-900">Upload Bukti Pembayaran <span class="text-red-500">*</span></label>
                                    <input type="file" name="payment_proof" accept="image/*" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-100 file:text-blue-700 hover:file:bg-blue-200" :required="paymentMethod === 'qris'">
                                </div>
                            </div>
                            
                            <div class="w-full sm:w-48 bg-white p-3 rounded-xl shadow-sm text-center border border-gray-100">
                                <p class="text-xs text-gray-500 mb-2">QRIS Toko ada di halaman detail toko masing-masing.</p>
                                <svg class="w-16 h-16 mx-auto text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/></svg>
                            </div>
                        </div>
                    </div>
                    
                    <div x-show="paymentMethod === 'whatsapp'" class="bg-[#25D366]/10 border border-[#25D366]/20 rounded-xl p-5 animate-fade-in">
                        <p class="text-sm text-[#075E54] flex gap-3">
                            <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/></svg>
                            <span>Setelah membuat pesanan, sistem akan mengarahkan Anda ke WhatsApp penjual untuk konfirmasi pembayaran secara manual.</span>
                        </p>
                    </div>
                </div>
            </div>

            {{-- Ringkasan Pesanan --}}
            <div class="w-full lg:w-1/3">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sticky top-24">
                    <h3 class="font-bold text-gray-900 text-lg mb-6 flex items-center gap-2">
                        <span class="w-8 h-8 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center text-sm font-bold">3</span>
                        Ringkasan Pesanan
                    </h3>
                    
                    @php $grandTotal = 0; @endphp
                    <div class="space-y-6 max-h-[60vh] overflow-y-auto pr-2 scrollbar-thin">
                        @foreach($cartsByStore as $storeId => $storeCarts)
                            @php 
                                $store = $storeCarts->first()->product->store;
                                $storeSubtotal = $storeCarts->sum('subtotal');
                                $grandTotal += $storeSubtotal;
                            @endphp
                            <div class="border-b border-gray-100 pb-4 last:border-0 last:pb-0">
                                <div class="text-xs font-semibold text-gray-500 mb-3 flex items-center gap-1 uppercase tracking-wide">
                                    <span>🏪</span> {{ $store->name }}
                                </div>
                                <div class="space-y-3">
                                    @foreach($storeCarts as $cart)
                                        <div class="flex justify-between text-sm">
                                            <div class="flex gap-3">
                                                <img src="{{ $cart->product->main_image_url }}" class="w-10 h-10 rounded border object-cover">
                                                <div>
                                                    <p class="font-medium text-gray-900 line-clamp-1">{{ $cart->product->name }}</p>
                                                    <p class="text-gray-500">{{ $cart->quantity }} x {{ $cart->product->formatted_price }}</p>
                                                </div>
                                            </div>
                                            <div class="font-semibold text-gray-900 whitespace-nowrap">
                                                {{ $cart->formatted_subtotal }}
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                    
                    <div class="divider border-dashed mb-4 mt-6"></div>
                    
                    <div class="flex justify-between items-center mb-8">
                        <span class="font-bold text-gray-900">Total Pembayaran</span>
                        <span class="font-bold text-xl text-emerald-600">Rp {{ number_format($grandTotal, 0, ',', '.') }}</span>
                    </div>

                    <button type="submit" class="btn-primary w-full h-12 text-base shadow-md group">
                        Buat Pesanan
                        <svg class="w-5 h-5 ml-1 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                    </button>
                    <p class="text-xs text-center text-gray-500 mt-4">Pesanan Anda akan dipisah berdasarkan toko.</p>
                </div>
            </div>
        </form>
    </div>
</x-app-layout>
