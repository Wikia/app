-- MySQL dump 10.13  Distrib 5.1.32, for unknown-linux-gnu (x86_64)
--
-- Host: 10.8.2.198    Database: dataware
-- ------------------------------------------------------
-- Server version	5.0.56sp1-enterprise-gpl-log

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
-- Not dumping tablespaces as no INFORMATION_SCHEMA.FILES table on this server
--

--
-- Table structure for table `_ext_changes_xml`
--

SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE IF NOT EXISTS `_ext_changes_xml` (
  `id` bigint(20) NOT NULL auto_increment,
  `title` varchar(100) default NULL,
  `url` varchar(200) default NULL,
  `timestamp` bigint(20) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `blobs`
--

SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE IF NOT EXISTS `blobs` (
  `blob_id` int(10) NOT NULL auto_increment,
  `rev_wikia_id` int(8) unsigned NOT NULL,
  `rev_id` int(10) unsigned default NULL,
  `rev_page_id` int(10) unsigned NOT NULL,
  `rev_namespace` int(10) unsigned NOT NULL default '0',
  `rev_user` int(10) unsigned NOT NULL default '0',
  `rev_user_text` varchar(255) character set latin1 collate latin1_bin NOT NULL default '',
  `rev_timestamp` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `blob_text` mediumtext NOT NULL,
  `rev_flags` tinyblob,
  `rev_ip` int(10) unsigned default NULL,
  PRIMARY KEY  (`blob_id`),
  KEY `rev_page_id` (`rev_wikia_id`,`rev_page_id`,`rev_id`),
  KEY `rev_namespace` (`rev_wikia_id`,`rev_page_id`,`rev_namespace`),
  KEY `rev_user` (`rev_wikia_id`,`rev_user`,`rev_timestamp`),
  KEY `rev_user_text` (`rev_wikia_id`,`rev_user_text`,`rev_timestamp`),
  KEY `blobs_rev_timestamp` (`rev_timestamp`),
  KEY `rev_ip` (`rev_ip`)
) ENGINE=InnoDB AUTO_INCREMENT=97929383 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `city_local_users`
--

SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE IF NOT EXISTS `city_local_users` (
  `lu_wikia_id` int(8) unsigned NOT NULL,
  `lu_user_id` int(10) unsigned NOT NULL,
  `lu_user_name` varchar(255) NOT NULL default '',
  `lu_numgroups` int(10) unsigned NOT NULL default '0',
  `lu_singlegroup` char(16) default '',
  `lu_allgroups` mediumtext,
  `lu_rev_cnt` int(11) unsigned NOT NULL default '0',
  `lu_blocked` int(1) unsigned NOT NULL default '0',
  `lu_closed` int(1) unsigned NOT NULL default '0',
  PRIMARY KEY  (`lu_wikia_id`,`lu_user_id`,`lu_user_name`),
  KEY `lu_wikia_id` (`lu_wikia_id`),
  KEY `lu_user_name_inx` (`lu_user_name`),
  KEY `lu_user_name` (`lu_user_id`,`lu_user_name`),
  KEY `lu_rev_cnt` (`lu_rev_cnt`,`lu_user_id`),
  KEY `lu_blocked` (`lu_blocked`,`lu_user_id`),
  KEY `lu_closed` (`lu_closed`,`lu_user_id`),
  KEY `lu_singlegroup` (`lu_wikia_id`,`lu_singlegroup`),
  KEY `lu_allgroups` (`lu_allgroups`(200)),
  KEY `lu_wikia_rev_cnt` (`lu_wikia_id`,`lu_rev_cnt`,`lu_user_id`),
  KEY `lu_user_id` (`lu_wikia_id`,`lu_user_id`),
  KEY `lu_user_cnt` (`lu_user_id`,`lu_rev_cnt`,`lu_wikia_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `daemon_tasks`
--

SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE IF NOT EXISTS `daemon_tasks` (
  `dt_id` int(10) unsigned NOT NULL auto_increment,
  `dt_name` varbinary(100) NOT NULL,
  `dt_script` varbinary(100) NOT NULL,
  `dt_desc` tinyblob NOT NULL,
  `dt_input_params` blob NOT NULL,
  `dt_value_type` int(10) unsigned NOT NULL default '1',
  `dt_addedby` int(10) unsigned NOT NULL,
  `dt_visible` int(1) unsigned NOT NULL default '1',
  `dt_added` char(14) NOT NULL default '',
  PRIMARY KEY  (`dt_id`),
  UNIQUE KEY `dt_name` (`dt_name`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `daemon_tasks_jobs`
--

SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE IF NOT EXISTS `daemon_tasks_jobs` (
  `dj_id` int(10) unsigned NOT NULL auto_increment,
  `dj_dt_id` int(10) unsigned NOT NULL,
  `dj_start` char(14) NOT NULL default '',
  `dj_end` char(14) NOT NULL default '',
  `dj_frequency` enum('day','week','month') NOT NULL default 'day',
  `dj_visible` tinyint(1) default '1',
  `dj_param_values` blob NOT NULL,
  `dj_result_file` text,
  `dj_result_emails` text,
  `dj_createdby` int(10) unsigned NOT NULL default '0',
  `dj_added` char(14) NOT NULL default '',
  PRIMARY KEY  (`dj_id`),
  KEY `dj_dt_id` (`dj_dt_id`),
  KEY `visible` (`dj_visible`),
  KEY `period` (`dj_start`,`dj_end`),
  KEY `frequency` (`dj_frequency`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `email_types`
--

SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE IF NOT EXISTS `email_types` (
  `id` tinyint(3) unsigned NOT NULL,
  `type` varchar(64) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `emails`
--

SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE IF NOT EXISTS `emails` (
  `send_date` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  `send_from` tinytext NOT NULL,
  `send_to` tinytext NOT NULL,
  `user_id` int(5) unsigned NOT NULL,
  `city_id` int(9) unsigned NOT NULL,
  `success` tinyint(3) unsigned NOT NULL,
  `failure_reason` tinytext,
  `type_id` tinyint(3) unsigned default NULL,
  KEY `emails_send_to` (`send_to`(255)),
  KEY `emails_send_date` (`send_date`),
  KEY `emails_user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `eye2`
--

SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE IF NOT EXISTS `eye2` (
  `cookie` varchar(32) default NULL,
  `city_id` int(11) default NULL,
  `id` varchar(32) default NULL,
  `page` varchar(255) default NULL,
  `timestamp` varchar(14) default NULL,
  `user` int(11) default NULL,
  `user_text` varchar(255) default NULL,
  KEY `eye2_cookie` (`cookie`),
  KEY `eye2_all` (`cookie`,`city_id`,`id`,`page`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `global_watchlist`
--

SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE IF NOT EXISTS `global_watchlist` (
  `gwa_id` int(11) NOT NULL auto_increment,
  `gwa_user_id` int(11) default NULL,
  `gwa_city_id` int(11) default NULL,
  `gwa_namespace` int(11) default NULL,
  `gwa_title` varchar(255) default NULL,
  `gwa_rev_id` int(11) default NULL,
  `gwa_timestamp` varchar(14) default NULL,
  PRIMARY KEY  (`gwa_id`),
  KEY `user_id` (`gwa_user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=20813231 DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `magcloud_collection`
--

SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE IF NOT EXISTS `magcloud_collection` (
  `mco_hash` varchar(32) NOT NULL,
  `mco_user_id` int(11) default '0',
  `mco_wiki_id` int(11) default '0',
  `mco_updated` datetime default NULL,
  `mco_articles` text,
  `mco_cover` text,
  `mco_publish` text,
  PRIMARY KEY  (`mco_hash`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `magcloud_collection_log`
--

SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE IF NOT EXISTS `magcloud_collection_log` (
  `mcl_publish_hash` varchar(32) default NULL,
  `mcl_publish_timestamp` int(11) default NULL,
  `mcl_publish_token` text,
  `mcl_publish_code` int(11) default NULL,
  `mcl_publish_msg` text,
  `mcl_publish_raw_result` text,
  `mcl_timestamp` int(11) default NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `notify_log`
--

SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE IF NOT EXISTS `notify_log` (
  `nl_id` int(11) NOT NULL auto_increment,
  `nl_city` int(11) NOT NULL,
  `nl_type` char(32) NOT NULL,
  `nl_editor` int(6) NOT NULL,
  `nl_watcher` int(6) NOT NULL,
  `nl_title` varchar(255) NOT NULL,
  `nl_namespace` int(11) NOT NULL,
  `nl_timestamp` char(14) default NULL,
  PRIMARY KEY  (`nl_id`),
  KEY `nl_watcher` (`nl_watcher`),
  KEY `nl_editor` (`nl_editor`),
  KEY `nl_title` (`nl_title`,`nl_namespace`),
  KEY `nl_type` (`nl_type`,`nl_timestamp`),
  KEY `nl_city` (`nl_city`)
) ENGINE=InnoDB AUTO_INCREMENT=7436840 DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `page_editors`
--

SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE IF NOT EXISTS `page_editors` (
  `pc_wikia_id` int(10) unsigned NOT NULL,
  `pc_page_id` int(10) unsigned NOT NULL,
  `pc_page_ns` int(6) unsigned NOT NULL,
  `pc_is_content` int(1) unsigned NOT NULL,
  `pc_date` date NOT NULL,
  `pc_user_id` int(10) unsigned NOT NULL,
  `pc_all_count` int(10) unsigned NOT NULL,
  PRIMARY KEY  (`pc_wikia_id`,`pc_page_id`,`pc_page_ns`,`pc_date`,`pc_user_id`),
  KEY `pc_count_users` (`pc_is_content`,`pc_wikia_id`,`pc_page_id`,`pc_user_id`),
  KEY `pc_count_date` (`pc_is_content`,`pc_wikia_id`,`pc_page_id`,`pc_user_id`,`pc_all_count`),
  KEY `pc_count` (`pc_wikia_id`,`pc_page_id`,`pc_user_id`,`pc_all_count`),
  KEY `pc_date` (`pc_date`,`pc_user_id`,`pc_all_count`),
  KEY `pc_wikia_date` (`pc_wikia_id`,`pc_date`,`pc_user_id`,`pc_all_count`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `page_edits`
--

SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE IF NOT EXISTS `page_edits` (
  `pe_wikia_id` int(10) unsigned NOT NULL,
  `pe_page_id` int(10) unsigned NOT NULL,
  `pe_page_ns` int(6) unsigned NOT NULL,
  `pe_is_content` int(1) unsigned NOT NULL,
  `pe_date` date NOT NULL,
  `pe_anon_count` int(10) unsigned NOT NULL,
  `pe_all_count` int(10) unsigned NOT NULL,
  `pe_words` int(10) unsigned NOT NULL default '0',
  `pe_diff_words` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`pe_wikia_id`,`pe_page_id`,`pe_page_ns`,`pe_date`),
  KEY `pe_count_date` (`pe_is_content`,`pe_wikia_id`,`pe_page_id`,`pe_all_count`,`pe_anon_count`),
  KEY `pe_count` (`pe_wikia_id`,`pe_page_id`,`pe_all_count`,`pe_anon_count`),
  KEY `pe_date` (`pe_date`,`pe_all_count`,`pe_anon_count`),
  KEY `pe_wikia_date` (`pe_wikia_id`,`pe_date`,`pe_all_count`),
  KEY `pe_wikia_anon_date` (`pe_wikia_id`,`pe_date`,`pe_anon_count`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `page_edits_month`
--

SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE IF NOT EXISTS `page_edits_month` (
  `pe_date` date NOT NULL,
  `pe_edits` int(10) unsigned NOT NULL default '0',
  `pe_content_edits` int(10) unsigned NOT NULL default '0',
  `pe_editors` int(10) unsigned NOT NULL default '0',
  `pe_content_editors` int(10) unsigned NOT NULL default '0',
  `pe_anon_editors` int(10) unsigned NOT NULL default '0',
  `pe_anon_content_editors` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`pe_date`),
  KEY `pe_editors_date` (`pe_date`,`pe_editors`,`pe_anon_editors`),
  KEY `pe_content_editors_date` (`pe_date`,`pe_content_editors`,`pe_anon_content_editors`),
  KEY `pe_edits_date` (`pe_date`,`pe_edits`),
  KEY `pe_content_edits_date` (`pe_date`,`pe_content_edits`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `pages`
--

SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE IF NOT EXISTS `pages` (
  `page_wikia_id` int(8) unsigned NOT NULL,
  `page_id` int(10) unsigned NOT NULL,
  `page_namespace` int(10) unsigned NOT NULL default '0',
  `page_title` varchar(255) NOT NULL,
  `page_counter` int(8) unsigned NOT NULL default '0',
  `page_edits` int(10) unsigned NOT NULL default '0',
  `page_title_lower` varchar(255) default NULL,
  `page_status` int(3) unsigned default '0',
  `page_latest` int(8) unsigned NOT NULL default '0',
  PRIMARY KEY  (`page_wikia_id`,`page_id`),
  KEY `page_namespace` (`page_wikia_id`,`page_namespace`,`page_title`),
  KEY `page_title_lower` (`page_wikia_id`,`page_namespace`,`page_status`,`page_title_lower`),
  KEY `page_latest` (`page_wikia_id`,`page_namespace`,`page_latest`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `text_regex`
--

SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE IF NOT EXISTS `text_regex` (
  `tr_id` int(8) NOT NULL auto_increment,
  `tr_text` varchar(255) NOT NULL,
  `tr_timestamp` char(14) NOT NULL,
  `tr_user` int(8) NOT NULL,
  `tr_subpage` varchar(255) NOT NULL,
  PRIMARY KEY  (`tr_id`),
  UNIQUE KEY `tr_text_subpage` (`tr_text`,`tr_subpage`),
  KEY `tr_subpage` (`tr_subpage`),
  KEY `tr_timestamp` (`tr_timestamp`),
  KEY `tr_user` (`tr_user`)
) ENGINE=InnoDB AUTO_INCREMENT=202 DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `text_regex_stats`
--

SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE IF NOT EXISTS `text_regex_stats` (
  `trs_id` int(5) NOT NULL auto_increment,
  `trs_tr_id` int(8) NOT NULL,
  `trs_timestamp` char(14) NOT NULL,
  `trs_user` varchar(255) NOT NULL,
  `trs_text` text NOT NULL,
  `trs_comment` text NOT NULL,
  PRIMARY KEY  (`trs_id`),
  KEY `trs_tr_id` (`trs_tr_id`),
  KEY `trs_timestamp` (`trs_timestamp`),
  KEY `trs_user` (`trs_user`)
) ENGINE=InnoDB AUTO_INCREMENT=113042 DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `upload_log`
--

SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE IF NOT EXISTS `upload_log` (
  `up_page_id` int(8) unsigned NOT NULL default '0',
  `up_title` varchar(255) NOT NULL,
  `up_path` varchar(255) NOT NULL,
  `up_created` char(14) default '',
  `up_sent` char(14) default '',
  `up_flags` int(8) default '0',
  `up_city_id` int(10) NOT NULL default '0',
  `up_imgpath` varchar(255) NOT NULL default '',
  `up_old_path` mediumblob,
  `up_id` int(11) unsigned NOT NULL auto_increment,
  `up_action` char(1) default 'u',
  `up_datacenter` char(1) default 's',
  PRIMARY KEY  (`up_id`),
  KEY `up_id` (`up_page_id`),
  KEY `up_title` (`up_title`),
  KEY `up_city_id` (`up_city_id`),
  KEY `up_flags_idx` (`up_flags`),
  KEY `up_datacenter_idx` (`up_datacenter`)
) ENGINE=InnoDB AUTO_INCREMENT=2823291 DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `user_edits_summary`
--

SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE IF NOT EXISTS `user_edits_summary` (
  `city_id` int(9) unsigned NOT NULL,
  `user_id` int(9) unsigned NOT NULL,
  `edit_ns` int(9) unsigned NOT NULL,
  `edit_count` int(9) unsigned NOT NULL,
  PRIMARY KEY  (`city_id`,`user_id`,`edit_ns`),
  KEY `edit_count` (`user_id`,`edit_ns`,`edit_count`),
  KEY `edit_ns` (`user_id`,`edit_ns`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `user_history`
--

SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE IF NOT EXISTS `user_history` (
  `user_id` int(5) unsigned NOT NULL,
  `user_name` varchar(255) character set latin1 collate latin1_bin NOT NULL default '',
  `user_real_name` varchar(255) character set latin1 collate latin1_bin NOT NULL default '',
  `user_password` tinyblob NOT NULL,
  `user_newpassword` tinyblob NOT NULL,
  `user_email` tinytext NOT NULL,
  `user_options` blob NOT NULL,
  `user_touched` varchar(14) character set latin1 collate latin1_bin NOT NULL default '',
  `user_token` varchar(32) character set latin1 collate latin1_bin NOT NULL default '',
  `uh_timestamp` timestamp NOT NULL default CURRENT_TIMESTAMP,
  KEY `user_name` (`user_name`(10)),
  KEY `idx_user_history_timestamp` (`uh_timestamp`),
  KEY `idx_user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `user_login_history`
--

SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE IF NOT EXISTS `user_login_history` (
  `user_id` int(5) unsigned NOT NULL,
  `city_id` int(9) unsigned default '0',
  `ulh_timestamp` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `ulh_from` tinyint(4) default '0',
  `ulh_rememberme` tinyint(4) default NULL,
  KEY `idx_user_login_history_timestamp` (`ulh_timestamp`),
  KEY `idx_user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `user_login_history_summary`
--

SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE IF NOT EXISTS `user_login_history_summary` (
  `user_id` int(8) unsigned NOT NULL,
  `ulh_timestamp` timestamp NOT NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY  (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `user_summary`
--

SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE IF NOT EXISTS `user_summary` (
  `city_id` int(9) unsigned NOT NULL,
  `user_id` int(9) unsigned NOT NULL,
  `edit_count` int(9) unsigned NOT NULL,
  `rev_first` int(9) unsigned NOT NULL,
  `rev_last` int(9) unsigned NOT NULL,
  `page_first` int(5) unsigned NOT NULL,
  `page_last` int(5) unsigned NOT NULL,
  `ns_first` int(5) unsigned NOT NULL,
  `ns_last` int(5) unsigned NOT NULL,
  `ts_edit_first` timestamp NULL default NULL,
  `ts_edit_last` timestamp NULL default NULL,
  `first_logged_in` timestamp NULL default NULL,
  `last_logged_in` timestamp NULL default NULL,
  `ts_options_changed` timestamp NULL default NULL,
  PRIMARY KEY  (`city_id`,`user_id`),
  KEY `edit_count` (`city_id`,`user_id`,`edit_count`),
  KEY `rev_last` (`city_id`,`user_id`,`rev_last`),
  KEY `page_last` (`city_id`,`user_id`,`page_last`,`ns_last`,`ts_edit_last`),
  KEY `ts_edit_last` (`city_id`,`user_id`,`ts_edit_last`),
  KEY `last_logged_in` (`city_id`,`user_id`,`last_logged_in`),
  KEY `user_id` (`user_id`),
  KEY `rev_city_last` (`city_id`,`rev_last`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `wikiastaff_log`
--

SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE IF NOT EXISTS `wikiastaff_log` (
  `slog_id` int(10) unsigned NOT NULL auto_increment,
  `slog_type` varbinary(10) NOT NULL default '',
  `slog_action` varbinary(10) NOT NULL default '',
  `slog_timestamp` binary(14) NOT NULL default '19700101000000',
  `slog_user` int(10) unsigned NOT NULL default '0',
  `slog_userdst` int(10) unsigned NOT NULL default '0',
  `slog_comment` varbinary(255) default NULL,
  `slog_params` blob,
  `slog_deleted` tinyint(3) unsigned NOT NULL default '0',
  `slog_site` varbinary(200) default NULL,
  `slog_user_name` varbinary(255) NOT NULL,
  `slog_user_namedst` varbinary(255) NOT NULL,
  `slog_city` int(11) default NULL,
  PRIMARY KEY  (`slog_id`),
  KEY `slog_time` (`slog_timestamp`)
) ENGINE=InnoDB AUTO_INCREMENT=651 DEFAULT CHARSET=binary;
SET character_set_client = @saved_cs_client;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2010-07-19 13:51:42
