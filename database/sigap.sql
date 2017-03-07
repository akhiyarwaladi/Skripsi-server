-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Mar 07, 2017 at 11:45 AM
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
  `id_alat` varchar(32) NOT NULL,
  `id_user` int(11) NOT NULL,
  `nama` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `alatuser`
--

INSERT INTO `alatuser` (`id`, `id_alat`, `id_user`, `nama`) VALUES
(11, 'fb1b48fdedbf4954a1b456fef45ae1f9', 1, 'Sigap003'),
(12, 'e87fb3ef5b24d00ded37d4c3b4ae1290', 1, 'SIgap004'),
(13, '40664b8af3ac490bb46fd49888c3ab9f', 2, 'sipadat001'),
(14, '892210a8d2dae6b7ba9602c80820b287', 5, 'Sigap1'),
(15, 'b33cd1d62b1d48fe8ebcc18d29d50c97', 5, 'Sigap2');

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
(2, 'fc90840a09747e79f1ef051b4f05d193', 2016, 0, '2016-07-24 08:01:53'),
(3, '892210a8d2dae6b7ba9602c80820b287', 2016, 0, '2016-07-24 08:16:57'),
(4, 'b33cd1d62b1d48fe8ebcc18d29d50c97', 2016, 0, '2016-07-30 09:42:37'),
(5, 'a3c59aa60699b426b7dba2a03e7be301', 2016, 0, '2016-07-30 09:42:39'),
(6, 'fb1b48fdedbf4954a1b456fef45ae1f9', 2016, 0, '2016-07-30 09:42:40'),
(7, 'bd7794c408f0dbbbea6731f3befa1164', 2016, 0, '2016-07-30 12:04:49'),
(8, '66c5e5deb5fcea7f567974cc73011c63', 2016, 0, '2016-07-30 12:04:51'),
(9, '6d8a3a6d6c1879d702125dc9092a2f90', 2016, 0, '2016-07-30 12:04:51'),
(10, '830ed14cbab24f4e926e9ec7ee735b05', 2016, 0, '2016-07-30 12:04:52'),
(11, 'e87fb3ef5b24d00ded37d4c3b4ae1290', 2016, 0, '2016-07-30 12:05:06'),
(12, '3f550e24770f59b005e77531c38ab3b2', 2016, 0, '2016-07-30 12:05:06'),
(13, 'b30354d0ebf76a6ddd1bb6cb450e789f', 2016, 0, '2016-07-30 12:05:07'),
(14, 'b5a5c0be51142e107ec7f9aed403696d', 2016, 0, '2016-07-30 12:05:07'),
(15, '7f972ae97098de7bba71ef6652812886', 2016, 0, '2016-07-30 12:05:08'),
(16, '1a08f403c08a6486a55b1f00b7d1357c', 2016, 0, '2016-07-30 12:05:08'),
(17, '10e66f560f08a6294cab1458523dda79', 2016, 0, '2016-07-30 12:05:09'),
(18, '8127d162e662163a36e75ef7ca1cfd55', 2016, 0, '2016-07-30 12:05:09'),
(19, '870fc14a12bdb0cefe68356e9a086a91', 2016, 0, '2016-07-30 12:38:36'),
(20, 'f0903b12f55c3c716432d3b2c6ca3857', 2016, 0, '2016-08-01 12:45:51'),
(21, '6ca308e70dba7a144094567a45863fb8', 2016, 0, '2016-08-01 13:43:38'),
(22, '198e52aa8ef1e5780e3218a485bfbdcc', 2016, 0, '2016-08-01 14:13:20'),
(23, 'c71316beccf2018817a86af3b1483c18', 2016, 0, '2016-08-01 14:13:21'),
(24, '74db35701b2cbed7c6bb8727031dd729', 2016, 0, '2016-08-01 14:13:23'),
(25, 'd991f1ac7ae09df66e7a711fe89098a6', 2016, 0, '2016-08-01 16:10:00'),
(26, 'c21466863fee733d9e0216c57cdd260c', 2016, 0, '2016-08-01 17:16:45'),
(33, '89455b83a7fa99a6be6b9c9ace9ff825', 2016, 0, '2016-08-01 17:21:54'),
(34, '31b99bbaad223f92a3719c34253a0d4e', 2016, 0, '2016-08-01 17:24:10'),
(35, '356f9af403d098dc954098121880cdae', 2016, 0, '2016-08-01 17:27:37'),
(36, '08cafd687940874c26d51e18406dfecc', 2016, 0, '2016-08-01 17:37:19'),
(37, '661c9f563160595014c4dcb4b020f64a', 2016, 0, '2016-10-14 16:34:06'),
(38, '46f9e0451f0419b323c6073ee9c7af5d', 2016, 0, '2016-10-14 16:34:59'),
(39, '7a50cefbd5119be40e3496f0df7b9f63', 2016, 0, '2016-10-14 16:34:59'),
(40, '3dbd8ba007989ab7679297ea4371ffd7', 2016, 0, '2016-10-14 16:35:00'),
(41, 'f18e18b556901fd9b3e80281fb5fc057', 2017, 0, '2017-02-26 14:06:18'),
(42, '7aeca4d17a15c0b33ab3cf704650d553', 2017, 0, '2017-02-26 14:06:46'),
(43, '7528cf069e51fb56ddd53c14b95d4dc8', 2017, 0, '2017-02-26 14:09:11'),
(44, 'd7348e3f16a617c9cd6591d0246dae90', 2017, 0, '2017-02-26 14:09:15'),
(45, '4c3ba70071dbd7c7e77e8623d6f03e56', 2017, 0, '2017-02-26 14:09:15'),
(46, '2e4cd7d29b35b153cf1ee7454faec324', 2017, 0, '2017-02-26 14:09:15'),
(47, '0c87b02230559d0ae12a27a6092cc513', 2017, 0, '2017-02-26 14:09:16'),
(48, 'd9a3d850657e808d31fb3efa8c8213b6', 2017, 0, '2017-02-26 14:09:16'),
(49, 'e141553efc3bfc921b4b43300e2b52d2', 2017, 0, '2017-02-26 14:09:16'),
(50, 'c1ad06307cb13be2aa95f49d552d9868', 2017, 0, '2017-02-26 14:13:43'),
(51, 'c310c2646ef4c45632c578ae17eba0ee', 2017, 0, '2017-02-26 14:13:44'),
(52, 'd3a9a3dc5cde6923731a1fd3d575a7e9', 2017, 0, '2017-02-26 14:13:44'),
(53, 'c4369b75f7a37ff02759a01c6b22aa2c', 2017, 0, '2017-02-26 14:13:45'),
(54, '71cd1248da83f1603639868d68e88aee', 2017, 0, '2017-02-26 14:13:47');

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

--
-- Dumping data for table `datasensor`
--

INSERT INTO `datasensor` (`id`, `id_alat`, `hpsp`, `hpc`, `uk`, `optime`, `created_at`) VALUES
(184, 15, 5, 3, 1, 60, '2017-03-03 08:21:01'),
(185, 14, 5, 3, 1, 60, '2017-03-03 08:21:52'),
(186, 15, 5, 3, 1, 60, '2017-03-03 08:22:06'),
(187, 14, 5, 3, 1, 60, '2017-03-03 08:22:56'),
(188, 15, 5, 3, 1, 60, '2017-03-03 08:23:11'),
(189, 14, 5, 3, -0.133333, 0, '2017-03-06 04:46:05'),
(190, 14, 5, 3, 1, 60, '2017-03-06 04:47:09'),
(191, 14, 5, 3, 1, 60, '2017-03-06 04:48:14'),
(192, 14, 5, 3, 1, 60, '2017-03-06 04:49:20'),
(193, 14, 5, 3, -0.133333, 0, '2017-03-06 05:02:20'),
(194, 14, 5, 3, 1, 60, '2017-03-06 05:03:26'),
(195, 14, 5, 3, -0.133333, 0, '2017-03-06 05:09:55'),
(196, 14, 5, 3, 1, 60, '2017-03-06 05:11:01'),
(197, 14, 5, 3, 1, 60, '2017-03-06 05:12:05'),
(198, 14, 5, 3, 1, 60, '2017-03-06 05:13:11'),
(199, 14, 5, 3, 1, 60, '2017-03-06 05:14:15'),
(200, 14, 5, 3, -0.133333, 0, '2017-03-06 05:17:30'),
(201, 14, 5, 3, -0.133333, 0, '2017-03-06 05:19:40'),
(202, 14, 5, 3, 1, 60, '2017-03-06 05:20:45'),
(203, 14, 5, 3, 1, 60, '2017-03-06 05:21:50'),
(204, 14, 5, 3, 1, 60, '2017-03-06 05:24:04'),
(205, 14, 5, 3, 1, 60, '2017-03-06 05:25:07'),
(206, 14, 5, 3, 1, 60, '2017-03-06 05:26:11'),
(207, 14, 5, 3, 1, 60, '2017-03-06 05:27:16'),
(208, 14, 5, 3, -0.133333, 0, '2017-03-06 05:44:41'),
(209, 15, 5, 3, -0.133333, 0, '2017-03-06 06:07:17'),
(210, 15, 5, 3, 1, 60, '2017-03-06 06:08:24'),
(211, 15, 5, 3, 1, 60, '2017-03-06 06:09:29'),
(212, 15, 5, 3, 1, 60, '2017-03-06 06:10:33'),
(236, 15, 5, 3, -0.133333, 0, '2017-03-06 08:34:49'),
(237, 15, 5, 3, 1, 60, '2017-03-06 08:35:55'),
(238, 15, 5, 3, 1, 60, '2017-03-06 08:36:58'),
(239, 15, 5, 3, 1, 60, '2017-03-06 08:38:03'),
(240, 15, 5, 3, 1, 60, '2017-03-06 08:39:10'),
(241, 15, 5, 3, 1, 60, '2017-03-06 08:40:14'),
(242, 15, 5, 3, -0.133333, 0, '2017-03-06 08:42:24'),
(243, 15, 5, 3, 1, 60, '2017-03-06 08:43:29'),
(244, 15, 5, 3, 1, 60, '2017-03-06 08:44:34'),
(245, 15, 5, 3, -0.133333, 0, '2017-03-06 08:45:39'),
(246, 15, 5, 3, 1, 60, '2017-03-06 08:46:44');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(32) NOT NULL,
  `auth_key` varchar(32) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `api_key` varchar(32) NOT NULL,
  `access_token` varchar(100) DEFAULT NULL,
  `fcm_registration_id` text NOT NULL,
  `status` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `email`, `auth_key`, `password_hash`, `api_key`, `access_token`, `fcm_registration_id`, `status`, `created_at`) VALUES
(4, 'ayaseeli@gmail.com', 'ayaseeli@gmail.com', '', '$2a$10$2b18b1ab5e8a007ec070au6LeVC9QMQRuRRSOMLYsCHvqNXEoCwkW', '277d3f42ee5e84cfb5fcd973d055f43c', NULL, '', 1, '2017-03-06 10:32:52'),
(5, 'akiyar18@gmail.com', 'akiyar18@gmail.com', '', '$2a$10$2c7181d77100c2f2825f6uAA1QcYBmU/ZIT2VglFxbAnQJxdugNvC', '5d55ed73dda2730ec3e01a5f8c631966', NULL, '', 1, '2017-03-07 10:18:38');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `alatuser`
--
ALTER TABLE `alatuser`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_user` (`id_user`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `dataalat`
--
ALTER TABLE `dataalat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;
--
-- AUTO_INCREMENT for table `datasensor`
--
ALTER TABLE `datasensor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=247;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `alatuser`
--
ALTER TABLE `alatuser`
  ADD CONSTRAINT `alatuser_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`);

--
-- Constraints for table `datasensor`
--
ALTER TABLE `datasensor`
  ADD CONSTRAINT `datasensor_ibfk_1` FOREIGN KEY (`id_alat`) REFERENCES `alatuser` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
