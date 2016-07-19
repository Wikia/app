-- MySQL dump 10.13  Distrib 5.6.24-72.2, for debian-linux-gnu (x86_64)
--
-- Host: slave.db-sharedb.service.consul    Database: content_review
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
-- Table structure for table `content_review_status`
--

DROP TABLE IF EXISTS `content_review_status`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `content_review_status` (
  `wiki_id` int(10) unsigned NOT NULL,
  `page_id` int(10) unsigned NOT NULL,
  `revision_id` int(10) unsigned NOT NULL,
  `status` smallint(5) unsigned NOT NULL,
  `submit_user_id` int(10) unsigned NOT NULL,
  `submit_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `review_user_id` int(10) unsigned DEFAULT NULL,
  `review_start` timestamp NULL DEFAULT NULL,
  `escalated` tinyint(1) NOT NULL DEFAULT '0',
  UNIQUE KEY `page_id` (`wiki_id`,`page_id`,`revision_id`),
  UNIQUE KEY `content_review_unique_idx` (`wiki_id`,`page_id`,`status`),
  KEY `content_review_status_idx` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `current_reviewed_revisions`
--

DROP TABLE IF EXISTS `current_reviewed_revisions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `current_reviewed_revisions` (
  `wiki_id` int(10) unsigned NOT NULL,
  `page_id` int(10) unsigned NOT NULL,
  `revision_id` int(10) unsigned NOT NULL,
  `touched` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  UNIQUE KEY `uniq_idx` (`wiki_id`,`page_id`,`revision_id`,`touched`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `reviewed_content_logs`
--

DROP TABLE IF EXISTS `reviewed_content_logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `reviewed_content_logs` (
  `wiki_id` int(10) unsigned NOT NULL,
  `page_id` int(10) unsigned NOT NULL,
  `revision_id` int(10) unsigned NOT NULL,
  `status` smallint(5) unsigned NOT NULL,
  `submit_user_id` int(10) unsigned NOT NULL,
  `submit_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `review_user_id` int(10) unsigned NOT NULL,
  `review_start` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `review_end` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `escalated` tinyint(1) NOT NULL DEFAULT '0',
  KEY `wiki_id_review_end_idx` (`wiki_id`,`review_end`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-04-18 11:28:06