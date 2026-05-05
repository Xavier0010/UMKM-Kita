<x-guest-layout>
    <div class="mb-6 text-center">
        <div class="w-16 h-16 bg-amber-100 text-amber-500 rounded-full flex items-center justify-center text-3xl mx-auto mb-4 shadow-inner">
            🏪
        </div>
        <h2 class="text-2xl font-bold text-gray-900 font-heading">Daftar Toko UMKM</h2>
        <p class="text-sm text-gray-500 mt-1">Lengkapi profil tokomu untuk mulai berjualan</p>
    </div>

    <form method="POST" action="{{ route('seller.store.store') }}" enctype="multipart/form-data" class="space-y-4">
        @csrf

        <div>
            <label for="name" class="form-label">Nama Toko</label>
            <input id="name" class="form-input" type="text" name="name" :value="old('name')" required autofocus />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <div>
            <label for="city" class="form-label">Kota / Kabupaten</label>
            <input id="city" class="form-input" type="text" name="city" :value="old('city')" required placeholder="Contoh: Sidoarjo" />
            <x-input-error :messages="$errors->get('city')" class="mt-2" />
        </div>

        <div>
            <label for="address" class="form-label">Alamat Lengkap Toko</label>
            <textarea id="address" class="form-input" name="address" rows="3" required>{{ old('address') }}</textarea>
            <x-input-error :messages="$errors->get('address')" class="mt-2" />
        </div>

        <div>
            <label for="whatsapp" class="form-label">Nomor WhatsApp Aktif</label>
            <input id="whatsapp" class="form-input" type="text" name="whatsapp" :value="old('whatsapp')" required placeholder="08123456789" />
            <x-input-error :messages="$errors->get('whatsapp')" class="mt-2" />
        </div>

        <div>
            <label for="description" class="form-label">Deskripsi Toko</label>
            <textarea id="description" class="form-input" name="description" rows="3" required placeholder="Jelaskan apa saja yang dijual di tokomu...">{{ old('description') }}</textarea>
            <x-input-error :messages="$errors->get('description')" class="mt-2" />
        </div>

        <div>
            <label for="logo" class="form-label">Logo Toko (Opsional)</label>
            <input id="logo" class="form-input py-2" type="file" name="logo" accept="image/*" />
            <x-input-error :messages="$errors->get('logo')" class="mt-2" />
        </div>

        <div class="mt-6">
            <button type="submit" class="btn-primary w-full shadow-md bg-amber-500 hover:bg-amber-600 focus:ring-amber-500 border-none">
                Daftarkan Toko Sekarang
            </button>
        </div>
    </form>
</x-guest-layout>
