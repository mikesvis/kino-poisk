SET NAMES utf8mb4;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `movies`;
CREATE TABLE `movies` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `original` varchar(255) DEFAULT NULL,
  `year` year NOT NULL,
  `created_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `name` (`name`),
  KEY `year` (`year`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


DROP TABLE IF EXISTS `raitings`;
CREATE TABLE `raitings` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `movie_id` int unsigned NOT NULL,
  `position` int unsigned NOT NULL,
  `raiting` float NOT NULL,
  `votes` int unsigned NOT NULL,
  `created_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `movie_id` (`movie_id`),
  KEY `position` (`position`),
  CONSTRAINT `raitings_ibfk_1` FOREIGN KEY (`movie_id`) REFERENCES `movies` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
