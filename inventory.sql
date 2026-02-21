-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Feb 21, 2026 at 03:34 PM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `inventory`
--

-- --------------------------------------------------------

--
-- Table structure for table `barangs`
--

CREATE TABLE `barangs` (
  `id` bigint UNSIGNED NOT NULL,
  `nama_barang` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kategori` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jumlah_stok` int NOT NULL DEFAULT '0',
  `harga_satuan` int NOT NULL DEFAULT '0',
  `lead_time` int NOT NULL DEFAULT '1',
  `satuan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal_masuk` date NOT NULL,
  `rak_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `barangs`
--

INSERT INTO `barangs` (`id`, `nama_barang`, `kategori`, `jumlah_stok`, `harga_satuan`, `lead_time`, `satuan`, `tanggal_masuk`, `rak_id`, `created_at`, `updated_at`) VALUES
(9, 'beras', 'premium', 4, 70000, 6, 'karung', '2026-01-26', 8, '2026-01-25 23:12:53', '2026-02-20 21:29:31'),
(10, 'beng2', 'cemilan', 67, 2000, 4, 'pcs', '2026-02-20', 9, '2026-02-19 21:41:24', '2026-02-20 16:35:12');

-- --------------------------------------------------------

--
-- Table structure for table `detail_transaksis`
--

CREATE TABLE `detail_transaksis` (
  `id` bigint UNSIGNED NOT NULL,
  `transaksi_id` bigint UNSIGNED NOT NULL,
  `barang_id` bigint UNSIGNED NOT NULL,
  `jumlah` int NOT NULL DEFAULT '1',
  `harga_satuan` decimal(15,2) NOT NULL DEFAULT '0.00',
  `subtotal` decimal(15,2) NOT NULL DEFAULT '0.00',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `detail_transaksis`
--

INSERT INTO `detail_transaksis` (`id`, `transaksi_id`, `barang_id`, `jumlah`, `harga_satuan`, `subtotal`, `created_at`, `updated_at`) VALUES
(60, 59, 10, 1, '0.00', '0.00', '2026-02-20 16:35:12', '2026-02-20 16:35:12'),
(61, 59, 10, 1, '0.00', '0.00', '2026-02-20 16:35:12', '2026-02-20 16:35:12'),
(62, 59, 10, 1, '0.00', '0.00', '2026-02-20 16:35:12', '2026-02-20 16:35:12'),
(63, 59, 9, 1, '0.00', '0.00', '2026-02-20 16:35:12', '2026-02-20 16:35:12'),
(64, 59, 9, 1, '0.00', '0.00', '2026-02-20 16:35:12', '2026-02-20 16:35:12'),
(65, 59, 9, 1, '0.00', '0.00', '2026-02-20 16:35:12', '2026-02-20 16:35:12'),
(66, 59, 9, 1, '0.00', '0.00', '2026-02-20 16:35:12', '2026-02-20 16:35:12'),
(67, 60, 9, 1, '0.00', '0.00', '2026-02-20 16:40:14', '2026-02-20 16:40:14'),
(68, 60, 9, 1, '0.00', '0.00', '2026-02-20 16:40:14', '2026-02-20 16:40:14'),
(69, 60, 9, 1, '0.00', '0.00', '2026-02-20 16:40:14', '2026-02-20 16:40:14'),
(70, 60, 9, 1, '0.00', '0.00', '2026-02-20 16:40:14', '2026-02-20 16:40:14'),
(71, 61, 9, 1, '0.00', '0.00', '2026-02-20 21:17:32', '2026-02-20 21:17:32'),
(72, 61, 9, 1, '0.00', '0.00', '2026-02-20 21:17:32', '2026-02-20 21:17:32'),
(73, 61, 9, 1, '0.00', '0.00', '2026-02-20 21:17:32', '2026-02-20 21:17:32'),
(74, 61, 9, 1, '0.00', '0.00', '2026-02-20 21:17:32', '2026-02-20 21:17:32');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2025_05_11_063533_create_raks_table', 1),
(6, '2025_05_12_085254_create_barangs_table', 1),
(7, '2025_06_20_173831_create_transaksis_table', 1),
(8, '2025_06_23_082747_create_detail_transaksis_table', 1),
(9, '2025_07_12_162458_create_riwayat_pemesanan_ulangs_table', 1),
(10, '2025_07_13_090045_add_tanggal_to_riwayat_pemesanan_ulang_table', 1),
(11, '2025_08_01_232639_add_first_last_name_to_users_table', 1),
(12, '2025_08_01_235233_revert_users_to_name', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `raks`
--

CREATE TABLE `raks` (
  `id` bigint UNSIGNED NOT NULL,
  `rak` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kategori` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kapasitas` int NOT NULL DEFAULT '10',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `raks`
--

INSERT INTO `raks` (`id`, `rak`, `kategori`, `kapasitas`, `created_at`, `updated_at`) VALUES
(8, 'BRS001', 'makanan', 70, '2026-01-25 23:10:36', '2026-01-25 23:10:36'),
(9, '004', 'sembarang', 100, '2026-02-19 21:37:11', '2026-02-19 21:37:11');

-- --------------------------------------------------------

--
-- Table structure for table `riwayat_pemesanan_ulang`
--

CREATE TABLE `riwayat_pemesanan_ulang` (
  `id` bigint UNSIGNED NOT NULL,
  `barang_id` bigint UNSIGNED NOT NULL,
  `status` enum('pending','diproses','selesai') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `tanggal_pemesanan` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `riwayat_pemesanan_ulang`
--

INSERT INTO `riwayat_pemesanan_ulang` (`id`, `barang_id`, `status`, `tanggal_pemesanan`, `created_at`, `updated_at`) VALUES
(14, 9, 'diproses', '2026-02-21', '2026-02-20 16:35:12', '2026-02-20 16:37:48'),
(15, 9, 'diproses', '2026-02-21', '2026-02-20 16:40:14', '2026-02-20 16:41:36'),
(16, 9, 'pending', '2026-02-21', '2026-02-20 21:17:32', '2026-02-20 21:17:32');

-- --------------------------------------------------------

--
-- Table structure for table `transaksis`
--

CREATE TABLE `transaksis` (
  `id` bigint UNSIGNED NOT NULL,
  `tanggal_transaksi` date NOT NULL,
  `total_harga` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `transaksis`
--

INSERT INTO `transaksis` (`id`, `tanggal_transaksi`, `total_harga`, `created_at`, `updated_at`) VALUES
(59, '2026-02-21', 286000, '2026-02-20 16:35:12', '2026-02-20 16:35:12'),
(60, '2026-02-21', 280000, '2026-02-20 16:40:14', '2026-02-20 16:40:14'),
(61, '2026-10-21', 280000, '2026-02-20 21:17:32', '2026-02-20 21:17:32');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('admin','staff') COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `password`, `role`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Administrator', 'admin', '$2y$12$TDmexL.CtI4EozvVdcYThuHFerz6QGBhKlX9iaKqe9vqZb9atLW5u', 'admin', NULL, '2026-01-16 09:28:35', '2026-01-16 09:28:35'),
(2, 'Staff Gudang', 'staff', '$2y$12$169zRb6D1mN0i7jwH/iOEO7QhtPpfUqjN.Ce2Dn1XxYnMD/IEBkEu', 'staff', NULL, '2026-01-16 09:28:35', '2026-01-16 09:28:35');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `barangs`
--
ALTER TABLE `barangs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `barangs_rak_id_foreign` (`rak_id`);

--
-- Indexes for table `detail_transaksis`
--
ALTER TABLE `detail_transaksis`
  ADD PRIMARY KEY (`id`),
  ADD KEY `detail_transaksis_transaksi_id_foreign` (`transaksi_id`),
  ADD KEY `detail_transaksis_barang_id_foreign` (`barang_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `raks`
--
ALTER TABLE `raks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `riwayat_pemesanan_ulang`
--
ALTER TABLE `riwayat_pemesanan_ulang`
  ADD PRIMARY KEY (`id`),
  ADD KEY `riwayat_pemesanan_ulang_barang_id_foreign` (`barang_id`);

--
-- Indexes for table `transaksis`
--
ALTER TABLE `transaksis`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `barangs`
--
ALTER TABLE `barangs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `detail_transaksis`
--
ALTER TABLE `detail_transaksis`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `raks`
--
ALTER TABLE `raks`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `riwayat_pemesanan_ulang`
--
ALTER TABLE `riwayat_pemesanan_ulang`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `transaksis`
--
ALTER TABLE `transaksis`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `barangs`
--
ALTER TABLE `barangs`
  ADD CONSTRAINT `barangs_rak_id_foreign` FOREIGN KEY (`rak_id`) REFERENCES `raks` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `detail_transaksis`
--
ALTER TABLE `detail_transaksis`
  ADD CONSTRAINT `detail_transaksis_barang_id_foreign` FOREIGN KEY (`barang_id`) REFERENCES `barangs` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `detail_transaksis_transaksi_id_foreign` FOREIGN KEY (`transaksi_id`) REFERENCES `transaksis` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `riwayat_pemesanan_ulang`
--
ALTER TABLE `riwayat_pemesanan_ulang`
  ADD CONSTRAINT `riwayat_pemesanan_ulang_barang_id_foreign` FOREIGN KEY (`barang_id`) REFERENCES `barangs` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
