-- MySQL dump 10.13  Distrib 5.6.24-72.2, for debian-linux-gnu (x86_64)
--
-- Host: geo-db-specials-slave.query.consul    Database: specials
-- ------------------------------------------------------
-- Server version	5.7.18-15-log


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
  `edits` int(11) unsigned NOT NULL DEFAULT '0',
  `editdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `last_revision` int(11) NOT NULL DEFAULT '0',
  `cnt_groups` smallint(4) NOT NULL DEFAULT '0',
  `single_group` varchar(255) NOT NULL DEFAULT '',
  `all_groups` mediumtext NOT NULL,
  `user_is_blocked` tinyint(1) DEFAULT '0',
  `user_is_closed` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`wiki_id`,`user_id`,`user_name`),
  KEY `user_edits` (`user_id`,`edits`,`wiki_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

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
  `ml_ip_bin` varbinary(16) NOT NULL DEFAULT '',
  `ml_ts` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ml_city_id`,`ml_ip_bin`),
  KEY `multilookup_ts_inx` (`ml_ts`),
  KEY `multilookup_ip_bin_ts_inx` (`ml_ip_bin`,`ml_ts`)
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
  `ps_blocked_user_id` int(11) DEFAULT NULL,
  `ps_blocked_user` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '',
  `ps_wiki_id` int(9) NOT NULL,
  `ps_blocker_hit` smallint(1) unsigned NOT NULL,
  `ps_referrer` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`ps_id`),
  KEY `wiki_id` (`ps_wiki_id`,`ps_timestamp`),
  KEY `blocker_id` (`ps_blocker_id`,`ps_timestamp`)
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


-- Dump completed on 2017-12-04 11:45:53
