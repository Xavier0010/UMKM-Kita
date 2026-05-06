<?php
// proses.php

// Pastikan file ini diakses melalui form POST
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    // Jika ada yang iseng mengakses proses.php langsung melalui URL
    header("Location: index.php");
    exit();
}

// 1. Tangkap Data (Gunakan trim untuk membersihkan spasi)
$pembeli    = trim($_POST['pembeli']);
$produk     = trim($_POST['nama_produk']);
$jumlah     = (int)$_POST['jumlah'];

// 2. Validasi Backend (Pengaman ekstra jika user mematikan JavaScript)
if (empty($pembeli) || $jumlah < 1) {
    die("Data pesanan tidak valid. Silakan kembali dan ulangi proses pengisian form. <a href='index.php'>Kembali ke Katalog</a>");
}

// 3. Konfigurasi Nomor WhatsApp UMKM
// Format: Gunakan 62 (Kode Negara Indonesia) sebagai pengganti angka 0 di depan.
// Contoh: 081234567890 menjadi 6281234567890
$no_wa = "6281234567890";

// 4. Format Pesan WhatsApp
$teks = "Halo Admin UMKM Kita, saya ingin memesan:\n\n";
$teks .= "🛍️ *Produk*: " . $produk . "\n";
$teks .= "📦 *Jumlah*: " . $jumlah . "\n";
$teks .= "👤 *Atas Nama*: " . $pembeli . "\n\n";
$teks .= "Mohon informasi ketersediaan stok, total harga yang harus dibayar, dan metode pengirimannya. Terima kasih!";

// 5. Generate Link WA
// urlencode() penting agar spasi dan enter terkirim dengan benar ke URL WhatsApp
$link_wa = "https://wa.me/" . $no_wa . "?text=" . urlencode($teks);

// 6. Eksekusi Redirect
header("Location: " . $link_wa);
exit();
?>
