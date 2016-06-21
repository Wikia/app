-- noinspection SqlDialectInspectionForFile
-- noinspection SqlNoDataSourceInspectionForFile
-- MySQL dump 10.13  Distrib 5.6.24-72.2, for debian-linux-gnu (x86_64)
--
-- Host: slave.db-specials.service.consul    Database: specials
-- ------------------------------------------------------
-- Server version	5.6.24-72.2-log

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
-- Table structure for table `common_key_value`
--

DROP TABLE IF EXISTS `common_key_value`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `common_key_value` (
  `identifier` varchar(255) NOT NULL,
  `content` mediumblob NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`identifier`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `const_values`
--

DROP TABLE IF EXISTS `const_values`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `const_values` (
  `name` varchar(50) NOT NULL,
  `val` int(8) unsigned NOT NULL,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `discussion_reporting`
--

DROP TABLE IF EXISTS `discussion_reporting`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `discussion_reporting` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dr_query` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `dr_title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `discussion_dr_title_query_idx` (`dr_title`,`dr_query`)
) ENGINE=InnoDB AUTO_INCREMENT=109349 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `events_local_users`
--

DROP TABLE IF EXISTS `events_local_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `events_local_users` (
  `wiki_id` int(8) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `user_name` varchar(255) NOT NULL DEFAULT '',
  `last_ip` int(10) unsigned NOT NULL DEFAULT '0',
  `edits` int(11) unsigned NOT NULL DEFAULT '0',
  `editdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `last_revision` int(11) NOT NULL DEFAULT '0',
  `cnt_groups` smallint(4) NOT NULL DEFAULT '0',
  `single_group` char(25) NOT NULL DEFAULT '',
  `all_groups` mediumtext NOT NULL,
  `user_is_blocked` tinyint(1) DEFAULT '0',
  `user_is_closed` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`wiki_id`,`user_id`,`user_name`),
  KEY `user_edits` (`user_id`,`edits`,`wiki_id`),
  KEY `user_id` (`user_id`),
  KEY `edits` (`edits`),
  KEY `wiki_id` (`wiki_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

drop table if exists `groups`;

create table `groups` (
  `id` int(10) unsigned not null auto_increment,
  `name` varchar(255) not null,
  primary key (`id`),
  key (`name`)
) Engine=InnoDB default charset=latin1;

drop table if exists `user_groups`;

create table `user_groups` (
  `user_id` int(10) unsigned not null,
  `group_id` int(10) unsigned not null,
  `wiki_id` int(10) unsigned not null default '0',
  primary key (`user_id`, `group_id`, `wiki_id`),
  key (`user_id`),
  key (`group_id`),
  key (`wiki_id`),
  key `group_wikis` (`group_id`, `wiki_id`),
  foreign key(`group_id`) references `groups`(`id`) on delete cascade
) Engine=InnoDB default charset=latin1;

--
-- Table structure for table `jobs_dirty`
--

DROP TABLE IF EXISTS `jobs_dirty`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jobs_dirty` (
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `city_id` int(8) unsigned NOT NULL,
  `locked` timestamp NULL DEFAULT NULL,
  UNIQUE KEY `city_id_inx` (`city_id`),
  KEY `locked` (`locked`)
) ENGINE=MEMORY DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `jobs_summary`
--

DROP TABLE IF EXISTS `jobs_summary`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jobs_summary` (
  `city_id` int(8) unsigned NOT NULL,
  `total` int(8) unsigned DEFAULT '0',
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`city_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `multilookup`
--

DROP TABLE IF EXISTS `multilookup`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `multilookup` (
  `ml_city_id` int(9) unsigned NOT NULL,
  `ml_ip` int(10) unsigned NOT NULL,
  `ml_count` int(6) unsigned NOT NULL DEFAULT '0',
  `ml_ts` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ml_city_id`,`ml_ip`),
  KEY `multilookup_ts_inx` (`ml_ip`,`ml_ts`),
  KEY `multilookup_cnt_ts_inx` (`ml_ip`,`ml_count`,`ml_ts`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `phalanx_stats`
--

DROP TABLE IF EXISTS `phalanx_stats`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `phalanx_stats` (
  `ps_id` int(11) NOT NULL AUTO_INCREMENT,
  `ps_blocker_id` int(8) unsigned NOT NULL,
  `ps_blocker_type` smallint(1) unsigned NOT NULL,
  `ps_timestamp` binary(14) NOT NULL DEFAULT '\0\0\0\0\0\0\0\0\0\0\0\0\0\0',
  `ps_blocked_user` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '',
  `ps_wiki_id` int(9) NOT NULL,
  `ps_blocker_hit` smallint(1) unsigned NOT NULL,
  `ps_referrer` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`ps_id`),
  KEY `wiki_id` (`ps_wiki_id`,`ps_timestamp`),
  KEY `blocker_id` (`ps_blocker_id`,`ps_timestamp`),
  KEY `ps_timestamp` (`ps_timestamp`),
  KEY `ps_blocker_id` (`ps_blocker_id`)
) ENGINE=InnoDB AUTO_INCREMENT=95236281 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `searchdigest`
--

DROP TABLE IF EXISTS `searchdigest`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `searchdigest` (
  `sd_wiki` int(9) unsigned NOT NULL,
  `sd_query` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `sd_misses` int(9) unsigned NOT NULL,
  `sd_lastseen` date DEFAULT NULL,
  PRIMARY KEY (`sd_wiki`,`sd_query`),
  KEY `sd_wikimisses` (`sd_wiki`,`sd_misses`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `user_history`
--

DROP TABLE IF EXISTS `user_history`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_history` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(5) unsigned NOT NULL,
  `user_name` varchar(255) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL DEFAULT '',
  `user_real_name` varchar(255) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL DEFAULT '',
  `user_password` tinyblob NOT NULL,
  `user_newpassword` tinyblob NOT NULL,
  `user_email` tinytext NOT NULL,
  `user_options` blob NOT NULL,
  `user_touched` varchar(14) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL DEFAULT '',
  `user_token` varchar(32) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL DEFAULT '',
  `uh_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2823279 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `user_login_history`
--

DROP TABLE IF EXISTS `user_login_history`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_login_history` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(5) unsigned NOT NULL,
  `city_id` int(9) unsigned DEFAULT '0',
  `ulh_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ulh_from` tinyint(4) DEFAULT '0',
  `ulh_rememberme` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_user_login_history_wikia_timestamp` (`city_id`,`user_id`,`ulh_timestamp`)
) ENGINE=InnoDB AUTO_INCREMENT=512843396 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `user_login_history_summary`
--

DROP TABLE IF EXISTS `user_login_history_summary`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_login_history_summary` (
  `user_id` int(8) unsigned NOT NULL,
  `ulh_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `wikia_images`
--

DROP TABLE IF EXISTS `wikia_images`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wikia_images` (
  `wiki_id` int(11) unsigned NOT NULL,
  `images` int(6) unsigned NOT NULL DEFAULT '0',
  `oldimage` int(6) unsigned NOT NULL DEFAULT '0',
  `filearchive` int(6) unsigned NOT NULL DEFAULT '0',
  `allimages` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`wiki_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `wikia_page_backlinks`
--

DROP TABLE IF EXISTS `wikia_page_backlinks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wikia_page_backlinks` (
  `source_page_id` int(11) NOT NULL,
  `target_page_id` int(11) NOT NULL,
  `backlink_text` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `count` int(11) DEFAULT NULL,
  PRIMARY KEY (`source_page_id`,`target_page_id`,`backlink_text`),
  KEY `wikia_page_backlinks_source_page_id` (`source_page_id`),
  KEY `wikia_page_backlinks_target_page_id` (`target_page_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-04-18 11:01:02