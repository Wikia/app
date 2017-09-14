-- MySQL dump 10.13  Distrib 5.6.24-72.2, for debian-linux-gnu (x86_64)
--
-- Host: geo-db-statsdb-slave.query.consul    Database: stats
-- ------------------------------------------------------
-- Server version	5.6.24-72.2-log


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
  PRIMARY KEY (`ct_wikia_id`,`ct_page_id`,`ct_namespace`,`ct_kind`),
  KEY `ct_wikia_id` (`ct_wikia_id`),
  KEY `ct_page_id` (`ct_page_id`,`ct_namespace`),
  KEY `ct_timestamp` (`ct_timestamp`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Table structure for table `events`
--

DROP TABLE IF EXISTS `events`;
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

--
-- Table structure for table `events_ipv6`
--

DROP TABLE IF EXISTS `events_ipv6`;
CREATE TABLE `events_ipv6` (
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
  `ip_v6` varchar(45) DEFAULT NULL,
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


-- Dump completed on 2017-07-06  8:12:52
