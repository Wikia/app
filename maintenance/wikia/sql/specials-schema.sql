-- MySQL dump 10.13  Distrib 5.6.24-72.2, for debian-linux-gnu (x86_64)
--
-- Host: geo-db-specials-slave.query.consul    Database: specials
-- ------------------------------------------------------
-- Server version	5.6.24-72.2-log


--
-- Table structure for table `common_key_value`
--

DROP TABLE IF EXISTS `common_key_value`;
CREATE TABLE `common_key_value` (
  `identifier` varchar(255) NOT NULL,
  `content` mediumblob NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`identifier`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Table structure for table `const_values`
--

DROP TABLE IF EXISTS `const_values`;
CREATE TABLE `const_values` (
  `name` varchar(50) NOT NULL,
  `val` int(8) unsigned NOT NULL,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Table structure for table `crosslink`
--

DROP TABLE IF EXISTS `crosslink`;
CREATE TABLE `crosslink` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `source_wiki` int(8) unsigned NOT NULL,
  `source_page` int(8) unsigned NOT NULL,
  `target_wiki` int(8) unsigned NOT NULL,
  `target_page` int(8) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `source` (`source_wiki`,`source_page`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Table structure for table `discussion_reporting`
--

DROP TABLE IF EXISTS `discussion_reporting`;
CREATE TABLE `discussion_reporting` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dr_query` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `dr_title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `discussion_dr_title_query_idx` (`dr_title`,`dr_query`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Table structure for table `events_local_users`
--

DROP TABLE IF EXISTS `events_local_users`;
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

--
-- Table structure for table `groups`
--

DROP TABLE IF EXISTS `groups`;
CREATE TABLE `groups` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Table structure for table `jobs_dirty`
--

DROP TABLE IF EXISTS `jobs_dirty`;
CREATE TABLE `jobs_dirty` (
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `city_id` int(8) unsigned NOT NULL,
  `locked` timestamp NULL DEFAULT NULL,
  UNIQUE KEY `city_id_inx` (`city_id`),
  KEY `locked` (`locked`)
) ENGINE=MEMORY DEFAULT CHARSET=latin1;

--
-- Table structure for table `jobs_summary`
--

DROP TABLE IF EXISTS `jobs_summary`;
CREATE TABLE `jobs_summary` (
  `city_id` int(8) unsigned NOT NULL,
  `total` int(8) unsigned DEFAULT '0',
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`city_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Table structure for table `multilookup`
--

DROP TABLE IF EXISTS `multilookup`;
CREATE TABLE `multilookup` (
  `ml_city_id` int(9) unsigned NOT NULL,
  `ml_ip` int(10) unsigned NOT NULL,
  `ml_count` int(6) unsigned NOT NULL DEFAULT '0',
  `ml_ts` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ml_city_id`,`ml_ip`),
  KEY `multilookup_ts_inx` (`ml_ip`,`ml_ts`),
  KEY `multilookup_cnt_ts_inx` (`ml_ip`,`ml_count`,`ml_ts`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

--
-- Table structure for table `phalanx_stats`
--

DROP TABLE IF EXISTS `phalanx_stats`;
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Table structure for table `script_log`
--

DROP TABLE IF EXISTS `script_log`;
CREATE TABLE `script_log` (
  `logname` varchar(50) NOT NULL,
  `ts` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`logname`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Table structure for table `user_groups`
--

DROP TABLE IF EXISTS `user_groups`;
CREATE TABLE `user_groups` (
  `user_id` int(10) unsigned NOT NULL,
  `group_id` int(10) unsigned NOT NULL,
  `wiki_id` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`user_id`,`group_id`,`wiki_id`),
  KEY `user_id` (`user_id`),
  KEY `group_id` (`group_id`),
  KEY `wiki_id` (`wiki_id`),
  KEY `group_wikis` (`group_id`,`wiki_id`),
  CONSTRAINT `user_groups_ibfk_1` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Table structure for table `user_login_history`
--

DROP TABLE IF EXISTS `user_login_history`;
CREATE TABLE `user_login_history` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(5) unsigned NOT NULL,
  `city_id` int(9) unsigned DEFAULT '0',
  `ulh_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ulh_from` tinyint(4) DEFAULT '0',
  `ulh_rememberme` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_user_login_history_wikia_timestamp` (`city_id`,`user_id`,`ulh_timestamp`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Table structure for table `user_login_history_summary`
--

DROP TABLE IF EXISTS `user_login_history_summary`;
CREATE TABLE `user_login_history_summary` (
  `user_id` int(8) unsigned NOT NULL,
  `ulh_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Dump completed on 2017-03-30  9:35:07
