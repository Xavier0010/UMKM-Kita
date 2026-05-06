CREATE DATABASE IF NOT EXISTS `db_umkm`;
USE `db_umkm`;

-- ============================================
-- TABEL USERS (Login & Role System)
-- ============================================
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL UNIQUE,
  `password` varchar(255) NOT NULL,
  `role` enum('user','penjual','pembeli') NOT NULL DEFAULT 'user',
  `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- TABEL PRODUK (Katalog)
-- ============================================
CREATE TABLE IF NOT EXISTS `produk` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama_produk` varchar(255) NOT NULL,
  `harga` int(11) NOT NULL,
  `gambar` varchar(255) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `kategori` varchar(100) DEFAULT 'Umum',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- DATA DUMMY PRODUK
-- ============================================
INSERT INTO `produk` (`id`, `nama_produk`, `harga`, `gambar`, `deskripsi`, `kategori`) VALUES
(1, 'Keripik Pisang Coklat', 15000, 'produk1.jpg', 'Keripik pisang renyah dengan balutan coklat lumer yang manis dan gurih. Cocok untuk cemilan sore bersama keluarga.', 'Makanan'),
(2, 'Sambal Roa Khas', 25000, 'produk2.jpg', 'Sambal roa asli dengan level pedas yang pas untuk teman makan nasi. Dibuat dari ikan roa pilihan.', 'Makanan'),
(3, 'Kopi Bubuk Robusta', 35000, 'produk3.jpg', 'Kopi robusta pilihan hasil panen petani lokal dengan aroma khas yang menggugah selera.', 'Minuman'),
(4, 'Kerajinan Tas Anyaman', 85000, 'produk4.jpg', 'Tas anyaman cantik yang dibuat dengan tangan oleh pengrajin lokal untuk kebutuhan fashion Anda.', 'Kerajinan'),
(5, 'Madu Hutan Asli', 65000, 'produk5.jpg', 'Madu hutan murni tanpa campuran, diambil langsung dari lebah liar di hutan tropis.', 'Minuman'),
(6, 'Batik Tulis Motif Bunga', 120000, 'produk6.jpg', 'Batik tulis asli dengan motif bunga khas Nusantara, cocok untuk acara formal maupun kasual.', 'Kerajinan')
ON DUPLICATE KEY UPDATE `nama_produk` = VALUES(`nama_produk`);

-- ============================================
-- DATA DUMMY USER (password: 123456)
-- ============================================
-- Password di-hash dengan password_hash('123456', PASSWORD_DEFAULT)
-- Hash ini valid untuk PHP 8.x
INSERT INTO `users` (`nama`, `email`, `password`, `role`) VALUES
('Admin User', 'user@umkm.com', '$2y$12$2zbY.Dq92NNRJ0F9oF2AquXjZbQ3nu0KC3h7A0dFh5ECNvnt4APui', 'user'),
('Budi Penjual', 'penjual@umkm.com', '$2y$12$2zbY.Dq92NNRJ0F9oF2AquXjZbQ3nu0KC3h7A0dFh5ECNvnt4APui', 'penjual'),
('Siti Pembeli', 'pembeli@umkm.com', '$2y$12$2zbY.Dq92NNRJ0F9oF2AquXjZbQ3nu0KC3h7A0dFh5ECNvnt4APui', 'pembeli')
ON DUPLICATE KEY UPDATE `nama` = VALUES(`nama`);
