<div>
<nav class="navbar">
    <div class="nav-inner">
        <a href="/" class="nav-logo">🛒 <span>UMKM Kita</span></a>
        
        <div class="nav-search" id="navSearch">
            <input type="text" disabled placeholder="Wishlist" style="background: transparent;">
        </div>

        <div class="nav-actions">
            <a href="{{ route('home') }}" class="btn-outline" style="padding: 6px 12px; font-size: 14px; margin-right: 8px;">🏠 Kembali ke Katalog</a>
        </div>
    </div>
</nav>

<main class="main-content">
    <h2 class="section-title">Wishlist Anda ❤️</h2>

    @if(session()->has('message'))
        <div style="background: #dcfce7; color: #166534; padding: 16px; border-radius: 12px; margin-bottom: 24px; font-weight: 500;">
            {{ session('message') }}
        </div>
    @endif

    @if($wishlists->isEmpty())
        <div style="background: #fff; border-radius: 16px; padding: 40px; text-align: center; border: 1px solid #f1f5f9; box-shadow: 0 1px 3px rgba(0,0,0,0.04);">
            <div style="font-size: 3rem; margin-bottom: 16px;">❤️</div>
            <h3>Wishlist Anda kosong.</h3>
            <p style="color: #64748b; margin-top: 8px; margin-bottom: 24px;">Simpan produk yang Anda sukai di sini untuk dibeli nanti.</p>
            <a href="{{ route('home') }}" class="btn-cta">Jelajahi Katalog</a>
        </div>
    @else
        <div class="katalog">
            @foreach($wishlists as $wishlist)
                <div class="card" id="wishlist-{{ $wishlist->id }}">
                    <div class="card-image-wrapper">
                        <img src="{{ $wishlist->product->main_image ? asset('storage/'.$wishlist->product->main_image) : 'https://placehold.co/400x220/e2e8f0/64748b?text=Produk' }}" 
                             alt="{{ $wishlist->product->name ?? 'Produk Dihapus' }}"
                             onerror="this.src='https://placehold.co/400x220/e2e8f0/64748b?text=Foto+Produk'">
                        <button wire:click="removeItem({{ $wishlist->id }})" style="position: absolute; top: 12px; right: 12px; background: rgba(255,255,255,0.9); border: none; width: 32px; height: 32px; border-radius: 50%; cursor: pointer; color: #ef4444; font-size: 1.2rem; display: flex; align-items: center; justify-content: center; box-shadow: 0 2px 5px rgba(0,0,0,0.1);" title="Hapus dari Wishlist">
                            ×
                        </button>
                    </div>
                    <div class="card-body">
                        <h3 class="card-title">{{ $wishlist->product->name ?? 'Produk Dihapus' }}</h3>
                        <p class="card-price">Rp {{ number_format($wishlist->product->price ?? 0, 0, ',', '.') }}</p>
                        
                        <div style="margin-top: auto;">
                            @if($wishlist->product)
                                <button wire:click="pesan({{ $wishlist->product->id }}, '{{ addslashes($wishlist->product->name) }}')" class="btn-pesan" style="width: 100%; cursor: pointer;">
                                    <svg viewBox="0 0 24 24" width="16" height="16" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51a12.8 12.8 0 0 0-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413z"/></svg>
                                    Pesan via WhatsApp
                                </button>
                            @else
                                <button class="btn-pesan" disabled style="width: 100%; background: #94a3b8; cursor: not-allowed;">
                                    Produk Tidak Tersedia
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</main>
</div>
