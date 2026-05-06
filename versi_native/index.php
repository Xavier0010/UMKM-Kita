<?php 
require 'cek_login.php';
$user = currentUser();

// Ambil semua produk
$all_produk = mysqli_query($conn, "SELECT * FROM produk ORDER BY id DESC");

// Ambil daftar kategori
$kategori_list = mysqli_query($conn, "SELECT DISTINCT kategori FROM produk ORDER BY kategori ASC");
$kategori_arr = [];
while ($k = mysqli_fetch_assoc($kategori_list)) {
    $kategori_arr[] = $k['kategori'];
}

// Ambil rekomendasi (3 produk acak)
$rekomendasi = mysqli_query($conn, "SELECT * FROM produk ORDER BY RAND() LIMIT 3");

// Ambil total produk
$total_produk = mysqli_num_rows($all_produk);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard — UMKM Kita</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>

<!-- ============================================ -->
<!-- NAVBAR -->
<!-- ============================================ -->
<nav class="navbar">
    <div class="nav-inner">
        <a href="index.php" class="nav-logo">🛒 <span>UMKM Kita</span></a>
        
        <div class="nav-search" id="navSearch">
            <input type="text" id="searchInput" placeholder="Cari produk..." onkeyup="filterProduk()">
            <button class="search-btn">🔍</button>
        </div>

        <div class="nav-actions">
            <div class="nav-user-info">
                <div class="user-avatar"><?= strtoupper(substr($user['nama'], 0, 1)) ?></div>
                <div class="user-details">
                    <span class="user-name"><?= htmlspecialchars($user['nama']) ?></span>
                    <span class="user-role-badge role-<?= $user['role'] ?>"><?= ucfirst($user['role']) ?></span>
                </div>
            </div>
            <a href="logout.php" class="btn-logout" onclick="return confirm('Yakin ingin keluar?')">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
            </a>
        </div>

        <button class="nav-toggle" onclick="toggleMobileMenu()">☰</button>
    </div>
</nav>

<!-- Mobile Menu -->
<div class="mobile-menu" id="mobileMenu">
    <div class="mobile-search">
        <input type="text" placeholder="Cari produk..." onkeyup="filterProduk()">
    </div>
    <div class="mobile-user">
        <span>Halo, <?= htmlspecialchars($user['nama']) ?></span>
        <a href="logout.php" class="btn-logout-mobile">Logout</a>
    </div>
</div>

<main class="main-content">

    <!-- ============================================ -->
    <!-- WELCOME BANNER -->
    <!-- ============================================ -->
    <section class="welcome-banner">
        <div class="welcome-text">
            <span class="welcome-badge">🎉 Selamat Datang</span>
            <h1>Halo, <?= htmlspecialchars($user['nama']) ?>!</h1>
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
                    <h3><?= $total_produk ?></h3>
                    <p>Produk Tersedia</p>
                </div>
            </div>
        </div>
    </section>

    <!-- ============================================ -->
    <!-- AKTIVITAS TERAKHIR -->
    <!-- ============================================ -->
    <section class="activity-section">
        <h2 class="section-title">Aktivitas Terakhir</h2>
        <div class="activity-list">
            <div class="activity-item">
                <div class="activity-dot dot-blue"></div>
                <div class="activity-content">
                    <p class="activity-text">Akun berhasil dibuat.</p>
                    <span class="activity-time">Baru saja</span>
                </div>
            </div>
            <div class="activity-item">
                <div class="activity-dot dot-green"></div>
                <div class="activity-content">
                    <p class="activity-text">Login berhasil. Selamat menjelajah!</p>
                    <span class="activity-time">Hari ini</span>
                </div>
            </div>
            <div class="activity-empty-hint">
                <p>💡 Riwayat pesanan Anda akan muncul di sini setelah Anda memesan produk.</p>
            </div>
        </div>
    </section>

    <!-- ============================================ -->
    <!-- REKOMENDASI PRODUK -->
    <!-- ============================================ -->
    <section class="rekomendasi-section">
        <h2 class="section-title">Rekomendasi Untuk Anda ✨</h2>
        <div class="rekomendasi-grid">
            <?php while ($rec = mysqli_fetch_assoc($rekomendasi)): ?>
            <div class="rekom-card">
                <img src="assets/images/<?= htmlspecialchars($rec['gambar']) ?>" 
                     alt="<?= htmlspecialchars($rec['nama_produk']) ?>"
                     onerror="this.src='https://placehold.co/400x220/e2e8f0/64748b?text=Foto+Produk'">
                <div class="rekom-info">
                    <span class="rekom-badge"><?= htmlspecialchars($rec['kategori'] ?? 'Umum') ?></span>
                    <h4><?= htmlspecialchars($rec['nama_produk']) ?></h4>
                    <p class="rekom-price">Rp <?= number_format($rec['harga'], 0, ',', '.') ?></p>
                    <a href="#produk-<?= $rec['id'] ?>" class="rekom-link">Lihat Detail →</a>
                </div>
            </div>
            <?php endwhile; ?>
        </div>
    </section>

    <!-- ============================================ -->
    <!-- KATEGORI -->
    <!-- ============================================ -->
    <section class="kategori-section" id="katalog">
        <div class="section-header">
            <h2 class="section-title">Katalog Produk</h2>
            <div class="filter-buttons">
                <button class="filter-btn active" onclick="filterKategori('semua', this)">Semua</button>
                <?php foreach ($kategori_arr as $kat): ?>
                    <button class="filter-btn" onclick="filterKategori('<?= htmlspecialchars($kat) ?>', this)"><?= htmlspecialchars($kat) ?></button>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- ============================================ -->
    <!-- KATALOG PRODUK -->
    <!-- ============================================ -->
    <section class="katalog-section">
        <div class="katalog" id="katalogGrid">
            <?php
            // Reset pointer
            mysqli_data_seek($all_produk, 0);
            while ($row = mysqli_fetch_assoc($all_produk)):
            ?>
            <div class="card" data-kategori="<?= htmlspecialchars($row['kategori'] ?? 'Umum') ?>" data-nama="<?= htmlspecialchars(strtolower($row['nama_produk'])) ?>" id="produk-<?= $row['id'] ?>">
                <div class="card-image-wrapper">
                    <img src="assets/images/<?= htmlspecialchars($row['gambar']) ?>" 
                         alt="<?= htmlspecialchars($row['nama_produk']) ?>"
                         onerror="this.src='https://placehold.co/400x220/e2e8f0/64748b?text=Foto+Produk'">
                    <span class="card-badge"><?= htmlspecialchars($row['kategori'] ?? 'Umum') ?></span>
                </div>
                <div class="card-body">
                    <h3 class="card-title"><?= htmlspecialchars($row['nama_produk']) ?></h3>
                    <p class="card-desc"><?= htmlspecialchars($row['deskripsi']) ?></p>
                    <p class="card-price">Rp <?= number_format($row['harga'], 0, ',', '.') ?></p>
                    
                    <form action="proses.php" method="POST" onsubmit="return handlePesan(this)">
                        <input type="hidden" name="nama_produk" value="<?= htmlspecialchars($row['nama_produk']) ?>">
                        <input type="hidden" name="pembeli" value="<?= htmlspecialchars($user['nama']) ?>">
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
            <?php endwhile; ?>
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

<!-- FOOTER -->
<footer>
    <p>&copy; 2026 UMKM Kita — SMK Telkom Sidoarjo. Dibuat dengan ❤️ untuk UMKM lokal.</p>
</footer>

<!-- ============================================ -->
<!-- JAVASCRIPT -->
<!-- ============================================ -->
<script>
// --- Pesan via WA ---
function handlePesan(form) {
    let jumlah = form.jumlah.value;
    let nama_produk = form.nama_produk.value;
    if (jumlah < 1) { alert('Jumlah minimal 1.'); return false; }
    let yakin = confirm('Pesan ' + jumlah + 'x ' + nama_produk + '?\nAnda akan diarahkan ke WhatsApp.');
    if (!yakin) return false;
    let btn = form.querySelector('.btn-pesan');
    btn.innerHTML = 'Memproses... ⏳';
    btn.disabled = true;
    btn.style.opacity = '0.7';
    return true;
}

// --- Filter Kategori (JS tanpa reload) ---
function filterKategori(kategori, btn) {
    // Update active button
    document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');

    // Filter cards
    document.querySelectorAll('.card').forEach(card => {
        if (kategori === 'semua' || card.dataset.kategori === kategori) {
            card.style.display = '';
            card.style.animation = 'fadeIn 0.3s ease';
        } else {
            card.style.display = 'none';
        }
    });
}

// --- Search Produk ---
function filterProduk() {
    let query = document.getElementById('searchInput').value.toLowerCase();
    document.querySelectorAll('.card').forEach(card => {
        let nama = card.dataset.nama;
        card.style.display = nama.includes(query) ? '' : 'none';
    });
}

// --- Mobile Menu ---
function toggleMobileMenu() {
    document.getElementById('mobileMenu').classList.toggle('show');
}

// --- Smooth Scroll ---
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function(e) {
        let target = document.querySelector(this.getAttribute('href'));
        if (target) { e.preventDefault(); target.scrollIntoView({ behavior: 'smooth', block: 'start' }); }
    });
});

// --- Animate on scroll (simple) ---
const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.style.opacity = '1';
            entry.target.style.transform = 'translateY(0)';
        }
    });
}, { threshold: 0.1 });

document.querySelectorAll('.summary-card, .card, .rekom-card, .activity-item').forEach(el => {
    el.style.opacity = '0';
    el.style.transform = 'translateY(20px)';
    el.style.transition = 'all 0.5s ease';
    observer.observe(el);
});
</script>

</body>
</html>
