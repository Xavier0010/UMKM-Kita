<?php
require_once __DIR__ . '/../config.php';

// Pastikan sudah login dan role = penjual
if (!isLoggedIn()) {
    header("Location: ../login.php");
    exit();
}
$user = currentUser();
if ($user['role'] !== 'penjual') {
    header("Location: ../index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Penjual — UMKM Kita</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>

<nav class="navbar">
    <div class="nav-container">
        <a href="../index.php" class="nav-logo">🛒 UMKM Kita</a>
        <div class="nav-user">
            <span class="nav-greeting">Halo, <strong><?= htmlspecialchars($user['nama']) ?></strong></span>
            <span class="nav-role-badge role-penjual">Penjual</span>
            <a href="../logout.php" class="btn-logout">Logout</a>
        </div>
    </div>
</nav>

<section class="hero">
    <div class="hero-content">
        <h1>Dashboard Penjual 🏪</h1>
        <p>Selamat datang, <?= htmlspecialchars($user['nama']) ?>! Kelola produk UMKM Anda di sini.</p>
    </div>
</section>

<div class="container" style="padding: 40px 20px; text-align: center;">
    <div class="card" style="max-width: 500px; margin: 0 auto; padding: 40px;">
        <h3 class="card-title">🚧 Halaman Sedang Dikembangkan</h3>
        <p class="card-desc" style="margin-top: 10px;">Fitur manajemen produk untuk penjual akan segera hadir. Saat ini Anda tetap bisa melihat katalog produk.</p>
        <a href="../index.php" class="btn-primary" style="display: inline-block; margin-top: 20px; padding: 12px 30px;">Lihat Katalog</a>
    </div>
</div>

<footer>
    <p>&copy; 2026 UMKM Kita — SMK Telkom Sidoarjo</p>
</footer>

</body>
</html>
