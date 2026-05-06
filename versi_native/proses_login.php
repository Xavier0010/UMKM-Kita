<?php
// proses_login.php — Logika autentikasi (tanpa HTML)
require_once 'config.php';

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: login.php");
    exit();
}

$email    = trim($_POST['email'] ?? '');
$password = trim($_POST['password'] ?? '');

// Validasi backend
if (empty($email) || empty($password)) {
    header("Location: login.php?error=" . urlencode("Email dan password wajib diisi."));
    exit();
}

// Cari user di database (gunakan prepared statement untuk keamanan)
$stmt = mysqli_prepare($conn, "SELECT id, nama, email, password, role FROM users WHERE email = ?");
mysqli_stmt_bind_param($stmt, "s", $email);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if ($row = mysqli_fetch_assoc($result)) {
    // Verifikasi password hash
    if (password_verify($password, $row['password'])) {
        // Login berhasil — simpan data ke session
        $_SESSION['user_id']    = $row['id'];
        $_SESSION['user_nama']  = $row['nama'];
        $_SESSION['user_email'] = $row['email'];
        $_SESSION['user_role']  = $row['role'];

        // Redirect berdasarkan role
        switch ($row['role']) {
            case 'penjual':
                header("Location: penjual/dashboard.php");
                break;
            case 'pembeli':
                header("Location: index.php");
                break;
            default: // role 'user'
                header("Location: index.php");
                break;
        }
        exit();
    } else {
        header("Location: login.php?error=" . urlencode("Password salah. Silakan coba lagi."));
        exit();
    }
} else {
    header("Location: login.php?error=" . urlencode("Akun dengan email tersebut tidak ditemukan."));
    exit();
}
