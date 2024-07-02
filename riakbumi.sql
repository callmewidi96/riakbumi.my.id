-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 24, 2024 at 11:34 AM
-- Server version: 10.6.18-MariaDB
-- PHP Version: 8.1.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `riakbumi_riakbumi`
--

-- --------------------------------------------------------

--
-- Table structure for table `barang`
--

CREATE TABLE `barang` (
  `kode_barang` int(11) NOT NULL,
  `nama_barang` varchar(32) NOT NULL,
  `gambar` varchar(255) NOT NULL,
  `berat_barang` int(4) NOT NULL,
  `satuan_berat` varchar(2) NOT NULL,
  `kategori` varchar(10) NOT NULL,
  `deskripsi` varchar(255) NOT NULL,
  `stok` int(6) NOT NULL,
  `harga` int(6) NOT NULL,
  `terjual` int(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `barang`
--

INSERT INTO `barang` (`kode_barang`, `nama_barang`, `gambar`, `berat_barang`, `satuan_berat`, `kategori`, `deskripsi`, `stok`, `harga`, `terjual`) VALUES
(1, 'Madu 500gram', 'photo_2023-10-14_14-34-40.jpg', 500, 'kg', 'Konsumsi', '', 96, 130000, 48),
(2, 'Madu 300gram', 'photo_2023-10-14_14-35-14.jpg', 0, '', 'Konsumsi', 'madu asli berat 300gram', 122, 90000, 35),
(3, 'Madu 1kg', 'photo_2023-10-14_14-35-49.jpg', 1, 'kg', 'Konsumsi', '', 2, 240000, 33),
(4, 'Body Lotion', 'photo_2023-10-14_14-37-11.jpg', 100, '', 'Kosmetik', 'body lotion terbuat dari minyak tengkawang dengan berat 100ml', 28170, 100000, 48),
(5, 'Conditioner ', 'photo_2023-10-14_14-38-04.jpg', 0, '', 'Kosmetik', 'conditioner dari minyak tengkawang dengan berat 30g', 26, 65000, 40),
(6, 'Bodywash', 'bodywash.jpeg', 0, '', 'Kosmetik', 'Bodywash dari minyak tengkawang dengan berat 100ml', 5, 100000, 12),
(7, 'Kain tenun ukuran 120x240cm', 'Kain Tenun 120x240.jpeg', 0, '', 'Kain Tenun', 'kain tenun dengan lebar 120x240cm', 2, 150000, 11),
(12, 'Madu 300gram 21% kadar air', 'madu.jpeg', 0, '', 'Konsumsi', 'madu dengan berat 300gram', 7, 65000, 3),
(14, 'Hairmask dengan ekstrat nanas', 'lipbam.jpeg', 0, '', 'Kosmetik', 'terbuat dari ekstrak nanas', 10, 99000, 0),
(15, 'kain motif dayak', 'kain motif ukiran.jpeg', 0, '', 'Kain Tenun', 'kain dengan ukiran motif dayak diujir dengan bahan alami', 9, 1500000, 0),
(16, 'keranjang dari rotan', 'keranjang.jpeg', 0, '', 'kerajinan', 'terbuat dari bahan rotan\r\nukuran:\r\npanjang 27cm\r\nlebar-+14cm\r\ntinggi 8cm', 4, 48000, 0),
(17, 'Shampo ', 'shampo.jpeg', 0, '', 'Kosmetik', 'shampo dengan kukui oil dan vitamin B5', 5, 105000, 1),
(20, 'Body Scrub', 'body scrub.jpeg', 0, '', 'Kosmetik', 'Body Scrub natural', 15, 105000, 1),
(21, 'madu 5kg', 'madu.jpeg', 5, 'kg', 'Konsumsi', '', 2, 200000, 3);

-- --------------------------------------------------------

--
-- Table structure for table `jasa_antar`
--

CREATE TABLE `jasa_antar` (
  `no` int(11) NOT NULL,
  `nama_jasa_antar` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `jasa_antar`
--

INSERT INTO `jasa_antar` (`no`, `nama_jasa_antar`) VALUES
(1, 'JNE'),
(2, 'TIKI'),
(3, 'POS');

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `kode_kategori` int(11) NOT NULL,
  `nama_kategori` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`kode_kategori`, `nama_kategori`) VALUES
(1, 'Konsumsi'),
(2, 'Kosmetik'),
(3, 'Kain Tenun'),
(4, 'kerajinan');

-- --------------------------------------------------------

--
-- Table structure for table `keranjang`
--

CREATE TABLE `keranjang` (
  `kode_keranjang` int(11) NOT NULL,
  `username` varchar(32) NOT NULL,
  `kode_barang` int(11) NOT NULL,
  `jumlah` int(6) NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `keranjang`
--

INSERT INTO `keranjang` (`kode_keranjang`, `username`, `kode_barang`, `jumlah`, `status`) VALUES
(153, 'user', 4, 3, 0),
(154, 'user', 1, 3, 1),
(156, 'Caca', 4, 10, 0),
(157, 'Caca', 3, 2, 0),
(158, 'Caca', 21, 2, 0);

-- --------------------------------------------------------

--
-- Table structure for table `pembelian`
--

CREATE TABLE `pembelian` (
  `no_faktur` varchar(13) NOT NULL,
  `pembeli` varchar(32) NOT NULL,
  `supplier` varchar(255) NOT NULL,
  `tgl_pembelian` date NOT NULL,
  `total_harga_pembelian` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pembelian`
--

INSERT INTO `pembelian` (`no_faktur`, `pembeli`, `supplier`, `tgl_pembelian`, `total_harga_pembelian`) VALUES
('0', 'agi', 'anda', '2024-06-14', 2250000),
('1', 'admin', 'Anda', '2023-12-07', 1530000),
('112', 'Niko', 'Arcia oil', '2024-04-27', 1500000),
('112345', 'Adi', 'Petani', '2023-12-30', 880000),
('112345678', 'Agi', 'PT Wilma Pontianak', '2024-01-13', 2115000),
('113', 'Jerfi', 'Budi', '2024-04-27', 600000),
('12', 'Jefri', 'Dodi', '2024-04-20', 240000),
('1234678901', 'Agi', 'sinar pusaka', '2024-01-01', 60000),
('19213123', 'Admin', 'Supplier', '2023-12-20', 200000),
('2245', 'Niko', 'Arcila oil ', '2024-04-20', 1050000),
('2406241029171', 'Ani', 'Budi', '2024-06-24', 225000),
('999', 'agi', 'budi', '2024-06-15', 1500000);

-- --------------------------------------------------------

--
-- Table structure for table `pembelian_detail`
--

CREATE TABLE `pembelian_detail` (
  `no` int(11) NOT NULL,
  `no_faktur` varchar(13) NOT NULL,
  `nama_barang` varchar(32) NOT NULL,
  `harga_beli` int(11) NOT NULL,
  `jumlah_beli` int(11) NOT NULL,
  `berat_barang` int(5) NOT NULL,
  `satuan_berat` varchar(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pembelian_detail`
--

INSERT INTO `pembelian_detail` (`no`, `no_faktur`, `nama_barang`, `harga_beli`, `jumlah_beli`, `berat_barang`, `satuan_berat`) VALUES
(1, '1', 'Madu 500gram', 10000, 10, 0, ''),
(4, '19213123', 'Madu 300gram', 200000, 1, 0, ''),
(7, '112345', 'Madu 1kg', 300000, 1, 0, ''),
(8, '112345', 'Body Lotion', 58000, 10, 0, ''),
(9, '1234678901', 'Madu 500gram', 30000, 2, 0, ''),
(11, '112345678', 'Body Lotion', 45000, 47, 0, ''),
(12, '12', 'Madu/kg', 80000, 3, 0, ''),
(13, '1', 'Kain tenun', 50000, 10, 0, ''),
(14, '1', 'Kain tenun', 50000, 10, 0, ''),
(15, '1', 'Kain tenun', 50000, 10, 0, ''),
(16, '1', 'Kain tenun', 50000, 10, 0, ''),
(17, '1', 'Kain tenun', 50000, 10, 0, ''),
(18, '1', 'Kain tenun', 50000, 10, 0, ''),
(19, '113', 'Kain tenun', 60000, 10, 0, ''),
(20, '112', 'Body Lotion ', 50000, 30, 0, ''),
(21, '2245', 'Body lotion ', 50000, 21, 0, ''),
(25, '0', 'Madu 300gram', 45000, 50, 0, ''),
(39, '2406231328261', 'Body Lotion', 38000, 28000, 0, ''),
(40, '2406232147341', 'Madu', 200000, 1, 0, ''),
(41, '2406232150211', 'Body Lotion', 48000, 10, 0, ''),
(42, '2406201937591', 'Madu 500gram', 85000, 2, 0, ''),
(43, '2406201803351', 'Madu 500gram', 5000, 5, 0, ''),
(44, '2406201803351', 'Madu 1kg', 10000, 2, 0, ''),
(45, '3', 'Madu 500gram', 10000, 10, 0, ''),
(46, '3', 'Madu 1kg', 16000, 15, 0, ''),
(47, '1213', 'Madu 300gram', 2500000, 2, 0, ''),
(48, '1213', 'Madu 300gram', 2500000, 2, 0, ''),
(50, '999', 'madu', 100000, 15, 300, 'g'),
(51, '2406241029171', 'Bodywash', 45000, 5, 130, 'g');

-- --------------------------------------------------------

--
-- Table structure for table `penjualan`
--

CREATE TABLE `penjualan` (
  `kode_penjualan` varchar(13) NOT NULL,
  `username` varchar(32) NOT NULL,
  `nohp_terima` varchar(13) NOT NULL,
  `alamat_terima` varchar(255) NOT NULL,
  `nama_jasa_antar` varchar(32) NOT NULL,
  `paket_pengantaran` varchar(255) NOT NULL,
  `total_harga_barang` int(6) NOT NULL,
  `harga_ongkir` int(6) NOT NULL,
  `tgl_pesan` date NOT NULL,
  `tgl_hapus` datetime NOT NULL,
  `tgl_estimasi` date NOT NULL,
  `tgl_bayar` date NOT NULL,
  `tgl_antar` date NOT NULL,
  `tgl_terima` date NOT NULL,
  `status` varchar(20) NOT NULL,
  `pembayaran` varchar(30) NOT NULL,
  `bukti_antar` varchar(255) NOT NULL,
  `bukti_terima` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `penjualan`
--

INSERT INTO `penjualan` (`kode_penjualan`, `username`, `nohp_terima`, `alamat_terima`, `nama_jasa_antar`, `paket_pengantaran`, `total_harga_barang`, `harga_ongkir`, `tgl_pesan`, `tgl_hapus`, `tgl_estimasi`, `tgl_bayar`, `tgl_antar`, `tgl_terima`, `status`, `pembayaran`, `bukti_antar`, `bukti_terima`) VALUES
('2311181318181', 'Widi', '', 'Perdana', 'JNE', '', 1260000, 0, '2023-11-18', '0000-00-00 00:00:00', '2024-06-06', '2023-11-18', '2024-06-06', '0000-00-00', 'Diantar', '', '', ''),
('2311181323391', 'Widi', '', 'Perdana', 'JNE', '', 65000, 0, '2023-11-18', '0000-00-00 00:00:00', '2023-11-18', '2023-11-18', '2023-11-18', '2023-11-18', 'Diterima', '', '', ''),
('2311181341301', 'Widi', '', 'Perdana', 'JNE', '', 100000, 0, '2023-11-18', '0000-00-00 00:00:00', '2023-11-18', '2023-11-18', '2023-11-18', '2023-11-18', 'Diterima', '', '', ''),
('2311181352001', 'bella', '', 'Jakarta', 'JNE', '', 240000, 0, '2023-11-18', '0000-00-00 00:00:00', '2023-11-18', '0000-00-00', '2023-11-18', '0000-00-00', 'Diantar', '', '', ''),
('2311181450121', 'Widi', '', '', 'JNE', '', 90000, 0, '2023-11-18', '0000-00-00 00:00:00', '2023-11-17', '2023-11-18', '2023-11-18', '2023-11-18', 'Diterima', '', '', ''),
('2312061847081', 'Widi', '081122334560', 'Perdana<br>Kabupaten Landak, Kalimantan Barat', 'JNE', 'YES (Yakin Esok Sampai), Estimasi Sampai : 1-1 hari', 65000, 15000, '2023-12-06', '0000-00-00 00:00:00', '2023-12-08', '2023-12-06', '2023-12-09', '2023-12-08', 'Diterima', '', '', ''),
('2312081456211', 'Budi', '081234567800', 'yogyakarta<br>Kota Yogyakarta, DI Yogyakarta', 'JNE', 'OKE (Ongkos Kirim Ekonomis), Estimasi Sampai : 3-4 hari', 240000, 34000, '2023-12-08', '0000-00-00 00:00:00', '2023-12-08', '0000-00-00', '2023-12-08', '2023-12-12', 'Diterima', '', '', ''),
('2312311125461', 'Widi', '081122334560', 'Perdana<br>Kabupaten Pontianak, Kalimantan Barat', 'TIKI', 'REG (Regular Service), Estimasi Sampai : 2 hari', 130000, 9000, '2023-12-31', '2024-01-01 11:25:46', '2024-01-15', '0000-00-00', '2024-01-14', '0000-00-00', 'Diantar', '', '', ''),
('2401141541161', 'Aldi', '082134569876', 'Paris 2<br>Kota Pontianak, Kalimantan Barat', 'JNE', 'CTC (JNE City Courier), Estimasi Sampai : 1-2 hari', 90000, 7000, '2024-01-14', '2024-01-15 15:41:16', '2024-01-15', '0000-00-00', '2024-01-14', '2024-01-16', 'Diterima', '', '', ''),
('2401142304551', 'Widi', '081122334560', 'Perdana<br>Kota Pontianak, Kalimantan Barat', 'JNE', 'CTC (JNE City Courier), Estimasi Sampai : 1-2 hari', 65000, 7000, '2024-01-14', '2024-01-15 23:04:55', '2024-02-27', '0000-00-00', '2024-04-19', '0000-00-00', 'Diantar', '', '', ''),
('2401162232571', 'Dani', '084567890678', 'Ngabang<br>Kabupaten Landak, Kalimantan Barat', 'JNE', 'REG (Layanan Reguler), Estimasi Sampai : 3-5 hari', 200000, 12000, '2024-01-16', '2024-01-17 22:32:57', '2024-01-21', '0000-00-00', '2024-01-17', '0000-00-00', 'Diantar', '', '', ''),
('2401182139291', 'Angi', '081108673871', 'Ngabang<br>Kabupaten Landak, Kalimantan Barat', 'JNE', 'YES (Yakin Esok Sampai), Estimasi Sampai : 1-1 hari', 150000, 15000, '2024-01-18', '2024-01-19 21:39:29', '2024-01-19', '0000-00-00', '2024-01-19', '0000-00-00', 'Diantar', '', '', ''),
('2401190026491', 'Widi', '081122334560', 'Sanggau<br>Kabupaten Sanggau, Kalimantan Barat', 'JNE', 'YES (Yakin Esok Sampai), Estimasi Sampai : 1-1 hari', 150000, 15000, '2024-01-19', '2024-01-20 00:26:49', '2024-01-20', '0000-00-00', '2024-01-19', '0000-00-00', 'Diantar', '', '', ''),
('2401271712581', 'Widi', '081122334560', 'Perdana<br>Kota Pontianak, Kalimantan Barat', 'JNE', 'CTCYES (JNE City Courier), Estimasi Sampai : 1-1 hari', 150000, 10000, '2024-01-27', '2024-01-28 17:12:58', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', 'Kadaluarsa', '', '', ''),
('2401272115591', 'Widi', '081122334560', 'Perdana<br>Kota Pontianak, Kalimantan Barat', 'JNE', 'CTC (JNE City Courier), Estimasi Sampai : 1-2 hari', 3770000, 7000, '2024-01-27', '2024-01-28 21:15:59', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', 'Kadaluarsa', '', '', ''),
('2401291231531', 'Widi', '081122334560', 'bekasi<br>Kota Bekasi, Jawa Barat', 'JNE', 'REG (Layanan Reguler), Estimasi Sampai : 1-2 hari', 100000, 34000, '2024-01-29', '2024-01-30 12:31:53', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', 'Kadaluarsa', '', '', ''),
('2401291233001', 'Widi', '081122334560', 'Perdana<br>Kota Pontianak, Kalimantan Barat', 'JNE', 'CTC (JNE City Courier), Estimasi Sampai : 1-2 hari', 100000, 7000, '2024-01-29', '2024-01-30 12:33:00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', 'Kadaluarsa', '', '', ''),
('2401291320401', 'Widi', '081122334560', 'Perdana<br>Kota Pontianak, Kalimantan Barat', 'JNE', 'CTC (JNE City Courier), Estimasi Sampai : 1-2 hari', 100000, 7000, '2024-01-29', '2024-01-30 13:20:40', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', 'Kadaluarsa', '', '', ''),
('2401292053061', 'Budi', '82241340978', 'Purnama<br>Kota Pontianak, Kalimantan Barat', 'JNE', 'CTC (JNE City Courier), Estimasi Sampai : 1-2 hari', 240000, 7000, '2024-01-29', '2024-01-30 20:53:06', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', 'Kadaluarsa', '', '', ''),
('2401292056041', 'Budi', '82241340978', 'Purnama<br>Kota Pontianak, Kalimantan Barat', 'JNE', 'CTC (JNE City Courier), Estimasi Sampai : 1-2 hari', 90000, 7000, '2024-01-29', '2024-01-30 20:56:04', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', 'Kadaluarsa', '', '', ''),
('2401302254391', 'Budi', '82241340978', 'Jakarta<br>Kota Jakarta Barat, DKI Jakarta', 'JNE', 'REG (Layanan Reguler), Estimasi Sampai : 1-2 hari', 65000, 32000, '2024-01-30', '2024-01-31 22:54:39', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', 'Kadaluarsa', '', '', ''),
('2401311915581', 'Budi', '82241340978', 'Sanggau<br>Kabupaten Sanggau, Kalimantan Barat', 'JNE', 'REG (Layanan Reguler), Estimasi Sampai : 3-5 hari', 100000, 12000, '2024-01-31', '2024-02-01 19:15:58', '2024-02-27', '2024-01-31', '2024-02-27', '0000-00-00', 'Diantar', '', '', ''),
('2401311918091', 'Budi', '82241340978', 'Purnama<br>Kota Pontianak, Kalimantan Barat', 'JNE', 'CTC (JNE City Courier), Estimasi Sampai : 1-2 hari', 150000, 7000, '2024-01-31', '2024-02-01 19:18:09', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', 'Kadaluarsa', '', '', ''),
('2401311927451', 'Budi', '82241340978', 'Purnama<br>Kota Pontianak, Kalimantan Barat', 'JNE', 'CTC (JNE City Courier), Estimasi Sampai : 1-2 hari', 100000, 7000, '2024-01-31', '2024-02-01 19:27:45', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', 'Kadaluarsa', '', '', ''),
('2402011815481', 'Budi', '82241340978', 'Purnama<br>Kota Pontianak, Kalimantan Barat', 'JNE', 'CTC (JNE City Courier), Estimasi Sampai : 1-2 hari', 100000, 7000, '2024-02-01', '2024-02-02 18:15:48', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', 'Kadaluarsa', '', '', ''),
('2402152317101', 'amelia', '082156789001', 'Yogyakarta<br>Kota Yogyakarta, DI Yogyakarta', 'JNE', 'YES (Yakin Esok Sampai), Estimasi Sampai : 1-1 hari', 150000, 53000, '2024-02-15', '2024-02-16 23:17:10', '2024-02-15', '2024-02-15', '2024-02-16', '2024-02-15', 'Diterima', '', '', ''),
('2402152319141', 'amelia', '082156789001', 'Yogyakarta<br>Kabupaten Kulon Progo, DI Yogyakarta', 'JNE', 'OKE (Ongkos Kirim Ekonomis), Estimasi Sampai : 4-5 hari', 240000, 37000, '2024-02-15', '2024-02-16 23:19:14', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', 'Kadaluarsa', '', '', ''),
('2402152323221', 'Widi', '081122334560', 'sanggau<br>Kabupaten Sanggau, Kalimantan Barat', 'JNE', 'YES (Yakin Esok Sampai), Estimasi Sampai : 1-1 hari', 100000, 15000, '2024-02-15', '2024-02-16 23:23:22', '2024-02-15', '2024-02-15', '2024-02-16', '2024-06-15', 'Diterima', '', '', ''),
('2402152326191', 'amelia', '082156789001', 'Jakarta<br>Kota Jakarta Pusat, DKI Jakarta', 'JNE', 'REG (Layanan Reguler), Estimasi Sampai : 1-2 hari', 130000, 32000, '2024-02-15', '2024-02-16 23:26:19', '2024-02-15', '2024-02-15', '2024-02-16', '0000-00-00', 'Diantar', '', '', ''),
('2402152329311', 'amelia', '082156789001', 'Yogyakarta<br>Kota Jakarta Pusat, DKI Jakarta', 'JNE', 'REG (Layanan Reguler), Estimasi Sampai : 1-2 hari', 130000, 32000, '2024-02-15', '2024-02-16 23:29:31', '2024-04-19', '2024-02-15', '2024-04-19', '0000-00-00', 'Diantar', '', '', ''),
('2402152330221', 'amelia', '082156789001', 'Yogyakarta<br>Kota Yogyakarta, DI Yogyakarta', 'JNE', 'REG (Layanan Reguler), Estimasi Sampai : 2-3 hari', 65000, 40000, '2024-02-15', '2024-02-16 23:30:22', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', 'Kadaluarsa', '', '', ''),
('2402230839271', 'Budi', '82241340978', 'Purnama<br>Kota Jakarta Barat, DKI Jakarta', 'JNE', 'OKE (Ongkos Kirim Ekonomis), Estimasi Sampai : 2-3 hari', 300000, 28000, '2024-02-23', '2024-02-24 08:39:27', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', 'Kadaluarsa', '', '', ''),
('2402230841051', 'Budi', '82241340978', 'Purnama<br>Kota Jakarta Pusat, DKI Jakarta', 'JNE', 'REG (Layanan Reguler), Estimasi Sampai : 1-2 hari', 240000, 32000, '2024-02-23', '2024-02-24 08:41:05', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', 'Kadaluarsa', '', '', ''),
('2402272346441', 'vivi', '081234567890', 'Lampung<br>Kota Metro, Lampung', 'JNE', 'REG (Layanan Reguler), Estimasi Sampai : 3-4 hari', 260000, 58000, '2024-02-27', '2024-02-28 23:46:44', '2024-02-27', '2024-02-27', '2024-02-27', '2024-02-27', 'Diterima', '', '', ''),
('2404191915341', 'Caca', '08123456789', 'Yogyakarta<br>Kota Yogyakarta, DI Yogyakarta', 'JNE', 'YES (Yakin Esok Sampai), Estimasi Sampai : 1-1 hari', 250000, 53000, '2024-04-19', '2024-04-20 19:15:34', '2024-04-19', '2024-04-19', '2024-04-19', '2024-04-19', 'Diterima', '', '', ''),
('2404201732231', 'Mamat', '082233456789', 'Balikpapan<br>Kota Balikpapan, Kalimantan Timur', 'JNE', 'REG (Layanan Reguler), Estimasi Sampai : 1-2 hari', 260000, 63000, '2024-04-20', '2024-04-21 17:32:23', '2024-04-20', '2024-04-20', '2024-04-20', '2024-04-20', 'Diterima', '', '', ''),
('2404302353111', 'Caca', '081236985015', 'Pontianak <br>Kota Pontianak, Kalimantan Barat', 'JNE', 'CTC (JNE City Courier), Estimasi Sampai : 1-2 hari', 200000, 7000, '2024-04-30', '2024-05-01 23:53:11', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', 'Kadaluarsa', '', '', ''),
('2405022257481', 'Caca', '081236589485', 'Sanggau<br>Kabupaten Sanggau, Kalimantan Barat', 'JNE', 'YES (Yakin Esok Sampai), Estimasi Sampai : 1-1 hari', 100000, 15000, '2024-05-02', '2024-05-03 22:57:48', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', 'Kadaluarsa', '', '', ''),
('2405041338511', 'Caca', '081236589485', 'Sanggau<br>Kabupaten Sanggau, Kalimantan Barat', 'JNE', 'YES (Yakin Esok Sampai), Estimasi Sampai : 1-1 hari', 100000, 15000, '2024-05-04', '2024-05-05 13:38:51', '2024-05-31', '2024-05-04', '2024-05-31', '2024-05-31', 'Diterima', '', '', ''),
('2405312348361', 'Caca', '081236589485', 'Yogyakarta <br>Kota Yogyakarta, DI Yogyakarta', 'JNE', 'YES (Yakin Esok Sampai), Estimasi Sampai : 1-1 hari', 150000, 53000, '2024-05-31', '2024-06-01 23:48:36', '2024-05-31', '2024-05-31', '2024-05-31', '2024-05-31', 'Diterima', '', '', ''),
('2406032134411', 'Caca', '081236589485', 'Sanggau<br>Kabupaten Sanggau, Kalimantan Barat', 'JNE', 'REG (Layanan Reguler), Estimasi Sampai : 3-5 hari', 65000, 12000, '2024-06-03', '2024-06-04 21:34:41', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', 'Kadaluarsa', '', '', ''),
('2406041344301', 'Caca', '081236589485', 'Sanggau<br>Kabupaten Sanggau, Kalimantan Barat', 'JNE', 'YES (Yakin Esok Sampai), Estimasi Sampai : 1-1 hari', 150000, 15000, '2024-06-04', '2024-06-05 13:44:30', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', 'Kadaluarsa', '', '', ''),
('2406050928021', 'Caca', '081236589485', 'Sanggau<br>Kabupaten Sanggau, Kalimantan Barat', 'JNE', 'YES (Yakin Esok Sampai), Estimasi Sampai : 1-1 hari', 100000, 15000, '2024-06-05', '2024-06-06 09:28:02', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', 'Kadaluarsa', '', '', ''),
('2406062044301', 'Caca', '081236589485', 'Sanggau<br>Kabupaten Sanggau, Kalimantan Barat', 'JNE', 'YES (Yakin Esok Sampai), Estimasi Sampai : 1-1 hari', 65000, 15000, '2024-06-06', '2024-06-07 20:44:30', '2024-06-06', '2024-06-06', '2024-06-06', '2024-06-06', 'Diterima', 'bca-95982332899', '', ''),
('2406091059431', 'Caca', '081236589485', 'Sanggau<br>Kabupaten Sanggau, Kalimantan Barat', 'JNE', 'YES (Yakin Esok Sampai), Estimasi Sampai : 1-1 hari', 240000, 15000, '2024-06-09', '2024-06-10 10:59:43', '2024-06-09', '2024-06-09', '2024-06-09', '2024-06-09', 'Diterima', 'bca-95982564100', '', ''),
('2406091104401', 'Caca', '081236589485', 'Paris 2<br>Kota Pontianak, Kalimantan Barat', 'JNE', 'CTCYES (JNE City Courier), Estimasi Sampai : 1-1 hari', 65000, 10000, '2024-06-09', '2024-06-10 11:04:40', '2024-06-09', '2024-06-09', '2024-06-18', '2024-06-09', 'Diantar', 'bca-95982868025', '', ''),
('2406091107221', 'Caca', '081236589485', 'Sanggau<br>Kabupaten Sanggau, Kalimantan Barat', 'JNE', 'YES (Yakin Esok Sampai), Estimasi Sampai : 1-1 hari', 240000, 15000, '2024-06-09', '2024-06-10 11:07:22', '2024-06-09', '2024-06-09', '2024-06-09', '2024-06-09', 'Diterima', 'bni-9889598205040762', '', ''),
('2406130103011', 'Caca', '081236589485', 'Sanggau<br>Kabupaten Sanggau, Kalimantan Barat', 'JNE', 'YES (Yakin Esok Sampai), Estimasi Sampai : 1-1 hari', 130000, 15000, '2024-06-13', '2024-06-14 01:03:01', '2024-06-14', '2024-06-13', '2024-06-15', '2024-06-15', 'Diterima', 'bri-959824711184708155', '', ''),
('2406141621371', 'Widi', '081122334560', 'Perdana<br>Kota Pontianak, Kalimantan Barat', 'JNE', 'CTCYES (JNE City Courier), Estimasi Sampai : 1-1 hari', 65000, 10000, '2024-06-14', '2024-06-15 16:21:37', '2024-06-14', '2024-06-14', '2024-06-14', '2024-06-15', 'Diterima', 'bri-959825632032230201', '', ''),
('2406142103161', 'ria', '082345', 'pontianak<br>Kota Pontianak, Kalimantan Barat', 'JNE', 'CTCYES (JNE City Courier), Estimasi Sampai : 1-1 hari', 100000, 10000, '2024-06-14', '2024-06-15 21:03:16', '2024-06-14', '2024-06-14', '2024-06-14', '2024-06-15', 'Diterima', 'bri-959825698579453738', '', ''),
('2406150836161', 'Caca', '081236589485', 'Sanggau<br>Kabupaten Sanggau, Kalimantan Barat', 'JNE', 'YES (Yakin Esok Sampai), Estimasi Sampai : 1-1 hari', 105000, 15000, '2024-06-15', '2024-06-16 08:36:16', '2024-06-15', '2024-06-15', '2024-06-15', '2024-06-15', 'Diterima', 'bri-959825023087959772', '', ''),
('2406151326121', 'ani', '0871', 'pontianak<br>Kota Pontianak, Kalimantan Barat', 'JNE', 'CTCYES (JNE City Courier), Estimasi Sampai : 1-1 hari', 100000, 10000, '2024-06-15', '2024-06-16 13:26:12', '2024-06-15', '2024-06-15', '2024-06-15', '2024-06-15', 'Diterima', 'bri-959825826786856182', '', ''),
('2406151341281', 'ani', '0988', 'pontianak<br>Kota Pontianak, Kalimantan Barat', 'JNE', 'CTC (JNE City Courier), Estimasi Sampai : 1-2 hari', 235000, 7000, '2024-06-15', '2024-06-16 13:41:28', '2024-06-19', '2024-06-15', '2024-06-19', '0000-00-00', 'Diantar', 'bri-959824665581557227', '', ''),
('2406151428171', 'budi2', '08213456', 'pontianak<br>Kota Pontianak, Kalimantan Barat', 'JNE', 'CTCYES (JNE City Courier), Estimasi Sampai : 1-1 hari', 600000, 10000, '2024-06-15', '2024-06-16 14:28:17', '2024-06-15', '2024-06-15', '0000-00-00', '0000-00-00', 'Dikemas', 'bri-959823361307356338', '', ''),
('2406172230181', 'Caca', '081236589485', 'Sanggau<br>Kota Pontianak, Kalimantan Barat', 'JNE', 'CTCYES (JNE City Courier), Estimasi Sampai : 1-1 hari', 100000, 10000, '2024-06-17', '2024-06-18 22:30:18', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', 'Kadaluarsa', '', '', ''),
('2406182326371', 'user', '08123111', 'aa<br>Kabupaten Grobogan, Jawa Tengah', 'JNE', 'OKE (Ongkos Kirim Ekonomis), Estimasi Sampai : 4-5 hari', 130000, 37000, '2024-06-18', '2024-06-19 23:26:37', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', 'Kadaluarsa', '', '', ''),
('2406201418531', 'Caca', '081236589485', 'Sanggau<br>Kota Pontianak, Kalimantan Barat', 'JNE', 'CTCYES (JNE City Courier), Estimasi Sampai : 1-1 hari', 1000000, 10000, '2024-06-20', '2024-06-21 14:18:53', '2024-06-20', '2024-06-20', '2024-06-20', '2024-06-20', 'Diterima', 'bri-959823688790918282', 'Screenshot_20240620_141823.jpg', 'cover rodin.PNG');

-- --------------------------------------------------------

--
-- Table structure for table `penjualan_detail`
--

CREATE TABLE `penjualan_detail` (
  `no` int(11) NOT NULL,
  `kode_penjualan` varchar(13) NOT NULL,
  `kode_barang` int(11) NOT NULL,
  `jumlah` varchar(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `penjualan_detail`
--

INSERT INTO `penjualan_detail` (`no`, `kode_penjualan`, `kode_barang`, `jumlah`) VALUES
(1, '2311131151551', 4, '1'),
(2, '2311131151551', 5, '2'),
(3, '2311131158421', 1, '1'),
(4, '2311131204041', 2, '1'),
(5, '2311131207261', 3, '1'),
(6, '2311131215481', 4, '1'),
(7, '2311131503271', 1, '1'),
(8, '2311131506291', 4, '1'),
(9, '2311131508541', 5, '1'),
(10, '2311131516511', 1, '1'),
(11, '2311131520201', 5, '1'),
(12, '2311131523581', 3, '1'),
(13, '2311131526151', 1, '1'),
(14, '2311131528291', 3, '1'),
(15, '2311131530321', 2, '1'),
(16, '2311131532261', 2, '10'),
(17, '2311131537381', 5, '1'),
(18, '2311131541351', 4, '1'),
(19, '2311131544091', 4, '1'),
(20, '2311140956411', 3, '4'),
(21, '2311181259231', 2, '1'),
(22, '2311181318181', 2, '14'),
(23, '2311181323391', 5, '1'),
(24, '2311181341301', 4, '1'),
(25, '2311181352001', 3, '1'),
(26, '2311181450121', 2, '1'),
(27, '2311211237171', 3, '1'),
(28, '2311211240141', 4, '1'),
(29, '2311221047451', 5, '1'),
(30, '2311231031451', 3, '1'),
(31, '2311301037431', 3, '1'),
(32, '2311302029341', 3, '2'),
(33, '2312061837181', 2, '1'),
(34, '2312061847081', 5, '1'),
(35, '2312081456211', 3, '1'),
(36, '2312081502421', 5, '2'),
(37, '2312121330031', 1, '1'),
(38, '2312121330031', 5, '1'),
(39, '2312191540381', 3, '1'),
(40, '2312191544071', 3, '1'),
(41, '2312191550421', 2, '1'),
(42, '2312191552001', 1, '1'),
(43, '2312191557071', 4, '1'),
(44, '2312191603571', 4, '2'),
(45, '2312191608491', 3, '2'),
(46, '2312191610371', 4, '2'),
(54, '2312241027141', 5, '1'),
(57, '2312252307451', 1, '1'),
(59, '2312311125461', 1, '1'),
(77, '2401141541161', 2, '1'),
(78, '2401142304551', 5, '1'),
(81, '2401162232571', 6, '1'),
(82, '2401162232571', 4, '1'),
(89, '2401182139291', 7, '1'),
(90, '2401190026491', 7, '1'),
(97, '2401271712581', 7, '1'),
(98, '2401271742111', 6, '3'),
(99, '2401272115591', 1, '29'),
(102, '2401291231531', 6, '1'),
(103, '2401291233001', 4, '1'),
(108, '2401291320401', 4, '1'),
(110, '2401291403301', 6, '6'),
(111, '2401292053061', 3, '1'),
(112, '2401292056041', 2, '1'),
(115, '2401302254391', 5, '1'),
(116, '2401302257071', 4, '1'),
(117, '2401311500321', 4, '1'),
(118, '2401311504301', 7, '1'),
(119, '2401311508451', 4, '1'),
(120, '2401311512031', 5, '1'),
(121, '2401311516091', 4, '1'),
(122, '2401311915581', 4, '1'),
(123, '2401311918091', 7, '1'),
(124, '2401311927451', 4, '1'),
(125, '2402011815481', 6, '1'),
(126, '2402152317101', 7, '1'),
(127, '2402152319141', 3, '1'),
(128, '2402152323221', 4, '1'),
(129, '2402152326191', 1, '1'),
(130, '2402152329311', 1, '1'),
(131, '2402152330221', 12, '1'),
(132, '2402230839271', 4, '3'),
(133, '2402230841051', 3, '1'),
(134, '2402272346441', 5, '3'),
(135, '2402272346441', 12, '1'),
(136, '2404191915341', 4, '1'),
(137, '2404191915341', 7, '1'),
(139, '2404201732231', 1, '2'),
(142, '2404302353111', 4, '2'),
(144, '2405022257481', 4, '1'),
(145, '2405041338511', 4, '1'),
(146, '2405312348361', 7, '1'),
(148, '2406032134411', 5, '1'),
(149, '2406041344301', 7, '1'),
(150, '2406050928021', 4, '1'),
(152, '2406050955131', 1, '2'),
(153, '2406051450391', 4, '1'),
(154, '2406051501051', 5, '2'),
(155, '2406051501561', 3, '1'),
(156, '2406051504581', 1, '1'),
(157, '2406051506071', 12, '1'),
(158, '2406051507121', 2, '1'),
(159, '2406051508131', 2, '1'),
(160, '2406051527411', 3, '1'),
(161, '2406051532141', 3, '1'),
(162, '2406051543311', 3, '1'),
(163, '2406051556381', 3, '1'),
(164, '2406051558351', 7, '1'),
(165, '2406051609261', 5, '1'),
(166, '2406051614091', 3, '1'),
(167, '2406051616151', 1, '1'),
(168, '2406060922081', 7, '1'),
(169, '2406061054481', 5, '1'),
(170, '2406062044301', 5, '1'),
(171, '2406091059431', 3, '1'),
(172, '2406091104401', 5, '1'),
(173, '2406091107221', 3, '1'),
(174, '2406130103011', 1, '1'),
(175, '2406141621371', 5, '1'),
(176, '2406142103161', 4, '1'),
(177, '2406150836161', 17, '1'),
(178, '2406151326121', 4, '1'),
(179, '2406151341281', 1, '1'),
(180, '2406151341281', 20, '1'),
(181, '2406151428171', 21, '3'),
(182, '2406172230181', 4, '1'),
(183, '2406182326371', 1, '1'),
(184, '2406182327461', 5, '1'),
(185, '2406201418531', 4, '10');

-- --------------------------------------------------------

--
-- Table structure for table `ulasan`
--

CREATE TABLE `ulasan` (
  `no` int(11) NOT NULL,
  `kode_barang` int(11) NOT NULL,
  `username` varchar(32) NOT NULL,
  `ulasan` varchar(255) NOT NULL,
  `rating` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ulasan`
--

INSERT INTO `ulasan` (`no`, `kode_barang`, `username`, `ulasan`, `rating`) VALUES
(1, 2, 'Aldi', 'bagus', 5),
(2, 5, 'vivi', 'kualitasnya bagus, lembut di rambut', 5),
(3, 12, 'vivi', 'madunya enak banget', 4),
(4, 4, 'Caca', 'Bagus', 5),
(5, 7, 'Caca', 'Kualitasnya bagus', 4),
(6, 1, 'Mamat', 'Enak', 3),
(7, 1, 'Mamat', 'Enak', 3),
(8, 7, 'Caca', 'Bagus', 5),
(9, 7, 'Caca', '', 5),
(10, 5, 'Caca', 'Bagus banget', 5),
(11, 4, 'Widi', '', 5);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(4) NOT NULL,
  `username` varchar(32) NOT NULL,
  `password` varchar(32) NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `nohp` varchar(13) NOT NULL,
  `role` varchar(3) NOT NULL,
  `status` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `username`, `password`, `alamat`, `nohp`, `role`, `status`) VALUES
(1, 'admin', '123', '', '', 'adm', 'Aktif'),
(2, 'admin2', '123', '', '', 'adm', 'Aktif'),
(3, 'Aldi', '001', 'Paris 2', '082134569876', 'usr', 'Aktif'),
(4, 'amelia', 'amelia', 'Yogyakarta', '082156789001', 'usr', 'Aktif'),
(5, 'Angi', '111', 'Ngabang', '081108673871', 'usr', 'Aktif'),
(6, 'ani', 'ani', '', '', 'usr', 'Aktif'),
(7, 'bella', '123', '', '', 'usr', 'Aktif'),
(8, 'Budi', '111', 'Purnama', '82241340978', 'usr', 'Aktif'),
(9, 'budi2', 'budi2', 'pontianak', '08213456', 'usr', 'Aktif'),
(10, 'Caca', 'caca', 'Sanggau', '081236589485', 'usr', 'Aktif'),
(11, 'Dani', '111', 'Ngabang', '084567890678', 'usr', 'Aktif'),
(12, 'Dover', 'redisblue', 'Balai berkuak', '123456789', 'usr', 'Block'),
(13, 'dover21', '123445', '', '', 'usr', 'Aktif'),
(14, 'Evi', 'evi122', '', '', 'usr', 'Aktif'),
(15, 'Mamat', 'mamat', '', '', 'usr', 'Aktif'),
(16, 'redis', 'qwerty', '', '', 'usr', 'Aktif'),
(17, 'ria', 'ria', 'pontianak', '082345', 'usr', 'Aktif'),
(18, 'user', '123', '', '08123111', 'usr', 'Aktif'),
(19, 'vivi', 'vivi', '', '', 'usr', 'Aktif'),
(20, 'Widi', 'widi123', 'Perdana', '081122334560', 'usr', 'Aktif');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`kode_barang`);

--
-- Indexes for table `jasa_antar`
--
ALTER TABLE `jasa_antar`
  ADD PRIMARY KEY (`no`);

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`kode_kategori`);

--
-- Indexes for table `keranjang`
--
ALTER TABLE `keranjang`
  ADD PRIMARY KEY (`kode_keranjang`);

--
-- Indexes for table `pembelian`
--
ALTER TABLE `pembelian`
  ADD PRIMARY KEY (`no_faktur`);

--
-- Indexes for table `pembelian_detail`
--
ALTER TABLE `pembelian_detail`
  ADD PRIMARY KEY (`no`);

--
-- Indexes for table `penjualan`
--
ALTER TABLE `penjualan`
  ADD PRIMARY KEY (`kode_penjualan`);

--
-- Indexes for table `penjualan_detail`
--
ALTER TABLE `penjualan_detail`
  ADD PRIMARY KEY (`no`);

--
-- Indexes for table `ulasan`
--
ALTER TABLE `ulasan`
  ADD PRIMARY KEY (`no`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`username`),
  ADD UNIQUE KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `barang`
--
ALTER TABLE `barang`
  MODIFY `kode_barang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `jasa_antar`
--
ALTER TABLE `jasa_antar`
  MODIFY `no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `kode_kategori` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `keranjang`
--
ALTER TABLE `keranjang`
  MODIFY `kode_keranjang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=159;

--
-- AUTO_INCREMENT for table `pembelian_detail`
--
ALTER TABLE `pembelian_detail`
  MODIFY `no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `penjualan_detail`
--
ALTER TABLE `penjualan_detail`
  MODIFY `no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=186;

--
-- AUTO_INCREMENT for table `ulasan`
--
ALTER TABLE `ulasan`
  MODIFY `no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
