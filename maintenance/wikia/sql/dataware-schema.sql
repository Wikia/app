-- MySQL dump 10.13  Distrib 5.7.18-15, for debian-linux-gnu (x86_64)
--
-- Host: geo-db-archive-slave.query.consul    Database: dataware
-- ------------------------------------------------------
-- Server version	5.7.18-15-log

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `ab_config`
--

DROP TABLE IF EXISTS `ab_config`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ab_config` (
  `id` int(11) NOT NULL,
  `updated` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ab_experiment_group_ranges`
--

DROP TABLE IF EXISTS `ab_experiment_group_ranges`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ab_experiment_group_ranges` (
  `group_id` int(11) NOT NULL,
  `version_id` int(11) NOT NULL,
  `ranges` varchar(255) DEFAULT NULL,
  `styles` blob,
  `scripts` blob,
  PRIMARY KEY (`version_id`,`group_id`),
  KEY `group_id` (`group_id`),
  CONSTRAINT `fk_range_group` FOREIGN KEY (`group_id`) REFERENCES `ab_experiment_groups` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_range_version` FOREIGN KEY (`version_id`) REFERENCES `ab_experiment_versions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ab_experiment_groups`
--

DROP TABLE IF EXISTS `ab_experiment_groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ab_experiment_groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` tinyblob,
  `experiment_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `experiment_id` (`experiment_id`),
  CONSTRAINT `fk_group_experiment` FOREIGN KEY (`experiment_id`) REFERENCES `ab_experiments` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=373 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ab_experiment_versions`
--

DROP TABLE IF EXISTS `ab_experiment_versions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ab_experiment_versions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `experiment_id` int(11) NOT NULL,
  `start_time` datetime NOT NULL,
  `end_time` datetime NOT NULL,
  `ga_slot` varchar(45) NOT NULL,
  `control_group_id` int(11) DEFAULT NULL,
  `flags` int(11) NOT NULL DEFAULT '3',
  PRIMARY KEY (`id`),
  KEY `experiment_id` (`experiment_id`),
  KEY `control_group_id` (`control_group_id`),
  CONSTRAINT `fk_version_control_group` FOREIGN KEY (`control_group_id`) REFERENCES `ab_experiment_groups` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `fk_version_experiment` FOREIGN KEY (`experiment_id`) REFERENCES `ab_experiments` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=489 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ab_experiments`
--

DROP TABLE IF EXISTS `ab_experiments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ab_experiments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` tinyblob,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=91 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `blobs`
--

DROP TABLE IF EXISTS `blobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `blobs` (
  `blob_id` int(10) NOT NULL AUTO_INCREMENT,
  `blob_text` mediumtext NOT NULL,
  PRIMARY KEY (`blob_id`)
) ENGINE=InnoDB AUTO_INCREMENT=104820274 DEFAULT CHARSET=utf8
/*!50100 PARTITION BY RANGE (blob_id)
(PARTITION p0 VALUES LESS THAN (10388840) ENGINE = InnoDB,
 PARTITION p1 VALUES LESS THAN (20777680) ENGINE = InnoDB,
 PARTITION p2 VALUES LESS THAN (41555360) ENGINE = InnoDB,
 PARTITION p3 VALUES LESS THAN (62333040) ENGINE = InnoDB,
 PARTITION p4 VALUES LESS THAN (83110720) ENGINE = InnoDB,
 PARTITION p5 VALUES LESS THAN (103888400) ENGINE = InnoDB,
 PARTITION p6 VALUES LESS THAN MAXVALUE ENGINE = InnoDB) */;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `chat_ban_users`
--

DROP TABLE IF EXISTS `chat_ban_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `chat_ban_users` (
  `cbu_wiki_id` int(10) NOT NULL DEFAULT '0',
  `cbu_user_id` int(10) NOT NULL DEFAULT '0',
  `cbu_admin_user_id` int(10) NOT NULL DEFAULT '0',
  `reason` varbinary(255) DEFAULT NULL,
  `start_date` varbinary(14) DEFAULT NULL,
  `end_date` varbinary(14) DEFAULT NULL,
  UNIQUE KEY `cbu_user_id` (`cbu_wiki_id`,`cbu_user_id`),
  KEY `wiki_start_date` (`cbu_wiki_id`,`start_date`)
) ENGINE=InnoDB DEFAULT CHARSET=binary;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `chat_blocked_users`
--

DROP TABLE IF EXISTS `chat_blocked_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `chat_blocked_users` (
  `cbu_user_id` int(11) NOT NULL DEFAULT '0',
  `cbu_blocked_user_id` int(11) NOT NULL DEFAULT '0',
  UNIQUE KEY `cbu_user_id` (`cbu_user_id`,`cbu_blocked_user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `email_types`
--

DROP TABLE IF EXISTS `email_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `email_types` (
  `id` tinyint(3) unsigned NOT NULL,
  `type` varchar(64) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `global_watchlist`
--

DROP TABLE IF EXISTS `global_watchlist`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `global_watchlist` (
  `gwa_user_id` int(11) DEFAULT NULL,
  `gwa_city_id` int(11) DEFAULT NULL,
  `gwa_namespace` int(11) DEFAULT NULL,
  `gwa_title` varchar(255) DEFAULT NULL,
  `gwa_rev_id` int(11) DEFAULT NULL,
  `gwa_timestamp` varchar(14) DEFAULT NULL,
  `gwa_rev_timestamp` varchar(14) DEFAULT NULL,
  UNIQUE KEY `wikia_user` (`gwa_city_id`,`gwa_user_id`,`gwa_namespace`,`gwa_title`),
  KEY `user_id` (`gwa_user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `pages`
--

DROP TABLE IF EXISTS `pages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pages` (
  `page_wikia_id` int(8) unsigned NOT NULL,
  `page_id` int(8) unsigned NOT NULL,
  `page_namespace` int(8) unsigned NOT NULL DEFAULT '0',
  `page_title` varchar(255) NOT NULL,
  `page_is_content` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `page_is_redirect` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `page_latest` int(8) unsigned NOT NULL DEFAULT '0',
  `page_last_edited` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `page_created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`page_wikia_id`,`page_id`),
  KEY `page_title_namespace_latest_idx` (`page_title`,`page_namespace`,`page_latest`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `user_flags`
--

DROP TABLE IF EXISTS `user_flags`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_flags` (
  `city_id` int(9) NOT NULL,
  `user_id` int(10) NOT NULL,
  `type` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `data` varchar(255) NOT NULL,
  PRIMARY KEY (`city_id`,`user_id`,`type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `wall_notification`
--

DROP TABLE IF EXISTS `wall_notification`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wall_notification` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `wiki_id` int(11) NOT NULL,
  `is_read` tinyint(1) NOT NULL,
  `is_reply` tinyint(1) NOT NULL,
  `author_id` int(11) NOT NULL,
  `unique_id` int(11) NOT NULL,
  `entity_key` char(30) NOT NULL,
  `is_hidden` tinyint(1) NOT NULL,
  `notifyeveryone` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `unique_id` (`unique_id`),
  KEY `user_wiki_unique` (`user_id`,`wiki_id`,`unique_id`)
) ENGINE=InnoDB AUTO_INCREMENT=363602576 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `wall_notification_queue`
--

DROP TABLE IF EXISTS `wall_notification_queue`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wall_notification_queue` (
  `wiki_id` int(10) unsigned NOT NULL,
  `entity_key` varbinary(30) NOT NULL,
  `page_id` int(10) unsigned NOT NULL DEFAULT '0',
  `event_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`wiki_id`,`page_id`),
  KEY `event_date` (`event_date`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `wall_notification_queue_processed`
--

DROP TABLE IF EXISTS `wall_notification_queue_processed`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wall_notification_queue_processed` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `entity_key` varbinary(30) NOT NULL,
  `event_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_event_idx` (`user_id`,`entity_key`),
  KEY `event_date` (`event_date`)
) ENGINE=InnoDB AUTO_INCREMENT=23978307 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `wikiastaff_log`
--

DROP TABLE IF EXISTS `wikiastaff_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wikiastaff_log` (
  `slog_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `slog_type` varbinary(10) NOT NULL DEFAULT '',
  `slog_action` varbinary(10) NOT NULL DEFAULT '',
  `slog_timestamp` binary(14) NOT NULL DEFAULT '19700101000000',
  `slog_user` int(10) unsigned NOT NULL DEFAULT '0',
  `slog_userdst` int(10) unsigned NOT NULL DEFAULT '0',
  `slog_comment` blob,
  `slog_params` blob,
  `slog_deleted` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `slog_site` varbinary(200) DEFAULT NULL,
  `slog_user_name` varbinary(255) NOT NULL,
  `slog_user_namedst` varbinary(255) NOT NULL,
  `slog_city` int(11) DEFAULT NULL,
  PRIMARY KEY (`slog_id`),
  KEY `slog_time` (`slog_timestamp`)
) ENGINE=InnoDB AUTO_INCREMENT=2064033 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!50112 SET @disable_bulk_load = IF (@is_rocksdb_supported, 'SET SESSION rocksdb_bulk_load = @old_rocksdb_bulk_load', 'SET @dummy_rocksdb_bulk_load = 0') */;
/*!50112 PREPARE s FROM @disable_bulk_load */;
/*!50112 EXECUTE s */;
/*!50112 DEALLOCATE PREPARE s */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-05-28 17:16:35
