-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 15, 2024 at 04:47 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_sig`
--

-- --------------------------------------------------------

--
-- Table structure for table `markers`
--

CREATE TABLE `markers` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `lat` double NOT NULL,
  `lng` double NOT NULL,
  `name` varchar(256) DEFAULT NULL,
  `description` varchar(256) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `markers`
--

INSERT INTO `markers` (`id`, `user_id`, `lat`, `lng`, `name`, `description`) VALUES
(12, 1, -3.9658455569886493, 122.53976047039033, 'D\'Blitz Hotel Kendari', 'Hotel Bintang 3'),
(13, 1, -3.9650527843913825, 122.53984093666078, 'Hotel Krisan', 'Hotel Bintang 2'),
(14, 1, -3.9642236480228275, 122.5427430868149, 'Hotel Cempaka', 'Hotel Bintang 1'),
(15, 1, -3.9636454294225327, 122.54451870918275, 'Hotel Grand SO', 'Hotel Bintang 1'),
(16, 1, -3.9681915824468668, 122.53196854928015, 'Swiss-Belhotel Kendari', 'Hotel Bintang 4'),
(17, 1, -3.969709839341525, 122.52943933010103, 'Same Hotel Kendari', 'Hotel Bintang 3'),
(18, 1, -3.970142758606803, 122.52825379371644, 'CLARO Kendari', 'Hotel Bintang 4'),
(19, 1, -3.9701478849792933, 122.52754032611848, 'Hotel Kubra', 'Hotel Bintang 1');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`) VALUES
(1, 'yusran', '$2y$10$v52kRwyfjBhfSdLeIJRIOeX40h4gkFr635ojHe1U71jWcBdIySxQK'),
(2, 'nas', '$2y$10$o7LgJ4J9Xf6Id/u.wjtCaOL.iJRucTv6hxalPoSm3wEpKJhFDjGoi'),
(3, 'olan', '$2y$10$GBIbTRbYZIv8HLy3M1I10.ga.QfYP0PWt7jUltWzFSl9Sse6U8Sq.');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `markers`
--
ALTER TABLE `markers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `markers`
--
ALTER TABLE `markers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `markers`
--
ALTER TABLE `markers`
  ADD CONSTRAINT `user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
