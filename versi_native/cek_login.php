<?php
// cek_login.php — Middleware sederhana: taruh di atas halaman yang butuh login
require_once __DIR__ . '/config.php';

if (!isLoggedIn()) {
    header("Location: login.php");
    exit();
}
