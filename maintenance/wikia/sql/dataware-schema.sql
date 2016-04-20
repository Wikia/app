-- MySQL dump 10.13  Distrib 5.6.24-72.2, for debian-linux-gnu (x86_64)
--
-- Host: slave.db-archive.service.consul    Database: dataware
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
SET @MYSQLDUMP_TEMP_LOG_BIN = @@SESSION.SQL_LOG_BIN;
SET @@SESSION.SQL_LOG_BIN= 0;

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
  KEY `version_id` (`version_id`),
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
) ENGINE=InnoDB AUTO_INCREMENT=224 DEFAULT CHARSET=latin1;
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
) ENGINE=InnoDB AUTO_INCREMENT=321 DEFAULT CHARSET=latin1;
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
) ENGINE=InnoDB AUTO_INCREMENT=61 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `blobs`
--

DROP TABLE IF EXISTS `blobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `blobs` (
  `blob_id` int(10) NOT NULL AUTO_INCREMENT,
  `rev_wikia_id` int(8) unsigned NOT NULL,
  `rev_id` int(10) unsigned DEFAULT NULL,
  `rev_page_id` int(10) unsigned NOT NULL,
  `rev_namespace` int(10) unsigned NOT NULL DEFAULT '0',
  `rev_user` int(10) unsigned NOT NULL DEFAULT '0',
  `rev_user_text` varchar(255) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL DEFAULT '',
  `rev_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `blob_text` mediumtext NOT NULL,
  `rev_flags` tinyblob,
  `rev_ip` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`blob_id`),
  KEY `rev_page_id` (`rev_wikia_id`,`rev_page_id`,`rev_id`),
  KEY `rev_namespace` (`rev_wikia_id`,`rev_page_id`,`rev_namespace`),
  KEY `rev_user` (`rev_wikia_id`,`rev_user`,`rev_timestamp`),
  KEY `rev_user_text` (`rev_wikia_id`,`rev_user_text`,`rev_timestamp`),
  KEY `blobs_rev_timestamp` (`rev_timestamp`),
  KEY `rev_ip` (`rev_ip`)
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
) ENGINE=InnoDB AUTO_INCREMENT=97672 DEFAULT CHARSET=binary;
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
-- Table structure for table `emails_storage`
--

DROP TABLE IF EXISTS `emails_storage`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `emails_storage` (
  `entry_id` int(10) NOT NULL AUTO_INCREMENT,
  `source_id` int(10) NOT NULL,
  `page_id` int(10) NOT NULL,
  `city_id` int(9) NOT NULL,
  `email` tinytext,
  `user_id` int(10) unsigned DEFAULT NULL,
  `beacon_id` char(10) DEFAULT NULL,
  `feedback` varchar(255) DEFAULT NULL,
  `timestamp` char(14) DEFAULT NULL,
  PRIMARY KEY (`entry_id`),
  KEY `emails_storage_entry_source` (`source_id`),
  KEY `emails_storage_entry_timestamp` (`city_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8604 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `global_registry`
--

DROP TABLE IF EXISTS `global_registry`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `global_registry` (
  `item_id` int(10) NOT NULL,
  `item_type` int(10) NOT NULL,
  `item_value` blob NOT NULL,
  `item_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`item_id`,`item_type`)
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
  KEY `user_id` (`gwa_user_id`),
  KEY `user_city_id` (`gwa_user_id`,`gwa_city_id`)
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
-- Table structure for table `image_review`
--

DROP TABLE IF EXISTS `image_review`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `image_review` (
  `wiki_id` int(11) NOT NULL,
  `page_id` int(11) NOT NULL,
  `revision_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `reviewer_id` int(11) DEFAULT NULL,
  `state` int(11) NOT NULL DEFAULT '0',
  `priority` int(11) NOT NULL DEFAULT '0',
  `flags` int(11) NOT NULL DEFAULT '0',
  `last_edited` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `review_start` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `review_end` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `top_200` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`wiki_id`,`page_id`),
  KEY `query_idx1` (`wiki_id`,`state`,`priority`,`last_edited`),
  KEY `query_idx2` (`state`,`review_end`,`review_start`),
  KEY `user_id` (`user_id`),
  KEY `stats_idx` (`reviewer_id`,`state`),
  KEY `priority_index` (`priority`),
  KEY `last_edited_priority` (`last_edited`,`priority`),
  KEY `priority_last_edited` (`priority`,`last_edited`),
  KEY `page_id_idx` (`page_id`),
  KEY `review_by_edit_prio` (`reviewer_id`,`review_start`,`priority`,`last_edited`),
  KEY `image_list` (`wiki_id`,`top_200`),
  KEY `image_list2` (`state`,`top_200`,`last_edited`,`priority`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `image_review_stats`
--

DROP TABLE IF EXISTS `image_review_stats`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `image_review_stats` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `reviewer_id` int(11) NOT NULL,
  `wiki_id` int(11) NOT NULL,
  `page_id` int(11) NOT NULL,
  `review_state` int(11) NOT NULL DEFAULT '0',
  `review_end` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `image_idx` (`wiki_id`,`page_id`),
  KEY `state_date_idx` (`reviewer_id`,`review_state`,`review_end`)
) ENGINE=InnoDB AUTO_INCREMENT=47723529 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `image_review_wikis`
--

DROP TABLE IF EXISTS `image_review_wikis`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `image_review_wikis` (
  `wiki_id` int(11) NOT NULL,
  `top200` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`wiki_id`),
  KEY `top200` (`top200`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `info_data`
--

DROP TABLE IF EXISTS `info_data`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `info_data` (
  `wid` int(11) DEFAULT NULL,
  `id` int(11) DEFAULT NULL,
  `title` tinytext,
  `info_key` tinytext,
  `value` text,
  `template` tinytext,
  `additional` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `info_schema_map`
--

DROP TABLE IF EXISTS `info_schema_map`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `info_schema_map` (
  `info_key` tinytext,
  `template` tinytext,
  `type` tinytext
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `info_templates`
--

DROP TABLE IF EXISTS `info_templates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `info_templates` (
  `wid` int(11) DEFAULT NULL,
  `template` tinytext
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `notify_log`
--

DROP TABLE IF EXISTS `notify_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `notify_log` (
  `nl_id` int(11) NOT NULL AUTO_INCREMENT,
  `nl_city` int(11) NOT NULL,
  `nl_type` char(32) NOT NULL,
  `nl_editor` int(6) NOT NULL,
  `nl_watcher` int(6) NOT NULL,
  `nl_title` varchar(255) NOT NULL,
  `nl_namespace` int(11) NOT NULL,
  `nl_timestamp` char(14) DEFAULT NULL,
  PRIMARY KEY (`nl_id`),
  KEY `nl_watcher` (`nl_watcher`),
  KEY `nl_editor` (`nl_editor`),
  KEY `nl_title` (`nl_title`,`nl_namespace`),
  KEY `nl_type` (`nl_type`,`nl_timestamp`),
  KEY `nl_city` (`nl_city`)
) ENGINE=InnoDB AUTO_INCREMENT=207266637 DEFAULT CHARSET=latin1;
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
  `page_title_lower` varchar(255) DEFAULT NULL,
  `page_title` varchar(255) NOT NULL,
  `page_status` smallint(4) unsigned DEFAULT '0',
  `page_is_content` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `page_is_redirect` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `page_edits` int(8) unsigned NOT NULL DEFAULT '0',
  `page_latest` int(8) unsigned NOT NULL DEFAULT '0',
  `page_last_edited` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `page_last_indexed` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`page_wikia_id`,`page_id`),
  KEY `page_namespace` (`page_wikia_id`,`page_namespace`,`page_title`),
  KEY `page_title_lower_wikia` (`page_title_lower`,`page_wikia_id`,`page_namespace`),
  KEY `page_wikia_title_lower` (`page_wikia_id`,`page_title_lower`,`page_namespace`),
  KEY `page_latest` (`page_wikia_id`,`page_namespace`,`page_latest`),
  KEY `page_last_indexed` (`page_wikia_id`,`page_last_indexed`,`page_id`),
  KEY `page_title_lower_edits` (`page_title_lower`,`page_wikia_id`,`page_edits`),
  KEY `page_wikia_edited` (`page_wikia_id`,`page_last_edited`,`page_title_lower`),
  KEY `page_namespace_lower` (`page_wikia_id`,`page_namespace`,`page_title_lower`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `parser_speed_article`
--

DROP TABLE IF EXISTS `parser_speed_article`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `parser_speed_article` (
  `wiki_id` int(11) NOT NULL,
  `article_id` int(11) NOT NULL,
  `page_ns` int(11) DEFAULT NULL,
  `average_time` decimal(10,3) DEFAULT NULL,
  `minimum_time` decimal(10,3) DEFAULT NULL,
  `maximum_time` decimal(10,3) DEFAULT NULL,
  `wikitext_size` int(11) DEFAULT NULL,
  `html_size` int(11) DEFAULT NULL,
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `exp_func_count` int(11) DEFAULT NULL,
  `node_count` int(11) DEFAULT NULL,
  `post_expand_size` int(11) DEFAULT NULL,
  `temp_arg_size` int(11) DEFAULT NULL,
  PRIMARY KEY (`wiki_id`,`article_id`),
  KEY `namespace` (`wiki_id`,`page_ns`),
  KEY `avg_time` (`wiki_id`,`average_time`),
  KEY `min_time` (`wiki_id`,`minimum_time`),
  KEY `max_time` (`wiki_id`,`maximum_time`),
  KEY `wikitext_size` (`wiki_id`,`wikitext_size`),
  KEY `html_size` (`wiki_id`,`html_size`),
  KEY `exp_func_count` (`wiki_id`,`exp_func_count`),
  KEY `node_count` (`wiki_id`,`node_count`),
  KEY `post_expand_size` (`wiki_id`,`post_expand_size`),
  KEY `temp_arg_size` (`wiki_id`,`temp_arg_size`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `photo_gallery_feeds`
--

DROP TABLE IF EXISTS `photo_gallery_feeds`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `photo_gallery_feeds` (
  `url` varchar(255) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `data` blob NOT NULL,
  PRIMARY KEY (`url`),
  KEY `timestamp` (`timestamp`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `rovi_episode_series`
--

DROP TABLE IF EXISTS `rovi_episode_series`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rovi_episode_series` (
  `series_id` int(10) unsigned NOT NULL,
  `program_id` int(10) unsigned NOT NULL DEFAULT '0',
  `season_program_id` int(10) unsigned DEFAULT NULL,
  `episode_title` varbinary(255) DEFAULT NULL,
  `episode_season_number` int(5) unsigned NOT NULL,
  `episode_season_sequence` int(5) unsigned NOT NULL,
  `episode_series_sequence` int(5) unsigned DEFAULT NULL,
  PRIMARY KEY (`series_id`,`program_id`),
  CONSTRAINT `rovi_episode_series_ibfk_1` FOREIGN KEY (`series_id`) REFERENCES `rovi_series` (`series_id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `rovi_programs`
--

DROP TABLE IF EXISTS `rovi_programs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rovi_programs` (
  `show_type` char(2) DEFAULT NULL,
  `program_id` bigint(20) NOT NULL,
  `series_id` bigint(20) DEFAULT NULL,
  `season_program_id` bigint(20) DEFAULT NULL,
  `variant_parent_id` bigint(20) DEFAULT NULL,
  `title_parent_id` bigint(20) DEFAULT NULL,
  `group_id` bigint(20) DEFAULT NULL,
  `is_group_language_primary` char(1) DEFAULT NULL,
  `group_size` int(11) DEFAULT NULL,
  `long_title` varchar(128) DEFAULT NULL,
  `medium_title` varchar(50) DEFAULT NULL,
  `short_title` varchar(30) DEFAULT NULL,
  `grid_title` varchar(15) DEFAULT NULL,
  `grid2_title` varchar(8) DEFAULT NULL,
  `alias_title` varchar(128) DEFAULT NULL,
  `alias_title_2` varchar(128) DEFAULT NULL,
  `alias_title_3` varchar(128) DEFAULT NULL,
  `alias_title_4` varchar(128) DEFAULT NULL,
  `original_title` varchar(128) DEFAULT NULL,
  `original_episode_title` varchar(128) DEFAULT NULL,
  `category` varchar(15) DEFAULT NULL,
  `sports_subtitle` varchar(128) DEFAULT NULL,
  `episode_title` varchar(128) DEFAULT NULL,
  `episode_number` varchar(20) DEFAULT NULL,
  `run_time` int(11) DEFAULT NULL,
  `release_year` int(11) DEFAULT NULL,
  `record_language` char(2) DEFAULT NULL,
  `syndicated` char(1) DEFAULT NULL,
  `event_date` char(8) DEFAULT NULL,
  `hdtv_level` varchar(30) DEFAULT NULL,
  `audio_level` varchar(30) DEFAULT NULL,
  `3D_level` varchar(30) DEFAULT NULL,
  `movie_type` varchar(30) DEFAULT NULL,
  `color_type` varchar(30) DEFAULT NULL,
  `official_program_url` varchar(2000) DEFAULT NULL,
  `additional_program_url` varchar(2000) DEFAULT NULL,
  `delta` char(3) DEFAULT NULL,
  `part_number` int(11) DEFAULT NULL,
  `total_number_of_parts` int(11) DEFAULT NULL,
  `category_id` bigint(20) DEFAULT NULL,
  `iso_3_character_language` char(3) DEFAULT NULL,
  PRIMARY KEY (`program_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `rovi_programs_credits`
--

DROP TABLE IF EXISTS `rovi_programs_credits`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rovi_programs_credits` (
  `program_id` bigint(20) NOT NULL,
  `credit_id` bigint(20) DEFAULT NULL,
  `org_id` bigint(20) DEFAULT NULL,
  `credit_type` varchar(30) DEFAULT NULL,
  `first_name` varchar(120) DEFAULT NULL,
  `last_name_single_name_org_name` varchar(256) DEFAULT NULL,
  `full_credit_name` varchar(256) DEFAULT NULL,
  `part_name` varchar(60) DEFAULT NULL,
  `sequence_number` int(11) DEFAULT NULL,
  `delta` char(3) NOT NULL,
  `program_credit_id` bigint(20) NOT NULL,
  `credit_type_id` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`program_credit_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `rovi_programs_genres`
--

DROP TABLE IF EXISTS `rovi_programs_genres`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rovi_programs_genres` (
  `program_id` bigint(20) NOT NULL,
  `genre` varchar(60) DEFAULT NULL,
  `genre_sequence` bigint(20) NOT NULL,
  `delta` char(3) NOT NULL,
  `genre_id` bigint(20) NOT NULL,
  PRIMARY KEY (`program_id`,`genre_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `rovi_series`
--

DROP TABLE IF EXISTS `rovi_series`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rovi_series` (
  `series_id` int(10) unsigned NOT NULL,
  `full_title` varbinary(512) NOT NULL,
  `synopsis` varbinary(2048) DEFAULT NULL,
  PRIMARY KEY (`series_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `scavenger_hunt_entries`
--

DROP TABLE IF EXISTS `scavenger_hunt_entries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `scavenger_hunt_entries` (
  `entry_id` int(10) NOT NULL AUTO_INCREMENT,
  `game_id` int(10) NOT NULL,
  `user_id` int(10) DEFAULT NULL,
  `entry_name` varchar(255) DEFAULT NULL,
  `entry_email` varchar(255) DEFAULT NULL,
  `entry_answer` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`entry_id`),
  KEY `scavenger_hunt_entries_by_game` (`game_id`,`entry_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2350 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `scavenger_hunt_games`
--

DROP TABLE IF EXISTS `scavenger_hunt_games`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `scavenger_hunt_games` (
  `game_id` int(10) NOT NULL AUTO_INCREMENT,
  `wiki_id` int(10) NOT NULL,
  `game_name` varchar(255) NOT NULL,
  `game_is_enabled` tinyint(1) DEFAULT '0',
  `game_data` blob,
  PRIMARY KEY (`game_id`),
  KEY `scavenger_hunt_games_for_list` (`wiki_id`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tv_series`
--

DROP TABLE IF EXISTS `tv_series`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tv_series` (
  `series_name` varchar(255) NOT NULL,
  `series_lang` varchar(5) NOT NULL,
  `series_lookup` varchar(255) NOT NULL,
  PRIMARY KEY (`series_name`,`series_lang`,`series_lookup`),
  KEY `series_lookup` (`series_lookup`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tv_series_wikis`
--

DROP TABLE IF EXISTS `tv_series_wikis`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tv_series_wikis` (
  `wiki_id` int(11) NOT NULL,
  `series_lookup` varchar(255) NOT NULL,
  `wiki_name` varchar(255) NOT NULL,
  `wiki_lang` varchar(5) NOT NULL,
  PRIMARY KEY (`wiki_id`,`series_lookup`),
  KEY `series_lookup` (`series_lookup`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `upload_log`
--

DROP TABLE IF EXISTS `upload_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `upload_log` (
  `up_page_id` int(8) unsigned NOT NULL DEFAULT '0',
  `up_title` varchar(255) NOT NULL,
  `up_path` varchar(255) NOT NULL,
  `up_created` char(14) DEFAULT '',
  `up_sent` char(14) DEFAULT '',
  `up_flags` int(8) DEFAULT '0',
  `up_city_id` int(10) NOT NULL DEFAULT '0',
  `up_imgpath` varchar(255) NOT NULL DEFAULT '',
  `up_old_path` mediumblob,
  `up_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `up_action` char(1) DEFAULT 'u',
  `up_datacenter` char(1) DEFAULT 's',
  `up_repl_lock` datetime DEFAULT NULL,
  `up_repl_pid` int(11) DEFAULT NULL,
  PRIMARY KEY (`up_id`),
  KEY `up_id` (`up_page_id`),
  KEY `up_title` (`up_title`),
  KEY `up_city_id` (`up_city_id`),
  KEY `up_flags_idx` (`up_flags`),
  KEY `up_datacenter_idx` (`up_datacenter`),
  KEY `up_repl_lock_idx` (`up_repl_lock`),
  KEY `up_repl_pid_idx` (`up_repl_pid`),
  KEY `up_created` (`up_created`)
) ENGINE=InnoDB AUTO_INCREMENT=32175779 DEFAULT CHARSET=latin1;
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
-- Table structure for table `video_imagetable_backup`
--

DROP TABLE IF EXISTS `video_imagetable_backup`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `video_imagetable_backup` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `wiki_id` int(11) NOT NULL,
  `img_name` varchar(255) DEFAULT NULL,
  `img_metadata` mediumblob,
  `img_user` int(5) unsigned DEFAULT NULL,
  `img_user_text` varchar(255) DEFAULT NULL,
  `img_timestamp` char(14) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `vitb_wiki` (`wiki_id`)
) ENGINE=InnoDB AUTO_INCREMENT=322100 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `video_interwiki`
--

DROP TABLE IF EXISTS `video_interwiki`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `video_interwiki` (
  `city_id` int(11) NOT NULL,
  `article_id` int(8) unsigned NOT NULL,
  `video_title` varchar(255) NOT NULL,
  `last_accessed` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  UNIQUE KEY `viw_idx` (`city_id`,`article_id`,`video_title`,`last_accessed`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `video_migration_log`
--

DROP TABLE IF EXISTS `video_migration_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `video_migration_log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `action_time` char(14) NOT NULL,
  `wiki_id` int(11) NOT NULL,
  `action_name` varchar(255) NOT NULL,
  `action_status` varchar(255) NOT NULL,
  `action_desc` varchar(255) NOT NULL,
  `wiki_dbname` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `city_id` (`wiki_id`,`action_time`)
) ENGINE=InnoDB AUTO_INCREMENT=989939 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `video_migration_sanitization`
--

DROP TABLE IF EXISTS `video_migration_sanitization`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `video_migration_sanitization` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `city_id` int(11) NOT NULL,
  `old_title` varchar(255) NOT NULL,
  `sanitized_title` varchar(255) NOT NULL,
  `operation_status` char(14) NOT NULL DEFAULT 'UNKNOWN',
  `operation_time` char(14) NOT NULL,
  `article_title` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `city_id` (`city_id`,`old_title`),
  KEY `sanitized_title` (`sanitized_title`)
) ENGINE=InnoDB AUTO_INCREMENT=28091 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `video_notmigrated`
--

DROP TABLE IF EXISTS `video_notmigrated`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `video_notmigrated` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `wiki_id` int(11) NOT NULL,
  `wiki_name` varchar(255) NOT NULL,
  `video_count` int(11) NOT NULL,
  `wiki_dbname` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `vnm_wikiid` (`wiki_id`),
  KEY `vnm_wikiname` (`wiki_name`)
) ENGINE=InnoDB AUTO_INCREMENT=16437 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `video_notmigrated2`
--

DROP TABLE IF EXISTS `video_notmigrated2`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `video_notmigrated2` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `wiki_id` int(11) NOT NULL,
  `wiki_name` varchar(255) NOT NULL,
  `wiki_dbname` varchar(255) DEFAULT NULL,
  `video_count` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `vnm_wikiid` (`wiki_id`),
  KEY `vnm_wikiname` (`wiki_name`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `video_postmigrate_undo`
--

DROP TABLE IF EXISTS `video_postmigrate_undo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `video_postmigrate_undo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `wiki_id` int(11) NOT NULL,
  `entry_table` varchar(255) NOT NULL,
  `entry_id` varchar(255) NOT NULL,
  `entry_id_field` varchar(255) NOT NULL,
  `entry_ns_field` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `vpu_wiki_id` (`wiki_id`)
) ENGINE=InnoDB AUTO_INCREMENT=798955 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `video_premigrate`
--

DROP TABLE IF EXISTS `video_premigrate`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `video_premigrate` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `img_name` varchar(255) NOT NULL,
  `wiki_id` int(11) NOT NULL,
  `provider` varchar(255) NOT NULL,
  `new_metadata` blob,
  `is_name_taken` int(11) NOT NULL,
  `api_url` blob,
  `video_id` tinyblob,
  `status` int(11) NOT NULL,
  `status_msg` blob,
  `full_response` blob,
  `thumbnail_url` varchar(255) DEFAULT NULL,
  `backlinks` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `vp_wiki_img` (`wiki_id`,`img_name`),
  KEY `vp_prov` (`provider`),
  KEY `vp_nametaken` (`is_name_taken`)
) ENGINE=InnoDB AUTO_INCREMENT=606896 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `video_sanitization_failededit`
--

DROP TABLE IF EXISTS `video_sanitization_failededit`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `video_sanitization_failededit` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `city_id` int(11) NOT NULL,
  `city_name` varchar(255) NOT NULL,
  `article_id` int(11) NOT NULL,
  `article_title` varchar(255) NOT NULL,
  `article_namespace` int(11) NOT NULL,
  `rename_from` varchar(255) NOT NULL,
  `rename_to` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `city_id` (`city_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1039 DEFAULT CHARSET=latin1;
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
  `is_read` int(11) NOT NULL,
  `is_reply` int(11) NOT NULL,
  `author_id` int(11) NOT NULL,
  `unique_id` int(11) NOT NULL,
  `entity_key` char(30) NOT NULL,
  `is_hidden` int(11) NOT NULL DEFAULT '0',
  `notifyeveryone` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `unique_id` (`unique_id`),
  KEY `user` (`user_id`,`wiki_id`),
  KEY `user_wiki_unique` (`user_id`,`wiki_id`,`unique_id`)
) ENGINE=InnoDB AUTO_INCREMENT=188869644 DEFAULT CHARSET=latin1;
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
) ENGINE=InnoDB AUTO_INCREMENT=357998 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `wikia_rss_feeds`
--

DROP TABLE IF EXISTS `wikia_rss_feeds`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wikia_rss_feeds` (
  `wrf_wikia_id` int(10) unsigned NOT NULL,
  `wrf_page_id` int(10) unsigned NOT NULL,
  `wrf_url` varchar(255) DEFAULT NULL,
  `wrf_feed` char(20) NOT NULL DEFAULT '',
  `wrf_pub_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `wrf_title` varchar(255) DEFAULT NULL,
  `wrf_description` varchar(1024) DEFAULT NULL,
  `wrf_img_url` varchar(500) DEFAULT NULL,
  `wrf_img_width` int(5) DEFAULT NULL,
  `wrf_img_height` int(5) DEFAULT NULL,
  `wrf_ins_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `wrf_source` char(10) NOT NULL,
  PRIMARY KEY (`wrf_wikia_id`,`wrf_page_id`,`wrf_feed`,`wrf_pub_date`),
  KEY `fresh_content` (`wrf_feed`,`wrf_pub_date`),
  KEY `last_inserted` (`wrf_feed`,`wrf_source`,`wrf_ins_date`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
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
) ENGINE=InnoDB AUTO_INCREMENT=1286040 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `withcity_log`
--

DROP TABLE IF EXISTS `withcity_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `withcity_log` (
  `name` varbinary(30) NOT NULL,
  `city_id` int(10) unsigned NOT NULL,
  `records` int(6) unsigned NOT NULL,
  `pos` int(6) unsigned NOT NULL,
  `start` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `end` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`name`,`city_id`),
  KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
SET @@SESSION.SQL_LOG_BIN = @MYSQLDUMP_TEMP_LOG_BIN;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-04-18 10:57:33
