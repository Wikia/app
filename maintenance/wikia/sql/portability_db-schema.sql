-- MySQL dump 10.16  Distrib 10.1.37-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: geo-db-archive-slave.query.consul    Database: portability_db
-- ------------------------------------------------------
-- Server version	5.7.25-28-log


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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- Dump completed on 2019-04-18 12:56:14
