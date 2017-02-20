-- phpMyAdmin SQL Dump
-- version 4.3.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jul 25, 2016 at 09:05 AM
-- Server version: 5.6.24
-- PHP Version: 5.6.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `sipadat`
--

-- --------------------------------------------------------

--
-- Table structure for table `alatuser`
--

CREATE TABLE IF NOT EXISTS `alatuser` (
  `id` int(11) NOT NULL,
  `id_alat` varchar(32) NOT NULL,
  `id_user` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `alatuser`
--

INSERT INTO `alatuser` (`id`, `id_alat`, `id_user`) VALUES
(3, '4d9fa11830afb28f9587ec53a1d96dd0', 5);

-- --------------------------------------------------------

--
-- Table structure for table `dataalat`
--

CREATE TABLE IF NOT EXISTS `dataalat` (
  `id` int(11) NOT NULL,
  `kode` varchar(32) NOT NULL,
  `tanggal_produksi` int(11) NOT NULL,
  `status` int(1) NOT NULL,
  `registered_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `dataalat`
--

INSERT INTO `dataalat` (`id`, `kode`, `tanggal_produksi`, `status`, `registered_at`) VALUES
(1, '40664b8af3ac490bb46fd49888c3ab9f', 2016, 0, '2016-07-24 08:00:43'),
(2, 'fc90840a09747e79f1ef051b4f05d193', 2016, 0, '2016-07-24 08:01:53'),
(3, 'b23d6a2cca18239e3c83759a479bc2e2', 2016, 0, '2016-07-24 08:18:39'),
(4, '258020dcf96eb76a6db9dc940f926c20', 2016, 0, '2016-07-24 17:43:24'),
(5, 'acfa1c9d35df0958339a8beff3bd5a38', 2016, 0, '2016-07-25 03:11:27'),
(6, '4d9fa11830afb28f9587ec53a1d96dd0', 2016, 0, '2016-07-25 03:12:40'),
(7, '39b0c84ae0c0e4a82f050f8fe5308ae7', 2016, 0, '2016-07-25 04:15:50'),
(8, 'c0be290aa4876793cdf2ca1adeeae987', 2016, 0, '2016-07-25 07:04:02');

-- --------------------------------------------------------

--
-- Table structure for table `datasensor`
--

CREATE TABLE IF NOT EXISTS `datasensor` (
  `id` int(11) NOT NULL,
  `id_alat` varchar(32) NOT NULL,
  `suhu` float NOT NULL,
  `ph` float NOT NULL,
  `do` float NOT NULL,
  `hasil` float NOT NULL,
  `status` int(1) NOT NULL,
  `create_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `datasensor`
--

INSERT INTO `datasensor` (`id`, `id_alat`, `suhu`, `ph`, `do`, `hasil`, `status`, `create_at`) VALUES
(1, '123', 3, 4, 5, 2, 1, '2016-07-24 01:02:39'),
(2, '123', 3, 4, 5, 98, 1, '2016-07-24 01:04:46'),
(3, 'a5378660d461721073a7dde756caddbc', 3, 4, 56, 98, 1, '2016-07-24 01:06:14');

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE IF NOT EXISTS `tasks` (
  `id` int(11) NOT NULL,
  `sensor1` float NOT NULL,
  `sensor2` float NOT NULL,
  `sensor3` float NOT NULL,
  `output` float NOT NULL,
  `status` int(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tasks`
--

INSERT INTO `tasks` (`id`, `sensor1`, `sensor2`, `sensor3`, `output`, `status`, `created_at`) VALUES
(1, 1, 2, 3, 4, 0, '2016-07-23 23:47:56'),
(2, 1, 2, 3, 4, 0, '2016-07-23 23:48:01'),
(3, 1, 2, 3, 4, 0, '2016-07-23 23:50:14'),
(4, 1, 2, 3, 4, 0, '2016-07-23 23:50:15'),
(5, 1, 2, 3, 4, 0, '2016-07-23 23:50:16'),
(6, 1, 2, 3, 4, 0, '2016-07-23 23:54:07'),
(7, 1, 2, 3, 4, 0, '2016-07-23 23:57:43'),
(8, 1, 2, 3, 4, 0, '2016-07-24 00:00:27'),
(9, 1, 2, 3, 4, 0, '2016-07-24 00:01:32'),
(10, 1, 2, 3, 4, 0, '2016-07-24 00:01:52'),
(11, 1, 2, 3, 4, 0, '2016-07-24 00:02:06'),
(12, 1, 2, 3, 4, 0, '2016-07-24 00:02:17'),
(13, 1, 2, 3, 4, 0, '2016-07-24 00:02:24'),
(14, 1, 2, 3, 4, 0, '2016-07-24 00:02:36'),
(15, 1, 2, 3, 4, 0, '2016-07-24 00:03:00'),
(16, 1, 2, 3, 4, 0, '2016-07-24 00:03:36'),
(17, 1, 2, 3, 4, 0, '2016-07-24 00:10:12'),
(18, 1, 2, 3, 7, 0, '2016-07-24 00:11:13'),
(19, 0, 0, 0, 0, 0, '2016-07-24 00:28:58'),
(20, 1, 2, 3, 9, 0, '2016-07-24 00:45:31'),
(21, 1, 2, 3, 7, 0, '2016-07-24 00:48:12'),
(22, 1, 2, 3, 7, 0, '2016-07-24 00:48:12');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL,
  `name` varchar(250) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `password_hash` text NOT NULL,
  `api_key` varchar(32) NOT NULL,
  `gcm_registration_id` text NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password_hash`, `api_key`, `gcm_registration_id`, `status`, `created_at`) VALUES
(5, 'ardhimaarik', 'ardhimaarik2@yahoo.co.id', '$2a$10$ea5f31763120d0eb282c4u4dxVNqZP/Fc8cVEncM8aHlZRdMkISbK', 'dfeae61f06b23ce3aded80ee701d1300', '', 1, '2016-07-23 20:09:22');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `alatuser`
--
ALTER TABLE `alatuser`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dataalat`
--
ALTER TABLE `dataalat`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `datasensor`
--
ALTER TABLE `datasensor`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tasks`
--
ALTER TABLE `tasks`
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
-- AUTO_INCREMENT for table `alatuser`
--
ALTER TABLE `alatuser`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `dataalat`
--
ALTER TABLE `dataalat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `datasensor`
--
ALTER TABLE `datasensor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=23;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
>>>>>>> origin/master
