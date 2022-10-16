-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Sep 04, 2022 at 05:36 PM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ams_ta_ech`
--

-- --------------------------------------------------------

--
-- Table structure for table `absensipegawai`
--

CREATE TABLE `absensipegawai` (
  `uid` int(10) UNSIGNED NOT NULL,
  `id` int(11) NOT NULL,
  `id_admin` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_lengkap` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `selfie_masuk` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `selfie_pulang` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `jam_masuk` time DEFAULT NULL,
  `jam_pulang` time DEFAULT NULL,
  `jam_kerja` time DEFAULT NULL,
  `keterangan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `latitude` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `longitude` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `akunpegawai`
--

CREATE TABLE `akunpegawai` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_admin` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_jabatan` int(10) UNSIGNED NOT NULL,
  `id_golongan` int(10) UNSIGNED DEFAULT NULL,
  `role` enum('Manager','Admin','Pegawai') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Pegawai',
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jumlah_kerja` int(11) DEFAULT NULL,
  `tanggal_masuk` date NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Aktif',
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bonus`
--

CREATE TABLE `bonus` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_admin` int(10) UNSIGNED NOT NULL,
  `jenis_bonus` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nominal` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cuti`
--

CREATE TABLE `cuti` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_admin` int(10) UNSIGNED NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_pegawai` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_lengkap` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jumlah_hari` int(11) NOT NULL,
  `tanggal_cuti` date NOT NULL,
  `tanggal_mulai` date NOT NULL,
  `tanggal_akhir` date NOT NULL,
  `jenis_cuti` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `keterangan` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `bukti_cuti` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status_cuti` enum('Diterima','Ditolak','Diproses') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Diproses',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cuti_perusahaans`
--

CREATE TABLE `cuti_perusahaans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cuti_tahunans`
--

CREATE TABLE `cuti_tahunans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `datagaji`
--

CREATE TABLE `datagaji` (
  `id` int(11) NOT NULL,
  `id_admin` int(11) NOT NULL,
  `no_pegawai` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_lengkap` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_jabatan` int(10) UNSIGNED NOT NULL,
  `id_golongan` int(10) UNSIGNED DEFAULT NULL,
  `id_tunjangan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_bonus` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_potongan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `total_tunjangan` int(11) DEFAULT NULL,
  `total_bonus` int(11) DEFAULT NULL,
  `total_potongan` int(11) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `jam_kerja` time DEFAULT NULL,
  `status` enum('Aktif','Tidak Aktif') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Aktif',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `golongan`
--

CREATE TABLE `golongan` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_admin` int(10) UNSIGNED NOT NULL,
  `golongan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pendidikan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nominal` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hari`
--

CREATE TABLE `hari` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `hari` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hitung_gaji`
--

CREATE TABLE `hitung_gaji` (
  `id` int(11) NOT NULL,
  `id_admin` int(11) NOT NULL,
  `no_gaji` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tunjangan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bonus` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `potongan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nominal_tunjangan` int(11) DEFAULT NULL,
  `nominal_bonus` int(11) DEFAULT NULL,
  `nominal_potongan` int(11) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `izin`
--

CREATE TABLE `izin` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_admin` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_lengkap` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_pegawai` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jenis_izin` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bukti` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status_izin` enum('Diproses','Diterima','Ditolak') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Diproses',
  `tanggal` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jabatan`
--

CREATE TABLE `jabatan` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_admin` int(10) UNSIGNED NOT NULL,
  `jabatan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gaji` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `jabatan`
--

INSERT INTO `jabatan` (`id`, `id_admin`, `jabatan`, `gaji`, `created_at`, `updated_at`) VALUES
(1, 1, 'Manager', 8000000, NULL, NULL),
(2, 1, 'Admin HRD', 5000000, NULL, NULL),
(3, 1, 'HRD', 5000000, NULL, NULL),
(4, 1, 'Staff HRD', 4500000, NULL, NULL),
(5, 1, 'Programmer', 10000000, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `jamabsen`
--

CREATE TABLE `jamabsen` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_admin` int(10) UNSIGNED NOT NULL,
  `jam_masuk` time NOT NULL DEFAULT '00:00:00',
  `jam_pulang` time NOT NULL DEFAULT '00:00:00',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `laporan`
--

CREATE TABLE `laporan` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_admin` int(10) UNSIGNED NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_pegawai` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_lengkap` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal_laporan` date NOT NULL,
  `id_jabatan` int(10) UNSIGNED NOT NULL,
  `deskripsi` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `lampiran` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status_laporan` enum('Diterima','Ditolak','Diproses') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Diproses',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lembur`
--

CREATE TABLE `lembur` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_admin` int(10) UNSIGNED NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal_lembur` date NOT NULL,
  `nama_lengkap` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_pegawai` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jammulai` time NOT NULL,
  `jamselesai` time NOT NULL,
  `aktifitas` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `buktilembur` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status_lembur` enum('Diterima','Ditolak','Diproses') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Diproses',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `master_cuti_perusahaan`
--

CREATE TABLE `master_cuti_perusahaan` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_admin` int(11) NOT NULL,
  `jumlah_cuti` int(11) NOT NULL,
  `tahun` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_05_07_013751_create_users_table', 1),
(2, '2019_08_19_000000_create_failed_jobs_table', 1),
(3, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(4, '2022_05_06_120505_create_perusahaan_table', 1),
(5, '2022_05_07_013316_create_jabatan_table', 1),
(6, '2022_05_7_160800_create_golongan_table', 1),
(7, '2022_06_04_103808_create_absensipegawai_table', 1),
(8, '2022_06_17_164136_create_tunjangan_table', 1),
(9, '2022_06_18_030251_create_bonus_table', 1),
(10, '2022_06_20_035749_create_pegawais_table', 1),
(11, '2022_06_20_041650_create_jamabsen_table', 1),
(12, '2022_06_22_031302_create_potongan_table', 1),
(13, '2022_06_24_175203_create_akunpegawai_table', 1),
(14, '2022_06_29_071757_create_reqabsen_table', 1),
(15, '2022_06_29_071830_create_izin_table', 1),
(16, '2022_07_01_131018_create_lembur_table', 1),
(17, '2022_07_01_140708_create_laporan_table', 1),
(18, '2022_07_04_043842_create_hitung_gaji_table', 1),
(19, '2022_07_04_105842_create_datagaji_table', 1),
(20, '2022_07_04_111420_master_cuti_perusahaan', 1),
(21, '2022_07_04_111425_create_table_master_cuti_tahunan', 1),
(22, '2022_07_04_111428_create_cuti_table', 1),
(23, '2022_07_27_171731_create_password_resets_table', 1),
(24, '2022_08_05_100540_create_hari_table', 1),
(25, '2022_08_05_113124_create_riwayatgaji_table', 1),
(26, '2022_08_05_113509_create_penggajian_table', 1),
(27, '2022_08_17_152810_create_cuti_tahunans_table', 1),
(28, '2022_08_17_191718_create_cuti_perusahaans_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pegawais`
--

CREATE TABLE `pegawais` (
  `id` int(11) NOT NULL,
  `id_admin` int(11) NOT NULL,
  `no_pegawai` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_lengkap` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pendidikan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_golongan` int(10) UNSIGNED DEFAULT NULL,
  `id_jabatan` int(10) UNSIGNED NOT NULL,
  `jam_kerja` time DEFAULT NULL,
  `no_ktp` bigint(20) DEFAULT NULL,
  `no_hp` bigint(20) DEFAULT NULL,
  `alamat` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jumlah_kerja` int(11) DEFAULT NULL,
  `jatah_cuti` int(11) DEFAULT NULL,
  `tanggal_masuk` date NOT NULL,
  `status` enum('Aktif','Tidak Aktif') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Aktif',
  `gender` enum('Laki-Laki','Perempuan') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `logout_at` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `penggajian`
--

CREATE TABLE `penggajian` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_admin` int(11) NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_jabatan` int(10) UNSIGNED NOT NULL,
  `id_golongan` int(10) UNSIGNED DEFAULT NULL,
  `id_tunjangan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '-',
  `id_bonus` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '-',
  `id_potongan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '-',
  `total_tunjangan` int(11) DEFAULT NULL,
  `total_bonus` int(11) DEFAULT NULL,
  `total_potongan` int(11) DEFAULT NULL,
  `total_gaji` int(11) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Belum Diambil',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `perusahaan`
--

CREATE TABLE `perusahaan` (
  `id` int(10) UNSIGNED NOT NULL,
  `nama_perusahaan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jumlah_karyawan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `admin_perusahaan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_perusahaan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `provinsi` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kota` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `npwp` bigint(20) DEFAULT NULL,
  `kode_pos` int(11) DEFAULT NULL,
  `det_alamat` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bidang` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `potongan`
--

CREATE TABLE `potongan` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_admin` int(10) UNSIGNED NOT NULL,
  `jenis_potongan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nominal` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reqabsen`
--

CREATE TABLE `reqabsen` (
  `uid` int(10) UNSIGNED NOT NULL,
  `id` int(11) NOT NULL,
  `id_admin` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_lengkap` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_pegawai` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alasan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bukti_pendukung` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status_req` enum('Diproses','Diterima','Ditolak') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Diproses',
  `tanggal_req` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `riwayatgaji`
--

CREATE TABLE `riwayatgaji` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_admin` int(11) NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_jabatan` int(10) UNSIGNED NOT NULL,
  `id_golongan` int(10) UNSIGNED DEFAULT NULL,
  `tunjangan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nominal_tunjangan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `total_tunjangan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bonus` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nominal_bonus` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `total_bonus` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `potongan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nominal_potongan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `total_potongan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gaji_kotor` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gaji_bersih` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gaji_pokok` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Belum Diambil',
  `tanggal_ambil` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `table_master_cuti_tahunan`
--

CREATE TABLE `table_master_cuti_tahunan` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_admin` int(10) UNSIGNED NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_pegawai` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_lengkap` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_cuti` int(10) UNSIGNED NOT NULL,
  `jumlah_cuti` int(11) NOT NULL,
  `cuti_terpakai` int(11) NOT NULL,
  `sisa_cuti` int(11) NOT NULL,
  `tahun` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tunjangan`
--

CREATE TABLE `tunjangan` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_admin` int(10) UNSIGNED NOT NULL,
  `jenis_tunjangan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nominal` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('Manager','Admin','Pegawai') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Admin',
  `jabatan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nama_perusahaan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `provinsi` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kota` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `det_alamat` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `npwp` bigint(20) DEFAULT NULL,
  `kode_pos` int(11) DEFAULT NULL,
  `bidang` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jumlah_karyawan` int(11) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `logout_at` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `role`, `jabatan`, `nama_perusahaan`, `provinsi`, `kota`, `det_alamat`, `npwp`, `kode_pos`, `bidang`, `jumlah_karyawan`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `logout_at`) VALUES
(1, 'Admin', 'admin@gmail.com', 'Admin', 'CEO', 'PT AMS Indonesia', 'Jawa Tengah', 'Surakarta', 'Sekolah Vokasi Universitas Sebelas Maret, Surakarta, Jawa Tengah', 123456789, 12345, 'IT', 50, NULL, '$2y$10$BLePaez954rTMkQcoOdqOODiQzbIKQwWvxqLg38s2l/pTz0FWwtxu', NULL, NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `absensipegawai`
--
ALTER TABLE `absensipegawai`
  ADD PRIMARY KEY (`uid`);

--
-- Indexes for table `akunpegawai`
--
ALTER TABLE `akunpegawai`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `akunpegawai_email_unique` (`email`),
  ADD KEY `akunpegawai_id_admin_foreign` (`id_admin`),
  ADD KEY `akunpegawai_id_jabatan_foreign` (`id_jabatan`),
  ADD KEY `akunpegawai_id_golongan_foreign` (`id_golongan`);

--
-- Indexes for table `bonus`
--
ALTER TABLE `bonus`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bonus_id_admin_foreign` (`id_admin`);

--
-- Indexes for table `cuti`
--
ALTER TABLE `cuti`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cuti_id_admin_foreign` (`id_admin`);

--
-- Indexes for table `cuti_perusahaans`
--
ALTER TABLE `cuti_perusahaans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cuti_tahunans`
--
ALTER TABLE `cuti_tahunans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `datagaji`
--
ALTER TABLE `datagaji`
  ADD UNIQUE KEY `datagaji_email_unique` (`email`),
  ADD KEY `datagaji_id_jabatan_foreign` (`id_jabatan`),
  ADD KEY `datagaji_id_golongan_foreign` (`id_golongan`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `golongan`
--
ALTER TABLE `golongan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `golongan_id_admin_foreign` (`id_admin`);

--
-- Indexes for table `hari`
--
ALTER TABLE `hari`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `izin`
--
ALTER TABLE `izin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jabatan`
--
ALTER TABLE `jabatan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jabatan_id_admin_foreign` (`id_admin`);

--
-- Indexes for table `jamabsen`
--
ALTER TABLE `jamabsen`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `jamabsen_id_unique` (`id`),
  ADD KEY `jamabsen_id_admin_foreign` (`id_admin`);

--
-- Indexes for table `laporan`
--
ALTER TABLE `laporan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `laporan_id_admin_foreign` (`id_admin`),
  ADD KEY `laporan_id_jabatan_foreign` (`id_jabatan`);

--
-- Indexes for table `lembur`
--
ALTER TABLE `lembur`
  ADD PRIMARY KEY (`id`),
  ADD KEY `lembur_id_admin_foreign` (`id_admin`);

--
-- Indexes for table `master_cuti_perusahaan`
--
ALTER TABLE `master_cuti_perusahaan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `pegawais`
--
ALTER TABLE `pegawais`
  ADD UNIQUE KEY `pegawais_email_unique` (`email`),
  ADD KEY `pegawais_id_golongan_foreign` (`id_golongan`),
  ADD KEY `pegawais_id_jabatan_foreign` (`id_jabatan`);

--
-- Indexes for table `penggajian`
--
ALTER TABLE `penggajian`
  ADD PRIMARY KEY (`id`),
  ADD KEY `penggajian_id_jabatan_foreign` (`id_jabatan`),
  ADD KEY `penggajian_id_golongan_foreign` (`id_golongan`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `perusahaan`
--
ALTER TABLE `perusahaan`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `perusahaan_email_perusahaan_unique` (`email_perusahaan`);

--
-- Indexes for table `potongan`
--
ALTER TABLE `potongan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `potongan_id_admin_foreign` (`id_admin`);

--
-- Indexes for table `reqabsen`
--
ALTER TABLE `reqabsen`
  ADD PRIMARY KEY (`uid`);

--
-- Indexes for table `riwayatgaji`
--
ALTER TABLE `riwayatgaji`
  ADD PRIMARY KEY (`id`),
  ADD KEY `riwayatgaji_id_golongan_foreign` (`id_golongan`);

--
-- Indexes for table `table_master_cuti_tahunan`
--
ALTER TABLE `table_master_cuti_tahunan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `table_master_cuti_tahunan_id_admin_foreign` (`id_admin`),
  ADD KEY `table_master_cuti_tahunan_id_cuti_foreign` (`id_cuti`);

--
-- Indexes for table `tunjangan`
--
ALTER TABLE `tunjangan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tunjangan_id_admin_foreign` (`id_admin`);

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
-- AUTO_INCREMENT for table `absensipegawai`
--
ALTER TABLE `absensipegawai`
  MODIFY `uid` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `akunpegawai`
--
ALTER TABLE `akunpegawai`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bonus`
--
ALTER TABLE `bonus`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cuti`
--
ALTER TABLE `cuti`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cuti_perusahaans`
--
ALTER TABLE `cuti_perusahaans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cuti_tahunans`
--
ALTER TABLE `cuti_tahunans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `golongan`
--
ALTER TABLE `golongan`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hari`
--
ALTER TABLE `hari`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `izin`
--
ALTER TABLE `izin`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jabatan`
--
ALTER TABLE `jabatan`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `jamabsen`
--
ALTER TABLE `jamabsen`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `laporan`
--
ALTER TABLE `laporan`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lembur`
--
ALTER TABLE `lembur`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `master_cuti_perusahaan`
--
ALTER TABLE `master_cuti_perusahaan`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `penggajian`
--
ALTER TABLE `penggajian`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `perusahaan`
--
ALTER TABLE `perusahaan`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `potongan`
--
ALTER TABLE `potongan`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reqabsen`
--
ALTER TABLE `reqabsen`
  MODIFY `uid` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `riwayatgaji`
--
ALTER TABLE `riwayatgaji`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `table_master_cuti_tahunan`
--
ALTER TABLE `table_master_cuti_tahunan`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tunjangan`
--
ALTER TABLE `tunjangan`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `akunpegawai`
--
ALTER TABLE `akunpegawai`
  ADD CONSTRAINT `akunpegawai_id_admin_foreign` FOREIGN KEY (`id_admin`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `akunpegawai_id_golongan_foreign` FOREIGN KEY (`id_golongan`) REFERENCES `golongan` (`id`),
  ADD CONSTRAINT `akunpegawai_id_jabatan_foreign` FOREIGN KEY (`id_jabatan`) REFERENCES `jabatan` (`id`);

--
-- Constraints for table `bonus`
--
ALTER TABLE `bonus`
  ADD CONSTRAINT `bonus_id_admin_foreign` FOREIGN KEY (`id_admin`) REFERENCES `users` (`id`);

--
-- Constraints for table `cuti`
--
ALTER TABLE `cuti`
  ADD CONSTRAINT `cuti_id_admin_foreign` FOREIGN KEY (`id_admin`) REFERENCES `akunpegawai` (`id_admin`);

--
-- Constraints for table `datagaji`
--
ALTER TABLE `datagaji`
  ADD CONSTRAINT `datagaji_id_golongan_foreign` FOREIGN KEY (`id_golongan`) REFERENCES `golongan` (`id`),
  ADD CONSTRAINT `datagaji_id_jabatan_foreign` FOREIGN KEY (`id_jabatan`) REFERENCES `jabatan` (`id`);

--
-- Constraints for table `golongan`
--
ALTER TABLE `golongan`
  ADD CONSTRAINT `golongan_id_admin_foreign` FOREIGN KEY (`id_admin`) REFERENCES `users` (`id`);

--
-- Constraints for table `jabatan`
--
ALTER TABLE `jabatan`
  ADD CONSTRAINT `jabatan_id_admin_foreign` FOREIGN KEY (`id_admin`) REFERENCES `users` (`id`);

--
-- Constraints for table `jamabsen`
--
ALTER TABLE `jamabsen`
  ADD CONSTRAINT `jamabsen_id_admin_foreign` FOREIGN KEY (`id_admin`) REFERENCES `users` (`id`);

--
-- Constraints for table `laporan`
--
ALTER TABLE `laporan`
  ADD CONSTRAINT `laporan_id_admin_foreign` FOREIGN KEY (`id_admin`) REFERENCES `akunpegawai` (`id_admin`),
  ADD CONSTRAINT `laporan_id_jabatan_foreign` FOREIGN KEY (`id_jabatan`) REFERENCES `akunpegawai` (`id`);

--
-- Constraints for table `lembur`
--
ALTER TABLE `lembur`
  ADD CONSTRAINT `lembur_id_admin_foreign` FOREIGN KEY (`id_admin`) REFERENCES `akunpegawai` (`id_admin`);

--
-- Constraints for table `pegawais`
--
ALTER TABLE `pegawais`
  ADD CONSTRAINT `pegawais_id_golongan_foreign` FOREIGN KEY (`id_golongan`) REFERENCES `golongan` (`id`),
  ADD CONSTRAINT `pegawais_id_jabatan_foreign` FOREIGN KEY (`id_jabatan`) REFERENCES `jabatan` (`id`);

--
-- Constraints for table `penggajian`
--
ALTER TABLE `penggajian`
  ADD CONSTRAINT `penggajian_id_golongan_foreign` FOREIGN KEY (`id_golongan`) REFERENCES `golongan` (`id`),
  ADD CONSTRAINT `penggajian_id_jabatan_foreign` FOREIGN KEY (`id_jabatan`) REFERENCES `jabatan` (`id`);

--
-- Constraints for table `potongan`
--
ALTER TABLE `potongan`
  ADD CONSTRAINT `potongan_id_admin_foreign` FOREIGN KEY (`id_admin`) REFERENCES `users` (`id`);

--
-- Constraints for table `riwayatgaji`
--
ALTER TABLE `riwayatgaji`
  ADD CONSTRAINT `riwayatgaji_id_golongan_foreign` FOREIGN KEY (`id_golongan`) REFERENCES `golongan` (`id`);

--
-- Constraints for table `table_master_cuti_tahunan`
--
ALTER TABLE `table_master_cuti_tahunan`
  ADD CONSTRAINT `table_master_cuti_tahunan_id_admin_foreign` FOREIGN KEY (`id_admin`) REFERENCES `akunpegawai` (`id_admin`),
  ADD CONSTRAINT `table_master_cuti_tahunan_id_cuti_foreign` FOREIGN KEY (`id_cuti`) REFERENCES `master_cuti_perusahaan` (`id`);

--
-- Constraints for table `tunjangan`
--
ALTER TABLE `tunjangan`
  ADD CONSTRAINT `tunjangan_id_admin_foreign` FOREIGN KEY (`id_admin`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
