-- MySQL dump 10.13  Distrib 5.6.24-72.2, for debian-linux-gnu (x86_64)
--
-- Host: slave.db-statsdb.service.consul    Database: stats
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
-- Table structure for table `cat_lang_monthly_stats`
--

DROP TABLE IF EXISTS `cat_lang_monthly_stats`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cat_lang_monthly_stats` (
  `wiki_cat_id` int(8) unsigned NOT NULL,
  `wiki_lang_id` int(8) unsigned NOT NULL,
  `stats_date` mediumint(6) unsigned NOT NULL DEFAULT '0',
  `users_all` int(8) unsigned NOT NULL DEFAULT '0',
  `users_content_ns` int(8) unsigned NOT NULL DEFAULT '0',
  `users_user_ns` int(8) unsigned NOT NULL DEFAULT '0',
  `users_5times` int(8) unsigned NOT NULL DEFAULT '0',
  `users_100times` int(8) unsigned NOT NULL DEFAULT '0',
  `articles` int(8) unsigned NOT NULL DEFAULT '0',
  `articles_daily` int(8) unsigned NOT NULL DEFAULT '0',
  `articles_edits` int(8) unsigned NOT NULL DEFAULT '0',
  `images_links` int(8) unsigned NOT NULL DEFAULT '0',
  `images_uploaded` int(8) unsigned NOT NULL DEFAULT '0',
  `video_links` int(8) unsigned NOT NULL DEFAULT '0',
  `video_uploaded` int(8) unsigned NOT NULL DEFAULT '0',
  `ts` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`wiki_cat_id`,`wiki_lang_id`,`stats_date`),
  KEY `stats_date` (`stats_date`),
  KEY `ts` (`wiki_cat_id`,`wiki_lang_id`,`ts`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `cat_monthly_stats`
--

DROP TABLE IF EXISTS `cat_monthly_stats`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cat_monthly_stats` (
  `wiki_cat_id` int(8) unsigned NOT NULL,
  `stats_date` mediumint(6) unsigned NOT NULL DEFAULT '0',
  `users_all` int(8) unsigned NOT NULL DEFAULT '0',
  `users_content_ns` int(8) unsigned NOT NULL DEFAULT '0',
  `users_user_ns` int(8) unsigned NOT NULL DEFAULT '0',
  `users_5times` int(8) unsigned NOT NULL DEFAULT '0',
  `users_100times` int(8) unsigned NOT NULL DEFAULT '0',
  `articles` int(8) unsigned NOT NULL DEFAULT '0',
  `articles_daily` int(8) unsigned NOT NULL DEFAULT '0',
  `articles_edits` int(8) unsigned NOT NULL DEFAULT '0',
  `images_links` int(8) unsigned NOT NULL DEFAULT '0',
  `images_uploaded` int(8) unsigned NOT NULL DEFAULT '0',
  `video_links` int(8) unsigned NOT NULL DEFAULT '0',
  `video_uploaded` int(8) unsigned NOT NULL DEFAULT '0',
  `ts` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`wiki_cat_id`,`stats_date`),
  KEY `stats_date` (`stats_date`),
  KEY `ts` (`wiki_cat_id`,`ts`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `chatlog`
--

DROP TABLE IF EXISTS `chatlog`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `chatlog` (
  `wiki_id` int(8) unsigned NOT NULL,
  `user_id` int(8) unsigned NOT NULL,
  `log_id` int(8) unsigned NOT NULL AUTO_INCREMENT,
  `event_type` tinyint(2) unsigned NOT NULL DEFAULT '6',
  `event_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`log_id`),
  KEY `wikilog` (`wiki_id`,`log_id`),
  KEY `event_date` (`wiki_id`,`event_date`),
  KEY `users` (`user_id`,`wiki_id`,`event_type`),
  KEY `wiki_users` (`wiki_id`,`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=59123752 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `city_used_tags`
--

DROP TABLE IF EXISTS `city_used_tags`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `city_used_tags` (
  `ct_wikia_id` int(8) unsigned NOT NULL,
  `ct_page_id` int(8) unsigned NOT NULL,
  `ct_namespace` int(8) unsigned NOT NULL,
  `ct_kind` varchar(50) NOT NULL DEFAULT '',
  `ct_timestamp` varchar(14) NOT NULL DEFAULT '19700101000000',
  PRIMARY KEY (`ct_wikia_id`,`ct_page_id`,`ct_namespace`,`ct_kind`),
  KEY `ct_wikia_id` (`ct_wikia_id`),
  KEY `ct_page_id` (`ct_page_id`,`ct_namespace`),
  KEY `ct_timestamp` (`ct_timestamp`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `dead_wiki_stats`
--

DROP TABLE IF EXISTS `dead_wiki_stats`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dead_wiki_stats` (
  `id` int(11) NOT NULL DEFAULT '0',
  `name` varchar(255) DEFAULT NULL,
  `created` varchar(15) DEFAULT NULL,
  `last_edited` varchar(15) DEFAULT NULL,
  `edits` int(11) DEFAULT NULL,
  `content_pages` int(11) DEFAULT NULL,
  `pv_last_month` int(11) DEFAULT NULL,
  `status` varchar(32) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `events`
--

DROP TABLE IF EXISTS `events`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `events` (
  `wiki_id` int(8) unsigned NOT NULL,
  `page_id` int(8) unsigned NOT NULL,
  `rev_id` int(8) unsigned NOT NULL,
  `log_id` int(8) unsigned NOT NULL DEFAULT '0',
  `user_id` int(8) unsigned NOT NULL,
  `user_is_bot` enum('N','Y') DEFAULT 'N',
  `page_ns` smallint(5) unsigned NOT NULL,
  `is_content` enum('N','Y') DEFAULT 'N',
  `is_redirect` enum('N','Y') DEFAULT 'N',
  `ip` int(10) unsigned NOT NULL DEFAULT '0',
  `rev_timestamp` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `image_links` int(5) unsigned NOT NULL DEFAULT '0',
  `video_links` int(5) unsigned NOT NULL DEFAULT '0',
  `total_words` int(4) unsigned NOT NULL DEFAULT '0',
  `rev_size` mediumint(7) unsigned NOT NULL DEFAULT '0',
  `wiki_lang_id` smallint(5) unsigned NOT NULL DEFAULT '0',
  `wiki_cat_id` tinyint(2) unsigned NOT NULL DEFAULT '0',
  `event_type` tinyint(2) unsigned NOT NULL DEFAULT '1',
  `event_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `media_type` tinyint(2) unsigned NOT NULL DEFAULT '0',
  `rev_date` date NOT NULL DEFAULT '0000-00-00',
  `beacon_id` varchar(32) NOT NULL DEFAULT '',
  PRIMARY KEY (`wiki_id`,`page_id`,`rev_id`,`log_id`,`rev_timestamp`),
  KEY `event_date_idx` (`event_date`),
  KEY `page_ns_idx` (`page_ns`),
  KEY `rev_timestamp_idx` (`rev_timestamp`),
  KEY `user_id_idx` (`user_id`),
  KEY `wiki_cat_id_idx` (`wiki_cat_id`),
  KEY `wiki_id_idx` (`wiki_id`),
  KEY `wiki_lang_id_idx` (`wiki_lang_id`),
  KEY `for_editcount_idx` (`user_id`,`page_ns`,`event_type`),
  KEY `for_admin_dashboard_idx` (`wiki_id`,`event_date`),
  KEY `for_wikia_api_last_editors_idx` (`wiki_id`,`rev_timestamp`),
  KEY `for_lookup_contribs_idx` (`wiki_id`,`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1
/*!50100 PARTITION BY RANGE (YEAR(rev_timestamp))
(PARTITION ev2002 VALUES LESS THAN (2002) ENGINE = InnoDB,
PARTITION ev2003 VALUES LESS THAN (2003) ENGINE = InnoDB,
PARTITION ev2004 VALUES LESS THAN (2004) ENGINE = InnoDB,
PARTITION ev2005 VALUES LESS THAN (2005) ENGINE = InnoDB,
PARTITION ev2006 VALUES LESS THAN (2006) ENGINE = InnoDB,
PARTITION ev2007 VALUES LESS THAN (2007) ENGINE = InnoDB,
PARTITION ev2008 VALUES LESS THAN (2008) ENGINE = InnoDB,
PARTITION ev2009 VALUES LESS THAN (2009) ENGINE = InnoDB,
PARTITION ev2010 VALUES LESS THAN (2010) ENGINE = InnoDB,
PARTITION ev2011 VALUES LESS THAN (2011) ENGINE = InnoDB,
PARTITION ev2012 VALUES LESS THAN (2012) ENGINE = InnoDB,
PARTITION ev2013 VALUES LESS THAN (2013) ENGINE = InnoDB,
PARTITION ev2014 VALUES LESS THAN (2014) ENGINE = InnoDB,
PARTITION ev9999 VALUES LESS THAN MAXVALUE ENGINE = InnoDB) */;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `events_log`
--

DROP TABLE IF EXISTS `events_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `events_log` (
  `el_type` char(32) NOT NULL,
  `el_wiki` int(5) DEFAULT '0',
  `el_language` int(5) DEFAULT '0',
  `el_category` int(5) DEFAULT '0',
  `el_catlang` int(5) DEFAULT '0',
  `el_summary` int(5) DEFAULT '0',
  `el_start` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `el_end` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`el_type`),
  KEY `el_start_end` (`el_type`,`el_start`,`el_end`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ignored_users`
--

DROP TABLE IF EXISTS `ignored_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ignored_users` (
  `user_id` int(5) unsigned NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `lang_monthly_stats`
--

DROP TABLE IF EXISTS `lang_monthly_stats`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lang_monthly_stats` (
  `wiki_lang_id` int(8) unsigned NOT NULL,
  `stats_date` mediumint(6) unsigned NOT NULL DEFAULT '0',
  `users_all` int(8) unsigned NOT NULL DEFAULT '0',
  `users_content_ns` int(8) unsigned NOT NULL DEFAULT '0',
  `users_user_ns` int(8) unsigned NOT NULL DEFAULT '0',
  `users_5times` int(8) unsigned NOT NULL DEFAULT '0',
  `users_100times` int(8) unsigned NOT NULL DEFAULT '0',
  `articles` int(8) unsigned NOT NULL DEFAULT '0',
  `articles_daily` int(8) unsigned NOT NULL DEFAULT '0',
  `articles_edits` int(8) unsigned NOT NULL DEFAULT '0',
  `images_links` int(8) unsigned NOT NULL DEFAULT '0',
  `images_uploaded` int(8) unsigned NOT NULL DEFAULT '0',
  `video_links` int(8) unsigned NOT NULL DEFAULT '0',
  `video_uploaded` int(8) unsigned NOT NULL DEFAULT '0',
  `ts` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`wiki_lang_id`,`stats_date`),
  KEY `stats_date` (`stats_date`),
  KEY `ts` (`wiki_lang_id`,`ts`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `namespace_monthly_stats`
--

DROP TABLE IF EXISTS `namespace_monthly_stats`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `namespace_monthly_stats` (
  `wiki_id` int(8) unsigned NOT NULL,
  `page_ns` int(6) unsigned NOT NULL,
  `wiki_cat_id` int(8) unsigned NOT NULL,
  `wiki_lang_id` int(8) unsigned NOT NULL,
  `stats_date` mediumint(6) unsigned NOT NULL DEFAULT '0',
  `pages_all` int(8) unsigned NOT NULL DEFAULT '0',
  `pages_daily` int(8) unsigned NOT NULL DEFAULT '0',
  `pages_edits` int(8) unsigned NOT NULL DEFAULT '0',
  `ts` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`wiki_id`,`stats_date`,`page_ns`),
  KEY `stats_date` (`stats_date`,`page_ns`),
  KEY `lang_stats` (`stats_date`,`wiki_lang_id`,`page_ns`),
  KEY `cat_stats` (`stats_date`,`wiki_cat_id`,`page_ns`),
  KEY `lang_cat_stats` (`stats_date`,`wiki_lang_id`,`wiki_cat_id`,`page_ns`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1
/*!50100 PARTITION BY RANGE (YEAR(stats_date))
(PARTITION nms2002 VALUES LESS THAN (2002) ENGINE = InnoDB,
PARTITION nms2003 VALUES LESS THAN (2003) ENGINE = InnoDB,
PARTITION nms2004 VALUES LESS THAN (2004) ENGINE = InnoDB,
PARTITION nms2005 VALUES LESS THAN (2005) ENGINE = InnoDB,
PARTITION nms2006 VALUES LESS THAN (2006) ENGINE = InnoDB,
PARTITION nms2007 VALUES LESS THAN (2007) ENGINE = InnoDB,
PARTITION nms2008 VALUES LESS THAN (2008) ENGINE = InnoDB,
PARTITION nms2009 VALUES LESS THAN (2009) ENGINE = InnoDB,
PARTITION nms2010 VALUES LESS THAN (2010) ENGINE = InnoDB,
PARTITION nms2011 VALUES LESS THAN (2011) ENGINE = InnoDB,
PARTITION nms2012 VALUES LESS THAN (2012) ENGINE = InnoDB,
PARTITION nms2013 VALUES LESS THAN (2013) ENGINE = InnoDB,
PARTITION nms2014 VALUES LESS THAN (2014) ENGINE = InnoDB,
PARTITION nms2015 VALUES LESS THAN (2015) ENGINE = InnoDB,
PARTITION nms9999 VALUES LESS THAN MAXVALUE ENGINE = InnoDB) */;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `scribe_log`
--

DROP TABLE IF EXISTS `scribe_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `scribe_log` (
  `hostname` char(32) NOT NULL,
  `logdate` int(5) unsigned NOT NULL DEFAULT '0',
  `logcount` int(8) unsigned NOT NULL DEFAULT '0',
  `ts` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`hostname`,`logdate`),
  KEY `hostname_ts` (`hostname`,`ts`,`logdate`),
  KEY `logdate` (`logdate`,`logcount`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `summary_monthly_stats`
--

DROP TABLE IF EXISTS `summary_monthly_stats`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `summary_monthly_stats` (
  `stats_date` mediumint(6) unsigned NOT NULL DEFAULT '0',
  `users_all` int(8) unsigned NOT NULL DEFAULT '0',
  `users_content_ns` int(8) unsigned NOT NULL DEFAULT '0',
  `users_user_ns` int(8) unsigned NOT NULL DEFAULT '0',
  `users_5times` int(8) unsigned NOT NULL DEFAULT '0',
  `users_100times` int(8) unsigned NOT NULL DEFAULT '0',
  `articles` int(8) unsigned NOT NULL DEFAULT '0',
  `articles_daily` int(8) unsigned NOT NULL DEFAULT '0',
  `articles_edits` int(8) unsigned NOT NULL DEFAULT '0',
  `images_links` int(8) unsigned NOT NULL DEFAULT '0',
  `images_uploaded` int(8) unsigned NOT NULL DEFAULT '0',
  `video_links` int(8) unsigned NOT NULL DEFAULT '0',
  `video_uploaded` int(8) unsigned NOT NULL DEFAULT '0',
  `ts` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`stats_date`),
  KEY `ts` (`stats_date`,`ts`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `wikia_monthly_stats`
--

DROP TABLE IF EXISTS `wikia_monthly_stats`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wikia_monthly_stats` (
  `wiki_id` int(8) unsigned NOT NULL,
  `stats_date` mediumint(6) unsigned NOT NULL DEFAULT '0',
  `users_all` int(8) unsigned NOT NULL DEFAULT '0',
  `users_content_ns` int(8) unsigned NOT NULL DEFAULT '0',
  `users_user_ns` int(8) unsigned NOT NULL DEFAULT '0',
  `users_5times` int(8) unsigned NOT NULL DEFAULT '0',
  `users_100times` int(8) unsigned NOT NULL DEFAULT '0',
  `articles` int(8) unsigned NOT NULL DEFAULT '0',
  `articles_daily` int(8) unsigned NOT NULL DEFAULT '0',
  `articles_edits` int(8) unsigned NOT NULL DEFAULT '0',
  `images_links` int(8) unsigned NOT NULL DEFAULT '0',
  `images_uploaded` int(8) unsigned NOT NULL DEFAULT '0',
  `video_links` int(8) unsigned NOT NULL DEFAULT '0',
  `video_uploaded` int(8) unsigned NOT NULL DEFAULT '0',
  `ts` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`wiki_id`,`stats_date`),
  KEY `stats_date` (`stats_date`),
  KEY `ts` (`wiki_id`,`ts`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-04-18 11:01:15