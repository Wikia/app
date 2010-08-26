-- MySQL dump 10.11
--
-- Host: localhost    Database: archive
-- ------------------------------------------------------
-- Server version	5.0.77-1-log

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
-- Table structure for table `city_domains`
--

SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `city_domains` (
  `city_id` int(10) unsigned NOT NULL,
  `city_domain` varchar(255) NOT NULL default 'wikia.com',
  `city_timestamp` varchar(14) NOT NULL default '19700101000000',
  `city_new_id` int(10) unsigned default NULL,
  PRIMARY KEY  (`city_id`,`city_domain`,`city_timestamp`),
  KEY `city_domains_idx` (`city_domain`),
  KEY `city_domains_timestamp_idx` (`city_domain`,`city_timestamp`),
  KEY `city_new_id_idx` (`city_new_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `city_list`
--

SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `city_list` (
  `city_id` int(9) NOT NULL,
  `city_path` varchar(255) NOT NULL default '/home/wikicities/cities/notreal',
  `city_dbname` varchar(64) NOT NULL default 'notreal',
  `city_sitename` varchar(255) NOT NULL default 'wikicities',
  `city_url` varchar(255) NOT NULL default 'http://notreal.wikicities.com/',
  `city_created` datetime default NULL,
  `city_founding_user` int(5) default NULL,
  `city_adult` tinyint(1) default '0',
  `city_public` int(1) NOT NULL default '1',
  `city_additional` text,
  `city_description` text,
  `city_title` varchar(255) default NULL,
  `city_founding_email` varchar(255) default NULL,
  `city_lang` varchar(7) NOT NULL default 'en',
  `city_special_config` text,
  `city_umbrella` varchar(255) default NULL,
  `city_ip` varchar(256) NOT NULL default '/usr/wikia/source/wiki',
  `city_google_analytics` varchar(100) default '',
  `city_google_search` varchar(100) default '',
  `city_google_maps` varchar(100) default '',
  `city_indexed_rev` int(8) unsigned NOT NULL default '1',
  `city_lastdump_timestamp` varchar(14) default '19700101000000',
  `city_factory_timestamp` varchar(14) default '19700101000000',
  `city_useshared` tinyint(1) default '1',
  `city_flags` int(10) unsigned not null default '0',
  `city_cluster` varchar(255) default NULL,
  `ad_cat` char(4) NOT NULL default '',
  KEY `city_id` (`city_id`),
  KEY `city_dbname_idx` (`city_dbname`),
  KEY `city_title_idx` (`city_title`),
  KEY `city_url_idx` (`city_url`),
  KEY `city_flags_idx` (`city_flags`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `city_variables`
--

SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `city_variables` (
  `cv_city_id` int(9) unsigned NOT NULL default '1',
  `cv_variable_id` smallint(5) unsigned NOT NULL default '0',
  `cv_value` mediumblob NOT NULL,
  `cv_timestamp` char(14) NOT NULL default '19700101000000'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `wikia_tasks`
--

SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `wikia_tasks` (
  `task_id` int(11) NOT NULL auto_increment,
  `task_user_id` int(5) unsigned NOT NULL default '0',
  `task_type` varchar(255) NOT NULL default '',
  `task_priority` tinyint(4) NOT NULL default '0',
  `task_status` tinyint(4) NOT NULL default '0',
  `task_started` char(14) NOT NULL,
  `task_finished` char(14) NOT NULL,
  `task_arguments` text,
  `task_log` mediumblob,
  `task_added` char(14) NOT NULL,
  PRIMARY KEY  (`task_id`),
  KEY `task_added_idx` (`task_added`)
) ENGINE=InnoDB AUTO_INCREMENT=6128 DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2009-05-05 10:26:54


-- #64375: Ensure wgServer is unique
alter table city_variables_pool add cv_is_unique int(1) default 0;
update city_variables_pool set cv_is_unique = 1 where cv_name = 'wgServer';
