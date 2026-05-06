<?php
// setup_db.php — Setup/reset database
$host = "127.0.0.1";
$user = "root";
$pass = "";

$conn = @mysqli_connect($host, $user, $pass);

if (!$conn) {
    echo "ERROR: Tidak dapat terhubung ke MySQL.\n";
    exit(1);
}

// Drop dan buat ulang database agar tabel terbaru selalu di-apply
mysqli_query($conn, "DROP DATABASE IF EXISTS `db_umkm`");

$sqlContent = file_get_contents(__DIR__ . '/database.sql');

if (mysqli_multi_query($conn, $sqlContent)) {
    do {
        if ($res = mysqli_store_result($conn)) {
            mysqli_free_result($res);
        }
    } while (mysqli_more_results($conn) && mysqli_next_result($conn));
    
    // Cek apakah ada error di akhir multi-query
    if (mysqli_errno($conn)) {
        echo "ERROR: " . mysqli_error($conn) . "\n";
        exit(1);
    }
    echo "SUCCESS: Database 'db_umkm' berhasil dibuat ulang dengan tabel terbaru!\n";
} else {
    echo "ERROR: " . mysqli_error($conn) . "\n";
    exit(1);
}

mysqli_close($conn);
