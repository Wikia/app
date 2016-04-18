-- MySQL dump 10.13  Distrib 5.6.24-72.2, for debian-linux-gnu (x86_64)
--
-- Host: slave.db-sharedb.service.consul    Database: wikicities
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
-- Table structure for table `abuse_filter`
--

DROP TABLE IF EXISTS `abuse_filter`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `abuse_filter` (
  `af_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `af_pattern` blob NOT NULL,
  `af_user` bigint(20) unsigned NOT NULL,
  `af_user_text` varchar(255) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL,
  `af_timestamp` binary(14) NOT NULL,
  `af_enabled` tinyint(1) NOT NULL DEFAULT '1',
  `af_comments` blob,
  `af_public_comments` tinyblob,
  `af_hidden` tinyint(1) NOT NULL DEFAULT '0',
  `af_hit_count` bigint(20) NOT NULL DEFAULT '0',
  `af_throttled` tinyint(1) NOT NULL DEFAULT '0',
  `af_deleted` tinyint(1) NOT NULL DEFAULT '0',
  `af_actions` varchar(255) NOT NULL DEFAULT '',
  `af_global` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`af_id`),
  KEY `af_user` (`af_user`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `abuse_filter_action`
--

DROP TABLE IF EXISTS `abuse_filter_action`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `abuse_filter_action` (
  `afa_filter` bigint(20) unsigned NOT NULL,
  `afa_consequence` varchar(255) NOT NULL,
  `afa_parameters` tinyblob NOT NULL,
  PRIMARY KEY (`afa_filter`,`afa_consequence`),
  KEY `afa_consequence` (`afa_consequence`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `abuse_filter_history`
--

DROP TABLE IF EXISTS `abuse_filter_history`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `abuse_filter_history` (
  `afh_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `afh_filter` bigint(20) unsigned NOT NULL,
  `afh_user` bigint(20) unsigned NOT NULL,
  `afh_user_text` varchar(255) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL,
  `afh_timestamp` binary(14) NOT NULL,
  `afh_pattern` blob NOT NULL,
  `afh_comments` blob NOT NULL,
  `afh_flags` tinyblob NOT NULL,
  `afh_public_comments` tinyblob,
  `afh_actions` blob,
  `afh_deleted` tinyint(1) NOT NULL DEFAULT '0',
  `afh_changed_fields` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`afh_id`),
  KEY `afh_filter` (`afh_filter`),
  KEY `afh_user` (`afh_user`),
  KEY `afh_user_text` (`afh_user_text`),
  KEY `afh_timestamp` (`afh_timestamp`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `abuse_filter_log`
--

DROP TABLE IF EXISTS `abuse_filter_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `abuse_filter_log` (
  `afl_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `afl_filter` varchar(64) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL,
  `afl_user` bigint(20) unsigned NOT NULL,
  `afl_user_text` varchar(255) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL,
  `afl_ip` varchar(255) NOT NULL,
  `afl_action` varbinary(255) NOT NULL,
  `afl_actions` varbinary(255) NOT NULL,
  `afl_var_dump` blob NOT NULL,
  `afl_timestamp` binary(14) NOT NULL,
  `afl_namespace` tinyint(4) NOT NULL,
  `afl_title` varchar(255) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL,
  `afl_wiki` varchar(64) CHARACTER SET latin1 COLLATE latin1_bin DEFAULT NULL,
  `afl_deleted` tinyint(1) DEFAULT NULL,
  `afl_patrolled_by` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`afl_id`),
  KEY `afl_timestamp` (`afl_timestamp`),
  KEY `filter_timestamp` (`afl_filter`,`afl_timestamp`),
  KEY `user_timestamp` (`afl_user`,`afl_user_text`,`afl_timestamp`),
  KEY `page_timestamp` (`afl_namespace`,`afl_title`,`afl_timestamp`),
  KEY `ip_timestamp` (`afl_ip`,`afl_timestamp`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ach_ranking_snapshots`
--

DROP TABLE IF EXISTS `ach_ranking_snapshots`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ach_ranking_snapshots` (
  `wiki_id` int(9) NOT NULL,
  `date` datetime NOT NULL,
  `data` text COLLATE utf8_unicode_ci NOT NULL,
  UNIQUE KEY `wiki_id` (`wiki_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ad_provider`
--

DROP TABLE IF EXISTS `ad_provider`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ad_provider` (
  `provider_id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `provider_name` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`provider_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ad_provider_value`
--

DROP TABLE IF EXISTS `ad_provider_value`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ad_provider_value` (
  `apv_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `provider_id` tinyint(3) unsigned NOT NULL,
  `city_id` int(10) unsigned DEFAULT NULL,
  `keyname` varchar(25) DEFAULT NULL,
  `keyvalue` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`apv_id`),
  UNIQUE KEY `city_id` (`city_id`,`keyname`,`keyvalue`),
  KEY `provider_id` (`provider_id`,`city_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ad_slot`
--

DROP TABLE IF EXISTS `ad_slot`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ad_slot` (
  `as_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `slot` varchar(50) NOT NULL,
  `skin` varchar(25) NOT NULL,
  `size` varchar(25) DEFAULT NULL,
  `load_priority` tinyint(3) unsigned DEFAULT NULL,
  `default_provider_id` tinyint(3) unsigned NOT NULL,
  `default_enabled` enum('Yes','No') DEFAULT 'Yes',
  PRIMARY KEY (`as_id`),
  UNIQUE KEY `slot` (`slot`,`skin`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ad_slot_20081018`
--

DROP TABLE IF EXISTS `ad_slot_20081018`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ad_slot_20081018` (
  `as_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `slot` varchar(50) NOT NULL,
  `skin` varchar(25) NOT NULL,
  `size` varchar(25) DEFAULT NULL,
  `default_provider_id` tinyint(3) unsigned NOT NULL,
  `default_enabled` enum('Yes','No') DEFAULT 'Yes',
  PRIMARY KEY (`as_id`),
  UNIQUE KEY `slot` (`slot`,`skin`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ad_slot_o`
--

DROP TABLE IF EXISTS `ad_slot_o`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ad_slot_o` (
  `as_id` smallint(5) unsigned NOT NULL,
  `city_id` int(10) unsigned NOT NULL,
  `provider_id` tinyint(3) unsigned DEFAULT NULL,
  `enabled` enum('Yes','No') DEFAULT NULL,
  `comment` text,
  PRIMARY KEY (`as_id`,`city_id`),
  KEY `city_id` (`city_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ad_slot_override`
--

DROP TABLE IF EXISTS `ad_slot_override`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ad_slot_override` (
  `as_id` smallint(5) unsigned NOT NULL,
  `city_id` int(10) unsigned NOT NULL,
  `provider_id` tinyint(3) unsigned DEFAULT NULL,
  `enabled` enum('Yes','No') DEFAULT NULL,
  `comment` text,
  PRIMARY KEY (`as_id`,`city_id`),
  KEY `city_id` (`city_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `advert_ads`
--

DROP TABLE IF EXISTS `advert_ads`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `advert_ads` (
  `ad_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `wiki_db` varchar(255) NOT NULL,
  `page_id` int(10) unsigned NOT NULL,
  `page_original_url` text NOT NULL COMMENT 'the url when the page was sponsored',
  `ad_link_url` text NOT NULL,
  `ad_link_text` varchar(255) NOT NULL,
  `ad_text` text NOT NULL,
  `ad_price` decimal(10,2) NOT NULL,
  `ad_months` int(11) NOT NULL COMMENT 'duration ad runs for',
  `user_email` tinyblob NOT NULL,
  `ad_status` int(11) NOT NULL COMMENT 'moderation status',
  `last_pay_date` date NOT NULL COMMENT 'last completed paypal payment',
  PRIMARY KEY (`ad_id`),
  KEY `wiki_db_page_id_ad_price` (`wiki_db`,`page_id`,`ad_price`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `advert_pmts`
--

DROP TABLE IF EXISTS `advert_pmts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `advert_pmts` (
  `pay_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ad_id` int(10) unsigned NOT NULL,
  `payer_email` varchar(255) NOT NULL,
  `pay_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `pay_amt` int(11) NOT NULL,
  `pay_type` varchar(50) NOT NULL COMMENT 'paypal payment type',
  `pay_status` varchar(50) NOT NULL,
  `pay_conf_msg` mediumtext NOT NULL,
  PRIMARY KEY (`pay_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `apiGate_keys`
--

DROP TABLE IF EXISTS `apiGate_keys`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `apiGate_keys` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `apiKey` varchar(255) NOT NULL,
  `email` tinytext NOT NULL,
  `firstName` varchar(255) NOT NULL,
  `lastName` varchar(255) NOT NULL,
  `nickName` varchar(255) DEFAULT NULL,
  `enabled` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `archive`
--

DROP TABLE IF EXISTS `archive`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `archive` (
  `ar_namespace` int(11) NOT NULL,
  `ar_title` varchar(255) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL DEFAULT '',
  `ar_text` mediumtext NOT NULL,
  `ar_comment` tinyblob NOT NULL,
  `ar_user` int(5) unsigned NOT NULL DEFAULT '0',
  `ar_user_text` varchar(255) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL DEFAULT '',
  `ar_timestamp` varchar(14) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL DEFAULT '',
  `ar_minor_edit` tinyint(1) NOT NULL DEFAULT '0',
  `ar_flags` tinyblob NOT NULL,
  `ar_rev_id` int(8) unsigned DEFAULT NULL,
  `ar_text_id` int(8) unsigned DEFAULT NULL,
  `ar_deleted` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `ar_len` int(10) unsigned DEFAULT NULL,
  `ar_page_id` int(10) unsigned DEFAULT NULL,
  `ar_parent_id` int(10) unsigned DEFAULT NULL,
  `ar_sha1` varbinary(32) NOT NULL DEFAULT '',
  KEY `name_title_timestamp` (`ar_namespace`,`ar_title`,`ar_timestamp`),
  KEY `usertext_timestamp` (`ar_user_text`,`ar_timestamp`),
  KEY `page_revision` (`ar_page_id`,`ar_rev_id`),
  KEY `ar_revid` (`ar_rev_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `blog_listing_relation`
--

DROP TABLE IF EXISTS `blog_listing_relation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `blog_listing_relation` (
  `blr_relation` varbinary(255) NOT NULL DEFAULT '',
  `blr_title` varbinary(255) NOT NULL DEFAULT '',
  `blr_type` enum('cat','user') DEFAULT NULL,
  UNIQUE KEY `wl_user` (`blr_relation`,`blr_title`,`blr_type`),
  KEY `type_relation` (`blr_relation`,`blr_type`)
) ENGINE=InnoDB DEFAULT CHARSET=binary;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `brokenlinks`
--

DROP TABLE IF EXISTS `brokenlinks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `brokenlinks` (
  `bl_from` int(8) unsigned NOT NULL DEFAULT '0',
  `bl_to` varchar(255) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL DEFAULT '',
  UNIQUE KEY `bl_from` (`bl_from`,`bl_to`),
  KEY `bl_to` (`bl_to`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `category`
--

DROP TABLE IF EXISTS `category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `category` (
  `cat_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cat_title` varchar(255) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL,
  `cat_pages` int(11) NOT NULL DEFAULT '0',
  `cat_subcats` int(11) NOT NULL DEFAULT '0',
  `cat_files` int(11) NOT NULL DEFAULT '0',
  `cat_hidden` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`cat_id`),
  UNIQUE KEY `cat_title` (`cat_title`),
  KEY `cat_pages` (`cat_pages`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `categorylinks`
--

DROP TABLE IF EXISTS `categorylinks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categorylinks` (
  `cl_from` int(8) unsigned NOT NULL DEFAULT '0',
  `cl_to` varchar(255) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL DEFAULT '',
  `cl_sortkey` varbinary(230) NOT NULL DEFAULT '',
  `cl_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `cl_sortkey_prefix` varchar(255) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL DEFAULT '',
  `cl_collation` varbinary(32) NOT NULL DEFAULT '',
  `cl_type` enum('page','subcat','file') NOT NULL DEFAULT 'page',
  UNIQUE KEY `cl_from` (`cl_from`,`cl_to`),
  KEY `cl_timestamp` (`cl_to`,`cl_timestamp`),
  KEY `cl_collation` (`cl_collation`),
  KEY `cl_sortkey` (`cl_to`,`cl_type`,`cl_sortkey`,`cl_from`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `change_tag`
--

DROP TABLE IF EXISTS `change_tag`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `change_tag` (
  `ct_rc_id` int(11) DEFAULT NULL,
  `ct_log_id` int(11) DEFAULT NULL,
  `ct_rev_id` int(11) DEFAULT NULL,
  `ct_tag` varchar(255) NOT NULL,
  `ct_params` blob,
  UNIQUE KEY `change_tag_rc_tag` (`ct_rc_id`,`ct_tag`),
  UNIQUE KEY `change_tag_log_tag` (`ct_log_id`,`ct_tag`),
  UNIQUE KEY `change_tag_rev_tag` (`ct_rev_id`,`ct_tag`),
  KEY `change_tag_tag_id` (`ct_tag`,`ct_rc_id`,`ct_rev_id`,`ct_log_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `city_ads`
--

DROP TABLE IF EXISTS `city_ads`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `city_ads` (
  `r` int(11) NOT NULL AUTO_INCREMENT,
  `city_id` int(9) NOT NULL,
  `ad_skin` varchar(15) NOT NULL DEFAULT 'monaco',
  `ad_lang` char(2) NOT NULL DEFAULT '',
  `ad_cat` char(4) NOT NULL DEFAULT '',
  `ad_pos` varchar(15) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `ad_zone` mediumint(9) NOT NULL,
  `ad_server` char(1) NOT NULL DEFAULT 'L',
  `comment` varchar(255) NOT NULL DEFAULT '',
  `dbname` varchar(255) NOT NULL DEFAULT '',
  `ad_keywords` varchar(255) NOT NULL DEFAULT '',
  `domain` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`r`),
  UNIQUE KEY `mainidx` (`city_id`,`ad_skin`,`ad_lang`,`ad_cat`,`ad_pos`) USING BTREE,
  KEY `lookupidx` (`city_id`,`ad_skin`),
  KEY `cityidx` (`city_id`),
  KEY `zoneidx` (`ad_zone`),
  KEY `posidx` (`ad_pos`),
  KEY `langidx` (`ad_lang`),
  KEY `skinidx` (`ad_skin`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `city_cat_mapping`
--

DROP TABLE IF EXISTS `city_cat_mapping`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `city_cat_mapping` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `city_id` int(11) DEFAULT NULL,
  `cat_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `city_id_idx` (`city_id`),
  KEY `cat_id_idx` (`cat_id`),
  CONSTRAINT `city_cat_mapping_ibfk_1` FOREIGN KEY (`city_id`) REFERENCES `city_list` (`city_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `city_cats`
--

DROP TABLE IF EXISTS `city_cats`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `city_cats` (
  `cat_id` int(9) NOT NULL AUTO_INCREMENT,
  `cat_name` varchar(255) DEFAULT NULL,
  `cat_url` text,
  `cat_short` varchar(255) DEFAULT NULL,
  `cat_deprecated` tinyint(1) DEFAULT '0',
  `cat_active` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`cat_id`),
  KEY `cat_name_idx` (`cat_name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `city_domains`
--

DROP TABLE IF EXISTS `city_domains`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `city_domains` (
  `city_id` int(9) NOT NULL,
  `city_domain` varchar(255) NOT NULL DEFAULT 'wikia.com',
  PRIMARY KEY (`city_id`,`city_domain`),
  UNIQUE KEY `city_domains_archive_idx_uniq` (`city_domain`),
  CONSTRAINT `city_domains_ibfk_1_archive` FOREIGN KEY (`city_id`) REFERENCES `city_list` (`city_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `city_image_migrate`
--

DROP TABLE IF EXISTS `city_image_migrate`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `city_image_migrate` (
  `city_id` int(10) unsigned NOT NULL,
  `migration_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `locked` tinyint(1) unsigned DEFAULT NULL,
  PRIMARY KEY (`city_id`),
  KEY `locked` (`locked`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `city_image_migrate_v1`
--

DROP TABLE IF EXISTS `city_image_migrate_v1`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `city_image_migrate_v1` (
  `city_id` int(10) unsigned NOT NULL,
  `migration_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `locked` tinyint(1) unsigned DEFAULT NULL,
  PRIMARY KEY (`city_id`),
  KEY `locked` (`locked`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `city_lang`
--

DROP TABLE IF EXISTS `city_lang`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `city_lang` (
  `lang_id` mediumint(2) unsigned NOT NULL AUTO_INCREMENT,
  `lang_code` char(8) NOT NULL,
  `lang_name` varchar(255) NOT NULL,
  PRIMARY KEY (`lang_id`),
  KEY `lang_code_idx` (`lang_code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `city_list`
--

DROP TABLE IF EXISTS `city_list`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `city_list` (
  `city_id` int(9) NOT NULL AUTO_INCREMENT,
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
  `city_last_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `city_founding_ip` int(10) unsigned NOT NULL DEFAULT '0',
  `city_vertical` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`city_id`),
  UNIQUE KEY `urlidx` (`city_url`),
  UNIQUE KEY `city_dbname_idx` (`city_dbname`),
  KEY `titleidx` (`city_title`),
  KEY `city_flags` (`city_flags`),
  KEY `city_created` (`city_created`,`city_lang`),
  KEY `city_founding_user_inx` (`city_founding_user`),
  KEY `city_cluster` (`city_cluster`),
  KEY `city_founding_ip` (`city_founding_ip`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `city_list_log`
--

DROP TABLE IF EXISTS `city_list_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `city_list_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cl_city_id` int(9) NOT NULL,
  `cl_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `cl_user_id` int(5) unsigned DEFAULT NULL,
  `cl_type` int(5) NOT NULL,
  `cl_text` mediumtext NOT NULL,
  `cl_var_id` int(5) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cl_city_id_idx` (`cl_city_id`),
  KEY `cl_type_idx` (`cl_type`),
  KEY `cl_timestamp_idx` (`cl_timestamp`),
  KEY `var_city` (`cl_var_id`,`cl_city_id`),
  CONSTRAINT `city_list_log_ibfk_1` FOREIGN KEY (`cl_city_id`) REFERENCES `city_list` (`city_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `city_tag`
--

DROP TABLE IF EXISTS `city_tag`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `city_tag` (
  `id` int(8) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `city_tag_name_uniq` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `city_tag_map`
--

DROP TABLE IF EXISTS `city_tag_map`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `city_tag_map` (
  `city_id` int(9) NOT NULL,
  `tag_id` int(8) unsigned NOT NULL,
  PRIMARY KEY (`city_id`,`tag_id`),
  KEY `tag_id` (`tag_id`),
  CONSTRAINT `city_tag_map_ibfk_1` FOREIGN KEY (`city_id`) REFERENCES `city_list` (`city_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `city_tag_map_ibfk_2` FOREIGN KEY (`tag_id`) REFERENCES `city_tag` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `city_variables`
--

DROP TABLE IF EXISTS `city_variables`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `city_variables` (
  `cv_city_id` int(9) NOT NULL,
  `cv_variable_id` smallint(5) unsigned NOT NULL DEFAULT '0',
  `cv_value` text NOT NULL,
  PRIMARY KEY (`cv_variable_id`,`cv_city_id`),
  KEY `cv_city_id_archive` (`cv_city_id`),
  KEY `cv_variable_id` (`cv_variable_id`,`cv_value`(300))
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `city_variables_groups`
--

DROP TABLE IF EXISTS `city_variables_groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `city_variables_groups` (
  `cv_group_id` int(11) NOT NULL AUTO_INCREMENT,
  `cv_group_name` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`cv_group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `city_variables_pool`
--

DROP TABLE IF EXISTS `city_variables_pool`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `city_variables_pool` (
  `cv_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `cv_name` varchar(255) NOT NULL,
  `cv_description` text NOT NULL,
  `cv_variable_type` enum('integer','long','string','float','array','boolean','text','struct','hash') NOT NULL DEFAULT 'integer',
  `cv_variable_group` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `cv_access_level` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '1 - read only\n2 - admin writable\n3 - user writable\n',
  `cv_is_unique` int(1) DEFAULT '0',
  PRIMARY KEY (`cv_id`),
  UNIQUE KEY `idx_name_unique` (`cv_name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `city_verticals`
--

DROP TABLE IF EXISTS `city_verticals`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `city_verticals` (
  `vertical_id` int(9) NOT NULL,
  `vertical_name` varchar(255) DEFAULT NULL,
  `vertical_url` text,
  `vertical_short` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`vertical_id`),
  KEY `vertical_name_idx` (`vertical_name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `city_visualization`
--

DROP TABLE IF EXISTS `city_visualization`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `city_visualization` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `city_id` int(11) DEFAULT NULL,
  `city_lang_code` char(8) NOT NULL DEFAULT 'en',
  `city_vertical` int(11) DEFAULT NULL,
  `city_headline` varchar(255) DEFAULT NULL,
  `city_description` text,
  `city_main_image` varchar(255) DEFAULT NULL,
  `city_flags` smallint(8) DEFAULT '0',
  `city_images` text,
  PRIMARY KEY (`id`),
  KEY `cv_cid_cf_ce` (`city_id`,`city_flags`),
  CONSTRAINT `city_visualization_ibfk_1` FOREIGN KEY (`city_id`) REFERENCES `city_list` (`city_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `city_visualization_image_review_stats`
--

DROP TABLE IF EXISTS `city_visualization_image_review_stats`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `city_visualization_image_review_stats` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `reviewer_id` int(11) NOT NULL,
  `city_id` int(11) NOT NULL,
  `page_id` int(11) NOT NULL,
  `review_state` int(11) NOT NULL DEFAULT '0',
  `review_end` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `reviewer_idx` (`reviewer_id`),
  KEY `stats_idx` (`reviewer_id`,`review_state`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `city_visualization_images`
--

DROP TABLE IF EXISTS `city_visualization_images`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `city_visualization_images` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `city_id` int(11) NOT NULL,
  `page_id` int(8) NOT NULL,
  `city_lang_code` varchar(8) DEFAULT NULL,
  `image_index` int(11) DEFAULT '1',
  `image_name` varchar(255) NOT NULL,
  `image_review_status` tinyint(3) unsigned DEFAULT NULL,
  `last_edited` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `review_start` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `review_end` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `reviewer_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `city_visualization_images_ifbk_1` (`city_id`),
  KEY `cvi_image_review_status` (`image_review_status`),
  KEY `cvi_city_lang_code` (`city_lang_code`),
  CONSTRAINT `city_visualization_images_ifbk_1` FOREIGN KEY (`city_id`) REFERENCES `city_visualization` (`city_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `city_visualization_images_xwiki`
--

DROP TABLE IF EXISTS `city_visualization_images_xwiki`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `city_visualization_images_xwiki` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `city_id` int(11) NOT NULL,
  `city_lang_code` varchar(8) DEFAULT NULL,
  `image_type` int(11) DEFAULT '0',
  `image_index` int(11) DEFAULT '1',
  `image_name` varchar(255) NOT NULL,
  `image_review_status` tinyint(3) unsigned DEFAULT NULL,
  `last_edited` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `review_start` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `review_end` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `reviewer_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `city_visualization_images_xwiki_ifbk_1` (`city_id`),
  KEY `cvix_image_type` (`image_type`),
  KEY `cvix_image_review_status` (`image_review_status`),
  KEY `cvix_city_lang_code` (`city_lang_code`),
  CONSTRAINT `city_visualization_images_xwiki_ifbk_1` FOREIGN KEY (`city_id`) REFERENCES `city_visualization_xwiki` (`city_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `city_visualization_xwiki`
--

DROP TABLE IF EXISTS `city_visualization_xwiki`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `city_visualization_xwiki` (
  `city_id` int(11) NOT NULL DEFAULT '0',
  `city_lang_code` char(8) NOT NULL DEFAULT 'en',
  `city_vertical` int(11) DEFAULT NULL,
  `city_headline` varchar(255) DEFAULT NULL,
  `city_description` text,
  `city_flags` smallint(8) DEFAULT '0',
  PRIMARY KEY (`city_id`,`city_lang_code`),
  KEY `cvx_cid_cf_ce` (`city_id`,`city_flags`),
  CONSTRAINT `city_visualization_xwiki_ibfk_1` FOREIGN KEY (`city_id`) REFERENCES `city_list` (`city_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `comments_index`
--

DROP TABLE IF EXISTS `comments_index`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `comments_index` (
  `parent_page_id` int(10) unsigned NOT NULL,
  `comment_id` int(10) unsigned NOT NULL,
  `parent_comment_id` int(10) unsigned NOT NULL DEFAULT '0',
  `last_child_comment_id` int(10) unsigned NOT NULL DEFAULT '0',
  `archived` tinyint(1) NOT NULL DEFAULT '0',
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  `removed` tinyint(1) NOT NULL DEFAULT '0',
  `locked` tinyint(1) NOT NULL DEFAULT '0',
  `protected` tinyint(1) NOT NULL DEFAULT '0',
  `sticky` tinyint(1) NOT NULL DEFAULT '0',
  `first_rev_id` int(10) unsigned NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `last_rev_id` int(10) unsigned NOT NULL DEFAULT '0',
  `last_touched` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`parent_page_id`,`comment_id`),
  KEY `comment_id` (`comment_id`,`archived`,`deleted`,`removed`),
  KEY `parent_comment_id` (`parent_comment_id`,`archived`,`deleted`,`removed`),
  KEY `sticky` (`sticky`,`created_at`),
  KEY `parent_page_id` (`parent_page_id`,`archived`,`deleted`,`removed`,`parent_comment_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `cu_changes`
--

DROP TABLE IF EXISTS `cu_changes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cu_changes` (
  `cuc_id` int(11) NOT NULL AUTO_INCREMENT,
  `cuc_namespace` int(11) NOT NULL DEFAULT '0',
  `cuc_title` varchar(255) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL DEFAULT '',
  `cuc_user` int(11) NOT NULL DEFAULT '0',
  `cuc_user_text` varchar(255) NOT NULL DEFAULT '',
  `cuc_actiontext` varchar(255) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL DEFAULT '',
  `cuc_comment` varchar(255) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL DEFAULT '',
  `cuc_minor` tinyint(1) NOT NULL DEFAULT '0',
  `cuc_page_id` int(10) unsigned NOT NULL DEFAULT '0',
  `cuc_this_oldid` int(10) unsigned NOT NULL DEFAULT '0',
  `cuc_last_oldid` int(10) unsigned NOT NULL DEFAULT '0',
  `cuc_type` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `cuc_timestamp` char(14) NOT NULL DEFAULT '',
  `cuc_ip` varchar(255) DEFAULT '',
  `cuc_ip_hex` varchar(255) DEFAULT NULL,
  `cuc_xff` varchar(255) CHARACTER SET latin1 COLLATE latin1_bin DEFAULT '',
  `cuc_xff_hex` varchar(255) DEFAULT NULL,
  `cuc_agent` varchar(255) CHARACTER SET latin1 COLLATE latin1_bin DEFAULT NULL,
  PRIMARY KEY (`cuc_id`),
  KEY `cuc_ip_hex_time` (`cuc_ip_hex`,`cuc_timestamp`),
  KEY `cuc_xff_hex_time` (`cuc_xff_hex`,`cuc_timestamp`),
  KEY `cuc_timestamp` (`cuc_timestamp`),
  KEY `cuc_user_ip_time` (`cuc_user`,`cuc_ip`,`cuc_timestamp`),
  KEY `cuc_user_time` (`cuc_user`,`cuc_timestamp`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `cu_log`
--

DROP TABLE IF EXISTS `cu_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cu_log` (
  `cul_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cul_timestamp` binary(14) NOT NULL,
  `cul_user` int(10) unsigned NOT NULL,
  `cul_user_text` varchar(255) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL,
  `cul_reason` varchar(255) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL,
  `cul_type` varbinary(30) NOT NULL,
  `cul_target_id` int(10) unsigned NOT NULL DEFAULT '0',
  `cul_target_text` blob NOT NULL,
  `cul_target_hex` varbinary(255) NOT NULL DEFAULT '',
  `cul_range_start` varbinary(255) NOT NULL DEFAULT '',
  `cul_range_end` varbinary(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`cul_id`),
  KEY `cul_timestamp` (`cul_timestamp`),
  KEY `cul_user` (`cul_user`,`cul_timestamp`),
  KEY `cul_type_target` (`cul_type`,`cul_target_id`,`cul_timestamp`),
  KEY `cul_target_hex` (`cul_target_hex`,`cul_timestamp`),
  KEY `cul_range_start` (`cul_range_start`,`cul_timestamp`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `dmca_request`
--

DROP TABLE IF EXISTS `dmca_request`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dmca_request` (
  `dmca_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `dmca_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `dmca_requestor_type` tinyint(3) unsigned NOT NULL,
  `dmca_fullname` varchar(255) NOT NULL,
  `dmca_email` varchar(255) NOT NULL,
  `dmca_address` varchar(1000) NOT NULL,
  `dmca_telephone` varchar(20) NOT NULL DEFAULT '',
  `dmca_original_urls` text NOT NULL,
  `dmca_infringing_urls` text NOT NULL,
  `dmca_comments` text NOT NULL,
  `dmca_signature` varchar(255) NOT NULL,
  `dmca_action_taken` varchar(7) DEFAULT NULL,
  `dmca_ce_id` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`dmca_id`),
  KEY `dmca_date` (`dmca_date`),
  KEY `dmca_email` (`dmca_email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `dumps`
--

DROP TABLE IF EXISTS `dumps`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dumps` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dump_wiki_id` int(9) NOT NULL,
  `dump_wiki_dbname` varchar(64) NOT NULL,
  `dump_wiki_url` varchar(255) NOT NULL,
  `dump_user_name` varchar(255) NOT NULL,
  `dump_hidden` enum('N','Y') DEFAULT 'N',
  `dump_closed` enum('N','Y') DEFAULT 'N',
  `dump_requested` datetime NOT NULL,
  `dump_completed` datetime DEFAULT NULL,
  `dump_hold` enum('N','Y') DEFAULT 'N',
  `dump_errors` text,
  `dump_compression` enum('gzip','7zip') NOT NULL DEFAULT 'gzip',
  PRIMARY KEY (`id`),
  KEY `dumps_ibfk_1` (`dump_wiki_id`),
  KEY `dumps_dump_requested_idx` (`dump_requested`),
  KEY `dumps_dump_completed_hold_idx` (`dump_completed`,`dump_hold`),
  CONSTRAINT `dumps_ibfk_1` FOREIGN KEY (`dump_wiki_id`) REFERENCES `city_list` (`city_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `external_user`
--

DROP TABLE IF EXISTS `external_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `external_user` (
  `eu_local_id` int(10) unsigned NOT NULL,
  `eu_external_id` varchar(255) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL,
  PRIMARY KEY (`eu_local_id`),
  UNIQUE KEY `eu_external_id` (`eu_external_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `externallinks`
--

DROP TABLE IF EXISTS `externallinks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `externallinks` (
  `el_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `el_from` int(8) unsigned NOT NULL DEFAULT '0',
  `el_to` blob NOT NULL,
  `el_index` blob NOT NULL,
  PRIMARY KEY (`el_id`),
  KEY `el_from` (`el_from`,`el_to`(40)),
  KEY `el_to` (`el_to`(60),`el_from`),
  KEY `el_index` (`el_index`(60))
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `filearchive`
--

DROP TABLE IF EXISTS `filearchive`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `filearchive` (
  `fa_id` int(11) NOT NULL AUTO_INCREMENT,
  `fa_name` varchar(255) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL DEFAULT '',
  `fa_archive_name` varchar(255) CHARACTER SET latin1 COLLATE latin1_bin DEFAULT '',
  `fa_storage_group` varchar(16) DEFAULT NULL,
  `fa_storage_key` varchar(64) CHARACTER SET latin1 COLLATE latin1_bin DEFAULT '',
  `fa_deleted_user` int(11) DEFAULT NULL,
  `fa_deleted_timestamp` char(14) CHARACTER SET latin1 COLLATE latin1_bin DEFAULT '',
  `fa_deleted_reason` text,
  `fa_size` int(8) unsigned DEFAULT '0',
  `fa_width` int(5) DEFAULT '0',
  `fa_height` int(5) DEFAULT '0',
  `fa_metadata` mediumblob,
  `fa_bits` int(3) DEFAULT '0',
  `fa_media_type` enum('UNKNOWN','BITMAP','DRAWING','AUDIO','VIDEO','MULTIMEDIA','OFFICE','TEXT','EXECUTABLE','ARCHIVE') DEFAULT NULL,
  `fa_major_mime` enum('unknown','application','audio','image','text','video','message','model','multipart') DEFAULT 'unknown',
  `fa_minor_mime` varbinary(100) DEFAULT 'unknown',
  `fa_description` tinyblob,
  `fa_user` int(5) unsigned DEFAULT '0',
  `fa_user_text` varchar(255) CHARACTER SET latin1 COLLATE latin1_bin DEFAULT '',
  `fa_timestamp` char(14) CHARACTER SET latin1 COLLATE latin1_bin DEFAULT '',
  `fa_deleted` tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`fa_id`),
  KEY `fa_name` (`fa_name`,`fa_timestamp`),
  KEY `fa_storage_group` (`fa_storage_group`,`fa_storage_key`),
  KEY `fa_deleted_timestamp` (`fa_deleted_timestamp`),
  KEY `fa_user_timestamp` (`fa_user_text`,`fa_timestamp`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `founder_emails_event`
--

DROP TABLE IF EXISTS `founder_emails_event`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `founder_emails_event` (
  `feev_id` int(11) NOT NULL AUTO_INCREMENT,
  `feev_wiki_id` int(11) NOT NULL,
  `feev_timestamp` varchar(14) DEFAULT NULL,
  `feev_type` varchar(32) DEFAULT NULL,
  `feev_data` blob NOT NULL,
  PRIMARY KEY (`feev_id`),
  KEY `feev_wiki_id` (`feev_wiki_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `founder_progress_bar_tasks`
--

DROP TABLE IF EXISTS `founder_progress_bar_tasks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `founder_progress_bar_tasks` (
  `wiki_id` int(10) NOT NULL,
  `task_id` int(10) NOT NULL,
  `task_count` int(10) DEFAULT '0',
  `task_completed` tinyint(1) NOT NULL DEFAULT '0',
  `task_skipped` tinyint(1) NOT NULL DEFAULT '0',
  `task_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`wiki_id`,`task_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `garbage_collector`
--

DROP TABLE IF EXISTS `garbage_collector`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `garbage_collector` (
  `gc_id` int(11) NOT NULL AUTO_INCREMENT,
  `gc_filename` varchar(285) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL DEFAULT '',
  `gc_timestamp` varchar(14) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL DEFAULT '',
  `gc_wiki_id` int(9) DEFAULT NULL,
  PRIMARY KEY (`gc_id`),
  KEY `gc_timestamp` (`gc_timestamp`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `global_watchlist`
--

DROP TABLE IF EXISTS `global_watchlist`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `global_watchlist` (
  `gwa_id` int(11) NOT NULL AUTO_INCREMENT,
  `gwa_user_id` int(11) DEFAULT NULL,
  `gwa_city_id` int(11) DEFAULT NULL,
  `gwa_namespace` int(11) DEFAULT NULL,
  `gwa_title` varchar(255) DEFAULT NULL,
  `gwa_rev_id` int(11) DEFAULT NULL,
  `gwa_timestamp` varchar(14) DEFAULT NULL,
  PRIMARY KEY (`gwa_id`),
  KEY `user_id` (`gwa_user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `image`
--

DROP TABLE IF EXISTS `image`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `image` (
  `img_name` varchar(255) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL DEFAULT '',
  `img_size` int(8) unsigned NOT NULL DEFAULT '0',
  `img_description` tinyblob NOT NULL,
  `img_user` int(5) unsigned NOT NULL DEFAULT '0',
  `img_user_text` varchar(255) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL DEFAULT '',
  `img_timestamp` varchar(14) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL DEFAULT '',
  `img_width` int(5) NOT NULL DEFAULT '0',
  `img_height` int(5) NOT NULL DEFAULT '0',
  `img_bits` int(5) NOT NULL DEFAULT '0',
  `img_metadata` mediumblob NOT NULL,
  `img_media_type` enum('UNKNOWN','BITMAP','DRAWING','AUDIO','VIDEO','MULTIMEDIA','OFFICE','TEXT','EXECUTABLE','ARCHIVE') DEFAULT NULL,
  `img_major_mime` enum('unknown','application','audio','image','text','video','message','model','multipart') NOT NULL DEFAULT 'unknown',
  `img_minor_mime` varbinary(100) NOT NULL DEFAULT 'unknown',
  `img_sha1` varbinary(32) NOT NULL DEFAULT '',
  PRIMARY KEY (`img_name`),
  KEY `img_size` (`img_size`),
  KEY `img_timestamp` (`img_timestamp`),
  KEY `img_sha1` (`img_sha1`),
  KEY `img_usertext_timestamp` (`img_user_text`,`img_timestamp`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `imagelinks`
--

DROP TABLE IF EXISTS `imagelinks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `imagelinks` (
  `il_from` int(8) unsigned NOT NULL DEFAULT '0',
  `il_to` varchar(255) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL DEFAULT '',
  UNIQUE KEY `il_from` (`il_from`,`il_to`),
  UNIQUE KEY `il_to` (`il_to`,`il_from`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ipblocks`
--

DROP TABLE IF EXISTS `ipblocks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ipblocks` (
  `ipb_id` int(8) NOT NULL AUTO_INCREMENT,
  `ipb_address` tinyblob NOT NULL,
  `ipb_user` int(8) unsigned NOT NULL DEFAULT '0',
  `ipb_by` int(8) unsigned NOT NULL DEFAULT '0',
  `ipb_reason` tinyblob NOT NULL,
  `ipb_timestamp` char(14) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL DEFAULT '',
  `ipb_auto` tinyint(1) NOT NULL DEFAULT '0',
  `ipb_anon_only` tinyint(1) NOT NULL DEFAULT '0',
  `ipb_create_account` tinyint(1) NOT NULL DEFAULT '1',
  `ipb_expiry` char(14) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL DEFAULT '',
  `ipb_range_start` tinyblob NOT NULL,
  `ipb_range_end` tinyblob NOT NULL,
  `ipb_enable_autoblock` tinyint(1) NOT NULL DEFAULT '1',
  `ipb_deleted` tinyint(1) NOT NULL DEFAULT '0',
  `ipb_block_email` tinyint(4) NOT NULL DEFAULT '0',
  `ipb_by_text` varchar(255) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL DEFAULT '',
  `ipb_allow_usertalk` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`ipb_id`),
  UNIQUE KEY `ipb_address_unique` (`ipb_address`(255),`ipb_user`,`ipb_auto`),
  KEY `ipb_user` (`ipb_user`),
  KEY `ipb_range` (`ipb_range_start`(8),`ipb_range_end`(8)),
  KEY `ipb_timestamp` (`ipb_timestamp`),
  KEY `ipb_expiry` (`ipb_expiry`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `iwlinks`
--

DROP TABLE IF EXISTS `iwlinks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `iwlinks` (
  `iwl_from` int(10) unsigned NOT NULL DEFAULT '0',
  `iwl_prefix` varbinary(20) NOT NULL DEFAULT '',
  `iwl_title` varchar(255) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL DEFAULT '',
  UNIQUE KEY `iwl_from` (`iwl_from`,`iwl_prefix`,`iwl_title`),
  UNIQUE KEY `iwl_prefix_title_from` (`iwl_prefix`,`iwl_title`,`iwl_from`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `jabstatus`
--

DROP TABLE IF EXISTS `jabstatus`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jabstatus` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `wikia` varchar(200) NOT NULL,
  `user` int(11) NOT NULL DEFAULT '0',
  `jid` varchar(50) NOT NULL,
  `status` varchar(10) NOT NULL,
  `presence` char(1) NOT NULL DEFAULT 'A',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `langlinks`
--

DROP TABLE IF EXISTS `langlinks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `langlinks` (
  `ll_from` int(8) unsigned NOT NULL DEFAULT '0',
  `ll_lang` varchar(10) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL DEFAULT '',
  `ll_title` varchar(255) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL DEFAULT '',
  UNIQUE KEY `ll_from` (`ll_from`,`ll_lang`),
  KEY `ll_lang` (`ll_lang`,`ll_title`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `link`
--

DROP TABLE IF EXISTS `link`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `link` (
  `link_id` int(11) NOT NULL AUTO_INCREMENT,
  `link_name` varchar(255) NOT NULL,
  `link_description` text NOT NULL,
  `link_page_id` int(11) NOT NULL DEFAULT '0',
  `link_url` text,
  `link_type` int(5) NOT NULL DEFAULT '0',
  `link_status` int(5) NOT NULL DEFAULT '0',
  `link_submitter_user_id` int(11) NOT NULL DEFAULT '0',
  `link_submitter_user_name` varchar(255) NOT NULL,
  `link_submit_date` datetime DEFAULT NULL,
  `link_approved_date` datetime DEFAULT NULL,
  PRIMARY KEY (`link_id`),
  KEY `link_approved_date` (`link_approved_date`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `links`
--

DROP TABLE IF EXISTS `links`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `links` (
  `l_from` int(8) unsigned NOT NULL DEFAULT '0',
  `l_to` int(8) unsigned NOT NULL DEFAULT '0',
  UNIQUE KEY `l_from` (`l_from`,`l_to`),
  KEY `l_to` (`l_to`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `locks`
--

DROP TABLE IF EXISTS `locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `locks` (
  `lock_id` int(11) NOT NULL AUTO_INCREMENT,
  `facility` varchar(255) NOT NULL,
  `host` varchar(255) NOT NULL,
  `process_id` int(11) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `reason` varchar(255) NOT NULL,
  PRIMARY KEY (`lock_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `log_search`
--

DROP TABLE IF EXISTS `log_search`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `log_search` (
  `ls_field` varbinary(32) NOT NULL,
  `ls_value` varchar(255) NOT NULL,
  `ls_log_id` int(10) unsigned NOT NULL DEFAULT '0',
  UNIQUE KEY `ls_field_val` (`ls_field`,`ls_value`,`ls_log_id`),
  KEY `ls_log_id` (`ls_log_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `logging`
--

DROP TABLE IF EXISTS `logging`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `logging` (
  `log_type` varbinary(32) NOT NULL,
  `log_action` varbinary(32) NOT NULL,
  `log_timestamp` varchar(14) NOT NULL DEFAULT '19700101000000',
  `log_user` int(10) unsigned NOT NULL DEFAULT '0',
  `log_namespace` int(11) NOT NULL,
  `log_title` varchar(255) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL DEFAULT '',
  `log_comment` varchar(255) NOT NULL DEFAULT '',
  `log_params` blob NOT NULL,
  `log_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `log_deleted` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `log_user_text` varchar(255) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL DEFAULT '',
  `log_page` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`log_id`),
  KEY `type_time` (`log_type`,`log_timestamp`),
  KEY `user_time` (`log_user`,`log_timestamp`),
  KEY `page_time` (`log_namespace`,`log_title`,`log_timestamp`),
  KEY `times` (`log_timestamp`),
  KEY `log_user_type_time` (`log_user`,`log_type`,`log_timestamp`),
  KEY `log_page_id_time` (`log_page`,`log_timestamp`),
  KEY `type_action` (`log_type`,`log_action`,`log_timestamp`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `math`
--

DROP TABLE IF EXISTS `math`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `math` (
  `math_inputhash` varchar(16) NOT NULL DEFAULT '',
  `math_outputhash` varchar(16) NOT NULL DEFAULT '',
  `math_html_conservativeness` tinyint(1) NOT NULL DEFAULT '0',
  `math_html` text,
  `math_mathml` text,
  UNIQUE KEY `math_inputhash` (`math_inputhash`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `messages_status`
--

DROP TABLE IF EXISTS `messages_status`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `messages_status` (
  `msg_wiki_id` int(9) unsigned NOT NULL DEFAULT '0',
  `msg_recipient_id` int(10) unsigned NOT NULL DEFAULT '0',
  `msg_id` int(7) unsigned NOT NULL,
  `msg_status` tinyint(4) NOT NULL,
  `msg_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`msg_wiki_id`,`msg_recipient_id`,`msg_id`),
  KEY `msg_recipient_msg_id` (`msg_recipient_id`,`msg_id`),
  KEY `msg_id` (`msg_id`),
  KEY `msg_date_wiki` (`msg_date`,`msg_wiki_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `messages_text`
--

DROP TABLE IF EXISTS `messages_text`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `messages_text` (
  `msg_id` int(7) unsigned NOT NULL AUTO_INCREMENT,
  `msg_sender_id` int(10) unsigned NOT NULL,
  `msg_text` mediumtext NOT NULL,
  `msg_mode` tinyint(4) NOT NULL DEFAULT '0',
  `msg_removed` tinyint(4) NOT NULL DEFAULT '0',
  `msg_expire` datetime DEFAULT NULL,
  `msg_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `msg_recipient_name` varchar(255) DEFAULT NULL,
  `msg_group_name` varchar(255) DEFAULT NULL,
  `msg_wiki_name` varchar(255) DEFAULT NULL,
  `msg_hub_id` int(9) DEFAULT NULL,
  `msg_cluster_id` int(9) DEFAULT NULL,
  `msg_lang` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`msg_id`),
  KEY `removed_mode_expire_date` (`msg_removed`,`msg_mode`,`msg_expire`,`msg_date`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `module_deps`
--

DROP TABLE IF EXISTS `module_deps`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `module_deps` (
  `md_module` varbinary(255) NOT NULL,
  `md_skin` varbinary(32) NOT NULL,
  `md_deps` mediumblob NOT NULL,
  UNIQUE KEY `md_module_skin` (`md_module`,`md_skin`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `msg_resource`
--

DROP TABLE IF EXISTS `msg_resource`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `msg_resource` (
  `mr_resource` varbinary(255) NOT NULL,
  `mr_lang` varbinary(32) NOT NULL,
  `mr_blob` mediumblob NOT NULL,
  `mr_timestamp` binary(14) NOT NULL,
  UNIQUE KEY `mr_resource_lang` (`mr_resource`,`mr_lang`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `msg_resource_links`
--

DROP TABLE IF EXISTS `msg_resource_links`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `msg_resource_links` (
  `mrl_resource` varbinary(255) NOT NULL,
  `mrl_message` varbinary(255) NOT NULL,
  UNIQUE KEY `mrl_message_resource` (`mrl_message`,`mrl_resource`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `notify_log`
--

DROP TABLE IF EXISTS `notify_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `notify_log` (
  `nl_id` int(11) NOT NULL AUTO_INCREMENT,
  `nl_type` char(32) NOT NULL,
  `nl_editor` int(6) NOT NULL,
  `nl_watcher` int(6) NOT NULL,
  `nl_title` varchar(255) NOT NULL,
  `nl_namespace` int(11) NOT NULL,
  `nl_timestamp` char(14) DEFAULT NULL,
  PRIMARY KEY (`nl_id`),
  KEY `nl_watcher` (`nl_watcher`),
  KEY `nl_editor` (`nl_editor`),
  KEY `nl_title` (`nl_title`,`nl_namespace`),
  KEY `nl_type` (`nl_type`,`nl_timestamp`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `oaiaudit`
--

DROP TABLE IF EXISTS `oaiaudit`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `oaiaudit` (
  `oa_client` int(11) DEFAULT NULL,
  `oa_timestamp` varchar(14) DEFAULT NULL,
  `oa_dbname` varchar(32) DEFAULT NULL,
  `oa_response_size` int(11) DEFAULT NULL,
  `oa_ip` varchar(32) DEFAULT NULL,
  `oa_agent` text,
  `oa_request` text,
  KEY `oa_client` (`oa_client`,`oa_timestamp`),
  KEY `oa_timestamp` (`oa_timestamp`,`oa_client`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `oaiuser`
--

DROP TABLE IF EXISTS `oaiuser`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `oaiuser` (
  `ou_id` int(11) NOT NULL AUTO_INCREMENT,
  `ou_name` varchar(255) DEFAULT NULL,
  `ou_password_hash` tinyblob,
  PRIMARY KEY (`ou_id`),
  UNIQUE KEY `ou_name` (`ou_name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `objectcache`
--

DROP TABLE IF EXISTS `objectcache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `objectcache` (
  `keyname` varchar(255) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL DEFAULT '',
  `value` mediumblob,
  `exptime` datetime DEFAULT NULL,
  UNIQUE KEY `keyname` (`keyname`),
  KEY `exptime` (`exptime`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `oldimage`
--

DROP TABLE IF EXISTS `oldimage`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `oldimage` (
  `oi_name` varchar(255) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL DEFAULT '',
  `oi_archive_name` varchar(255) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL DEFAULT '',
  `oi_size` int(8) unsigned NOT NULL DEFAULT '0',
  `oi_description` tinyblob NOT NULL,
  `oi_user` int(5) unsigned NOT NULL DEFAULT '0',
  `oi_user_text` varchar(255) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL DEFAULT '',
  `oi_timestamp` varchar(14) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL DEFAULT '',
  `oi_width` int(5) NOT NULL DEFAULT '0',
  `oi_height` int(5) NOT NULL DEFAULT '0',
  `oi_bits` int(3) NOT NULL DEFAULT '0',
  `oi_metadata` mediumblob NOT NULL,
  `oi_media_type` enum('UNKNOWN','BITMAP','DRAWING','AUDIO','VIDEO','MULTIMEDIA','OFFICE','TEXT','EXECUTABLE','ARCHIVE') DEFAULT NULL,
  `oi_major_mime` enum('unknown','application','audio','image','text','video','message','model','multipart') NOT NULL DEFAULT 'unknown',
  `oi_minor_mime` varbinary(100) NOT NULL DEFAULT 'unknown',
  `oi_deleted` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `oi_sha1` varbinary(32) NOT NULL DEFAULT '',
  KEY `oi_name_timestamp` (`oi_name`,`oi_timestamp`),
  KEY `oi_name_archive_name` (`oi_name`,`oi_archive_name`(14)),
  KEY `oi_sha1` (`oi_sha1`),
  KEY `oi_usertext_timestamp` (`oi_user_text`,`oi_timestamp`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `page`
--

DROP TABLE IF EXISTS `page`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `page` (
  `page_id` int(8) unsigned NOT NULL AUTO_INCREMENT,
  `page_namespace` int(11) NOT NULL,
  `page_title` varchar(255) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL,
  `page_restrictions` tinyblob NOT NULL,
  `page_counter` bigint(20) unsigned NOT NULL DEFAULT '0',
  `page_is_redirect` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `page_is_new` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `page_random` double unsigned NOT NULL,
  `page_touched` char(14) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL DEFAULT '',
  `page_latest` int(8) unsigned NOT NULL,
  `page_len` int(8) unsigned NOT NULL,
  PRIMARY KEY (`page_id`),
  UNIQUE KEY `name_title` (`page_namespace`,`page_title`),
  KEY `page_random` (`page_random`),
  KEY `page_len` (`page_len`),
  KEY `page_random_2` (`page_random`),
  KEY `page_redirect_namespace_len` (`page_is_redirect`,`page_namespace`,`page_len`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `page_props`
--

DROP TABLE IF EXISTS `page_props`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `page_props` (
  `pp_page` int(11) NOT NULL,
  `pp_propname` varbinary(60) NOT NULL,
  `pp_value` blob NOT NULL,
  PRIMARY KEY (`pp_page`,`pp_propname`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `page_restrictions`
--

DROP TABLE IF EXISTS `page_restrictions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `page_restrictions` (
  `pr_page` int(8) NOT NULL,
  `pr_type` varchar(255) NOT NULL,
  `pr_level` varchar(255) NOT NULL,
  `pr_cascade` tinyint(4) NOT NULL,
  `pr_user` int(8) DEFAULT NULL,
  `pr_expiry` char(14) CHARACTER SET latin1 COLLATE latin1_bin DEFAULT NULL,
  `pr_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`pr_page`,`pr_type`),
  UNIQUE KEY `pr_id` (`pr_id`),
  KEY `pr_page` (`pr_page`),
  KEY `pr_typelevel` (`pr_type`,`pr_level`),
  KEY `pr_level` (`pr_level`),
  KEY `pr_cascade` (`pr_cascade`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `page_visited`
--

DROP TABLE IF EXISTS `page_visited`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `page_visited` (
  `article_id` int(9) NOT NULL,
  `count` int(8) NOT NULL,
  `prev_diff` int(8) NOT NULL DEFAULT '0',
  PRIMARY KEY (`article_id`),
  KEY `page_visited_cnt_inx` (`count`),
  KEY `pv_changes` (`prev_diff`,`article_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `page_wikia_props`
--

DROP TABLE IF EXISTS `page_wikia_props`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `page_wikia_props` (
  `page_id` int(10) NOT NULL,
  `propname` int(10) NOT NULL,
  `props` blob NOT NULL,
  PRIMARY KEY (`page_id`,`propname`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `pagelinks`
--

DROP TABLE IF EXISTS `pagelinks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pagelinks` (
  `pl_from` int(8) unsigned NOT NULL DEFAULT '0',
  `pl_namespace` int(11) NOT NULL DEFAULT '0',
  `pl_title` varchar(255) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL DEFAULT '',
  UNIQUE KEY `pl_from` (`pl_from`,`pl_namespace`,`pl_title`),
  UNIQUE KEY `pl_namespace` (`pl_namespace`,`pl_title`,`pl_from`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `phalanx`
--

DROP TABLE IF EXISTS `phalanx`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `phalanx` (
  `p_id` int(6) unsigned NOT NULL AUTO_INCREMENT,
  `p_author_id` int(6) NOT NULL,
  `p_text` blob NOT NULL,
  `p_ip_hex` varchar(35) DEFAULT NULL,
  `p_type` smallint(1) unsigned NOT NULL,
  `p_timestamp` binary(14) NOT NULL DEFAULT '\0\0\0\0\0\0\0\0\0\0\0\0\0\0',
  `p_expire` binary(14) DEFAULT NULL,
  `p_exact` tinyint(1) NOT NULL DEFAULT '0',
  `p_regex` tinyint(1) NOT NULL DEFAULT '0',
  `p_case` tinyint(1) NOT NULL DEFAULT '0',
  `p_reason` tinyblob NOT NULL,
  `p_lang` varchar(10) DEFAULT NULL,
  `p_comment` tinyblob NOT NULL,
  PRIMARY KEY (`p_id`),
  KEY `p_ip_hex` (`p_ip_hex`),
  KEY `p_lang` (`p_lang`,`p_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `poll_info`
--

DROP TABLE IF EXISTS `poll_info`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `poll_info` (
  `poll_id` varchar(32) NOT NULL DEFAULT '',
  `poll_txt` text,
  `poll_date` datetime DEFAULT NULL,
  `poll_title` varchar(255) DEFAULT NULL,
  `poll_domain` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`poll_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `poll_message`
--

DROP TABLE IF EXISTS `poll_message`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `poll_message` (
  `poll_id` varchar(32) NOT NULL DEFAULT '',
  `poll_user` varchar(255) NOT NULL DEFAULT '',
  `poll_ip` varchar(255) DEFAULT NULL,
  `poll_msg` varchar(255) DEFAULT NULL,
  `poll_date` datetime DEFAULT NULL,
  PRIMARY KEY (`poll_id`,`poll_user`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `poll_vote`
--

DROP TABLE IF EXISTS `poll_vote`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `poll_vote` (
  `poll_id` varchar(32) NOT NULL DEFAULT '',
  `poll_user` varchar(255) NOT NULL DEFAULT '',
  `poll_ip` varchar(255) DEFAULT NULL,
  `poll_answer` int(3) DEFAULT NULL,
  `poll_date` datetime DEFAULT NULL,
  PRIMARY KEY (`poll_id`,`poll_user`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `profiling`
--

DROP TABLE IF EXISTS `profiling`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `profiling` (
  `pf_count` int(11) NOT NULL DEFAULT '0',
  `pf_time` float NOT NULL DEFAULT '0',
  `pf_name` varchar(255) NOT NULL DEFAULT '',
  `pf_server` varchar(30) NOT NULL DEFAULT '',
  `pf_memory` float NOT NULL DEFAULT '0',
  UNIQUE KEY `pf_name_server` (`pf_name`,`pf_server`)
) ENGINE=MEMORY DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `protected_titles`
--

DROP TABLE IF EXISTS `protected_titles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `protected_titles` (
  `pt_namespace` int(11) NOT NULL,
  `pt_title` varchar(255) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL,
  `pt_user` int(10) unsigned NOT NULL,
  `pt_reason` tinyblob,
  `pt_timestamp` binary(14) NOT NULL,
  `pt_expiry` varbinary(14) NOT NULL DEFAULT '',
  `pt_create_perm` varbinary(60) NOT NULL,
  PRIMARY KEY (`pt_namespace`,`pt_title`),
  KEY `pt_timestamp` (`pt_timestamp`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `querycache`
--

DROP TABLE IF EXISTS `querycache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `querycache` (
  `qc_type` char(32) NOT NULL DEFAULT '',
  `qc_value` int(5) unsigned NOT NULL DEFAULT '0',
  `qc_namespace` int(11) NOT NULL,
  `qc_title` char(255) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL DEFAULT '',
  KEY `qc_type` (`qc_type`,`qc_value`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `querycache_info`
--

DROP TABLE IF EXISTS `querycache_info`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `querycache_info` (
  `qci_type` varchar(32) NOT NULL DEFAULT '',
  `qci_timestamp` char(14) NOT NULL DEFAULT '19700101000000',
  UNIQUE KEY `qci_type` (`qci_type`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `querycachetwo`
--

DROP TABLE IF EXISTS `querycachetwo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `querycachetwo` (
  `qcc_type` char(32) NOT NULL,
  `qcc_value` int(5) unsigned NOT NULL DEFAULT '0',
  `qcc_namespace` int(11) NOT NULL DEFAULT '0',
  `qcc_title` char(255) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL DEFAULT '',
  `qcc_namespacetwo` int(11) NOT NULL DEFAULT '0',
  `qcc_titletwo` char(255) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL DEFAULT '',
  KEY `qcc_type` (`qcc_type`,`qcc_value`),
  KEY `qcc_title` (`qcc_type`,`qcc_namespace`,`qcc_title`),
  KEY `qcc_titletwo` (`qcc_type`,`qcc_namespacetwo`,`qcc_titletwo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `rank_entry`
--

DROP TABLE IF EXISTS `rank_entry`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rank_entry` (
  `ren_id` int(11) NOT NULL AUTO_INCREMENT,
  `ren_city_id` int(11) DEFAULT NULL,
  `ren_page_name` varchar(255) DEFAULT NULL,
  `ren_page_url` varchar(255) DEFAULT NULL,
  `ren_is_main_page` enum('0','1') DEFAULT '0',
  `ren_phrase` varchar(255) DEFAULT NULL,
  `ren_created` datetime DEFAULT NULL,
  PRIMARY KEY (`ren_id`),
  KEY `city_id` (`ren_city_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `rank_result`
--

DROP TABLE IF EXISTS `rank_result`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rank_result` (
  `rre_id` int(11) NOT NULL AUTO_INCREMENT,
  `rre_ren_id` int(11) DEFAULT NULL,
  `rre_engine` varchar(32) CHARACTER SET latin1 DEFAULT NULL,
  `rre_date` datetime DEFAULT NULL,
  `rre_rank` int(11) DEFAULT NULL,
  PRIMARY KEY (`rre_id`),
  KEY `entry_id` (`rre_ren_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `recentchanges`
--

DROP TABLE IF EXISTS `recentchanges`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `recentchanges` (
  `rc_id` int(8) NOT NULL AUTO_INCREMENT,
  `rc_timestamp` varchar(14) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL DEFAULT '',
  `rc_cur_time` varchar(14) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL DEFAULT '',
  `rc_user` int(10) unsigned NOT NULL DEFAULT '0',
  `rc_user_text` varchar(255) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL DEFAULT '',
  `rc_namespace` int(11) NOT NULL,
  `rc_title` varchar(255) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL DEFAULT '',
  `rc_comment` varchar(255) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL DEFAULT '',
  `rc_minor` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `rc_bot` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `rc_new` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `rc_cur_id` int(10) unsigned NOT NULL DEFAULT '0',
  `rc_this_oldid` int(10) unsigned NOT NULL DEFAULT '0',
  `rc_last_oldid` int(10) unsigned NOT NULL DEFAULT '0',
  `rc_type` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `rc_moved_to_ns` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `rc_moved_to_title` varchar(255) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL DEFAULT '',
  `rc_patrolled` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `rc_ip` varchar(15) NOT NULL DEFAULT '',
  `rc_old_len` int(10) DEFAULT NULL,
  `rc_new_len` int(10) DEFAULT NULL,
  `rc_deleted` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `rc_logid` int(10) unsigned NOT NULL DEFAULT '0',
  `rc_log_type` varbinary(255) DEFAULT NULL,
  `rc_log_action` varbinary(255) DEFAULT NULL,
  `rc_params` blob,
  PRIMARY KEY (`rc_id`),
  KEY `rc_timestamp` (`rc_timestamp`),
  KEY `rc_namespace_title` (`rc_namespace`,`rc_title`),
  KEY `rc_cur_id` (`rc_cur_id`),
  KEY `new_name_timestamp` (`rc_new`,`rc_namespace`,`rc_timestamp`),
  KEY `rc_ip` (`rc_ip`),
  KEY `rc_ns_usertext` (`rc_namespace`,`rc_user_text`),
  KEY `rc_user_text` (`rc_user_text`,`rc_timestamp`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `redirect`
--

DROP TABLE IF EXISTS `redirect`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `redirect` (
  `rd_from` int(8) unsigned NOT NULL DEFAULT '0',
  `rd_namespace` int(11) NOT NULL DEFAULT '0',
  `rd_title` varchar(255) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL DEFAULT '',
  `rd_interwiki` varchar(32) DEFAULT NULL,
  `rd_fragment` varchar(255) CHARACTER SET latin1 COLLATE latin1_bin DEFAULT NULL,
  PRIMARY KEY (`rd_from`),
  KEY `rd_ns_title` (`rd_namespace`,`rd_title`,`rd_from`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `revision`
--

DROP TABLE IF EXISTS `revision`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `revision` (
  `rev_id` int(8) unsigned NOT NULL AUTO_INCREMENT,
  `rev_page` int(8) unsigned NOT NULL,
  `rev_comment` tinyblob NOT NULL,
  `rev_user` int(5) unsigned NOT NULL DEFAULT '0',
  `rev_user_text` varchar(255) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL DEFAULT '',
  `rev_timestamp` char(14) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL DEFAULT '',
  `rev_minor_edit` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `rev_deleted` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `rev_text_id` int(8) unsigned NOT NULL,
  `rev_len` int(10) unsigned DEFAULT NULL,
  `rev_parent_id` int(10) unsigned DEFAULT NULL,
  `rev_sha1` varbinary(32) NOT NULL DEFAULT '',
  PRIMARY KEY (`rev_page`,`rev_id`),
  UNIQUE KEY `rev_id` (`rev_id`),
  KEY `rev_timestamp` (`rev_timestamp`),
  KEY `page_timestamp` (`rev_page`,`rev_timestamp`),
  KEY `user_timestamp` (`rev_user`,`rev_timestamp`),
  KEY `usertext_timestamp` (`rev_user_text`,`rev_timestamp`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `rollup_api_events`
--

DROP TABLE IF EXISTS `rollup_api_events`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rollup_api_events` (
  `period_id` smallint(5) unsigned NOT NULL,
  `time_id` datetime NOT NULL,
  `api_key` binary(16) NOT NULL,
  `api_type` varchar(255) NOT NULL DEFAULT '',
  `api_function` varchar(255) NOT NULL DEFAULT '',
  `ip` int(10) unsigned NOT NULL,
  `wiki_id` int(10) unsigned NOT NULL,
  `events` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`period_id`,`time_id`,`api_key`,`api_type`,`api_function`,`ip`,`wiki_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `share_feature`
--

DROP TABLE IF EXISTS `share_feature`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `share_feature` (
  `sf_user_id` int(5) unsigned NOT NULL,
  `sf_provider_id` int(2) unsigned NOT NULL,
  `sf_clickcount` int(11) DEFAULT '0',
  PRIMARY KEY (`sf_user_id`,`sf_provider_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `shared_newtalks`
--

DROP TABLE IF EXISTS `shared_newtalks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shared_newtalks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sn_user_id` int(5) unsigned DEFAULT NULL,
  `sn_user_ip` varchar(255) DEFAULT '',
  `sn_wiki` varchar(31) DEFAULT NULL,
  `sn_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `sn_user_id_sn_user_ip_sn_wiki_idx` (`sn_user_id`,`sn_user_ip`,`sn_wiki`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `shared_user_groups`
--

DROP TABLE IF EXISTS `shared_user_groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shared_user_groups` (
  `sug_user` int(5) unsigned NOT NULL DEFAULT '0',
  `sug_group` char(16) NOT NULL DEFAULT '',
  PRIMARY KEY (`sug_user`,`sug_group`),
  KEY `sug_group` (`sug_group`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `site_stats`
--

DROP TABLE IF EXISTS `site_stats`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `site_stats` (
  `ss_row_id` int(8) unsigned NOT NULL DEFAULT '0',
  `ss_total_views` bigint(20) unsigned DEFAULT '0',
  `ss_total_edits` bigint(20) unsigned DEFAULT '0',
  `ss_good_articles` bigint(20) unsigned DEFAULT '0',
  `ss_total_pages` bigint(20) DEFAULT '-1',
  `ss_users` bigint(20) DEFAULT '-1',
  `ss_admins` int(10) DEFAULT '-1',
  `ss_images` int(10) DEFAULT '0',
  `ss_active_users` bigint(20) DEFAULT '-1',
  UNIQUE KEY `ss_row_id` (`ss_row_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `spam_regex`
--

DROP TABLE IF EXISTS `spam_regex`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `spam_regex` (
  `spam_id` int(5) NOT NULL AUTO_INCREMENT,
  `spam_text` varchar(255) NOT NULL,
  `spam_timestamp` char(14) NOT NULL,
  `spam_user` varchar(255) NOT NULL,
  `spam_textbox` int(1) NOT NULL DEFAULT '1',
  `spam_summary` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`spam_id`),
  UNIQUE KEY `spam_text` (`spam_text`),
  KEY `spam_timestamp` (`spam_timestamp`),
  KEY `spam_user` (`spam_user`),
  KEY `spam_reges_idx` (`spam_summary`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `spoofuser`
--

DROP TABLE IF EXISTS `spoofuser`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `spoofuser` (
  `su_name` varchar(255) NOT NULL DEFAULT '',
  `su_normalized` varchar(255) DEFAULT NULL,
  `su_legal` tinyint(1) DEFAULT NULL,
  `su_error` text,
  `su_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`su_name`),
  KEY `su_normalized` (`su_normalized`,`su_name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `stats_blockedby`
--

DROP TABLE IF EXISTS `stats_blockedby`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `stats_blockedby` (
  `stats_id` int(8) NOT NULL AUTO_INCREMENT,
  `stats_user` varchar(255) CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL,
  `stats_blocker` varchar(255) CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL,
  `stats_timestamp` char(14) NOT NULL,
  `stats_ip` char(15) NOT NULL,
  `stats_match` varchar(255) CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL DEFAULT '',
  `stats_wiki` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`stats_id`),
  KEY `stats_timestamp` (`stats_timestamp`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `system_events`
--

DROP TABLE IF EXISTS `system_events`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `system_events` (
  `ev_id` int(7) unsigned NOT NULL AUTO_INCREMENT,
  `ev_name` varchar(255) NOT NULL,
  `ev_user_id` int(9) unsigned NOT NULL DEFAULT '0',
  `ev_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ev_desc` text NOT NULL,
  `ev_hook` varchar(255) NOT NULL,
  `ev_hook_values` mediumtext NOT NULL,
  `ev_active` tinyint(3) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ev_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `system_events_data`
--

DROP TABLE IF EXISTS `system_events_data`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `system_events_data` (
  `ed_id` int(7) unsigned NOT NULL AUTO_INCREMENT,
  `ed_city_id` int(7) unsigned NOT NULL,
  `ed_ev_id` int(7) unsigned NOT NULL DEFAULT '0',
  `ed_et_id` int(7) unsigned NOT NULL DEFAULT '0',
  `ed_user_id` int(9) unsigned NOT NULL DEFAULT '0',
  `ed_user_ip` varchar(20) NOT NULL DEFAULT '',
  `ed_field_id` varchar(255) DEFAULT '',
  `ed_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ed_id`),
  KEY `ed_city_id` (`ed_city_id`),
  KEY `ed_ev_id` (`ed_ev_id`,`ed_et_id`),
  KEY `ed_user_id` (`ed_user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `system_events_params`
--

DROP TABLE IF EXISTS `system_events_params`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `system_events_params` (
  `ep_id` int(7) unsigned NOT NULL AUTO_INCREMENT,
  `ep_name` varchar(100) NOT NULL DEFAULT '',
  `ep_value` varchar(100) NOT NULL DEFAULT '',
  `ep_desc` text,
  `ep_user_id` int(9) unsigned NOT NULL DEFAULT '0',
  `ep_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ep_active` tinyint(3) NOT NULL DEFAULT '1',
  PRIMARY KEY (`ep_id`),
  KEY `ep_user_id` (`ep_user_id`),
  KEY `system_events_params_active` (`ep_active`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `system_events_text`
--

DROP TABLE IF EXISTS `system_events_text`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `system_events_text` (
  `te_id` int(7) unsigned NOT NULL AUTO_INCREMENT,
  `te_ev_id` int(7) unsigned NOT NULL,
  `te_user_id` int(9) unsigned NOT NULL DEFAULT '0',
  `te_et_id` tinyint(3) NOT NULL DEFAULT '0',
  `te_title` mediumtext NOT NULL,
  `te_content` text NOT NULL,
  `te_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`te_id`),
  KEY `te_ev_id` (`te_ev_id`,`te_et_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `system_events_types`
--

DROP TABLE IF EXISTS `system_events_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `system_events_types` (
  `et_id` int(7) unsigned NOT NULL AUTO_INCREMENT,
  `et_name` varchar(255) NOT NULL,
  `et_user_id` int(9) unsigned NOT NULL DEFAULT '0',
  `et_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `et_desc` text NOT NULL,
  `et_active` tinyint(3) NOT NULL DEFAULT '1',
  PRIMARY KEY (`et_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `system_events_users`
--

DROP TABLE IF EXISTS `system_events_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `system_events_users` (
  `eu_id` int(7) unsigned NOT NULL AUTO_INCREMENT,
  `eu_city_id` int(7) unsigned NOT NULL,
  `eu_ev_id` int(7) unsigned NOT NULL DEFAULT '0',
  `eu_et_id` int(7) unsigned NOT NULL DEFAULT '0',
  `eu_user_id` int(9) unsigned NOT NULL DEFAULT '0',
  `eu_user_ip` varchar(20) NOT NULL DEFAULT '',
  `eu_visible_count` int(5) DEFAULT '0',
  `eu_active` int(5) DEFAULT '1',
  `eu_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`eu_id`),
  KEY `eu_city_id` (`eu_city_id`),
  KEY `eu_ev_id` (`eu_ev_id`,`eu_et_id`),
  KEY `eu_user_id` (`eu_user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `t_city_ads`
--

DROP TABLE IF EXISTS `t_city_ads`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_city_ads` (
  `r` int(11) NOT NULL AUTO_INCREMENT,
  `city_id` mediumint(9) NOT NULL,
  `ad_skin` varchar(15) NOT NULL DEFAULT 'monaco',
  `ad_lang` char(2) NOT NULL DEFAULT '',
  `ad_cat` char(4) NOT NULL DEFAULT '',
  `ad_pos` varchar(15) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `ad_zone` mediumint(9) NOT NULL,
  `ad_server` char(1) NOT NULL DEFAULT 'L',
  `comment` varchar(255) NOT NULL DEFAULT '',
  `dbname` varchar(255) NOT NULL DEFAULT '',
  `ad_keywords` varchar(255) NOT NULL DEFAULT '',
  `domain` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`r`),
  UNIQUE KEY `mainidx` (`city_id`,`ad_skin`,`ad_lang`,`ad_cat`,`ad_pos`) USING BTREE,
  KEY `lookupidx` (`city_id`,`ad_skin`),
  KEY `cityidx` (`city_id`),
  KEY `zoneidx` (`ad_zone`),
  KEY `posidx` (`ad_pos`),
  KEY `langidx` (`ad_lang`),
  KEY `skinidx` (`ad_skin`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `t_city_ads_backup`
--

DROP TABLE IF EXISTS `t_city_ads_backup`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_city_ads_backup` (
  `r` int(11) NOT NULL AUTO_INCREMENT,
  `city_id` mediumint(9) NOT NULL,
  `ad_skin` varchar(15) NOT NULL DEFAULT 'monaco',
  `ad_lang` char(2) NOT NULL DEFAULT '',
  `ad_cat` char(4) NOT NULL DEFAULT '',
  `ad_pos` varchar(15) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `ad_zone` mediumint(9) NOT NULL,
  `ad_server` char(1) NOT NULL DEFAULT 'L',
  `comment` varchar(255) NOT NULL DEFAULT '',
  `dbname` varchar(255) NOT NULL DEFAULT '',
  `ad_keywords` varchar(255) NOT NULL DEFAULT '',
  `domain` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`r`),
  UNIQUE KEY `mainidx` (`city_id`,`ad_skin`,`ad_lang`,`ad_cat`,`ad_pos`) USING BTREE,
  KEY `lookupidx` (`city_id`,`ad_skin`),
  KEY `cityidx` (`city_id`),
  KEY `zoneidx` (`ad_zone`),
  KEY `posidx` (`ad_pos`),
  KEY `langidx` (`ad_lang`),
  KEY `skinidx` (`ad_skin`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `t_city_cat_mapping`
--

DROP TABLE IF EXISTS `t_city_cat_mapping`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_city_cat_mapping` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `city_id` int(11) DEFAULT NULL,
  `cat_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `city_id_idx` (`city_id`),
  KEY `cat_id_idx` (`cat_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `t_city_cats`
--

DROP TABLE IF EXISTS `t_city_cats`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_city_cats` (
  `cat_id` int(9) NOT NULL AUTO_INCREMENT,
  `cat_name` varchar(255) DEFAULT NULL,
  `cat_url` text,
  PRIMARY KEY (`cat_id`),
  KEY `cat_name_idx` (`cat_name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `t_city_domains`
--

DROP TABLE IF EXISTS `t_city_domains`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_city_domains` (
  `city_id` int(10) unsigned NOT NULL,
  `city_domain` varchar(255) NOT NULL DEFAULT 'wikia.com',
  PRIMARY KEY (`city_id`,`city_domain`),
  UNIQUE KEY `city_domains_idx_uniq` (`city_domain`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `t_city_list`
--

DROP TABLE IF EXISTS `t_city_list`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_city_list` (
  `city_id` int(9) NOT NULL AUTO_INCREMENT,
  `city_path` varchar(255) NOT NULL DEFAULT '/home/wikicities/cities/notreal',
  `city_dbname` varchar(31) NOT NULL DEFAULT 'notreal',
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
  `city_lang` varchar(7) NOT NULL DEFAULT 'en',
  `city_special_config` text,
  `city_umbrella` varchar(255) DEFAULT NULL,
  `city_ip` varchar(256) NOT NULL DEFAULT '/usr/wikia/source/wiki',
  `city_google_analytics` varchar(100) DEFAULT '',
  `city_google_search` varchar(100) DEFAULT '',
  `city_google_maps` varchar(100) DEFAULT '',
  `city_indexed_rev` int(8) unsigned NOT NULL DEFAULT '1',
  `city_deleted_timestamp` varchar(14) DEFAULT '19700101000000',
  `city_factory_timestamp` varchar(14) DEFAULT '19700101000000',
  `city_useshared` tinyint(1) DEFAULT '1',
  `ad_cat` char(4) NOT NULL DEFAULT '',
  PRIMARY KEY (`city_id`),
  KEY `city_dbname_idx` (`city_dbname`),
  KEY `titleidx` (`city_title`),
  KEY `dbnameidx` (`city_dbname`),
  KEY `urlidx` (`city_url`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tag_summary`
--

DROP TABLE IF EXISTS `tag_summary`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tag_summary` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ts_rc_id` int(11) DEFAULT NULL,
  `ts_log_id` int(11) DEFAULT NULL,
  `ts_rev_id` int(11) DEFAULT NULL,
  `ts_tags` blob NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `tag_summary_rc_id` (`ts_rc_id`),
  UNIQUE KEY `tag_summary_log_id` (`ts_log_id`),
  UNIQUE KEY `tag_summary_rev_id` (`ts_rev_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `templatelinks`
--

DROP TABLE IF EXISTS `templatelinks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `templatelinks` (
  `tl_from` int(8) unsigned NOT NULL DEFAULT '0',
  `tl_namespace` int(11) NOT NULL DEFAULT '0',
  `tl_title` varchar(255) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL DEFAULT '',
  UNIQUE KEY `tl_from` (`tl_from`,`tl_namespace`,`tl_title`),
  UNIQUE KEY `tl_namespace` (`tl_namespace`,`tl_title`,`tl_from`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `text`
--

DROP TABLE IF EXISTS `text`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `text` (
  `old_id` int(8) unsigned NOT NULL AUTO_INCREMENT,
  `old_namespace` tinyint(2) unsigned NOT NULL DEFAULT '0',
  `old_title` varchar(255) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL DEFAULT '',
  `old_text` mediumtext NOT NULL,
  `old_comment` tinyblob NOT NULL,
  `old_user` int(5) unsigned NOT NULL DEFAULT '0',
  `old_user_text` varchar(255) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL DEFAULT '',
  `old_timestamp` varchar(14) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL DEFAULT '',
  `old_minor_edit` tinyint(1) NOT NULL DEFAULT '0',
  `old_flags` tinyblob NOT NULL,
  `inverse_timestamp` varchar(14) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL DEFAULT '',
  PRIMARY KEY (`old_id`),
  KEY `old_timestamp` (`old_timestamp`),
  KEY `name_title_timestamp` (`old_namespace`,`old_title`,`inverse_timestamp`),
  KEY `user_timestamp` (`old_user`,`inverse_timestamp`),
  KEY `usertext_timestamp` (`old_user_text`,`inverse_timestamp`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `treatment_groups`
--

DROP TABLE IF EXISTS `treatment_groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `treatment_groups` (
  `id` int(11) NOT NULL,
  `experiment_id` int(11) NOT NULL,
  `experiment_version` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `is_control` tinyint(1) DEFAULT NULL,
  `percentage` tinyint(3) unsigned DEFAULT NULL,
  `ranges` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`experiment_id`,`experiment_version`,`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `updatelog`
--

DROP TABLE IF EXISTS `updatelog`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `updatelog` (
  `ul_key` varchar(255) NOT NULL,
  `ul_value` blob,
  PRIMARY KEY (`ul_key`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `uploadstash`
--

DROP TABLE IF EXISTS `uploadstash`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `uploadstash` (
  `us_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `us_user` int(10) unsigned NOT NULL,
  `us_key` varchar(255) NOT NULL,
  `us_orig_path` varchar(255) NOT NULL,
  `us_path` varchar(255) NOT NULL,
  `us_source_type` varchar(50) DEFAULT NULL,
  `us_timestamp` varbinary(14) NOT NULL,
  `us_status` varchar(50) NOT NULL,
  `us_size` int(10) unsigned NOT NULL,
  `us_sha1` varchar(31) NOT NULL,
  `us_mime` varchar(255) DEFAULT NULL,
  `us_media_type` enum('UNKNOWN','BITMAP','DRAWING','AUDIO','VIDEO','MULTIMEDIA','OFFICE','TEXT','EXECUTABLE','ARCHIVE') DEFAULT NULL,
  `us_image_width` int(10) unsigned DEFAULT NULL,
  `us_image_height` int(10) unsigned DEFAULT NULL,
  `us_image_bits` smallint(5) unsigned DEFAULT NULL,
  `us_chunk_inx` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`us_id`),
  UNIQUE KEY `us_key` (`us_key`),
  KEY `us_user` (`us_user`),
  KEY `us_timestamp` (`us_timestamp`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `user_id` int(5) unsigned NOT NULL AUTO_INCREMENT,
  `user_name` varchar(255) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL DEFAULT '',
  `user_real_name` varchar(255) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL DEFAULT '',
  `user_password` tinyblob NOT NULL,
  `user_newpassword` tinyblob NOT NULL,
  `user_email` tinytext NOT NULL,
  `user_touched` char(14) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL DEFAULT '',
  `user_token` char(32) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL DEFAULT '',
  `user_email_authenticated` char(14) CHARACTER SET latin1 COLLATE latin1_bin DEFAULT NULL,
  `user_email_token` char(32) CHARACTER SET latin1 COLLATE latin1_bin DEFAULT NULL,
  `user_email_token_expires` char(14) CHARACTER SET latin1 COLLATE latin1_bin DEFAULT NULL,
  `user_registration` varchar(16) DEFAULT NULL,
  `user_newpass_time` char(14) DEFAULT NULL,
  `user_editcount` int(11) DEFAULT NULL,
  `user_birthdate` date DEFAULT NULL,
  `user_options` blob NOT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `user_name` (`user_name`),
  KEY `user_email_token` (`user_email_token`),
  KEY `user_email` (`user_email`(40))
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `user_email_log`
--

DROP TABLE IF EXISTS `user_email_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_email_log` (
  `el_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `old_email` tinytext NOT NULL,
  `new_email` tinytext NOT NULL,
  `changed_by_id` int(10) unsigned NOT NULL,
  `changed_by_ip` char(40) NOT NULL,
  `changed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`el_id`),
  KEY `user_id` (`user_id`,`old_email`(40)),
  KEY `user_id_2` (`user_id`,`new_email`(40))
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `user_fbconnect`
--

DROP TABLE IF EXISTS `user_fbconnect`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_fbconnect` (
  `el_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_fbid` bigint(20) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_fb_app_id` bigint(20) DEFAULT '0',
  `user_fb_biz_token` varchar(255) DEFAULT '',
  PRIMARY KEY (`el_id`),
  UNIQUE KEY `user_id` (`user_id`,`user_fb_app_id`),
  UNIQUE KEY `user_fbid` (`user_fbid`,`user_fb_app_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `user_former_groups`
--

DROP TABLE IF EXISTS `user_former_groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_former_groups` (
  `ufg_user` int(10) unsigned NOT NULL DEFAULT '0',
  `ufg_group` varbinary(32) NOT NULL DEFAULT '',
  UNIQUE KEY `ufg_user_group` (`ufg_user`,`ufg_group`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `user_groups`
--

DROP TABLE IF EXISTS `user_groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_groups` (
  `ug_user` int(5) unsigned NOT NULL DEFAULT '0',
  `ug_group` varbinary(32) NOT NULL DEFAULT '',
  PRIMARY KEY (`ug_user`,`ug_group`),
  KEY `ug_group` (`ug_group`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `user_helios`
--

DROP TABLE IF EXISTS `user_helios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_helios` (
  `user_id` int(5) unsigned NOT NULL AUTO_INCREMENT,
  `user_name` varchar(255) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL DEFAULT '',
  `user_real_name` varchar(255) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL DEFAULT '',
  `user_password` tinyblob NOT NULL,
  `user_newpassword` tinyblob NOT NULL,
  `user_email` tinytext NOT NULL,
  `user_touched` char(14) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL DEFAULT '',
  `user_token` char(32) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL DEFAULT '',
  `user_email_authenticated` char(14) CHARACTER SET latin1 COLLATE latin1_bin DEFAULT NULL,
  `user_email_token` char(32) CHARACTER SET latin1 COLLATE latin1_bin DEFAULT NULL,
  `user_email_token_expires` char(14) CHARACTER SET latin1 COLLATE latin1_bin DEFAULT NULL,
  `user_registration` varchar(16) DEFAULT NULL,
  `user_newpass_time` char(14) DEFAULT NULL,
  `user_editcount` int(11) DEFAULT NULL,
  `user_birthdate` date DEFAULT NULL,
  `user_options` blob NOT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `user_name` (`user_name`),
  KEY `user_email_token` (`user_email_token`),
  KEY `user_email` (`user_email`(40))
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `user_interview_answers`
--

DROP TABLE IF EXISTS `user_interview_answers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_interview_answers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `wiki_id` int(11) DEFAULT NULL,
  `question_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `question` blob,
  `answer` blob,
  `date_set` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `user_interview_questions`
--

DROP TABLE IF EXISTS `user_interview_questions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_interview_questions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `wiki_id` int(11) DEFAULT NULL,
  `question` mediumblob,
  `date_set` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `user_mailing_list`
--

DROP TABLE IF EXISTS `user_mailing_list`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_mailing_list` (
  `um_id` int(11) NOT NULL AUTO_INCREMENT,
  `um_user_id` int(11) NOT NULL DEFAULT '0',
  `um_user_name` varchar(255) NOT NULL,
  `um_type` int(11) NOT NULL DEFAULT '0',
  `um_status` int(11) NOT NULL DEFAULT '0',
  `um_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`um_id`),
  KEY `um_user_id` (`um_user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `user_mssgstatus`
--

DROP TABLE IF EXISTS `user_mssgstatus`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_mssgstatus` (
  `user_id` int(5) NOT NULL,
  `user_ip` varchar(40) NOT NULL DEFAULT '0',
  `user_mssg_id` int(11) NOT NULL DEFAULT '0',
  `user_mssg_status` smallint(6) NOT NULL,
  `user_mssg_timestamp` int(11) NOT NULL,
  PRIMARY KEY (`user_id`,`user_ip`,`user_mssg_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `user_mssgtext`
--

DROP TABLE IF EXISTS `user_mssgtext`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_mssgtext` (
  `mssg_id` mediumint(9) NOT NULL AUTO_INCREMENT,
  `mssg_name` varchar(255) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL,
  `mssg_lang` varchar(10) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL,
  `mssg_avail` tinyint(1) NOT NULL DEFAULT '1',
  `mssg_text` mediumtext CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `mssg_comment` varchar(255) CHARACTER SET latin1 COLLATE latin1_bin DEFAULT NULL,
  PRIMARY KEY (`mssg_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `user_properties`
--

DROP TABLE IF EXISTS `user_properties`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_properties` (
  `up_user` int(11) NOT NULL,
  `up_property` varbinary(255) DEFAULT NULL,
  `up_value` blob,
  UNIQUE KEY `user_properties_user_property` (`up_user`,`up_property`),
  KEY `user_properties_property` (`up_property`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `uw_campaigns`
--

DROP TABLE IF EXISTS `uw_campaigns`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `uw_campaigns` (
  `campaign_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `campaign_name` varchar(255) NOT NULL,
  `campaign_enabled` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`campaign_id`),
  UNIQUE KEY `uw_campaigns_name` (`campaign_name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `valid_tag`
--

DROP TABLE IF EXISTS `valid_tag`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `valid_tag` (
  `vt_tag` varchar(255) NOT NULL,
  PRIMARY KEY (`vt_tag`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `watchlist`
--

DROP TABLE IF EXISTS `watchlist`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `watchlist` (
  `el_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `wl_user` int(5) unsigned NOT NULL DEFAULT '0',
  `wl_namespace` int(11) NOT NULL,
  `wl_title` varchar(255) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL DEFAULT '',
  `wl_notificationtimestamp` varchar(14) CHARACTER SET latin1 COLLATE latin1_bin DEFAULT NULL,
  `wl_wikia_addedtimestamp` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`el_id`),
  UNIQUE KEY `wl_user` (`wl_user`,`wl_namespace`,`wl_title`),
  KEY `namespace_title` (`wl_namespace`,`wl_title`),
  KEY `wl_wikia_addedtimestamp` (`wl_wikia_addedtimestamp`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `webmaster_sitemaps`
--

DROP TABLE IF EXISTS `webmaster_sitemaps`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `webmaster_sitemaps` (
  `wiki_id` int(9) unsigned NOT NULL DEFAULT '0',
  `user_id` smallint(5) unsigned DEFAULT NULL,
  `upload_date` date DEFAULT NULL,
  `page_count` int(7) DEFAULT NULL,
  PRIMARY KEY (`wiki_id`),
  KEY `user_count` (`user_id`,`page_count`),
  KEY `date_inx` (`upload_date`),
  CONSTRAINT `fk_webmaster_user_accounts` FOREIGN KEY (`user_id`) REFERENCES `webmaster_user_accounts` (`user_id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `webmaster_user_accounts`
--

DROP TABLE IF EXISTS `webmaster_user_accounts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `webmaster_user_accounts` (
  `user_id` smallint(5) unsigned NOT NULL DEFAULT '0',
  `user_name` varchar(255) DEFAULT NULL,
  `user_password` tinyblob,
  `wikis_number` smallint(5) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `widgets_extra`
--

DROP TABLE IF EXISTS `widgets_extra`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `widgets_extra` (
  `we_id` int(11) NOT NULL AUTO_INCREMENT,
  `we_widget_id` int(11) NOT NULL,
  `we_name` varchar(32) NOT NULL,
  `we_value` mediumtext NOT NULL,
  `we_blocked` int(11) NOT NULL,
  PRIMARY KEY (`we_id`),
  KEY `we_widget_id_idx` (`we_widget_id`),
  KEY `we_blocked_idx` (`we_blocked`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `wikia_homepage_collections`
--

DROP TABLE IF EXISTS `wikia_homepage_collections`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wikia_homepage_collections` (
  `id` int(8) unsigned NOT NULL AUTO_INCREMENT,
  `lang_code` varchar(8) NOT NULL,
  `sort` tinyint(2) unsigned NOT NULL DEFAULT '0',
  `name` varchar(255) NOT NULL,
  `sponsor_hero_image` varchar(255) DEFAULT NULL,
  `sponsor_image` varchar(255) DEFAULT NULL,
  `sponsor_url` varchar(255) DEFAULT NULL,
  `enabled` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `lang_code` (`lang_code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `wikia_homepage_collections_city_visualization`
--

DROP TABLE IF EXISTS `wikia_homepage_collections_city_visualization`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wikia_homepage_collections_city_visualization` (
  `collection_id` int(10) unsigned NOT NULL,
  `city_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`city_id`,`collection_id`),
  KEY `fk_wikia_homepage_collections` (`collection_id`),
  CONSTRAINT `fk_wikia_homepage_collections` FOREIGN KEY (`collection_id`) REFERENCES `wikia_homepage_collections` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `wikia_hub_modules`
--

DROP TABLE IF EXISTS `wikia_hub_modules`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wikia_hub_modules` (
  `city_id` int(11) NOT NULL DEFAULT '0',
  `lang_code` varchar(8) NOT NULL,
  `vertical_id` tinyint(4) NOT NULL,
  `hub_date` date NOT NULL,
  `module_id` tinyint(4) NOT NULL,
  `module_data` blob,
  `module_status` tinyint(4) NOT NULL DEFAULT '1',
  `last_editor_id` int(11) DEFAULT NULL,
  `last_edit_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`lang_code`,`vertical_id`,`hub_date`,`module_id`,`city_id`),
  KEY `by_city_id` (`city_id`,`hub_date`,`module_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `wikia_page_backlinks`
--

DROP TABLE IF EXISTS `wikia_page_backlinks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wikia_page_backlinks` (
  `source_page_id` int(11) NOT NULL,
  `target_page_id` int(11) NOT NULL,
  `backlink_text` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `count` int(11) DEFAULT NULL,
  PRIMARY KEY (`source_page_id`,`target_page_id`,`backlink_text`),
  KEY `wikia_page_backlinks_source_page_id` (`source_page_id`),
  KEY `wikia_page_backlinks_target_page_id` (`target_page_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `wikia_tasks`
--

DROP TABLE IF EXISTS `wikia_tasks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wikia_tasks` (
  `task_id` int(11) NOT NULL AUTO_INCREMENT,
  `task_user_id` int(5) unsigned NOT NULL DEFAULT '0',
  `task_type` varchar(255) NOT NULL DEFAULT '',
  `task_priority` tinyint(4) NOT NULL DEFAULT '0',
  `task_status` tinyint(4) NOT NULL DEFAULT '0',
  `task_started` char(14) NOT NULL,
  `task_finished` char(14) NOT NULL,
  `task_arguments` text,
  `task_log` text,
  `task_added` char(14) NOT NULL,
  PRIMARY KEY (`task_id`),
  KEY `task_added_idx` (`task_added`),
  KEY `task_status` (`task_status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `wikia_tasks_log`
--

DROP TABLE IF EXISTS `wikia_tasks_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wikia_tasks_log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `task_id` int(11) NOT NULL,
  `log_timestamp` char(14) NOT NULL,
  `log_line` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `new_fk_constraint` (`task_id`),
  CONSTRAINT `new_fk_constraint` FOREIGN KEY (`task_id`) REFERENCES `wikia_tasks` (`task_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-04-18 11:30:19