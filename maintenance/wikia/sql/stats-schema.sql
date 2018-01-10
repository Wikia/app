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
  PRIMARY KEY (`ct_wikia_id`,`ct_page_id`,`ct_namespace`,`ct_kind`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Dump completed on 2018-01-09 15:20:11
