-- Adminer 4.8.1 MySQL 5.5.5-10.3.31-MariaDB dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

DROP TABLE IF EXISTS `admob`;
CREATE TABLE `admob` (
  `id` int(11) NOT NULL,
  `app_id` varchar(255) NOT NULL,
  `banner_id` varchar(255) NOT NULL,
  `interstitial_id` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `admob` (`id`, `app_id`, `banner_id`, `interstitial_id`) VALUES
(1,	'ca-app-pub-3940256099942544~3347511713',	'ca-app-pub-3940256099942544/6300978111',	'ca-app-pub-3940256099942544/1033173712');

DROP TABLE IF EXISTS `ads`;
CREATE TABLE `ads` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `ads_type` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `media_url` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `ads_status` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `url` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `created_datetime` datetime NOT NULL,
  `modified_datetime` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `ads` (`id`, `name`, `description`, `ads_type`, `media_url`, `ads_status`, `url`, `created_datetime`, `modified_datetime`) VALUES
(3,	'Test',	'adssdfgsd',	'Bannerdsafassdfg',	'testing.csdfgs',	'1',	'testing.cfsdfgdsg',	'2021-06-07 09:06:19',	'2021-06-08 02:36:14');

DROP TABLE IF EXISTS `categories`;
CREATE TABLE `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text COLLATE utf8_unicode_ci NOT NULL,
  `created_datetime` datetime NOT NULL,
  `modified_datetime` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `categories` (`id`, `name`, `created_datetime`, `modified_datetime`) VALUES
(2,	'Action',	'2021-05-14 08:05:05',	'2021-05-23 03:35:50'),
(3,	'Romance',	'2021-05-14 08:05:54',	'2021-05-23 03:35:55'),
(4,	'Comedy',	'2021-05-23 10:05:03',	'2021-05-23 04:04:03'),
(5,	'Horror',	'2021-05-23 10:05:10',	'2021-05-23 04:04:10');

DROP TABLE IF EXISTS `episodes`;
CREATE TABLE `episodes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text COLLATE utf8_unicode_ci NOT NULL,
  `created_datetime` datetime NOT NULL,
  `modified_datetime` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `episodes` (`id`, `name`, `created_datetime`, `modified_datetime`) VALUES
(1,	'0',	'2021-05-14 08:05:23',	'2021-05-14 14:00:23'),
(2,	'1',	'2021-05-23 10:05:43',	'2021-05-23 04:00:43'),
(3,	'2',	'2021-05-23 10:05:47',	'2021-05-23 04:00:47'),
(4,	'3',	'2021-05-23 10:05:50',	'2021-05-23 03:35:58'),
(5,	'4',	'2021-05-23 10:05:53',	'2021-05-23 03:35:03'),
(6,	'5',	'2021-05-23 10:05:57',	'2021-05-23 03:35:08'),
(7,	'6',	'2021-05-23 10:05:12',	'2021-05-23 04:03:12'),
(8,	'7',	'2021-05-23 10:05:17',	'2021-05-23 04:03:17'),
(9,	'8',	'2021-05-23 10:05:21',	'2021-05-23 04:03:21'),
(10,	'9',	'2021-05-23 10:05:24',	'2021-05-23 04:03:24'),
(11,	'10',	'2021-05-23 10:05:28',	'2021-05-23 04:03:28');

DROP TABLE IF EXISTS `episode_file`;
CREATE TABLE `episode_file` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `season_episode_id` int(11) NOT NULL,
  `file_id` int(11) NOT NULL,
  `created_datetime` datetime NOT NULL,
  `modified_datetime` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `movie_episode_id` (`season_episode_id`),
  KEY `file_id` (`file_id`),
  CONSTRAINT `episode_file_ibfk_1` FOREIGN KEY (`file_id`) REFERENCES `mvfiles` (`id`),
  CONSTRAINT `episode_file_ibfk_2` FOREIGN KEY (`season_episode_id`) REFERENCES `season_episode` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `episode_file` (`id`, `season_episode_id`, `file_id`, `created_datetime`, `modified_datetime`) VALUES
(6,	5,	6,	'2021-12-02 09:12:25',	'2021-12-02 14:38:25'),
(7,	6,	7,	'2021-12-02 10:12:29',	'2021-12-02 15:37:29'),
(8,	7,	8,	'2021-12-02 10:12:24',	'2021-12-02 15:43:24');

DROP TABLE IF EXISTS `movies`;
CREATE TABLE `movies` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text COLLATE utf8_unicode_ci NOT NULL,
  `poster_landscape` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `poster_portrait` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `release_year` year(4) NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `movie_type_id` int(11) NOT NULL,
  `created_datetime` datetime NOT NULL,
  `modified_datetime` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `movie_type_id` (`movie_type_id`),
  CONSTRAINT `movies_ibfk_1` FOREIGN KEY (`movie_type_id`) REFERENCES `mvtypes` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `movies` (`id`, `name`, `poster_landscape`, `poster_portrait`, `release_year`, `description`, `movie_type_id`, `created_datetime`, `modified_datetime`) VALUES
(5,	'Arsenal Vs Liverpool',	'163849647694198369361a978dc4ecf5.jpg',	'163849647635101873661a978dc4ed38.jpg',	'2021',	'Liverpool’s front three helped themselves to a goal apiece after wearing down an inspired Aaron Ramsdale to beat Arsenal 4-0 and go second in the Premier League.  Ramsdale was on top form to deny the hosts in the early stages but Sadio Mane’s steered header put the Reds in front six minutes before the break.  Diogo Jota exploited an error from Nuno Tavares to waltz past Ramsdale and make it two in front of the Kop. And Mohamed Salah eventually got his goal after the Gunners keeper had further frustrated the Premier League’s top goalscorer.',	1,	'2021-11-29 05:11:16',	'2021-12-03 08:12:36'),
(6,	'Man U Vs Chelsea',	'1638496494777817061a978ee772c7.jpg',	'163849649492401973361a978ee77310.jpg',	'2021',	'Best  Match Ever.',	1,	'2021-12-02 09:12:25',	'2021-12-03 08:12:54'),
(7,	'Everton Vs Man City',	'1638496457122588030761a978c9106dc.jfif',	'163849645721571454261a978c910729.jpg',	'2021',	'Everton Vs Man City',	1,	'2021-12-02 10:12:24',	'2021-12-03 08:12:17');

DROP TABLE IF EXISTS `movie_category`;
CREATE TABLE `movie_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `movie_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `created_datetime` datetime NOT NULL,
  `modified_datetime` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `movie_Id` (`movie_id`),
  KEY `category_id` (`category_id`),
  CONSTRAINT `movie_category_ibfk_1` FOREIGN KEY (`movie_id`) REFERENCES `movies` (`id`),
  CONSTRAINT `movie_category_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `movie_category` (`id`, `movie_id`, `category_id`, `created_datetime`, `modified_datetime`) VALUES
(4,	5,	2,	'2021-11-29 05:11:16',	'2021-11-29 10:35:16'),
(8,	6,	2,	'2021-12-02 09:12:25',	'2021-12-02 14:38:25'),
(12,	7,	2,	'2021-12-02 10:12:24',	'2021-12-02 15:43:24');

DROP TABLE IF EXISTS `movie_season`;
CREATE TABLE `movie_season` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text COLLATE utf8_unicode_ci NOT NULL,
  `movie_id` int(11) NOT NULL,
  `season_id` int(11) NOT NULL,
  `created_datetime` datetime NOT NULL,
  `modified_datetime` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `movie_id` (`movie_id`),
  KEY `season_id` (`season_id`),
  CONSTRAINT `movie_season_ibfk_1` FOREIGN KEY (`movie_id`) REFERENCES `movies` (`id`),
  CONSTRAINT `movie_season_ibfk_2` FOREIGN KEY (`season_id`) REFERENCES `seasons` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `movie_season` (`id`, `name`, `movie_id`, `season_id`, `created_datetime`, `modified_datetime`) VALUES
(5,	'',	6,	1,	'2021-12-02 09:12:25',	'2021-12-03 08:12:54'),
(6,	'',	5,	1,	'2021-12-02 10:12:29',	'2021-12-03 08:12:36'),
(7,	'',	7,	1,	'2021-12-02 10:12:24',	'2021-12-03 08:12:17');

DROP TABLE IF EXISTS `mvfiles`;
CREATE TABLE `mvfiles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text COLLATE utf8_unicode_ci NOT NULL,
  `resolution_id` int(11) NOT NULL,
  `file_size` int(11) NOT NULL,
  `created_datetime` datetime NOT NULL,
  `modified_datetime` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `resolution_id` (`resolution_id`),
  CONSTRAINT `mvfiles_ibfk_1` FOREIGN KEY (`resolution_id`) REFERENCES `resolutions` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `mvfiles` (`id`, `name`, `resolution_id`, `file_size`, `created_datetime`, `modified_datetime`) VALUES
(6,	'https://miyabibonsaibucket.s3.ap-northeast-1.amazonaws.com/uploads/Free+domain+and+hosting+for+Junior+Web+Developers.mp4',	2,	5120,	'2021-12-02 09:12:25',	'2021-12-03 08:12:54'),
(7,	'https://miyabibonsaibucket.s3.ap-northeast-1.amazonaws.com/uploads/Free+domain+and+hosting+for+Junior+Web+Developers.mp4',	2,	2048,	'2021-12-02 10:12:29',	'2021-12-03 08:12:36'),
(8,	'https://miyabibonsaibucket.s3.ap-northeast-1.amazonaws.com/uploads/Free+domain+and+hosting+for+Junior+Web+Developers.mp4',	2,	2048,	'2021-12-02 10:12:24',	'2021-12-03 08:12:17');

DROP TABLE IF EXISTS `mvtypes`;
CREATE TABLE `mvtypes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text COLLATE utf8_unicode_ci NOT NULL,
  `created_datetime` datetime NOT NULL,
  `modified_datetime` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `mvtypes` (`id`, `name`, `created_datetime`, `modified_datetime`) VALUES
(1,	'movie',	'2021-05-14 16:03:01',	'2021-05-14 14:03:08'),
(2,	'series',	'2021-05-14 16:03:01',	'2021-05-14 14:03:08');

DROP TABLE IF EXISTS `resolutions`;
CREATE TABLE `resolutions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text COLLATE utf8_unicode_ci NOT NULL,
  `created_datetime` datetime NOT NULL,
  `modified_datetime` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `resolutions` (`id`, `name`, `created_datetime`, `modified_datetime`) VALUES
(1,	'720 p',	'2021-05-14 08:05:32',	'2021-05-14 14:00:32'),
(2,	'1080 p',	'2021-05-14 08:05:37',	'2021-05-14 01:35:41');

DROP TABLE IF EXISTS `seasons`;
CREATE TABLE `seasons` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text COLLATE utf8_unicode_ci NOT NULL,
  `created_datetime` datetime NOT NULL,
  `modified_datetime` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `seasons` (`id`, `name`, `created_datetime`, `modified_datetime`) VALUES
(1,	'0',	'2021-05-14 08:05:05',	'2021-05-14 01:35:16'),
(2,	'1',	'2021-05-23 10:05:58',	'2021-05-23 03:59:58'),
(3,	'2',	'2021-05-23 10:05:01',	'2021-05-23 04:00:01'),
(4,	'3',	'2021-05-23 10:05:06',	'2021-05-23 04:00:06'),
(5,	'4',	'2021-05-23 10:05:10',	'2021-05-23 04:00:10'),
(6,	'5',	'2021-05-23 10:05:14',	'2021-05-23 04:00:14'),
(7,	'6',	'2021-05-23 10:05:17',	'2021-05-23 04:00:17'),
(8,	'7',	'2021-05-23 10:05:21',	'2021-05-23 04:00:21'),
(9,	'8',	'2021-05-23 10:05:25',	'2021-05-23 04:00:25'),
(10,	'9',	'2021-05-23 10:05:29',	'2021-05-23 04:00:29'),
(11,	'10',	'2021-05-23 10:05:33',	'2021-05-23 04:00:33');

DROP TABLE IF EXISTS `season_episode`;
CREATE TABLE `season_episode` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text COLLATE utf8_unicode_ci NOT NULL,
  `duration` int(11) NOT NULL,
  `movie_season_id` int(11) NOT NULL,
  `episode_id` int(11) NOT NULL,
  `created_datetime` datetime NOT NULL,
  `modified_datetime` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `movie_season_id` (`movie_season_id`),
  KEY `episode_id` (`episode_id`),
  CONSTRAINT `season_episode_ibfk_2` FOREIGN KEY (`episode_id`) REFERENCES `episodes` (`id`),
  CONSTRAINT `season_episode_ibfk_3` FOREIGN KEY (`movie_season_id`) REFERENCES `movie_season` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `season_episode` (`id`, `name`, `duration`, `movie_season_id`, `episode_id`, `created_datetime`, `modified_datetime`) VALUES
(5,	'',	842,	5,	1,	'2021-12-02 09:12:25',	'2021-12-03 08:12:54'),
(6,	'',	842,	6,	1,	'2021-12-02 10:12:29',	'2021-12-03 08:12:36'),
(7,	'',	842,	7,	1,	'2021-12-02 10:12:24',	'2021-12-03 08:12:17');

DROP TABLE IF EXISTS `subscription`;
CREATE TABLE `subscription` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `user_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `user_type` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `exp_date` date NOT NULL,
  `created_datetime` datetime NOT NULL,
  `modified_datetime` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `subscription` (`id`, `user_id`, `user_name`, `user_type`, `exp_date`, `created_datetime`, `modified_datetime`) VALUES
(3,	5,	'Hein test',	'premium test',	'2012-07-12',	'2021-06-08 10:06:35',	'2021-06-08 03:36:50'),
(4,	5,	'Hein test',	'premium test',	'2012-07-12',	'2021-06-08 10:06:38',	'2021-06-08 03:36:38');

DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role` int(11) DEFAULT NULL,
  `name` text COLLATE utf8_unicode_ci NOT NULL,
  `password` text COLLATE utf8_unicode_ci NOT NULL,
  `personal_data` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `created_datetime` datetime NOT NULL,
  `modified_datetime` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `user` (`id`, `role`, `name`, `password`, `personal_data`, `created_datetime`, `modified_datetime`) VALUES
(5,	2,	'admin',	'password',	'testing',	'2021-06-07 09:06:23',	'2021-06-07 15:03:23');

-- 2021-12-06 11:21:58
