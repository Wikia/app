-- MySQL dump 10.13  Distrib 5.1.32, for unknown-linux-gnu (x86_64)
--
-- Host: 10.8.32.21    Database: stats
-- ------------------------------------------------------
-- Server version	5.1.37-1ubuntu5-log

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
-- Table structure for table `city_ip_activity`
--

SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `city_ip_activity` (
  `ca_id` int(8) NOT NULL AUTO_INCREMENT,
  `ca_ip_text` varchar(255) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL DEFAULT '',
  `ca_wikis_activity` text,
  `ca_latest_activity` text,
  PRIMARY KEY (`ca_id`),
  KEY `ca_ip_text` (`ca_ip_text`)
) ENGINE=InnoDB AUTO_INCREMENT=529443 DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `city_page_views`
--

SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `city_page_views` (
  `pv_city_id` int(8) unsigned NOT NULL,
  `pv_use_date` varchar(14) NOT NULL DEFAULT '',
  `pv_namespace` int(8) unsigned NOT NULL,
  `pv_views` int(10) unsigned NOT NULL,
  `pv_timestamp` datetime NOT NULL,
  `pv_city_lang` varchar(10) NOT NULL DEFAULT '',
  PRIMARY KEY (`pv_city_id`,`pv_use_date`,`pv_namespace`),
  KEY `pv_use_date` (`pv_use_date`),
  KEY `pv_namespace` (`pv_namespace`),
  KEY `pv_views_timestamp` (`pv_views`,`pv_timestamp`),
  KEY `pv_wiki_views_timestamp` (`pv_city_id`,`pv_views`,`pv_timestamp`),
  KEY `pv_city` (`pv_city_id`,`pv_namespace`,`pv_use_date`,`pv_views`),
  KEY `pv_city_lang` (`pv_city_lang`,`pv_city_id`,`pv_use_date`,`pv_views`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `city_page_vote`
--

SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `city_page_vote` (
  `city_id` int(8) unsigned NOT NULL,
  `page_id` int(8) unsigned NOT NULL,
  `page_title` varchar(255) DEFAULT NULL,
  `page_namespace` int(5) NOT NULL,
  `user_id` int(5) unsigned NOT NULL,
  `user_name` varchar(255) DEFAULT NULL,
  `vote` int(2) NOT NULL,
  `ip` varchar(32) NOT NULL,
  `time` datetime NOT NULL,
  `unique_id` varchar(32) NOT NULL DEFAULT '',
  PRIMARY KEY (`city_id`,`page_id`,`user_id`,`unique_id`,`ip`),
  KEY `user_id` (`user_id`),
  KEY `user_name` (`user_name`),
  KEY `page` (`page_id`,`page_namespace`),
  KEY `page_title` (`page_title`),
  KEY `time` (`time`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `city_used_tags`
--

SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
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
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `city_user_activity`
--

SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `city_user_activity` (
  `ca_id` int(8) NOT NULL AUTO_INCREMENT,
  `ca_user_text` varchar(255) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL DEFAULT '',
  `ca_wikis_activity` text,
  `ca_latest_activity` text,
  PRIMARY KEY (`ca_id`),
  KEY `ca_user_text` (`ca_user_text`)
) ENGINE=InnoDB AUTO_INCREMENT=413123 DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `city_user_edits`
--

SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `city_user_edits` (
  `ue_user_id` int(10) NOT NULL,
  `ue_user_text` varchar(255) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL DEFAULT '',
  `ue_edit_namespace` int(11) NOT NULL,
  `ue_edit_count` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ue_user_id`,`ue_edit_namespace`),
  KEY `ue_user_text` (`ue_user_text`),
  KEY `ue_edit_namespace` (`ue_edit_namespace`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `city_wikireferer`
--

SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `city_wikireferer` (
  `ref_city_id` int(8) NOT NULL,
  `ref_domain` varchar(255) NOT NULL DEFAULT '',
  `ref_timestamp` varchar(14) NOT NULL DEFAULT '19700101000000',
  `ref_count` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`ref_city_id`,`ref_domain`,`ref_timestamp`),
  KEY `ref_domain_key` (`ref_domain`),
  KEY `times` (`ref_timestamp`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `city_wikireferer_domain_views`
--

SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `city_wikireferer_domain_views` (
  `ref_city_id` int(8) NOT NULL,
  `ref_domain` varchar(255) NOT NULL DEFAULT '',
  `ref_count` int(10) unsigned NOT NULL DEFAULT '0',
  `ref_type` int(2) NOT NULL,
  PRIMARY KEY (`ref_city_id`,`ref_domain`,`ref_type`),
  KEY `ref_domain_key` (`ref_domain`),
  KEY `ref_type` (`ref_type`,`ref_count`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `city_wikireferer_domains`
--

SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `city_wikireferer_domains` (
  `ref_city_id` int(8) NOT NULL,
  `ref_domain` varchar(255) NOT NULL DEFAULT '',
  `ref_timestamp` varchar(14) NOT NULL DEFAULT '19700101000000',
  `ref_count` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`ref_city_id`,`ref_domain`,`ref_timestamp`),
  KEY `ref_domain_key` (`ref_domain`),
  KEY `times` (`ref_timestamp`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `city_wikireferer_views`
--

SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `city_wikireferer_views` (
  `ref_city_id` int(8) NOT NULL,
  `ref_domain` varchar(255) NOT NULL DEFAULT '',
  `ref_count` int(10) unsigned NOT NULL DEFAULT '0',
  `ref_type` int(2) NOT NULL,
  PRIMARY KEY (`ref_city_id`,`ref_domain`,`ref_type`),
  KEY `ref_domain_key` (`ref_domain`),
  KEY `ref_type` (`ref_type`,`ref_count`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `stats_editors`
--

SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `stats_editors` (
  `wikia_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `page_ns` int(6) unsigned NOT NULL,
  `is_content` int(1) unsigned NOT NULL,
  `date` int(6) unsigned NOT NULL,
  `count` int(10) unsigned NOT NULL,
  `last_page` int(10) unsigned NOT NULL,
  `last_edited` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`wikia_id`,`user_id`,`date`,`page_ns`,`is_content`),
  KEY `users` (`is_content`,`wikia_id`,`user_id`),
  KEY `count_users` (`is_content`,`wikia_id`,`user_id`,`count`),
  KEY `wikia_date` (`wikia_id`,`date`,`count`),
  KEY `users_last` (`user_id`,`count`,`last_page`,`last_edited`),
  KEY `users_ns` (`page_ns`,`user_id`,`count`),
  KEY `users_content` (`is_content`,`user_id`,`count`),
  KEY `wikia_last` (`wikia_id`,`last_page`,`last_edited`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `stats_hub`
--

SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `stats_hub` (
  `wikia_cat` varchar(10) NOT NULL,
  `page_ns` int(6) unsigned NOT NULL,
  `page_is_content` int(6) unsigned NOT NULL,
  `date` int(6) NOT NULL,
  `redirects` int(1) unsigned NOT NULL,
  `pages` int(10) unsigned NOT NULL,
  `rev_reg_count` int(10) unsigned NOT NULL,
  `rev_anon_count` int(10) unsigned NOT NULL,
  `last_edited` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`wikia_cat`,`date`,`page_ns`),
  KEY `pages` (`wikia_cat`,`page_ns`,`page_is_content`),
  KEY `count_revisions` (`wikia_cat`,`page_ns`,`page_is_content`,`rev_reg_count`,`rev_anon_count`),
  KEY `count_pages` (`page_is_content`,`wikia_cat`,`pages`),
  KEY `stats_date` (`wikia_cat`,`date`,`rev_reg_count`,`rev_anon_count`),
  KEY `page_last` (`rev_reg_count`,`rev_anon_count`,`last_edited`),
  KEY `page_ns` (`page_ns`,`rev_reg_count`,`rev_anon_count`),
  KEY `page_content` (`page_is_content`,`rev_reg_count`,`rev_anon_count`),
  KEY `wikia_last` (`wikia_cat`,`last_edited`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `stats_hub_editors`
--

SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `stats_hub_editors` (
  `wikia_cat` varchar(10) NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `page_ns` int(6) unsigned NOT NULL,
  `page_is_content` int(1) unsigned NOT NULL,
  `date` int(6) unsigned NOT NULL,
  `count` int(10) unsigned NOT NULL,
  `last_edited` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`wikia_cat`,`user_id`,`date`,`page_ns`),
  KEY `users` (`page_is_content`,`wikia_cat`),
  KEY `count_users` (`page_is_content`,`wikia_cat`,`count`),
  KEY `wikia_date` (`wikia_cat`,`date`,`count`),
  KEY `wikia_last` (`wikia_cat`,`last_edited`),
  KEY `users_ns` (`page_ns`,`count`),
  KEY `user_date` (`user_id`,`date`),
  KEY `users_content` (`page_is_content`,`count`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `stats_lang`
--

SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `stats_lang` (
  `wikia_lang` varchar(10) NOT NULL,
  `page_ns` int(6) unsigned NOT NULL,
  `page_is_content` int(6) unsigned NOT NULL,
  `date` int(6) NOT NULL,
  `redirects` int(1) unsigned NOT NULL,
  `pages` int(10) unsigned NOT NULL,
  `rev_reg_count` int(10) unsigned NOT NULL,
  `rev_anon_count` int(10) unsigned NOT NULL,
  `last_edited` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`wikia_lang`,`date`,`page_ns`),
  KEY `pages` (`wikia_lang`,`page_ns`,`page_is_content`),
  KEY `count_revisions` (`wikia_lang`,`page_ns`,`page_is_content`,`rev_reg_count`,`rev_anon_count`),
  KEY `count_pages` (`page_is_content`,`wikia_lang`,`pages`),
  KEY `stats_date` (`wikia_lang`,`date`,`rev_reg_count`,`rev_anon_count`),
  KEY `page_last` (`rev_reg_count`,`rev_anon_count`,`last_edited`),
  KEY `page_ns` (`page_ns`,`rev_reg_count`,`rev_anon_count`),
  KEY `page_content` (`page_is_content`,`rev_reg_count`,`rev_anon_count`),
  KEY `wikia_last` (`wikia_lang`,`last_edited`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `stats_lang_editors`
--

SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `stats_lang_editors` (
  `wikia_lang` varchar(10) NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `page_ns` int(6) unsigned NOT NULL,
  `page_is_content` int(1) unsigned NOT NULL,
  `date` int(6) unsigned NOT NULL,
  `count` int(10) unsigned NOT NULL,
  `last_edited` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`wikia_lang`,`user_id`,`date`,`page_ns`),
  KEY `users` (`page_is_content`,`wikia_lang`),
  KEY `count_users` (`page_is_content`,`wikia_lang`,`count`),
  KEY `wikia_date` (`wikia_lang`,`date`,`count`),
  KEY `wikia_last` (`wikia_lang`,`last_edited`),
  KEY `users_ns` (`page_ns`,`count`),
  KEY `user_date` (`user_id`,`date`),
  KEY `users_content` (`page_is_content`,`count`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `stats_pages`
--

SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `stats_pages` (
  `wikia_id` int(10) unsigned NOT NULL,
  `page_id` int(10) unsigned NOT NULL,
  `page_ns` int(6) unsigned NOT NULL,
  `date` int(6) NOT NULL,
  `is_content` int(1) unsigned NOT NULL,
  `is_redirect` int(1) unsigned NOT NULL,
  `page_size` int(10) unsigned NOT NULL,
  `rev_reg_count` int(10) unsigned NOT NULL,
  `rev_anon_count` int(10) unsigned NOT NULL,
  `last_edited` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `image_links` int(10) NOT NULL,
  `video_links` int(10) NOT NULL,
  `total_words` int(10) NOT NULL,
  PRIMARY KEY (`wikia_id`,`page_id`,`date`,`page_ns`),
  KEY `pages` (`is_content`,`wikia_id`,`page_id`),
  KEY `count_pages` (`is_content`,`wikia_id`,`page_id`,`rev_reg_count`,`rev_anon_count`),
  KEY `stats_date` (`wikia_id`,`date`,`rev_reg_count`,`rev_anon_count`),
  KEY `page_last` (`page_id`,`rev_reg_count`,`rev_anon_count`,`last_edited`),
  KEY `page_ns` (`page_ns`,`page_id`,`rev_reg_count`,`rev_anon_count`),
  KEY `page_content` (`is_content`,`page_id`,`rev_reg_count`,`rev_anon_count`),
  KEY `wikia_last` (`wikia_id`,`page_id`,`last_edited`),
  KEY `page_size` (`is_content`,`wikia_id`,`page_size`),
  KEY `links` (`wikia_id`,`is_content`,`image_links`,`video_links`),
  KEY `words` (`wikia_id`,`is_content`,`total_words`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `stats_summary`
--

SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `stats_summary` (
  `wikia_id` int(8) NOT NULL,
  `stats_date` int(6) NOT NULL DEFAULT '0',
  `wikia_hub` int(10) unsigned NOT NULL DEFAULT '0',
  `wikia_lang` varchar(15) NOT NULL DEFAULT '',
  `editors_allns` int(10) unsigned NOT NULL DEFAULT '0',
  `editors_contentns` int(10) unsigned NOT NULL DEFAULT '0',
  `editors_userns` int(10) unsigned NOT NULL DEFAULT '0',
  `editors_5times` int(10) unsigned NOT NULL DEFAULT '0',
  `editors_100times` int(10) unsigned NOT NULL DEFAULT '0',
  `editors_month_allns` int(10) unsigned NOT NULL DEFAULT '0',
  `editors_month_contentns` int(10) unsigned NOT NULL DEFAULT '0',
  `editors_month_userns` int(10) unsigned NOT NULL DEFAULT '0',
  `articles` int(10) unsigned NOT NULL DEFAULT '0',
  `articles_day` int(10) unsigned NOT NULL DEFAULT '0',
  `articles_0_5_size` int(10) unsigned NOT NULL DEFAULT '0',
  `database_edits` int(10) unsigned NOT NULL DEFAULT '0',
  `database_words` int(10) unsigned NOT NULL DEFAULT '0',
  `images_links` int(10) unsigned NOT NULL DEFAULT '0',
  `images_uploaded` int(10) unsigned NOT NULL DEFAULT '0',
  `video_embeded` int(10) unsigned NOT NULL DEFAULT '0',
  `video_uploaded` int(10) unsigned NOT NULL DEFAULT '0',
  `ts` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`wikia_id`,`stats_date`),
  KEY `hub` (`wikia_hub`,`stats_date`),
  KEY `lang` (`wikia_lang`,`stats_date`),
  KEY `stats_date` (`stats_date`),
  KEY `wikia_id` (`wikia_id`),
  KEY `ts` (`wikia_id`,`ts`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `tags_pv`
--

SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `tags_pv` (
  `city_id` int(8) unsigned NOT NULL,
  `tag_id` int(8) unsigned NOT NULL,
  `use_date` varchar(14) NOT NULL DEFAULT '',
  `city_lang` varchar(10) NOT NULL DEFAULT '',
  `namespace` int(8) unsigned NOT NULL,
  `pviews` int(10) unsigned NOT NULL,
  `ts` datetime NOT NULL,
  PRIMARY KEY (`city_id`,`tag_id`,`use_date`,`namespace`),
  KEY `pv_use_date` (`tag_id`,`use_date`),
  KEY `pv_namespace` (`tag_id`,`namespace`),
  KEY `tag_city` (`tag_id`,`city_id`,`use_date`),
  KEY `tag_lang` (`tag_id`,`city_lang`,`use_date`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `tags_stats_filter`
--

SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `tags_stats_filter` (
  `sf_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `sf_city_id` int(10) unsigned DEFAULT NULL,
  `sf_page_id` int(10) unsigned DEFAULT NULL,
  `sf_user_id` int(10) unsigned DEFAULT NULL,
  `sf_tag_id` int(10) unsigned NOT NULL,
  `sf_type` enum('blog','user','article','city') DEFAULT NULL,
  PRIMARY KEY (`sf_id`),
  UNIQUE KEY `sf_city_id` (`sf_city_id`,`sf_page_id`,`sf_user_id`,`sf_tag_id`,`sf_type`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2010-02-23 15:55:11
