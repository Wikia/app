-- MySQL dump 10.16  Distrib 10.1.37-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: geo-db-specials-slave.query.consul    Database: specials
-- ------------------------------------------------------
-- Server version	5.7.25-28-log


--
-- Table structure for table `city_used_tags`
--

DROP TABLE IF EXISTS `city_used_tags`;
CREATE TABLE `city_used_tags` (
  `ct_wikia_id` int(8) unsigned NOT NULL,
  `ct_page_id` int(8) unsigned NOT NULL,
  `ct_namespace` int(8) unsigned NOT NULL,
  `ct_kind` varchar(50) NOT NULL DEFAULT '',
  `ct_timestamp` varchar(14) NOT NULL DEFAULT '19700101000000',
  PRIMARY KEY (`ct_wikia_id`,`ct_page_id`,`ct_namespace`,`ct_kind`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
  `edits` int(11) unsigned NOT NULL DEFAULT '0',
  `editdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `last_revision` int(11) NOT NULL DEFAULT '0',
  `user_is_closed` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`wiki_id`,`user_id`),
  KEY `user_edits` (`user_id`,`edits`,`wiki_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

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
-- Table structure for table `rtbf_log`
--

DROP TABLE IF EXISTS `rtbf_log`;
CREATE TABLE `rtbf_log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(5) unsigned NOT NULL,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `number_of_wikis` int(10) unsigned DEFAULT NULL,
  `global_data_removed` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Table structure for table `rtbf_log_details`
--

DROP TABLE IF EXISTS `rtbf_log_details`;
CREATE TABLE `rtbf_log_details` (
  `log_id` int(10) unsigned NOT NULL,
  `wiki_id` int(10) unsigned NOT NULL,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `celery_task` char(39) DEFAULT NULL,
  `finished` datetime DEFAULT NULL,
  `was_successful` tinyint(1) DEFAULT NULL,
  UNIQUE KEY `log_id` (`log_id`,`wiki_id`),
  CONSTRAINT `rtbf_log_details_ibfk_1` FOREIGN KEY (`log_id`) REFERENCES `rtbf_log` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- Dump completed on 2019-04-18 12:56:28
