-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 18, 2021 at 08:13 AM
-- Server version: 10.4.20-MariaDB
-- PHP Version: 7.4.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `medisage`
--

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(150) DEFAULT NULL,
  `phone_number` varchar(11) DEFAULT NULL,
  `profile_image` varchar(255) DEFAULT NULL,
  `country` varchar(150) DEFAULT NULL,
  `country_code` varchar(10) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_by` int(11) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `name`, `email`, `phone_number`, `profile_image`, `country`, `country_code`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(1, 'Atish Pawar', 'pawar.atish1231@gmail.com', '8655023024', NULL, NULL, NULL, '2021-12-17 10:22:25', NULL, NULL, NULL),
(4, 'B', 'b@b.com', '8655023024', 'Resume.pdf', 'India', '91', '2021-12-18 01:11:36', NULL, '2021-12-18 01:11:36', NULL),
(5, 'C', 'c@c.com', '9988776655', '_20211216_103856.jpg.jpg', 'India', '91', '2021-12-17 07:14:31', NULL, '2021-12-17 07:14:31', NULL),
(6, 'D', 'd@d.com', '9988776655', '20211216_103856.jpg', 'Ind', '93', '2021-12-17 07:20:34', NULL, '2021-12-17 07:20:34', NULL),
(7, 'E', 'e@e.com', '9988776655', '20211216_103750.jpg', 'E', '92', '2021-12-17 07:20:51', NULL, '2021-12-17 07:20:51', NULL),
(8, 'New', 'new@new.com', '9988998899', 'map.png', 'New', '92', '2021-12-18 01:17:20', NULL, '2021-12-18 01:17:20', NULL),
(9, 'New', 'new@new.com', '9988998899', 'map.png', 'New', '92', '2021-12-18 01:17:47', NULL, '2021-12-18 01:17:47', NULL),
(10, 'new', 'new@new.com', '9988998899', 'email.png', 'new', '91', '2021-12-18 01:18:12', NULL, '2021-12-18 01:18:12', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
