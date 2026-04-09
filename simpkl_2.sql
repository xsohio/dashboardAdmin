-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 09, 2026 at 02:54 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `simpkl_2`
--

-- --------------------------------------------------------

--
-- Table structure for table `akun`
--

CREATE TABLE `akun` (
  `id_akun` int(11) NOT NULL,
  `namaDepan` varchar(100) NOT NULL,
  `namaBelakang` varchar(100) NOT NULL,
  `gmail` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `level` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bimbingan`
--

CREATE TABLE `bimbingan` (
  `id_bimbingan` int(15) NOT NULL,
  `materi_pembimbing` varchar(225) NOT NULL,
  `catatan_pembimbing` varchar(225) NOT NULL,
  `hari_tanggal_bimbingan` date NOT NULL,
  `id_pembimbing` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kegiatan`
--

CREATE TABLE `kegiatan` (
  `id_kegiatan` int(20) NOT NULL,
  `Hari_tanggal` date NOT NULL,
  `Waktu_kegiatan` varchar(20) NOT NULL,
  `Kegiatan_Pelaksanaan` varchar(255) NOT NULL,
  `id_siswa` int(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kelas`
--

CREATE TABLE `kelas` (
  `id_kelas` int(20) NOT NULL,
  `Kelas` varchar(30) NOT NULL,
  `Jurusan` varchar(50) NOT NULL,
  `id_walikelas` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kelas`
--

INSERT INTO `kelas` (`id_kelas`, `Kelas`, `Jurusan`, `id_walikelas`) VALUES
(1, 'XII RPL 1', 'Rekayasa Perangkat Lunak', 1),
(2, 'XII RPL 2', 'Rekayasa Perangkat Lunak', 2),
(3, 'XII TKJ', 'Teknik Komputer Jaringan', 3);

-- --------------------------------------------------------

--
-- Table structure for table `kopetensi`
--

CREATE TABLE `kopetensi` (
  `id_kopetensi` int(20) NOT NULL,
  `Kopetensi_dasar` varchar(100) NOT NULL,
  `Keterlaksanaan` varchar(50) NOT NULL,
  `id_siswa` int(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pembimbing_pkl`
--

CREATE TABLE `pembimbing_pkl` (
  `id_pembimbing` int(11) NOT NULL,
  `nama` varchar(60) NOT NULL,
  `jabatan` varchar(50) NOT NULL,
  `jab_terakhir` varchar(50) NOT NULL,
  `ttl` date NOT NULL,
  `alamat` varchar(100) NOT NULL,
  `no_kontak` varchar(16) NOT NULL,
  `id_perusahaan` int(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pembimbing_pkl`
--

INSERT INTO `pembimbing_pkl` (`id_pembimbing`, `nama`, `jabatan`, `jab_terakhir`, `ttl`, `alamat`, `no_kontak`, `id_perusahaan`) VALUES
(1, 'Ahmad Fauzi', 'Supervisor IT', 'S1 Teknik Informatika', '1985-03-12', 'Jl. Sudirman No.10', '081111111111', 1),
(2, 'Dewi Lestari', 'Network Engineer', 'S1 Sistem Informasi', '1990-07-20', 'Jl. Merdeka No.5', '082222222222', 2);

-- --------------------------------------------------------

--
-- Table structure for table `perusahaan`
--

CREATE TABLE `perusahaan` (
  `id_perusahaan` int(20) NOT NULL,
  `Nama_perusahaan` varchar(60) NOT NULL,
  `Alamat` varchar(100) NOT NULL,
  `telepon` varchar(20) DEFAULT NULL,
  `bidang` varchar(60) DEFAULT NULL,
  `kapasitas` int(5) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `perusahaan`
--

INSERT INTO `perusahaan` (`id_perusahaan`, `Nama_perusahaan`, `Alamat`, `telepon`, `bidang`, `kapasitas`) VALUES
(1, 'PT. Maju Bersama', 'Jl. Sudirman No.45, Jakarta', NULL, 'IT & Software', 10),
(2, 'CV. Teknologi Nusantara', 'Jl. Gatot Subroto No.12, Bandung', NULL, 'Networking', 5),
(3, 'PT. Digital Solusi', 'Jl. Ahmad Yani No.8, Surabaya', NULL, 'Web Development', 8),
(4, 'py', 'd', NULL, 'IT', 2);

-- --------------------------------------------------------

--
-- Table structure for table `siswa`
--

CREATE TABLE `siswa` (
  `id_siswa` int(15) NOT NULL,
  `Nis_siswa` varchar(15) NOT NULL,
  `Nama_siswa` varchar(40) NOT NULL,
  `Jenis_kelamin` varchar(10) NOT NULL,
  `Agama_siswa` varchar(10) NOT NULL,
  `TTL` varchar(50) NOT NULL,
  `NO_Kontak` varchar(15) NOT NULL,
  `Alamat_siswa` varchar(100) NOT NULL,
  `Goldar` varchar(4) NOT NULL,
  `id_kelas` int(20) NOT NULL,
  `id_perusahaan` int(25) NOT NULL,
  `id_pembimbing` int(20) NOT NULL,
  `id_walikelas` int(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `siswa`
--

INSERT INTO `siswa` (`id_siswa`, `Nis_siswa`, `Nama_siswa`, `Jenis_kelamin`, `Agama_siswa`, `TTL`, `NO_Kontak`, `Alamat_siswa`, `Goldar`, `id_kelas`, `id_perusahaan`, `id_pembimbing`, `id_walikelas`) VALUES
(1, '2024001', 'Andi Pratama', 'L', 'Islam', 'Bandung, 12 Jan 2007', '081100000001', 'Jl. Mawar No.1', 'O', 1, 1, 1, 1),
(2, '2024002', 'Budi Santoso', 'L', 'Islam', 'Jakarta, 05 Mar 2006', '081100000002', 'Jl. Melati No.2', 'A', 2, 2, 2, 2),
(4, '202400', 'er', 'L', 'Islam', 're', 'r', '', 'A', 1, 2, 1, 1),
(5, '202400', 'df', 'L', 'Islam', 'Surabaya, 20 Mei 2007', '081100000003', '', 'A', 1, 2, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id_users` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','siswa','pembimbing','wakasek') NOT NULL DEFAULT 'siswa',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_users`, `username`, `password`, `role`, `created_at`, `is_deleted`) VALUES
(1, 'noii', '3456', 'siswa', '2026-04-08 04:02:10', 0),
(3, 'polo', '34', 'siswa', '2026-04-08 04:04:10', 0),
(4, 'siswa1', '123', 'pembimbing', '2026-04-08 04:04:41', 0),
(5, '1021_re', '9', 'wakasek', '2026-04-08 04:05:01', 1),
(6, 'gttfd', '55', 'siswa', '2026-04-08 04:06:15', 1),
(7, 'B', 'baba', 'siswa', '2026-04-08 04:26:27', 1),
(8, 'tes', '123', 'siswa', '2026-04-08 04:28:03', 1),
(9, 'admin', 'admin123', 'admin', '2026-04-08 04:38:41', 0);

-- --------------------------------------------------------

--
-- Table structure for table `walikelas`
--

CREATE TABLE `walikelas` (
  `id_walikelas` int(15) NOT NULL,
  `Nama_wakel` varchar(40) NOT NULL,
  `Alamat` varchar(50) NOT NULL,
  `Agama_wakel` varchar(10) NOT NULL,
  `No_kontak` varchar(16) NOT NULL,
  `Mewalikelaskan` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `walikelas`
--

INSERT INTO `walikelas` (`id_walikelas`, `Nama_wakel`, `Alamat`, `Agama_wakel`, `No_kontak`, `Mewalikelaskan`) VALUES
(1, 'Bpk. Hendra Wijaya', 'Jl. Mawar No.5, Kota', 'Islam', '081234567890', 1),
(2, 'Ibu. Sari Indah', 'Jl. Melati No.3, Kota', 'Islam', '082234567891', 2),
(3, 'Bpk. Rudi Hartono', 'Jl. Kenanga No.7, Kota', 'Islam', '083234567892', 3);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `akun`
--
ALTER TABLE `akun`
  ADD PRIMARY KEY (`id_akun`);

--
-- Indexes for table `bimbingan`
--
ALTER TABLE `bimbingan`
  ADD PRIMARY KEY (`id_bimbingan`),
  ADD KEY `id_pembimbing` (`id_pembimbing`);

--
-- Indexes for table `kegiatan`
--
ALTER TABLE `kegiatan`
  ADD PRIMARY KEY (`id_kegiatan`),
  ADD KEY `id_siswa` (`id_siswa`);

--
-- Indexes for table `kelas`
--
ALTER TABLE `kelas`
  ADD PRIMARY KEY (`id_kelas`),
  ADD KEY `id_walikelas` (`id_walikelas`);

--
-- Indexes for table `kopetensi`
--
ALTER TABLE `kopetensi`
  ADD PRIMARY KEY (`id_kopetensi`),
  ADD KEY `id_siswa` (`id_siswa`);

--
-- Indexes for table `pembimbing_pkl`
--
ALTER TABLE `pembimbing_pkl`
  ADD PRIMARY KEY (`id_pembimbing`),
  ADD KEY `id_perusahaan` (`id_perusahaan`);

--
-- Indexes for table `perusahaan`
--
ALTER TABLE `perusahaan`
  ADD PRIMARY KEY (`id_perusahaan`);

--
-- Indexes for table `siswa`
--
ALTER TABLE `siswa`
  ADD PRIMARY KEY (`id_siswa`),
  ADD KEY `id_kelas` (`id_kelas`),
  ADD KEY `id_pembimbing` (`id_pembimbing`),
  ADD KEY `id_perusahaan` (`id_perusahaan`),
  ADD KEY `id_walikelas` (`id_walikelas`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_users`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `walikelas`
--
ALTER TABLE `walikelas`
  ADD PRIMARY KEY (`id_walikelas`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `akun`
--
ALTER TABLE `akun`
  MODIFY `id_akun` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bimbingan`
--
ALTER TABLE `bimbingan`
  MODIFY `id_bimbingan` int(15) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kegiatan`
--
ALTER TABLE `kegiatan`
  MODIFY `id_kegiatan` int(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kelas`
--
ALTER TABLE `kelas`
  MODIFY `id_kelas` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `kopetensi`
--
ALTER TABLE `kopetensi`
  MODIFY `id_kopetensi` int(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pembimbing_pkl`
--
ALTER TABLE `pembimbing_pkl`
  MODIFY `id_pembimbing` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `perusahaan`
--
ALTER TABLE `perusahaan`
  MODIFY `id_perusahaan` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `siswa`
--
ALTER TABLE `siswa`
  MODIFY `id_siswa` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id_users` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `walikelas`
--
ALTER TABLE `walikelas`
  MODIFY `id_walikelas` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bimbingan`
--
ALTER TABLE `bimbingan`
  ADD CONSTRAINT `bimbingan_ibfk_1` FOREIGN KEY (`id_pembimbing`) REFERENCES `pembimbing_pkl` (`id_pembimbing`);

--
-- Constraints for table `kegiatan`
--
ALTER TABLE `kegiatan`
  ADD CONSTRAINT `kegiatan_ibfk_1` FOREIGN KEY (`id_siswa`) REFERENCES `siswa` (`id_siswa`);

--
-- Constraints for table `kelas`
--
ALTER TABLE `kelas`
  ADD CONSTRAINT `kelas_ibfk_1` FOREIGN KEY (`id_walikelas`) REFERENCES `walikelas` (`id_walikelas`);

--
-- Constraints for table `kopetensi`
--
ALTER TABLE `kopetensi`
  ADD CONSTRAINT `kopetensi_ibfk_1` FOREIGN KEY (`id_siswa`) REFERENCES `siswa` (`id_siswa`);

--
-- Constraints for table `pembimbing_pkl`
--
ALTER TABLE `pembimbing_pkl`
  ADD CONSTRAINT `pembimbing_pkl_ibfk_1` FOREIGN KEY (`id_perusahaan`) REFERENCES `perusahaan` (`id_perusahaan`);

--
-- Constraints for table `siswa`
--
ALTER TABLE `siswa`
  ADD CONSTRAINT `siswa_ibfk_1` FOREIGN KEY (`id_kelas`) REFERENCES `kelas` (`id_kelas`),
  ADD CONSTRAINT `siswa_ibfk_2` FOREIGN KEY (`id_pembimbing`) REFERENCES `pembimbing_pkl` (`id_pembimbing`),
  ADD CONSTRAINT `siswa_ibfk_3` FOREIGN KEY (`id_perusahaan`) REFERENCES `perusahaan` (`id_perusahaan`),
  ADD CONSTRAINT `siswa_ibfk_4` FOREIGN KEY (`id_walikelas`) REFERENCES `walikelas` (`id_walikelas`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
