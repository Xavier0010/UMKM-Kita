<x-guest-layout>
    <div class="mb-6 text-center">
        <a href="/" class="inline-block">
            <div class="w-12 h-12 bg-emerald-600 rounded-xl flex items-center justify-center mx-auto mb-3 shadow-sm">
                <span class="text-white font-bold text-xl">U</span>
            </div>
            <h2 class="text-2xl font-bold text-gray-900 font-heading">Daftar Akun Baru</h2>
            <p class="text-sm text-gray-500 mt-1">Mulai perjalananmu bersama UMKM Kita</p>
        </a>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        <!-- Name -->
        <div>
            <label for="name" class="form-label">Nama Lengkap</label>
            <input id="name" class="form-input" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div>
            <label for="email" class="form-label">Email</label>
            <input id="email" class="form-input" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="form-label">Password</label>
            <input id="password" class="form-input" type="password" name="password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div>
            <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
            <input id="password_confirmation" class="form-input" type="password" name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- Role Selection -->
        <div class="pt-2">
            <label class="form-label">Daftar Sebagai</label>
            <div class="grid grid-cols-2 gap-3 mt-1">
                <label class="relative cursor-pointer">
                    <input type="radio" name="role" value="buyer" class="peer sr-only" checked>
                    <div class="px-4 py-3 rounded-xl border-2 border-gray-200 peer-checked:border-emerald-500 peer-checked:bg-emerald-50 hover:bg-gray-50 transition-all">
                        <div class="flex flex-col items-center text-center gap-1">
                            <span class="text-2xl">🛍️</span>
                            <span class="font-semibold text-gray-900 text-sm">Pembeli</span>
                            <span class="text-xs text-gray-500">Mulai berbelanja</span>
                        </div>
                    </div>
                </label>
                
                <label class="relative cursor-pointer">
                    <input type="radio" name="role" value="seller" class="peer sr-only">
                    <div class="px-4 py-3 rounded-xl border-2 border-gray-200 peer-checked:border-amber-500 peer-checked:bg-amber-50 hover:bg-gray-50 transition-all">
                        <div class="flex flex-col items-center text-center gap-1">
                            <span class="text-2xl">🏪</span>
                            <span class="font-semibold text-gray-900 text-sm">Penjual</span>
                            <span class="text-xs text-gray-500">Buka toko UMKM</span>
                        </div>
                    </div>
                </label>
            </div>
            <x-input-error :messages="$errors->get('role')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between mt-6 pt-4 border-t border-gray-100">
            <a class="text-sm text-emerald-600 hover:text-emerald-700 font-medium" href="{{ route('login') }}">
                Sudah punya akun?
            </a>

            <button type="submit" class="btn-primary">
                Daftar Sekarang
            </button>
        </div>
    </form>
</x-guest-layout>
