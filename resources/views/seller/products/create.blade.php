<x-seller-layout>
    <x-slot name="title">Tambah Produk</x-slot>

    <div class="max-w-4xl">
        <div class="flex items-center gap-4 mb-6">
            <a href="{{ route('seller.products.index') }}" class="text-gray-400 hover:text-emerald-600 transition-colors p-2 -ml-2 rounded-xl hover:bg-emerald-50">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            </a>
            <h2 class="text-xl font-bold font-heading text-gray-900">Tambah Produk Baru</h2>
        </div>

        <form action="{{ route('seller.products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h3 class="font-bold text-gray-900 mb-4 border-b border-gray-100 pb-3">Informasi Dasar</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="md:col-span-2">
                        <label class="form-label">Nama Produk <span class="text-red-500">*</span></label>
                        <input type="text" name="name" value="{{ old('name') }}" required class="form-input" placeholder="Contoh: Keripik Tempe Aneka Rasa">
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div>
                        <label class="form-label">Kategori <span class="text-red-500">*</span></label>
                        <select name="category_id" required class="form-select">
                            <option value="">Pilih Kategori</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
                    </div>

                    <div>
                        <label class="form-label">Status Produk</label>
                        <select name="is_active" class="form-select">
                            <option value="1" {{ old('is_active', '1') == '1' ? 'selected' : '' }}>Aktif (Tampilkan)</option>
                            <option value="0" {{ old('is_active') == '0' ? 'selected' : '' }}>Nonaktif (Sembunyikan)</option>
                        </select>
                        <x-input-error :messages="$errors->get('is_active')" class="mt-2" />
                    </div>

                    <div class="md:col-span-2">
                        <label class="form-label">Deskripsi Lengkap <span class="text-red-500">*</span></label>
                        <textarea name="description" rows="5" required class="form-input" placeholder="Jelaskan detail produk, bahan, ukuran, dan keunggulannya...">{{ old('description') }}</textarea>
                        <x-input-error :messages="$errors->get('description')" class="mt-2" />
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h3 class="font-bold text-gray-900 mb-4 border-b border-gray-100 pb-3">Harga & Stok</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="form-label">Harga (Rp) <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-500 font-medium">Rp</span>
                            <input type="number" name="price" value="{{ old('price') }}" min="0" required class="form-input pl-10" placeholder="0">
                        </div>
                        <x-input-error :messages="$errors->get('price')" class="mt-2" />
                    </div>

                    <div>
                        <label class="form-label">Stok Tersedia <span class="text-red-500">*</span></label>
                        <input type="number" name="stock" value="{{ old('stock', 1) }}" min="0" required class="form-input" placeholder="0">
                        <x-input-error :messages="$errors->get('stock')" class="mt-2" />
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h3 class="font-bold text-gray-900 mb-4 border-b border-gray-100 pb-3">Foto Produk</h3>
                
                <div class="space-y-6">
                    <div>
                        <label class="form-label">Foto Utama <span class="text-red-500">*</span></label>
                        <p class="text-xs text-gray-500 mb-2">Foto ini akan ditampilkan di halaman katalog. Format: JPG, PNG. Maks: 2MB.</p>
                        <input type="file" name="main_image" accept="image/jpeg,image/png,image/jpg" required class="form-input py-2">
                        <x-input-error :messages="$errors->get('main_image')" class="mt-2" />
                    </div>

                    <div>
                        <label class="form-label">Foto Galeri Tambahan (Maks 4 Foto)</label>
                        <p class="text-xs text-gray-500 mb-2">Pilih beberapa foto sekaligus dengan menahan tombol Ctrl/Cmd.</p>
                        <input type="file" name="gallery[]" accept="image/jpeg,image/png,image/jpg" multiple class="form-input py-2">
                        <x-input-error :messages="$errors->get('gallery')" class="mt-2" />
                    </div>
                </div>
            </div>

            <div class="flex justify-end gap-4">
                <a href="{{ route('seller.products.index') }}" class="btn-outline">Batal</a>
                <button type="submit" class="btn-primary shadow-md">Simpan Produk</button>
            </div>
        </form>
    </div>
</x-seller-layout>
