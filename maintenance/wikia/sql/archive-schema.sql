-- MySQL dump 10.13  Distrib 5.6.24-72.2, for debian-linux-gnu (x86_64)
--
-- Host: geo-db-archive-slave.query.consul    Database: archive
-- ------------------------------------------------------
-- Server version	5.7.18-15-log


--
-- Table structure for table `city_domains`
--

DROP TABLE IF EXISTS `city_domains`;
CREATE TABLE `city_domains` (
  `city_id` int(10) unsigned NOT NULL,
  `city_domain` varchar(255) NOT NULL DEFAULT 'wikia.com',
  `city_timestamp` varchar(14) NOT NULL DEFAULT '19700101000000',
  `city_new_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`city_id`,`city_domain`,`city_timestamp`,`city_new_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Table structure for table `city_list`
--

DROP TABLE IF EXISTS `city_list`;
CREATE TABLE `city_list` (
  `city_id` int(9) NOT NULL,
  `city_path` varchar(255) NOT NULL DEFAULT '/home/wikicities/cities/notreal',
  `city_dbname` varchar(64) NOT NULL DEFAULT 'notreal',
  `city_sitename` varchar(255) NOT NULL DEFAULT 'wikicities',
  `city_url` varchar(255) NOT NULL DEFAULT 'http://notreal.wikicities.com/',
  `city_created` datetime DEFAULT NULL,
  `city_founding_user` int(5) DEFAULT NULL,
  `city_adult` tinyint(1) DEFAULT '0',
  `city_public` int(1) NOT NULL DEFAULT '1',
  `city_additional` text,
  `city_description` text,
  `city_title` varchar(255) DEFAULT NULL,
  `city_founding_email` varchar(255) DEFAULT NULL,
  `city_lang` varchar(8) NOT NULL DEFAULT 'en',
  `city_special_config` text,
  `city_umbrella` varchar(255) DEFAULT NULL,
  `city_ip` varchar(256) NOT NULL DEFAULT '/usr/wikia/source/wiki',
  `city_google_analytics` varchar(100) DEFAULT '',
  `city_google_search` varchar(100) DEFAULT '',
  `city_google_maps` varchar(100) DEFAULT '',
  `city_indexed_rev` int(8) unsigned NOT NULL DEFAULT '1',
  `city_lastdump_timestamp` varchar(14) DEFAULT '19700101000000',
  `city_factory_timestamp` varchar(14) DEFAULT '19700101000000',
  `city_useshared` tinyint(1) DEFAULT '1',
  `ad_cat` char(4) NOT NULL DEFAULT '',
  `city_flags` int(10) unsigned NOT NULL DEFAULT '0',
  `city_cluster` varchar(255) DEFAULT NULL,
  `city_last_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `city_founding_ip` int(10) unsigned NOT NULL DEFAULT '0',
  `city_founding_ip_bin` varbinary(16) DEFAULT NULL,
  `city_vertical` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`city_id`),
  KEY `city_dbname_idx` (`city_dbname`),
  KEY `city_title_idx` (`city_title`),
  KEY `city_url_idx` (`city_url`),
  KEY `city_flags` (`city_flags`),
  KEY `city_founding_ip` (`city_founding_ip`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Table structure for table `city_variables`
--

DROP TABLE IF EXISTS `city_variables`;
CREATE TABLE `city_variables` (
  `cv_city_id` int(9) unsigned NOT NULL DEFAULT '1',
  `cv_variable_id` smallint(5) unsigned NOT NULL DEFAULT '0',
  `cv_value` mediumblob NOT NULL,
  `cv_timestamp` char(14) NOT NULL DEFAULT '19700101000000',
  PRIMARY KEY (`cv_variable_id`,`cv_city_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Table structure for table `wikia_tasks`
--

DROP TABLE IF EXISTS `wikia_tasks`;
CREATE TABLE `wikia_tasks` (
  `task_id` int(11) NOT NULL AUTO_INCREMENT,
  `task_user_id` int(5) unsigned NOT NULL DEFAULT '0',
  `task_type` varchar(255) NOT NULL DEFAULT '',
  `task_priority` tinyint(4) NOT NULL DEFAULT '0',
  `task_status` tinyint(4) NOT NULL DEFAULT '0',
  `task_started` char(14) NOT NULL,
  `task_finished` char(14) NOT NULL,
  `task_arguments` text,
  `task_log` mediumblob,
  `task_added` char(14) NOT NULL,
  PRIMARY KEY (`task_id`),
  KEY `task_added_idx` (`task_added`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Dump completed on 2018-03-15 15:22:11
