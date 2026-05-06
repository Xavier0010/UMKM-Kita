<?php
// config.php — Koneksi database & session starter
session_start();

$host = "localhost";
$user = "root";
$pass = "";
$db   = "db_umkm";

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Koneksi ke database gagal: " . mysqli_connect_error() . ". Pastikan XAMPP Apache dan MySQL sudah berjalan, dan database 'db_umkm' sudah dibuat.");
}

// Helper: cek apakah user sudah login
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

// Helper: ambil data user yang sedang login
function currentUser() {
    return [
        'id'    => $_SESSION['user_id'] ?? null,
        'nama'  => $_SESSION['user_nama'] ?? '',
        'email' => $_SESSION['user_email'] ?? '',
        'role'  => $_SESSION['user_role'] ?? 'user',
    ];
}
