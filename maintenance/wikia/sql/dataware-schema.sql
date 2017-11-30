-- MySQL dump 10.13  Distrib 5.6.24-72.2, for debian-linux-gnu (x86_64)
--
-- Host: geo-db-archive-slave.query.consul    Database: dataware
-- ------------------------------------------------------
-- Server version	5.7.18-15-log


--
-- Table structure for table `ab_config`
--

DROP TABLE IF EXISTS `ab_config`;
CREATE TABLE `ab_config` (
  `id` int(11) NOT NULL,
  `updated` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Table structure for table `ab_experiment_group_ranges`
--

DROP TABLE IF EXISTS `ab_experiment_group_ranges`;
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

--
-- Table structure for table `ab_experiment_groups`
--

DROP TABLE IF EXISTS `ab_experiment_groups`;
CREATE TABLE `ab_experiment_groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` tinyblob,
  `experiment_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `experiment_id` (`experiment_id`),
  CONSTRAINT `fk_group_experiment` FOREIGN KEY (`experiment_id`) REFERENCES `ab_experiments` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Table structure for table `ab_experiment_versions`
--

DROP TABLE IF EXISTS `ab_experiment_versions`;
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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Table structure for table `ab_experiments`
--

DROP TABLE IF EXISTS `ab_experiments`;
CREATE TABLE `ab_experiments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` tinyblob,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Table structure for table `blobs`
--

DROP TABLE IF EXISTS `blobs`;
CREATE TABLE `blobs` (
  `blob_id` int(10) NOT NULL AUTO_INCREMENT,
  `blob_text` mediumtext NOT NULL,
  PRIMARY KEY (`blob_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8
(PARTITION p0 VALUES LESS THAN (10388840) ENGINE = InnoDB,
 PARTITION p1 VALUES LESS THAN (20777680) ENGINE = InnoDB,
 PARTITION p2 VALUES LESS THAN (41555360) ENGINE = InnoDB,
 PARTITION p3 VALUES LESS THAN (62333040) ENGINE = InnoDB,
 PARTITION p4 VALUES LESS THAN (83110720) ENGINE = InnoDB,
 PARTITION p5 VALUES LESS THAN (103888400) ENGINE = InnoDB,
 PARTITION p6 VALUES LESS THAN MAXVALUE ENGINE = InnoDB) */;

--
-- Table structure for table `chat_ban_users`
--

DROP TABLE IF EXISTS `chat_ban_users`;
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

--
-- Table structure for table `chat_blocked_users`
--

DROP TABLE IF EXISTS `chat_blocked_users`;
CREATE TABLE `chat_blocked_users` (
  `cbu_user_id` int(11) NOT NULL DEFAULT '0',
  `cbu_blocked_user_id` int(11) NOT NULL DEFAULT '0',
  UNIQUE KEY `cbu_user_id` (`cbu_user_id`,`cbu_blocked_user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Table structure for table `email_types`
--

DROP TABLE IF EXISTS `email_types`;
CREATE TABLE `email_types` (
  `id` tinyint(3) unsigned NOT NULL,
  `type` varchar(64) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Table structure for table `global_registry`
--

DROP TABLE IF EXISTS `global_registry`;
CREATE TABLE `global_registry` (
  `item_id` int(10) NOT NULL,
  `item_type` int(10) NOT NULL,
  `item_value` blob NOT NULL,
  `item_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`item_id`,`item_type`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Table structure for table `global_watchlist`
--

DROP TABLE IF EXISTS `global_watchlist`;
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

--
-- Table structure for table `pages`
--

DROP TABLE IF EXISTS `pages`;
CREATE TABLE `pages` (
  `page_wikia_id` int(8) unsigned NOT NULL,
  `page_id` int(8) unsigned NOT NULL,
  `page_namespace` int(8) unsigned NOT NULL DEFAULT '0',
  `page_title` varchar(255) NOT NULL,
  `page_is_content` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `page_is_redirect` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `page_latest` int(8) unsigned NOT NULL DEFAULT '0',
  `page_last_edited` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`page_wikia_id`,`page_id`),
  KEY `page_title_namespace_latest_idx` (`page_title`,`page_namespace`,`page_latest`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Table structure for table `portability_dashboard`
--

DROP TABLE IF EXISTS `portability_dashboard`;
CREATE TABLE `portability_dashboard` (
  `wiki_id` int(11) NOT NULL,
  `portability` decimal(5,4) DEFAULT '0.0000',
  `infobox_portability` decimal(5,4) DEFAULT '0.0000',
  `traffic` int(11) DEFAULT '0',
  `migration_impact` int(11) DEFAULT '0',
  `typeless` int(11) DEFAULT '0',
  `custom_infoboxes` int(11) DEFAULT '0',
  `excluded` tinyint(4) DEFAULT '0',
  PRIMARY KEY (`wiki_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Table structure for table `rovi_episode_series`
--

DROP TABLE IF EXISTS `rovi_episode_series`;
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

--
-- Table structure for table `rovi_programs`
--

DROP TABLE IF EXISTS `rovi_programs`;
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

--
-- Table structure for table `rovi_programs_credits`
--

DROP TABLE IF EXISTS `rovi_programs_credits`;
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

--
-- Table structure for table `rovi_programs_genres`
--

DROP TABLE IF EXISTS `rovi_programs_genres`;
CREATE TABLE `rovi_programs_genres` (
  `program_id` bigint(20) NOT NULL,
  `genre` varchar(60) DEFAULT NULL,
  `genre_sequence` bigint(20) NOT NULL,
  `delta` char(3) NOT NULL,
  `genre_id` bigint(20) NOT NULL,
  PRIMARY KEY (`program_id`,`genre_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Table structure for table `rovi_series`
--

DROP TABLE IF EXISTS `rovi_series`;
CREATE TABLE `rovi_series` (
  `series_id` int(10) unsigned NOT NULL,
  `full_title` varbinary(512) NOT NULL,
  `synopsis` varbinary(2048) DEFAULT NULL,
  PRIMARY KEY (`series_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Table structure for table `tv_series`
--

DROP TABLE IF EXISTS `tv_series`;
CREATE TABLE `tv_series` (
  `series_name` varchar(255) NOT NULL,
  `series_lang` varchar(5) NOT NULL,
  `series_lookup` varchar(255) NOT NULL,
  PRIMARY KEY (`series_name`,`series_lang`,`series_lookup`),
  KEY `series_lookup` (`series_lookup`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Table structure for table `tv_series_wikis`
--

DROP TABLE IF EXISTS `tv_series_wikis`;
CREATE TABLE `tv_series_wikis` (
  `wiki_id` int(11) NOT NULL,
  `series_lookup` varchar(255) NOT NULL,
  `wiki_name` varchar(255) NOT NULL,
  `wiki_lang` varchar(5) NOT NULL,
  PRIMARY KEY (`wiki_id`,`series_lookup`),
  KEY `series_lookup` (`series_lookup`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Table structure for table `user_flags`
--

DROP TABLE IF EXISTS `user_flags`;
CREATE TABLE `user_flags` (
  `city_id` int(9) NOT NULL,
  `user_id` int(10) NOT NULL,
  `type` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `data` varchar(255) NOT NULL,
  PRIMARY KEY (`city_id`,`user_id`,`type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Table structure for table `wall_notification`
--

DROP TABLE IF EXISTS `wall_notification`;
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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Table structure for table `wall_notification_queue`
--

DROP TABLE IF EXISTS `wall_notification_queue`;
CREATE TABLE `wall_notification_queue` (
  `wiki_id` int(10) unsigned NOT NULL,
  `entity_key` varbinary(30) NOT NULL,
  `page_id` int(10) unsigned NOT NULL DEFAULT '0',
  `event_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`wiki_id`,`page_id`),
  KEY `event_date` (`event_date`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Table structure for table `wall_notification_queue_processed`
--

DROP TABLE IF EXISTS `wall_notification_queue_processed`;
CREATE TABLE `wall_notification_queue_processed` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `entity_key` varbinary(30) NOT NULL,
  `event_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_event_idx` (`user_id`,`entity_key`),
  KEY `event_date` (`event_date`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Table structure for table `wikia_rss_feeds`
--

DROP TABLE IF EXISTS `wikia_rss_feeds`;
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

--
-- Table structure for table `wikiastaff_log`
--

DROP TABLE IF EXISTS `wikiastaff_log`;
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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Dump completed on 2017-11-29  8:33:17
