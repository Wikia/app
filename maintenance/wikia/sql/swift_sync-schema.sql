-- MySQL dump 10.13  Distrib 5.6.24-72.2, for debian-linux-gnu (x86_64)
--
-- Host: geo-db-statsdb-slave.query.consul    Database: swift_sync
-- ------------------------------------------------------
-- Server version	5.6.24-72.2-log


--
-- Table structure for table `image_sync`
--

DROP TABLE IF EXISTS `image_sync`;
CREATE TABLE `image_sync` (
  `id` int(8) unsigned NOT NULL AUTO_INCREMENT,
  `city_id` int(8) unsigned NOT NULL,
  `img_action` varchar(32) NOT NULL,
  `img_src` blob,
  `img_dest` blob,
  `img_added` datetime DEFAULT NULL,
  `img_sync` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `city_id` (`city_id`,`img_added`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Table structure for table `image_sync_done`
--

DROP TABLE IF EXISTS `image_sync_done`;
CREATE TABLE `image_sync_done` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `city_id` int(8) unsigned NOT NULL,
  `img_action` varchar(32) NOT NULL,
  `img_src` blob,
  `img_dest` blob,
  `img_added` datetime DEFAULT NULL,
  `img_sync` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `img_error` smallint(4) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `city_id` (`city_id`,`img_sync`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Dump completed on 2017-10-16 14:47:41
