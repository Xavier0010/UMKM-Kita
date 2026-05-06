<div>
<!-- ============================================ -->
<!-- NAVBAR -->
<!-- ============================================ -->
<nav class="navbar">
    <div class="nav-inner">
        <a href="/" class="nav-logo">🛒 <span>UMKM Kita</span></a>
        
        <div class="nav-search" id="navSearch">
            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari produk...">
            <button class="search-btn">🔍</button>
        </div>

        <div class="nav-actions">
            @if(Auth::check())
            <div class="nav-user-info">
                <div class="user-avatar">{{ strtoupper(substr($user->name, 0, 1)) }}</div>
                <div class="user-details">
                    <span class="user-name">{{ $user->name }}</span>
                    <span class="user-role-badge role-{{ strtolower($user->role ?? 'user') }}">{{ ucfirst($user->role ?? 'User') }}</span>
                </div>
            </div>
            <button wire:click="logout" class="btn-logout" title="Logout" onclick="return confirm('Yakin ingin keluar?')">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
            </button>
            @else
            <a href="{{ route('authentication', ['tab' => 'login']) }}" class="btn-cta" style="padding: 8px 16px;">Login</a>
            @endif
        </div>

        <button class="nav-toggle" onclick="toggleMobileMenu()">☰</button>
    </div>
</nav>

<!-- Mobile Menu -->
<div class="mobile-menu" id="mobileMenu" wire:ignore.self>
    <div class="mobile-search">
        <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari produk...">
    </div>
    @if(Auth::check())
    <div class="mobile-user">
        <span>Halo, {{ $user->name }}</span>
        <button wire:click="logout" class="btn-logout-mobile">Logout</button>
    </div>
    @else
    <div class="mobile-user">
        <a href="{{ route('authentication', ['tab' => 'login']) }}" class="btn-logout-mobile" style="color:#2563eb; background:#dbeafe;">Login</a>
    </div>
    @endif
</div>

<main class="main-content">

    <!-- ============================================ -->
    <!-- WELCOME BANNER -->
    <!-- ============================================ -->
    <section class="welcome-banner">
        <div class="welcome-text">
            <span class="welcome-badge">🎉 Selamat Datang</span>
            <h1>Halo, {{ $user->name }}!</h1>
            <p>Temukan produk UMKM lokal terbaik. Pesan langsung via WhatsApp — mudah dan cepat.</p>
            <a href="#katalog" class="btn-cta">Jelajahi Produk</a>
        </div>
        <div class="welcome-illustration">
            <div class="welcome-shapes">
                <div class="shape shape-1"></div>
                <div class="shape shape-2"></div>
                <div class="shape shape-3"></div>
            </div>
            <span class="welcome-emoji">🛍️</span>
        </div>
    </section>

    <!-- ============================================ -->
    <!-- SUMMARY CARDS -->
    <!-- ============================================ -->
    <section class="summary-section">
        <div class="summary-grid">
            <div class="summary-card card-blue">
                <div class="summary-icon">📦</div>
                <div class="summary-info">
                    <h3>0</h3>
                    <p>Pesanan</p>
                </div>
            </div>
            <div class="summary-card card-pink">
                <div class="summary-icon">❤️</div>
                <div class="summary-info">
                    <h3>0</h3>
                    <p>Wishlist</p>
                </div>
            </div>
            <div class="summary-card card-green">
                <div class="summary-icon">💰</div>
                <div class="summary-info">
                    <h3>Rp 0</h3>
                    <p>Total Belanja</p>
                </div>
            </div>
            <div class="summary-card card-orange">
                <div class="summary-icon">🏷️</div>
                <div class="summary-info">
                    <h3>{{ $total_produk }}</h3>
                    <p>Produk Tersedia</p>
                </div>
            </div>
        </div>
    </section>

    <!-- ============================================ -->
    <!-- REKOMENDASI PRODUK -->
    <!-- ============================================ -->
    @if(empty($search))
    <section class="rekomendasi-section">
        <h2 class="section-title">Rekomendasi Untuk Anda ✨</h2>
        <div class="rekomendasi-grid">
            @foreach($rekomendasi as $rec)
            <div class="rekom-card">
                <img src="{{ $rec->main_image ? asset('storage/'.$rec->main_image) : asset('assets/images/'.$rec->id.'.jpg') }}" 
                     alt="{{ $rec->name }}"
                     onerror="this.src='https://placehold.co/400x220/e2e8f0/64748b?text=Foto+Produk'">
                <div class="rekom-info">
                    <span class="rekom-badge">Umum</span>
                    <h4>{{ $rec->name }}</h4>
                    <p class="rekom-price">Rp {{ number_format($rec->price, 0, ',', '.') }}</p>
                    <a href="#produk-{{ $rec->id }}" class="rekom-link">Lihat Detail →</a>
                </div>
            </div>
            @endforeach
        </div>
    </section>
    @endif

    <!-- ============================================ -->
    <!-- KATEGORI -->
    <!-- ============================================ -->
    <section class="kategori-section" id="katalog">
        <div class="section-header">
            <h2 class="section-title">Katalog Produk</h2>
            <div class="filter-buttons">
                <button class="filter-btn {{ $kategoriFilter == 'semua' ? 'active' : '' }}" wire:click="filterKategori('semua')">Semua</button>
                @foreach($kategori_list as $kat)
                    <button class="filter-btn {{ $kategoriFilter == $kat ? 'active' : '' }}" wire:click="filterKategori('{{ $kat }}')">{{ $kat }}</button>
                @endforeach
            </div>
        </div>
    </section>

    <!-- ============================================ -->
    <!-- KATALOG PRODUK -->
    <!-- ============================================ -->
    <section class="katalog-section">
        <div class="katalog" id="katalogGrid">
            @foreach($all_produk as $row)
            <div class="card" id="produk-{{ $row->id }}">
                <div class="card-image-wrapper">
                    <img src="{{ $row->main_image ? asset('storage/'.$row->main_image) : asset('assets/images/'.$row->id.'.jpg') }}" 
                         alt="{{ $row->name }}"
                         onerror="this.src='https://placehold.co/400x220/e2e8f0/64748b?text=Foto+Produk'">
                    <span class="card-badge">{{ $row->kategori_name ?? 'Umum' }}</span>
                </div>
                <div class="card-body">
                    <h3 class="card-title">{{ $row->name }}</h3>
                    <p class="card-desc">{{ $row->description }}</p>
                    <p class="card-price">Rp {{ number_format($row->price, 0, ',', '.') }}</p>
                    
                    <form wire:submit.prevent="pesan({{ $row->id }}, '{{ $row->name }}', $event.target.jumlah.value)">
                        <div class="form-group">
                            <label>Jumlah</label>
                            <input type="number" name="jumlah" value="1" min="1" class="input-form" required>
                        </div>
                        <button type="submit" class="btn-pesan">
                            <svg viewBox="0 0 24 24" width="16" height="16" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51a12.8 12.8 0 0 0-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413z"/></svg>
                            Pesan via WhatsApp
                        </button>
                    </form>
                </div>
            </div>
            @endforeach
        </div>
    </section>

    <!-- ============================================ -->
    <!-- KONTAK -->
    <!-- ============================================ -->
    <section class="kontak-section" id="kontak">
        <h2 class="section-title" style="color:#fff;">Hubungi Kami</h2>
        <div class="kontak-grid">
            <div class="kontak-item">
                <span class="kontak-icon">📍</span>
                <h4>Alamat</h4>
                <p>Jl. UMKM Sejahtera No. 123, Sidoarjo, Jawa Timur</p>
            </div>
            <div class="kontak-item">
                <span class="kontak-icon">📞</span>
                <h4>Telepon</h4>
                <p>081234567890</p>
            </div>
            <div class="kontak-item">
                <span class="kontak-icon">✉️</span>
                <h4>Email</h4>
                <p>info@umkmkita.com</p>
            </div>
        </div>
    </section>

</main>

<script>
function toggleMobileMenu() {
    document.getElementById('mobileMenu').classList.toggle('show');
}
</script>
</div>
