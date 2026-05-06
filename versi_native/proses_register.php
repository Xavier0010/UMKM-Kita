<?php
// proses_register.php — Logika registrasi user baru (tanpa HTML)
require_once 'config.php';

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: login.php?tab=register");
    exit();
}

$nama     = trim($_POST['nama'] ?? '');
$email    = trim($_POST['email'] ?? '');
$password = trim($_POST['password'] ?? '');
$role     = trim($_POST['role'] ?? 'user');

// Validasi backend
if (empty($nama) || empty($email) || empty($password)) {
    header("Location: login.php?tab=register&error=" . urlencode("Semua field wajib diisi."));
    exit();
}

if (strlen($password) < 6) {
    header("Location: login.php?tab=register&error=" . urlencode("Password minimal 6 karakter."));
    exit();
}

// Pastikan role valid
$allowed_roles = ['user', 'penjual', 'pembeli'];
if (!in_array($role, $allowed_roles)) {
    $role = 'user';
}

// Cek apakah email sudah terdaftar
$stmt = mysqli_prepare($conn, "SELECT id FROM users WHERE email = ?");
mysqli_stmt_bind_param($stmt, "s", $email);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) > 0) {
    header("Location: login.php?tab=register&error=" . urlencode("Email sudah terdaftar. Silakan gunakan email lain."));
    exit();
}

// Hash password dan simpan
$hashed = password_hash($password, PASSWORD_DEFAULT);
$stmt = mysqli_prepare($conn, "INSERT INTO users (nama, email, password, role) VALUES (?, ?, ?, ?)");
mysqli_stmt_bind_param($stmt, "ssss", $nama, $email, $hashed, $role);

if (mysqli_stmt_execute($stmt)) {
    header("Location: login.php?success=" . urlencode("Registrasi berhasil! Silakan login."));
    exit();
} else {
    header("Location: login.php?tab=register&error=" . urlencode("Terjadi kesalahan. Silakan coba lagi."));
    exit();
}
