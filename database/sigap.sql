-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Mar 29, 2017 at 06:18 AM
-- Server version: 10.1.16-MariaDB
-- PHP Version: 5.6.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sigap`
--

-- --------------------------------------------------------

--
-- Table structure for table `alatuser`
--

CREATE TABLE `alatuser` (
  `id` int(11) NOT NULL,
  `id_alat` int(11) NOT NULL,
  `kode_alat` varchar(32) NOT NULL,
  `id_user` int(11) NOT NULL,
  `nama` varchar(32) NOT NULL,
  `rssi` int(11) NOT NULL,
  `battery` int(11) NOT NULL,
  `latitude` varchar(32) NOT NULL,
  `longitude` varchar(32) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `alatuser`
--

INSERT INTO `alatuser` (`id`, `id_alat`, `kode_alat`, `id_user`, `nama`, `rssi`, `battery`, `latitude`, `longitude`, `status`) VALUES
(13, 1, '40664b8af3ac490bb46fd49888c3ab9f', 5, 'Coordinator', 0, 0, '-6.560612', '106.7285546', 0),
(14, 3, '892210a8d2dae6b7ba9602c80820b287', 5, 'Sigap1', 30, 50, '-6.560378', '106.729542', 1),
(15, 4, 'b33cd1d62b1d48fe8ebcc18d29d50c97', 5, 'Sigap2', 25, 0, '-6.5600364', '106.7303678', 0),
(16, 15, '7f972ae97098de7bba71ef6652812886', 5, 'Sigap3', 60, 33, '-6.5606335', '106.7298153', 0);

-- --------------------------------------------------------

--
-- Table structure for table `dataalat`
--

CREATE TABLE `dataalat` (
  `id` int(11) NOT NULL,
  `kode` varchar(32) NOT NULL,
  `tanggal_produksi` int(11) NOT NULL,
  `status` int(1) NOT NULL,
  `registered_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `dataalat`
--

INSERT INTO `dataalat` (`id`, `kode`, `tanggal_produksi`, `status`, `registered_at`) VALUES
(1, '40664b8af3ac490bb46fd49888c3ab9f', 2016, 0, '2016-07-24 08:00:43'),
(3, '892210a8d2dae6b7ba9602c80820b287', 2016, 0, '2016-07-24 08:16:57'),
(4, 'b33cd1d62b1d48fe8ebcc18d29d50c97', 2016, 0, '2016-07-30 09:42:37'),
(15, '7f972ae97098de7bba71ef6652812886', 2016, 0, '2016-07-30 12:05:08');

-- --------------------------------------------------------

--
-- Table structure for table `datasensor`
--

CREATE TABLE `datasensor` (
  `id` int(11) NOT NULL,
  `id_alat` int(11) NOT NULL,
  `hpsp` int(11) NOT NULL,
  `hpc` int(11) NOT NULL,
  `uk` float NOT NULL,
  `optime` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(32) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `api_key` varchar(32) NOT NULL,
  `fcm_registration_id` text NOT NULL,
  `status` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `email`, `password_hash`, `api_key`, `fcm_registration_id`, `status`, `created_at`) VALUES
(5, 'akhiyar', 'akiyar18@gmail.com', '$2a$10$2c7181d77100c2f2825f6uAA1QcYBmU/ZIT2VglFxbAnQJxdugNvC', '5d55ed73dda2730ec3e01a5f8c631966', 'dMoTiG7bj9k:APA91bFiWPLSJCIuBEz7-_Zd1ndpDiSzwVOwp6ogPcajwN3mdLNhdfQ3aG_B-NUOwJMuOKEiwpfbYe1XsxYpObMXvXClq2WIqzRP_SUnJmA-BKyvqlz-2R-I1mT0fF0RjuK_v0s-2z1h', 1, '2017-03-26 14:26:57'),
(7, 'waladi', 'akiyar@apps.ipb.ac.id', '$2a$10$854b02b09a7dd8c446495uklxXMDrdDnC.6qmnvRjDVYoL7RmTT6.', 'ac5f8d340aa5ad64c51b44afeb8e4546', 'dMoTiG7bj9k:APA91bFiWPLSJCIuBEz7-_Zd1ndpDiSzwVOwp6ogPcajwN3mdLNhdfQ3aG_B-NUOwJMuOKEiwpfbYe1XsxYpObMXvXClq2WIqzRP_SUnJmA-BKyvqlz-2R-I1mT0fF0RjuK_v0s-2z1h', 1, '2017-03-26 14:25:50');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `alatuser`
--
ALTER TABLE `alatuser`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_alat` (`id_alat`);

--
-- Indexes for table `dataalat`
--
ALTER TABLE `dataalat`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `datasensor`
--
ALTER TABLE `datasensor`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_alat` (`id_alat`),
  ADD KEY `id_alat_2` (`id_alat`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `alatuser`
--
ALTER TABLE `alatuser`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT for table `dataalat`
--
ALTER TABLE `dataalat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `datasensor`
--
ALTER TABLE `datasensor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `alatuser`
--
ALTER TABLE `alatuser`
  ADD CONSTRAINT `alatuser_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `alatuser_ibfk_2` FOREIGN KEY (`id_alat`) REFERENCES `dataalat` (`id`);

--
-- Constraints for table `datasensor`
--
ALTER TABLE `datasensor`
  ADD CONSTRAINT `datasensor_ibfk_1` FOREIGN KEY (`id_alat`) REFERENCES `alatuser` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
