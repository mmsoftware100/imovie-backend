-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 05, 2021 at 07:08 PM
-- Server version: 10.4.18-MariaDB
-- PHP Version: 8.0.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `datshin`
--

-- --------------------------------------------------------

--
-- Table structure for table `admob`
--

CREATE TABLE `admob` (
  `id` int(11) NOT NULL,
  `app_id` varchar(255) NOT NULL,
  `banner_id` varchar(255) NOT NULL,
  `interstitial_id` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admob`
--

INSERT INTO `admob` (`id`, `app_id`, `banner_id`, `interstitial_id`) VALUES
(1, 'ca-app-pub-3940256099942544~3347511713', 'ca-app-pub-3940256099942544/6300978111', 'ca-app-pub-3940256099942544/1033173712');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admob`
--
ALTER TABLE `admob`
  ADD PRIMARY KEY (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
