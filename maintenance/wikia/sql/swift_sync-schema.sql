-- MySQL dump 10.13  Distrib 5.6.24-72.2, for debian-linux-gnu (x86_64)
--
-- Host: slave.db-statsdb.service.consul    Database: swift_sync
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

--
-- Table structure for table `image_sync`
--

DROP TABLE IF EXISTS `image_sync`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
) ENGINE=InnoDB AUTO_INCREMENT=42308046 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `image_sync_done`
--

DROP TABLE IF EXISTS `image_sync_done`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `image_sync_done` (
  `id` int(8) NOT NULL AUTO_INCREMENT
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
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-04-18 11:05:45