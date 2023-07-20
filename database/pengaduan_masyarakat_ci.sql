-- phpMyAdmin SQL Dump
-- version 5.1.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 09, 2023 at 09:13 AM
-- Server version: 5.7.33
-- PHP Version: 7.4.19

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pengaduan_masyarakat_ci`
--

--
-- Table structure for table `kabupaten`
--

DROP TABLE IF EXISTS `kabupaten`;
CREATE TABLE `kabupaten` (
  `id_kabupaten` int(11) NOT NULL,
  `nama_kabupaten` varchar(255) NOT NULL,
  `ibukota` varchar(255) NOT NULL,
  PRIMARY KEY (`id_kabupaten`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `kabupaten`
--

LOCK TABLES `kabupaten` WRITE;
INSERT INTO `kabupaten` (`id_kabupaten`, `nama_kabupaten`, `ibukota`) VALUES
(1, 'Bangka', 'Sungai Liat'),
(2, 'Bangka Barat', 'Muntok'),
(3, 'Bangka Selatan', 'Toboali'),
(4, 'Bangka Tengah', 'Koba'),
(5, 'Belitung', 'Tanjung Pandan'),
(6, 'Belitung Timur', 'Manggar'),
(7, 'Pangkal Pinang', 'Pangkal Pinang');
UNLOCK TABLES;

--
-- Table structure for table `masyarakat`
--

DROP TABLE IF EXISTS `masyarakat`;
CREATE TABLE `masyarakat` (
  `id_masyarakat` int(11) NOT NULL AUTO_INCREMENT,
  `nik_masyarakat` bigint(16) NOT NULL,
  `username` varchar(25) NOT NULL,
  `password` varchar(225) NOT NULL,
  `is_verified` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id_masyarakat`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `masyarakat`
--

LOCK TABLES `masyarakat` WRITE;
INSERT INTO `masyarakat` (`id_masyarakat`,`nik_masyarakat`, `username`, `password`, `is_verified`) VALUES
(1, 1212345678912354, 'masyarakat', '$2y$10$BqCVWU56ME/Y.MctVXBw7uI8w26d1gK/HY219JiQWe./ppfYVEeYS', 1),
(2, 12345678918, 'lululala', '$2y$10$J23NNXSjscUHCEHXDkSaTOvbm8gQYRVmMtdqCGPQyJuFeuMfS.hJG', 1);
UNLOCK TABLES;

--
-- Table structure for table `masyarakat_detail`
--

DROP TABLE IF EXISTS `masyarakat_detail`;
CREATE TABLE `masyarakat_detail` (
  `id_masyarakat` int(11) NOT NULL,
  `nama_masyarakat` varchar(35) NOT NULL,
  `telp` varchar(13) NOT NULL,
  `alamat` varchar(35) NOT NULL,
  `foto_profile` varchar(225) NOT NULL,
  KEY `id_masyarakat` (`id_masyarakat`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `masyarakat_detail`
--

LOCK TABLES `masyarakat_detail` WRITE;
INSERT INTO `masyarakat_detail` (`id_masyarakat`, `nama_masyarakat`, `telp`, `alamat`, `foto_profile`) VALUES
(1,'aisyah','08131111111','pangkal','user.png'),
(2,'lulu','08111111111','PKG','user.png');
UNLOCK TABLES;

--
-- Table structure for table `pengaduan`
--

DROP TABLE IF EXISTS `pengaduan`;
CREATE TABLE `pengaduan` (
  `id_pengaduan` bigint(16) NOT NULL AUTO_INCREMENT,
  `tgl_pengaduan` date NOT NULL,
  `nik_masyarakat` bigint(16) NOT NULL,
  `hubungan` varchar(35) NOT NULL,
  `nama_pelaku` varchar(35) NOT NULL,
  `lokasi_kejadian` varchar(35) NOT NULL,
  `nama_korban` varchar(35) NOT NULL,
  `jenis_laporan` varchar(35) NOT NULL,
  `isi_laporan` text NOT NULL,
  `foto` varchar(255) NOT NULL,
  `status` enum('Diajukan','Diproses','Selesai','Ditolak') NOT NULL,
  `id_kabupaten` int(11) NOT NULL,
  PRIMARY KEY (`id_pengaduan`),
  KEY `nik_masyarakat` (`nik_masyarakat`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pengaduan`
--

LOCK TABLES `pengaduan` WRITE;
INSERT INTO `pengaduan` VALUES 
(1,'2023-07-17',1212345678912354,'sepupu','Parjo','Jalan Pramuka','Milo','Kekerasan Dalam Rumah Tangga','Tidak memberi nafkah','a6bc971dee560efe89d61a61cec5aa14.jpg','Diajukan',7);
UNLOCK TABLES;

--
-- Table structure for table `petugas`
--

DROP TABLE IF EXISTS `petugas`;
CREATE TABLE `petugas` (
  `id_petugas` int(11) NOT NULL AUTO_INCREMENT,
  `nama_petugas` varchar(35) NOT NULL,
  `nik_petugas` bigint(16) NOT NULL,
  `username_petugas` varchar(25) NOT NULL,
  `password_petugas` varchar(225) NOT NULL,
  `telp` varchar(13) NOT NULL,
  `alamat` varchar(35) NOT NULL,
  `foto_profile` varchar(225) NOT NULL,
  PRIMARY KEY (`id_petugas`),
  UNIQUE KEY `username_petugas` (`username_petugas`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `petugas`
--

LOCK TABLES `petugas` WRITE;
INSERT INTO `petugas` (`id_petugas`, `nama_petugas`, `nik_petugas`, `username_petugas`, `password_petugas`, `telp`, `alamat`, `foto_profile`) VALUES
(1, 'putri', 3212345678912354, 'admin', '$2y$10$YlpZmz2Uq.RxG5bHvMjYjej5y2AYkEzr9JbDKGHe3sWbpFkVhkury', '08111111111', 'belitong', 'user.png'),
(2, 'amini', 3212345678912352, 'petugas', '$2y$10$SIUNsTMGwDOoXJ62kgoMueorXuuDenxdG0ZKRU1NUigM2Xby0bAmC', '081222222222', 'mentok', 'user.png');
UNLOCK TABLES;

--
-- Table structure for table `petugas_kabupaten`
--

DROP TABLE IF EXISTS `petugas_kabupaten`;
CREATE TABLE `petugas_kabupaten` (
  `id_petugaskab` int(11) NOT NULL AUTO_INCREMENT,
  `nama_petugaskab` varchar(255) NOT NULL,
  `id_petugas` int(11) NOT NULL,
  `id_kabupaten` int(11) NOT NULL,
  PRIMARY KEY (`id_petugaskab`),
  KEY `petugas_kabupaten_ibfk_1` (`id_petugas`),
  KEY `petugas_kabupaten_ibfk_2` (`id_kabupaten`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `petugas_kabupaten`
--

LOCK TABLES `petugas_kabupaten` WRITE;
INSERT INTO `petugas_kabupaten` (`id_petugaskab`, `nama_petugaskab`, `id_petugas`, `id_kabupaten`) VALUES
(1, 'amini', 2, 7);
UNLOCK TABLES;

--
-- Table structure for table `tanggapan`
--

DROP TABLE IF EXISTS `tanggapan`;
CREATE TABLE `tanggapan` (
  `id_tanggapan` int(11) NOT NULL AUTO_INCREMENT,
  `id_pengaduan` bigint(16) NOT NULL,
  `tgl_tanggapan` date NOT NULL,
  `tanggapan` text NOT NULL,
  `id_petugaskab` int(11) NOT NULL,
  PRIMARY KEY (`id_tanggapan`),
  KEY `id_pengaduan` (`id_pengaduan`),
  KEY `id_petugaskab` (`id_petugaskab`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tanggapan`
--

LOCK TABLES `tanggapan` WRITE;
INSERT INTO `tanggapan` (`id_tanggapan`, `id_pengaduan`, `tgl_tanggapan`, `tanggapan`, `id_petugaskab`) VALUES
(1,1,'2023-07-18','sedang didalami',2);
UNLOCK TABLES;

--
-- Table structure for table `admin`
--

DROP TABLE IF EXISTS `admin`;
CREATE TABLE `admin` (
  `id_admin` int(11) NOT NULL AUTO_INCREMENT,
  `nama_admin` varchar(35) NOT NULL,
  `username_admin` varchar(25) NOT NULL,
  `password_admin` varchar(255) NOT NULL,
  PRIMARY KEY (`id_admin`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

LOCK TABLES `admin` WRITE;
INSERT INTO `admin` (`id_admin`, `nama_admin`, `username_admin`, `password_admin`) VALUES
(1, 'superadmin', 'superadmin', '$2y$10$YlpZmz2Uq.RxG5bHvMjYjej5y2AYkEzr9JbDKGHe3sWbpFkVhkury');
UNLOCK TABLES;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
