SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

-- --------------------------------------------------------

DROP TABLE IF EXISTS `ach_user_score`;
CREATE TABLE IF NOT EXISTS `ach_user_score` (
  `wiki_id` int(9) signed NOT NULL,
  `user_id` int(5) unsigned NOT NULL,
  `score` int(10) unsigned NOT NULL,
  UNIQUE KEY `wiki_id` (`wiki_id`,`user_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


DROP TABLE IF EXISTS `ach_user_counters`;
CREATE TABLE IF NOT EXISTS `ach_user_counters` (
  `user_id` int(5) unsigned NOT NULL,
  `data` text NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


DROP TABLE IF EXISTS `ach_user_badges`;
CREATE TABLE IF NOT EXISTS `ach_user_badges` (
  `wiki_id` int(9) signed NOT NULL,
  `user_id` int(5) unsigned NOT NULL,
  `badge_type_id` int(10) signed NOT NULL,
  `badge_lap` tinyint(3) unsigned NULL,
  `badge_level` tinyint(3) unsigned NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `notified` tinyint(1) NOT NULL DEFAULT '0',
  KEY `id` (`wiki_id`, `user_id`),
  KEY `badge_count` (`wiki_id`, `badge_type_id`, `badge_lap`),
  KEY `level_date2` (`wiki_id`, `badge_level`, `date`, `badge_lap`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


DROP TABLE IF EXISTS `ach_custom_badges`;
CREATE TABLE IF NOT EXISTS `ach_custom_badges` (
  `id` int(10) signed NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `wiki_id` int(9) signed NOT NULL,
  `cat` varchar(255),
  `enabled` tinyint(1) NOT NULL DEFAULT 0,
  `show_recents` tinyint(1) NOT NULL DEFAULT 0,
  `type` tinyint(1) NOT NULL,
  `link` varbinary(255),
  KEY `id` (`wiki_id`, `id`),
  KEY `type` (`wiki_id`, `type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


DROP TABLE IF EXISTS `ach_ranking_snapshots`;
CREATE TABLE `ach_ranking_snapshots` (
`wiki_id` INT( 9 ) NOT NULL ,
`date` DATETIME NOT NULL ,
`data` TEXT NOT NULL ,
UNIQUE (
`wiki_id`
)
) ENGINE = INNODB CHARACTER SET utf8 COLLATE utf8_unicode_ci;
