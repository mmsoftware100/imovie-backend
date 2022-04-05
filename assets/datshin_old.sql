-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 23, 2021 at 06:17 AM
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
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` text COLLATE utf8_unicode_ci NOT NULL,
  `created_datetime` datetime NOT NULL,
  `modified_datetime` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `created_datetime`, `modified_datetime`) VALUES
(2, 'Action', '2021-05-14 08:05:05', '2021-05-23 03:35:50'),
(3, 'Romance', '2021-05-14 08:05:54', '2021-05-23 03:35:55'),
(4, 'Comedy', '2021-05-23 10:05:03', '2021-05-23 04:04:03'),
(5, 'Horror', '2021-05-23 10:05:10', '2021-05-23 04:04:10');

-- --------------------------------------------------------

--
-- Table structure for table `episodes`
--

CREATE TABLE `episodes` (
  `id` int(11) NOT NULL,
  `name` text COLLATE utf8_unicode_ci NOT NULL,
  `created_datetime` datetime NOT NULL,
  `modified_datetime` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `episodes`
--

INSERT INTO `episodes` (`id`, `name`, `created_datetime`, `modified_datetime`) VALUES
(1, '0', '2021-05-14 08:05:23', '2021-05-14 14:00:23'),
(2, '1', '2021-05-23 10:05:43', '2021-05-23 04:00:43'),
(3, '2', '2021-05-23 10:05:47', '2021-05-23 04:00:47'),
(4, '3', '2021-05-23 10:05:50', '2021-05-23 03:35:58'),
(5, '4', '2021-05-23 10:05:53', '2021-05-23 03:35:03'),
(6, '5', '2021-05-23 10:05:57', '2021-05-23 03:35:08'),
(7, '6', '2021-05-23 10:05:12', '2021-05-23 04:03:12'),
(8, '7', '2021-05-23 10:05:17', '2021-05-23 04:03:17'),
(9, '8', '2021-05-23 10:05:21', '2021-05-23 04:03:21'),
(10, '9', '2021-05-23 10:05:24', '2021-05-23 04:03:24'),
(11, '10', '2021-05-23 10:05:28', '2021-05-23 04:03:28');

-- --------------------------------------------------------

--
-- Table structure for table `episode_file`
--

CREATE TABLE `episode_file` (
  `id` int(11) NOT NULL,
  `season_episode_id` int(11) NOT NULL,
  `file_id` int(11) NOT NULL,
  `created_datetime` datetime NOT NULL,
  `modified_datetime` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `movies`
--

CREATE TABLE `movies` (
  `id` int(11) NOT NULL,
  `name` text COLLATE utf8_unicode_ci NOT NULL,
  `poster_landscape` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `poster_portrait` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `release_year` year(4) NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `movie_type_id` int(11) NOT NULL,
  `created_datetime` datetime NOT NULL,
  `modified_datetime` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `movie_category`
--

CREATE TABLE `movie_category` (
  `id` int(11) NOT NULL,
  `movie_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `created_datetime` datetime NOT NULL,
  `modified_datetime` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `movie_season`
--

CREATE TABLE `movie_season` (
  `id` int(11) NOT NULL,
  `name` text COLLATE utf8_unicode_ci NOT NULL,
  `movie_id` int(11) NOT NULL,
  `season_id` int(11) NOT NULL,
  `created_datetime` datetime NOT NULL,
  `modified_datetime` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `mvfiles`
--

CREATE TABLE `mvfiles` (
  `id` int(11) NOT NULL,
  `name` text COLLATE utf8_unicode_ci NOT NULL,
  `resolution_id` int(11) NOT NULL,
  `file_size` int(11) NOT NULL,
  `created_datetime` datetime NOT NULL,
  `modified_datetime` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `mvtypes`
--

CREATE TABLE `mvtypes` (
  `id` int(11) NOT NULL,
  `name` text COLLATE utf8_unicode_ci NOT NULL,
  `created_datetime` datetime NOT NULL,
  `modified_datetime` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `mvtypes`
--

INSERT INTO `mvtypes` (`id`, `name`, `created_datetime`, `modified_datetime`) VALUES
(1, 'movie', '2021-05-14 16:03:01', '2021-05-14 14:03:08'),
(2, 'series', '2021-05-14 16:03:01', '2021-05-14 14:03:08');

-- --------------------------------------------------------

--
-- Table structure for table `resolutions`
--

CREATE TABLE `resolutions` (
  `id` int(11) NOT NULL,
  `name` text COLLATE utf8_unicode_ci NOT NULL,
  `created_datetime` datetime NOT NULL,
  `modified_datetime` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `resolutions`
--

INSERT INTO `resolutions` (`id`, `name`, `created_datetime`, `modified_datetime`) VALUES
(1, '720 p', '2021-05-14 08:05:32', '2021-05-14 14:00:32'),
(2, '1080 p', '2021-05-14 08:05:37', '2021-05-14 01:35:41');

-- --------------------------------------------------------

--
-- Table structure for table `seasons`
--

CREATE TABLE `seasons` (
  `id` int(11) NOT NULL,
  `name` text COLLATE utf8_unicode_ci NOT NULL,
  `created_datetime` datetime NOT NULL,
  `modified_datetime` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `seasons`
--

INSERT INTO `seasons` (`id`, `name`, `created_datetime`, `modified_datetime`) VALUES
(1, '0', '2021-05-14 08:05:05', '2021-05-14 01:35:16'),
(2, '1', '2021-05-23 10:05:58', '2021-05-23 03:59:58'),
(3, '2', '2021-05-23 10:05:01', '2021-05-23 04:00:01'),
(4, '3', '2021-05-23 10:05:06', '2021-05-23 04:00:06'),
(5, '4', '2021-05-23 10:05:10', '2021-05-23 04:00:10'),
(6, '5', '2021-05-23 10:05:14', '2021-05-23 04:00:14'),
(7, '6', '2021-05-23 10:05:17', '2021-05-23 04:00:17'),
(8, '7', '2021-05-23 10:05:21', '2021-05-23 04:00:21'),
(9, '8', '2021-05-23 10:05:25', '2021-05-23 04:00:25'),
(10, '9', '2021-05-23 10:05:29', '2021-05-23 04:00:29'),
(11, '10', '2021-05-23 10:05:33', '2021-05-23 04:00:33');

-- --------------------------------------------------------

--
-- Table structure for table `season_episode`
--

CREATE TABLE `season_episode` (
  `id` int(11) NOT NULL,
  `name` text COLLATE utf8_unicode_ci NOT NULL,
  `duration` int(11) NOT NULL,
  `movie_season_id` int(11) NOT NULL,
  `episode_id` int(11) NOT NULL,
  `created_datetime` datetime NOT NULL,
  `modified_datetime` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `episodes`
--
ALTER TABLE `episodes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `episode_file`
--
ALTER TABLE `episode_file`
  ADD PRIMARY KEY (`id`),
  ADD KEY `movie_episode_id` (`season_episode_id`),
  ADD KEY `file_id` (`file_id`);

--
-- Indexes for table `movies`
--
ALTER TABLE `movies`
  ADD PRIMARY KEY (`id`),
  ADD KEY `movie_type_id` (`movie_type_id`);

--
-- Indexes for table `movie_category`
--
ALTER TABLE `movie_category`
  ADD PRIMARY KEY (`id`),
  ADD KEY `movie_Id` (`movie_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `movie_season`
--
ALTER TABLE `movie_season`
  ADD PRIMARY KEY (`id`),
  ADD KEY `movie_id` (`movie_id`),
  ADD KEY `season_id` (`season_id`);

--
-- Indexes for table `mvfiles`
--
ALTER TABLE `mvfiles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `resolution_id` (`resolution_id`);

--
-- Indexes for table `mvtypes`
--
ALTER TABLE `mvtypes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `resolutions`
--
ALTER TABLE `resolutions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `seasons`
--
ALTER TABLE `seasons`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `season_episode`
--
ALTER TABLE `season_episode`
  ADD PRIMARY KEY (`id`),
  ADD KEY `movie_season_id` (`movie_season_id`),
  ADD KEY `episode_id` (`episode_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `episodes`
--
ALTER TABLE `episodes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `episode_file`
--
ALTER TABLE `episode_file`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `movies`
--
ALTER TABLE `movies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `movie_category`
--
ALTER TABLE `movie_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `movie_season`
--
ALTER TABLE `movie_season`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `mvfiles`
--
ALTER TABLE `mvfiles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `mvtypes`
--
ALTER TABLE `mvtypes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `resolutions`
--
ALTER TABLE `resolutions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `seasons`
--
ALTER TABLE `seasons`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `season_episode`
--
ALTER TABLE `season_episode`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `episode_file`
--
ALTER TABLE `episode_file`
  ADD CONSTRAINT `episode_file_ibfk_1` FOREIGN KEY (`file_id`) REFERENCES `mvfiles` (`id`),
  ADD CONSTRAINT `episode_file_ibfk_2` FOREIGN KEY (`season_episode_id`) REFERENCES `season_episode` (`id`);

--
-- Constraints for table `movies`
--
ALTER TABLE `movies`
  ADD CONSTRAINT `movies_ibfk_1` FOREIGN KEY (`movie_type_id`) REFERENCES `mvtypes` (`id`);

--
-- Constraints for table `movie_category`
--
ALTER TABLE `movie_category`
  ADD CONSTRAINT `movie_category_ibfk_1` FOREIGN KEY (`movie_id`) REFERENCES `movies` (`id`),
  ADD CONSTRAINT `movie_category_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`);

--
-- Constraints for table `movie_season`
--
ALTER TABLE `movie_season`
  ADD CONSTRAINT `movie_season_ibfk_1` FOREIGN KEY (`movie_id`) REFERENCES `movies` (`id`),
  ADD CONSTRAINT `movie_season_ibfk_2` FOREIGN KEY (`season_id`) REFERENCES `seasons` (`id`);

--
-- Constraints for table `mvfiles`
--
ALTER TABLE `mvfiles`
  ADD CONSTRAINT `mvfiles_ibfk_1` FOREIGN KEY (`resolution_id`) REFERENCES `resolutions` (`id`);

--
-- Constraints for table `season_episode`
--
ALTER TABLE `season_episode`
  ADD CONSTRAINT `season_episode_ibfk_2` FOREIGN KEY (`episode_id`) REFERENCES `episodes` (`id`),
  ADD CONSTRAINT `season_episode_ibfk_3` FOREIGN KEY (`movie_season_id`) REFERENCES `movie_season` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
