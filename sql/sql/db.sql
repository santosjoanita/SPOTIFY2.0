/*!40101 SET NAMES utf8 */;
/*!40014 SET FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET SQL_NOTES=0 */;

CREATE DATABASE /*!32312 IF NOT EXISTS*/ melodb /*!40100 DEFAULT CHARACTER SET utf8mb4 */;
USE melodb;

DROP TABLE IF EXISTS genres;
CREATE TABLE `genres` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'primary key',
  `genre` varchar(255) DEFAULT NULL COMMENT 'Music genre',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Genres table';

DROP TABLE IF EXISTS songs;
CREATE TABLE `songs` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'primary key',
  `title` varchar(255) DEFAULT NULL COMMENT 'Song title',
  `artist` varchar(255) DEFAULT NULL COMMENT 'Artist name',
  `album` varchar(255) DEFAULT NULL COMMENT 'Album name',
  `genre_id` int(11) DEFAULT NULL COMMENT 'FK to genres',
  `year` varchar(10) DEFAULT NULL COMMENT 'Release year',
  `cover_url` varchar(4000) DEFAULT NULL COMMENT 'Album cover image',
  PRIMARY KEY (`id`),
  KEY `genre_id` (`genre_id`),
  CONSTRAINT `songs_ibfk_1` FOREIGN KEY (`genre_id`) REFERENCES `genres` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Songs table';

DROP TABLE IF EXISTS user;
CREATE TABLE `user` (
  `id_user` varchar(255) NOT NULL COMMENT 'primary key',
  `password` varchar(400) DEFAULT NULL COMMENT 'Password',
  `name` varchar(400) DEFAULT NULL COMMENT 'User name',
  `photo` varchar(4000) DEFAULT NULL COMMENT 'Profile photo',
  `active` bit(1) DEFAULT NULL COMMENT 'Active account flag',
  PRIMARY KEY (`id_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='User table';
