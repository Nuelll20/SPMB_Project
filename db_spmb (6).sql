-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 17, 2026 at 01:37 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_spmb`
--

-- --------------------------------------------------------

--
-- Table structure for table `batch_pendaftaran`
--

CREATE TABLE `batch_pendaftaran` (
  `uid` int(16) NOT NULL,
  `cabang` varchar(255) NOT NULL,
  `nama_batch` varchar(255) NOT NULL,
  `tanggal_buka` date DEFAULT NULL,
  `tanggal_tutup` date DEFAULT NULL,
  `kuota` int(16) NOT NULL,
  `is_active` tinyint(1) NOT NULL,
  `created_at` date DEFAULT NULL,
  `dibuat_oleh` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `batch_pendaftaran`
--

INSERT INTO `batch_pendaftaran` (`uid`, `cabang`, `nama_batch`, `tanggal_buka`, `tanggal_tutup`, `kuota`, `is_active`, `created_at`, `dibuat_oleh`) VALUES
(1, 'Cabang Global', 'Gelombang 1 Tahun Ajaran 2026/2027', '2026-06-17', '2026-06-23', 20, 1, '2026-06-15', 'admin@spmb.local'),
(7, 'Cabang Global', 'Gelombang 2 Tahun Ajaran 2026/2027', '2026-06-24', '2026-06-27', 2, 0, '2026-06-16', 'admin@spmb.local');

-- --------------------------------------------------------

--
-- Table structure for table `berkas`
--

CREATE TABLE `berkas` (
  `uid` int(16) NOT NULL,
  `id_pendaftar` int(16) NOT NULL,
  `jenis_berkas` varchar(255) NOT NULL,
  `file_url` varchar(255) NOT NULL,
  `is_valid` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `berkas`
--

INSERT INTO `berkas` (`uid`, `id_pendaftar`, `jenis_berkas`, `file_url`, `is_valid`) VALUES
(4, 1, 'Kartu Keluarga', 'berkas/L7IRajbaHIujBaKoQ3KM81uCR2UlXLBoCOb3z6Rp.pdf', 1),
(5, 1, 'Akte Kelahiran', 'berkas/pXKrpl2wINJVt1zY2PWYvIgPhFzHu58TtzIYZQrP.pdf', 1),
(6, 1, 'E-KTP Orang Tua', 'berkas/IJwC2Nfz3yY0kpOdefpYIUaZMtezqoOcVWeptN61.pdf', 1),
(7, 1, 'Pas Foto', 'berkas/jJgcyFq8qX6mID5tyOhjCl8coZBHXaC4TPkVHE2H.png', 1),
(8, 2, 'Kartu Keluarga', 'berkas/1Z7PyxilVlx12jMV8vDU3fLwyYFgrOSGaFzAfARR.pdf', 0),
(9, 2, 'Akte Kelahiran', 'berkas/7E7pFKSn9FFsOVRW1Suhw1hMdth9bFTYO63Uvx38.pdf', 0),
(10, 2, 'E-KTP Orang Tua', 'berkas/ZixF455W7gYqrTG4G74MhiDBDVsIRfnDGdZeiQcI.pdf', 0),
(11, 2, 'Pas Foto', 'berkas/DEI6y0v4ICbujPuYWT50nTo9J7PjdllcoBzkeZQB.png', 0),
(12, 3, 'Kartu Keluarga', 'berkas/cxgFvjMfvck6icjj2b5Tz5GWE9yguOiPrLyyAcWp.pdf', 1),
(13, 3, 'Akte Kelahiran', 'berkas/k9Q4KkMgVGGpYHAaxRxljGAK8gB96zkfxK2WrxU6.pdf', 1),
(14, 3, 'E-KTP Orang Tua', 'berkas/EWsapNkkOBG32XW2ucWeegnkm5okHsNiwNSa269c.pdf', 1),
(15, 3, 'Pas Foto', 'berkas/XjRwDamn47zxrdcLq1i8WstbEBUPaPCZIgcSLkBg.png', 1),
(16, 3, 'Surat Baptis', 'berkas/TUEcg2dAD9QuTmak9bMQDs7w7feC7cUCHQZLsKY5.pdf', 1),
(17, 4, 'Kartu Keluarga', 'berkas/MFQiVwTABSaoxfVg0LRS63DLtmltV9t2qHS3w8Yg.pdf', 1),
(18, 4, 'Akte Kelahiran', 'berkas/YMLCVbRFoDkr411nqAm9Jo6pX6NqToGp0fpwuFwz.pdf', 1),
(19, 4, 'E-KTP Orang Tua', 'berkas/bGBpHXQntUuXaUJm0FQNJ6uJWJQwxh9l7h0BoSHD.pdf', 1),
(20, 4, 'Pas Foto', 'berkas/BD2hGEDjSGyInybjAPHxcEy1pLLtUCDvhE1MyUgz.png', 1),
(21, 6, 'Kartu Keluarga', 'berkas/6-arya/pendaftaran-6/kartu-keluarga-20260615201503-U61JbY.pdf', 1),
(22, 6, 'Akte Kelahiran', 'berkas/6-arya/pendaftaran-6/akte-kelahiran-20260615201503-uFOI3d.pdf', 1),
(23, 6, 'E-KTP Orang Tua', 'berkas/6-arya/pendaftaran-6/e-ktp-orang-tua-20260615201503-hzOCBf.pdf', 1),
(24, 6, 'Pas Foto', 'berkas/6-arya/pendaftaran-6/pas-foto-20260615201503-U0p6CY.png', 1),
(25, 7, 'Kartu Keluarga', 'berkas/6-arya/pendaftaran-7/kartu-keluarga-20260615201503-cj9Rrk.pdf', 0),
(26, 7, 'Akte Kelahiran', 'berkas/6-arya/pendaftaran-7/akte-kelahiran-20260615201503-v5H9OK.pdf', 0),
(27, 7, 'E-KTP Orang Tua', 'berkas/6-arya/pendaftaran-7/e-ktp-orang-tua-20260615201503-tKD5pq.pdf', 0),
(28, 7, 'Pas Foto', 'berkas/6-arya/pendaftaran-7/pas-foto-20260615201503-aPDDgg.png', 0),
(29, 8, 'Kartu Keluarga', 'berkas/6-arya/angello-2536672771356647/pendaftaran-8/kartu-keluarga-angello-2536672771356647-20260615202647-AH0p2Z.pdf', 1),
(30, 8, 'Akte Kelahiran', 'berkas/6-arya/angello-2536672771356647/pendaftaran-8/akte-kelahiran-angello-2536672771356647-20260615202647-5KoTj9.pdf', 1),
(31, 8, 'E-KTP Orang Tua', 'berkas/6-arya/angello-2536672771356647/pendaftaran-8/e-ktp-orang-tua-angello-2536672771356647-20260615202647-kCKeQM.pdf', 1),
(32, 8, 'Pas Foto', 'berkas/6-arya/angello-2536672771356647/pendaftaran-8/pas-foto-angello-2536672771356647-20260615202647-K8fvt6.png', 1),
(37, 10, 'Kartu Keluarga', 'berkas/5-angelo/jir-7827832748327483/pendaftaran-10/kartu-keluarga-jir-7827832748327483-20260616211418-aufK1a.pdf', 0),
(38, 10, 'Akte Kelahiran', 'berkas/5-angelo/jir-7827832748327483/pendaftaran-10/akte-kelahiran-jir-7827832748327483-20260616211420-y5Zue5.pdf', 1),
(39, 10, 'E-KTP Orang Tua', 'berkas/5-angelo/jir-7827832748327483/pendaftaran-10/e-ktp-orang-tua-jir-7827832748327483-20260616211420-5l8TlC.pdf', 1),
(40, 10, 'Pas Foto', 'berkas/5-angelo/jir-7827832748327483/pendaftaran-10/pas-foto-jir-7827832748327483-20260616211420-dzBs9M.png', 1),
(41, 11, 'Kartu Keluarga', 'berkas/5-angelo/njay-6363652511712323/pendaftaran-11/kartu-keluarga-njay-6363652511712323-20260616224454-9FmNvg.pdf', 1),
(42, 11, 'Akte Kelahiran', 'berkas/5-angelo/njay-6363652511712323/pendaftaran-11/akte-kelahiran-njay-6363652511712323-20260616224454-fsarkz.pdf', 1),
(43, 11, 'E-KTP Orang Tua', 'berkas/5-angelo/njay-6363652511712323/pendaftaran-11/e-ktp-orang-tua-njay-6363652511712323-20260616224454-5cMC1t.pdf', 1),
(44, 11, 'Pas Foto', 'berkas/5-angelo/njay-6363652511712323/pendaftaran-11/pas-foto-njay-6363652511712323-20260616224454-JNNoxT.png', 1);

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `calon_siswa`
--

CREATE TABLE `calon_siswa` (
  `uid` int(16) NOT NULL,
  `tempat_lahir` varchar(255) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `nik` varchar(16) NOT NULL,
  `alamat` varchar(250) NOT NULL,
  `agama` varchar(50) NOT NULL,
  `golongan_darah` varchar(3) DEFAULT NULL,
  `uid_orangtua` int(16) NOT NULL,
  `status` varchar(50) DEFAULT 'draft',
  `nomor_registrasi` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `calon_siswa`
--

INSERT INTO `calon_siswa` (`uid`, `tempat_lahir`, `nama`, `tanggal_lahir`, `nik`, `alamat`, `agama`, `golongan_darah`, `uid_orangtua`, `status`, `nomor_registrasi`, `created_at`, `updated_at`) VALUES
(1, 'JL.Candi Gebang', 'Immanuel', '2026-06-12', '5124356142351425', 'JL.Kaliurang', 'katolik', 'O', 4, 'draft', NULL, NULL, NULL),
(2, 'JL.Candi Gebang', 'Immanuel', '2026-06-12', '1782672368176378', 'JL.Kaliurang', 'katolik', 'O', 6, 'draft', NULL, NULL, NULL),
(3, 'JL. Sanata Dharma', 'Michael', '2026-06-13', '1233546325643254', 'Sanata Dharma', 'katolik', 'O', 8, 'draft', NULL, NULL, NULL),
(5, 'JL. Sanata Dharma', 'Michael', '2026-06-13', '6351654613546315', 'Sanata Dharma', 'katolik', 'O', 9, 'pending', 'REG-1781348354', '2026-06-13 03:59:14', '2026-06-13 03:59:14'),
(6, 'JL. Sanata Dharma', 'Michael', '2026-06-13', '1284798137817981', 'Sanata Dharma', 'katolik', 'O', 9, 'pending', 'REG-1781348601', '2026-06-13 04:03:21', '2026-06-13 04:03:21'),
(7, 'Metro', 'Praha', '2026-06-15', '1233442233445566', 'Lampung', 'kristen', 'O', 10, 'approved', 'REG-20260615-00007', '2026-06-15 09:12:25', '2026-06-15 10:04:45'),
(9, 'Metro', 'Immanuel', '2026-06-16', '1625371284985906', 'Lampung', 'kristen', 'A', 10, 'pending', 'REG-20260615-00009', '2026-06-15 10:11:17', '2026-06-15 10:11:17'),
(10, 'Metro', 'Arya', '2026-06-16', '9889184831784183', 'Lampung', 'katolik', 'O', 10, 'approved', 'REG-20260615-00010', '2026-06-15 11:18:59', '2026-06-15 11:18:59'),
(11, 'Metro', 'Arya', '2026-06-16', '1378429320090910', '21Tobacco', 'kristen', 'O', 11, 'approved', 'REG-20260615-00011', '2026-06-15 12:27:09', '2026-06-15 13:03:10'),
(13, 'klaten', 'alex', '2026-06-16', '1234567890123456', 'klaten', 'kristen', 'A', 11, 'approved', 'REG-20260615-00013', NULL, NULL),
(14, 'madiun', 'jope', '2026-06-14', '2131233212312312', 'madiun', 'islam', 'O', 11, 'rejected', 'REG-20260615-00014', NULL, NULL),
(15, 'Metro', 'Angello', '2026-06-16', '2536672771356647', '21Tobacco', 'kristen', 'O', 11, 'approved', 'REG-20260615-00015', NULL, NULL),
(17, 'Metro', 'jir', '2026-06-17', '7827832748327483', '21Tobacco', 'kristen', 'O', 11, 'rejected', 'REG-20260616-00017', NULL, NULL),
(18, 'Metro', 'Njay', '2026-06-17', '6363652511712323', '21Tobacco', 'kristen', 'O', 11, 'approved', 'REG-20260616-00018', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `komponen_tagihan`
--

CREATE TABLE `komponen_tagihan` (
  `uid` int(16) NOT NULL,
  `uid_tagihan` int(16) NOT NULL,
  `nama_komponen` varchar(255) NOT NULL,
  `qty` decimal(10,2) NOT NULL DEFAULT 1.00,
  `nominal` decimal(15,2) NOT NULL DEFAULT 0.00,
  `subtotal` decimal(15,2) NOT NULL DEFAULT 0.00,
  `urutan` int(11) NOT NULL DEFAULT 0,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `komponen_tagihan`
--

INSERT INTO `komponen_tagihan` (`uid`, `uid_tagihan`, `nama_komponen`, `qty`, `nominal`, `subtotal`, `urutan`, `created_at`, `updated_at`) VALUES
(1, 1, 'Biaya Formulir & Administrasi Pendaftaran Gelombang Utama', 1.00, 250000.00, 250000.00, 1, '2026-06-15 22:49:59', '2026-06-15 22:49:59'),
(2, 1, 'Uang Pangkal / Uang Gedung (Sesuai Komitmen Awal)', 1.00, 2500000.00, 2500000.00, 2, '2026-06-15 22:49:59', '2026-06-15 22:49:59'),
(3, 1, 'Anjay', 1.00, 99998.00, 99998.00, 3, '2026-06-15 22:49:59', '2026-06-15 22:49:59'),
(6, 2, 'Biaya Formulir & Administrasi Pendaftaran Gelombang Utama', 1.00, 250000.00, 250000.00, 1, '2026-06-16 13:21:20', '2026-06-16 13:21:20'),
(7, 2, 'Uang Pangkal / Uang Gedung (Sesuai Komitmen Awal)', 1.00, 2500000.00, 2500000.00, 2, '2026-06-16 13:21:20', '2026-06-16 13:21:20'),
(8, 3, 'Biaya Formulir & Administrasi Pendaftaran Gelombang Utama', 1.00, 250000.00, 250000.00, 1, '2026-06-16 22:46:45', '2026-06-16 22:46:45'),
(9, 3, 'Uang Pangkal / Uang Gedung (Sesuai Komitmen Awal)', 1.00, 2500000.00, 2500000.00, 2, '2026-06-16 22:46:45', '2026-06-16 22:46:45');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_06_11_180415_create_orang_tua_table', 2);

-- --------------------------------------------------------

--
-- Table structure for table `orang_tua`
--

CREATE TABLE `orang_tua` (
  `uid` int(16) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `no_telp` varchar(255) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `alamat` varchar(250) NOT NULL,
  `gaji` decimal(15,2) NOT NULL,
  `pendidikan` varchar(100) DEFAULT NULL,
  `unit_sekolah` varchar(255) DEFAULT NULL,
  `jumlah_anak` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orang_tua`
--

INSERT INTO `orang_tua` (`uid`, `user_id`, `no_telp`, `nama`, `alamat`, `gaji`, `pendidikan`, `unit_sekolah`, `jumlah_anak`) VALUES
(1, NULL, '-', 'Orang Tua', 'Jl. Kaliurang KM 5, Wirobrajan, Yogyakarta', 1.00, NULL, NULL, NULL),
(2, NULL, '-', 'Orang Tua', 'JL Kaliurang', 1.00, NULL, NULL, NULL),
(3, NULL, '-', 'Orang Tua', 'JL Kaliurang', 1.00, NULL, NULL, NULL),
(4, NULL, '082281334882', 'Michael Angelo Praha Jeshua Immanuel', 'JL.Kaliurang', 1.00, 'S1', 'TK Wirobrajan', 1),
(5, NULL, '082281334882', 'Michael Angelo Praha Jeshua Immanuel', 'JL.Kaliurang', 1.00, 'S1', 'TK Wirobrajan', 1),
(6, NULL, '082281334882', 'Michael Angelo Praha Jeshua Immanuel', 'JL.Kaliurang', 1.00, 'S1', 'TK Wirobrajan', 1),
(7, NULL, '082281334882', 'Michael Angelo Praha Jeshua Immanuel', 'JL.Kaliurang', 1.00, 'S1', 'TK Wirobrajan', 1),
(8, NULL, '082281334883', 'Michael Angelo Praha Jeshua Immanuel', 'Sanata Dharma', 1.00, 'S1', 'TK Wirobrajan', 1),
(9, NULL, '082281334883', 'Michael Angelo Praha Jeshua Immanuel', 'Sanata Dharma', 1.00, 'S1', 'TK Wirobrajan', 1),
(10, NULL, '082281334885', 'Angelo', 'Lampung', 4000000.00, 'S1', 'TK Wirobrajan', 1),
(11, 5, '083354667882', 'Arya', '21Tobacco', 4000000.00, 'S1', 'TK Wirobrajan', NULL),
(12, NULL, '082123123321312', 'alex', 'fafawfafwasfafawf', 4000000.00, 'S1', 'SD Kanisius', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pendaftar`
--

CREATE TABLE `pendaftar` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nisn` varchar(10) NOT NULL,
  `nama_lengkap` varchar(255) NOT NULL,
  `alamat_rumah` text NOT NULL,
  `jumlah_saudara` int(11) NOT NULL,
  `biaya_pendaftaran` bigint(20) NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `jenis_kelamin` enum('L','P') NOT NULL,
  `catatan_medis` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pendaftaran`
--

CREATE TABLE `pendaftaran` (
  `uid` int(16) NOT NULL,
  `no_pendaftaran` varchar(255) NOT NULL,
  `id_batch_pendaftaran` int(16) NOT NULL,
  `status_pendaftaran` varchar(255) NOT NULL,
  `diverifikasi_oleh` varchar(255) DEFAULT NULL,
  `alasan_penolakan` varchar(255) DEFAULT NULL,
  `jenis_penolakan` varchar(30) DEFAULT NULL,
  `tanggal_daftar` date NOT NULL,
  `calon_siswa_id` int(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pendaftaran`
--

INSERT INTO `pendaftaran` (`uid`, `no_pendaftaran`, `id_batch_pendaftaran`, `status_pendaftaran`, `diverifikasi_oleh`, `alasan_penolakan`, `jenis_penolakan`, `tanggal_daftar`, `calon_siswa_id`) VALUES
(1, 'REG-20260615-00007', 1, 'approved', 'admin@spmb.local', NULL, NULL, '2026-06-15', 7),
(2, 'REG-20260615-00009', 1, 'pending', NULL, NULL, NULL, '2026-06-15', 9),
(3, 'REG-20260615-00010', 1, 'approved', 'admin@spmb.local', NULL, NULL, '2026-06-15', 10),
(4, 'REG-20260615-00011', 1, 'approved', 'admin@spmb.local', NULL, NULL, '2026-06-15', 11),
(6, 'REG-20260615-00013', 1, 'approved', 'admin@spmb.local', NULL, NULL, '2026-06-15', 13),
(7, 'REG-20260615-00014', 1, 'rejected', 'admin@spmb.local', 'kamu jelek', NULL, '2026-06-15', 14),
(8, 'REG-20260615-00015', 1, 'approved', 'admin@spmb.local', NULL, NULL, '2026-06-15', 15),
(10, 'REG-20260616-00017', 1, 'rejected', 'admin@spmb.local', 'TIdak sesuai', 'berkas', '2026-06-16', 17),
(11, 'REG-20260616-00018', 1, 'approved', 'admin@spmb.local', NULL, NULL, '2026-06-16', 18);

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('XM4PI1KoGHWDhCG4h25d7y0PKayFcH5XShlmnOlG', 5, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'YTo3OntzOjY6Il90b2tlbiI7czo0MDoidEFzT0k4eTBWenZUd3VHUERtTUxWYksxeUNUN3F6cW91NER0Ym9SVyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzY6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9kYXNoYm9hcmRfb3J0dSI7czo1OiJyb3V0ZSI7czo5OiJkYXNoYm9hcmQiO31zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aTo1O3M6NDoicm9sZSI7czo0OiJ1c2VyIjtzOjU6ImVtYWlsIjtzOjIzOiJtaWNoYWVsYW5nZWxvQGdtYWlsLmNvbSI7czoxMjoidWlkX29yYW5ndHVhIjtpOjExO30=', 1781652514);

-- --------------------------------------------------------

--
-- Table structure for table `staf_spmb`
--

CREATE TABLE `staf_spmb` (
  `uid` int(16) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `jabatan` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `staf_spmb`
--

INSERT INTO `staf_spmb` (`uid`, `nama`, `jabatan`) VALUES
(1, 'Admin SPMB', 'admin'),
(2, 'Kepala Sekolah', 'kepsek');

-- --------------------------------------------------------

--
-- Table structure for table `tagihan`
--

CREATE TABLE `tagihan` (
  `uid` int(16) NOT NULL,
  `uid_pendaftaran` int(16) NOT NULL,
  `nomor_tagihan` varchar(255) NOT NULL,
  `subtotal_tagihan` decimal(15,2) NOT NULL DEFAULT 0.00,
  `diskon_tagihan` decimal(15,2) NOT NULL DEFAULT 0.00,
  `total_tagihan` decimal(15,2) NOT NULL,
  `status_tagihan` varchar(255) NOT NULL,
  `tanggal_tagihan` datetime DEFAULT NULL,
  `catatan_kepsek` varchar(255) DEFAULT NULL,
  `dibuat_oleh` varchar(255) DEFAULT NULL,
  `disetujui_oleh` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tagihan`
--

INSERT INTO `tagihan` (`uid`, `uid_pendaftaran`, `nomor_tagihan`, `subtotal_tagihan`, `diskon_tagihan`, `total_tagihan`, `status_tagihan`, `tanggal_tagihan`, `catatan_kepsek`, `dibuat_oleh`, `disetujui_oleh`, `created_at`, `updated_at`) VALUES
(1, 3, 'INV-20260615-00003', 2849998.00, 0.00, 2849998.00, 'pending', '2026-06-15 22:49:59', NULL, 'admin@spmb.local', NULL, '2026-06-15 22:49:59', '2026-06-15 22:49:59'),
(2, 8, 'INV-20260616-00008', 2750000.00, 0.00, 2750000.00, 'pending', '2026-06-16 13:21:20', NULL, 'admin@spmb.local', NULL, '2026-06-16 13:16:12', '2026-06-16 13:21:20'),
(3, 11, 'INV-20260616-00011', 2750000.00, 0.00, 2750000.00, 'pending', '2026-06-16 22:46:45', NULL, 'admin@spmb.local', NULL, '2026-06-16 22:46:45', '2026-06-16 22:46:45');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `uid` int(16) NOT NULL,
  `uid_user` int(16) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `hash_password` varchar(255) NOT NULL,
  `role` varchar(50) NOT NULL,
  `create_at` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`uid`, `uid_user`, `email`, `hash_password`, `role`, `create_at`) VALUES
(1, 1, 'admin@spmb.local', '$2y$12$NtxUmqieN2qF3rPyU67oj.LsBBhM6b.8gfdhVg4v/cbo2hcs/ATv.', 'admin', '2026-06-15'),
(2, 2, 'kepsek@spmb.local', '$2y$12$/OQyzgi6aycNd0JyN5TMsebKHp1IuczZK93Mopif.k0qU8Bsag57i', 'kepsek', '2026-06-15'),
(3, 0, 'alexanderwilliam189@gmail.com', '$2y$12$I8L.uU/vsEsZfSrLdf2bq.MAmugVKvGb8O37lhbyFdFAfSj/YGYWO', 'user', '2026-06-16'),
(4, 0, 'test2@gmail.com', '$2y$12$ar8XurEbJt2sPf4zmThndeGFbeR1fjv44AAp1Ww7PSSHFeM2/wy8C', 'user', '2026-06-16');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'eeeell', 'test@gmail.com', NULL, '$2y$12$lvbkciPKwrfV3kBjKmVTg.Y47wqUG0P0Adt5fRJ9.BJT2XwsynVum', NULL, NULL, NULL),
(2, 'el', 'test1@gmail.com', NULL, '$2y$12$6S.02/BnLhtbjATZhez7neCLT8VOzfdH3yzCvSfzvs/VufEY8uz/m', NULL, NULL, NULL),
(3, 'Alex', 'Alex20@gmail.com', NULL, '$2y$12$bAIdc1PqWs4eQGt98aJYYuLZLe4xSRbSDSnHisizVhvg6J2PsA1EK', NULL, NULL, NULL),
(4, 'Michael Angelo Praha Jeshua Immanuel', 'michaelsayang9@gmail.com', NULL, '$2y$12$UYwSlF5p8W3P3B03ltTr1O/oGnUL4kwg1HUqFeVnlgk2nIGrJQHeS', NULL, NULL, NULL),
(5, 'Angelo', 'michaelangelo@gmail.com', NULL, '$2y$12$PB90dv6wbIjXfWf1KweGjO.F6Z6GjZIR5.I/t8IhQ.aHU7F/0.ou6', NULL, '2026-06-15 09:09:50', '2026-06-15 09:09:50'),
(6, 'Arya', 'Arya@gmail.com', NULL, '$2y$12$ChkhCkuZnyKw3yWnZwSEk.O5ZSr1/NcQAUaSssFjVxz.C.UQg0SDa', NULL, '2026-06-15 12:06:59', '2026-06-15 12:06:59'),
(7, 'lex', 'lex@gmail.com', NULL, '$2y$12$6cl4DWBBc6xs9pBb4kUsnOaqCuDcJt0yFr6dyihxtDhMCjXzgDBgS', NULL, '2026-06-15 14:35:40', '2026-06-15 14:35:40'),
(8, 'alex', 'alex21@gmail.com', NULL, '$2y$12$uKa9D21C0Sx37aYJtdtpsO2RBvpgZFIz6eaa7leiEU8wlkUbnEJ1u', NULL, '2026-06-16 10:00:01', '2026-06-16 10:00:01');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `batch_pendaftaran`
--
ALTER TABLE `batch_pendaftaran`
  ADD PRIMARY KEY (`uid`);

--
-- Indexes for table `berkas`
--
ALTER TABLE `berkas`
  ADD PRIMARY KEY (`uid`),
  ADD KEY `id_pendaftar` (`id_pendaftar`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indexes for table `calon_siswa`
--
ALTER TABLE `calon_siswa`
  ADD PRIMARY KEY (`uid`),
  ADD UNIQUE KEY `nik` (`nik`),
  ADD KEY `uid_orangtua` (`uid_orangtua`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `komponen_tagihan`
--
ALTER TABLE `komponen_tagihan`
  ADD PRIMARY KEY (`uid`),
  ADD KEY `uid_tagihan` (`uid_tagihan`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orang_tua`
--
ALTER TABLE `orang_tua`
  ADD PRIMARY KEY (`uid`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `pendaftar`
--
ALTER TABLE `pendaftar`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `pendaftar_nisn_unique` (`nisn`);

--
-- Indexes for table `pendaftaran`
--
ALTER TABLE `pendaftaran`
  ADD PRIMARY KEY (`uid`),
  ADD UNIQUE KEY `no_pendaftaran` (`no_pendaftaran`),
  ADD KEY `id_batch_pendaftaran` (`id_batch_pendaftaran`),
  ADD KEY `calon_siswa_id` (`calon_siswa_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `staf_spmb`
--
ALTER TABLE `staf_spmb`
  ADD PRIMARY KEY (`uid`);

--
-- Indexes for table `tagihan`
--
ALTER TABLE `tagihan`
  ADD PRIMARY KEY (`uid`),
  ADD UNIQUE KEY `nomor_tagihan` (`nomor_tagihan`),
  ADD KEY `uid_pendaftaran` (`uid_pendaftaran`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`uid`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `batch_pendaftaran`
--
ALTER TABLE `batch_pendaftaran`
  MODIFY `uid` int(16) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `berkas`
--
ALTER TABLE `berkas`
  MODIFY `uid` int(16) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `calon_siswa`
--
ALTER TABLE `calon_siswa`
  MODIFY `uid` int(16) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `komponen_tagihan`
--
ALTER TABLE `komponen_tagihan`
  MODIFY `uid` int(16) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `orang_tua`
--
ALTER TABLE `orang_tua`
  MODIFY `uid` int(16) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `pendaftar`
--
ALTER TABLE `pendaftar`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pendaftaran`
--
ALTER TABLE `pendaftaran`
  MODIFY `uid` int(16) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `staf_spmb`
--
ALTER TABLE `staf_spmb`
  MODIFY `uid` int(16) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tagihan`
--
ALTER TABLE `tagihan`
  MODIFY `uid` int(16) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `uid` int(16) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `berkas`
--
ALTER TABLE `berkas`
  ADD CONSTRAINT `berkas_ibfk_1` FOREIGN KEY (`id_pendaftar`) REFERENCES `pendaftaran` (`uid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `calon_siswa`
--
ALTER TABLE `calon_siswa`
  ADD CONSTRAINT `calon_siswa_ibfk_1` FOREIGN KEY (`uid_orangtua`) REFERENCES `orang_tua` (`uid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `komponen_tagihan`
--
ALTER TABLE `komponen_tagihan`
  ADD CONSTRAINT `komponen_tagihan_ibfk_1` FOREIGN KEY (`uid_tagihan`) REFERENCES `tagihan` (`uid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `pendaftaran`
--
ALTER TABLE `pendaftaran`
  ADD CONSTRAINT `pendaftaran_ibfk_1` FOREIGN KEY (`id_batch_pendaftaran`) REFERENCES `batch_pendaftaran` (`uid`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pendaftaran_ibfk_2` FOREIGN KEY (`calon_siswa_id`) REFERENCES `calon_siswa` (`uid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tagihan`
--
ALTER TABLE `tagihan`
  ADD CONSTRAINT `tagihan_ibfk_1` FOREIGN KEY (`uid_pendaftaran`) REFERENCES `pendaftaran` (`uid`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
