-- MySQL dump 10.13  Distrib 5.6.24-72.2, for debian-linux-gnu (x86_64)
--
-- Host: geo-db-sharedb-slave.query.consul    Database: wikicities
-- ------------------------------------------------------
-- Server version	5.7.18-15-log


--
-- Table structure for table `ach_ranking_snapshots`
--

DROP TABLE IF EXISTS `ach_ranking_snapshots`;
CREATE TABLE `ach_ranking_snapshots` (
  `wiki_id` int(9) NOT NULL,
  `date` datetime NOT NULL,
  `data` text COLLATE utf8_unicode_ci NOT NULL,
  UNIQUE KEY `wiki_id` (`wiki_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Table structure for table `blog_listing_relation`
--

DROP TABLE IF EXISTS `blog_listing_relation`;
CREATE TABLE `blog_listing_relation` (
  `blr_relation` varbinary(255) NOT NULL DEFAULT '',
  `blr_title` varbinary(255) NOT NULL DEFAULT '',
  `blr_type` enum('cat','user') DEFAULT NULL,
  UNIQUE KEY `wl_user` (`blr_relation`,`blr_title`,`blr_type`),
  KEY `type_relation` (`blr_relation`,`blr_type`)
) ENGINE=InnoDB DEFAULT CHARSET=binary;

--
-- Table structure for table `city_cat_mapping`
--

DROP TABLE IF EXISTS `city_cat_mapping`;
CREATE TABLE `city_cat_mapping` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `city_id` int(11) DEFAULT NULL,
  `cat_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `city_id_idx` (`city_id`),
  KEY `cat_id_idx` (`cat_id`),
  CONSTRAINT `city_cat_mapping_ibfk_1` FOREIGN KEY (`city_id`) REFERENCES `city_list` (`city_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Table structure for table `city_cats`
--

DROP TABLE IF EXISTS `city_cats`;
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

--
-- Table structure for table `city_domains`
--

DROP TABLE IF EXISTS `city_domains`;
CREATE TABLE `city_domains` (
  `city_id` int(9) NOT NULL,
  `city_domain` varchar(255) NOT NULL DEFAULT 'wikia.com',
  PRIMARY KEY (`city_id`,`city_domain`),
  UNIQUE KEY `city_domains_archive_idx_uniq` (`city_domain`),
  CONSTRAINT `city_domains_ibfk_1_archive` FOREIGN KEY (`city_id`) REFERENCES `city_list` (`city_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Table structure for table `city_lang`
--

DROP TABLE IF EXISTS `city_lang`;
CREATE TABLE `city_lang` (
  `lang_id` mediumint(2) unsigned NOT NULL AUTO_INCREMENT,
  `lang_code` char(8) NOT NULL,
  `lang_name` varchar(255) NOT NULL,
  PRIMARY KEY (`lang_id`),
  KEY `lang_code_idx` (`lang_code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Table structure for table `city_list`
--

DROP TABLE IF EXISTS `city_list`;
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
  `city_vertical` int(11) NOT NULL DEFAULT '0',
  `city_founding_ip_bin` varbinary(16) DEFAULT NULL,
  PRIMARY KEY (`city_id`),
  UNIQUE KEY `urlidx` (`city_url`),
  UNIQUE KEY `city_dbname_idx` (`city_dbname`),
  KEY `titleidx` (`city_title`),
  KEY `city_flags` (`city_flags`),
  KEY `city_created` (`city_created`,`city_lang`),
  KEY `city_founding_user_inx` (`city_founding_user`),
  KEY `city_cluster` (`city_cluster`),
  KEY `city_founding_ip_bin` (`city_founding_ip_bin`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Table structure for table `city_list_log`
--

DROP TABLE IF EXISTS `city_list_log`;
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

--
-- Table structure for table `city_tag`
--

DROP TABLE IF EXISTS `city_tag`;
CREATE TABLE `city_tag` (
  `id` int(8) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `city_tag_name_uniq` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Table structure for table `city_tag_map`
--

DROP TABLE IF EXISTS `city_tag_map`;
CREATE TABLE `city_tag_map` (
  `city_id` int(9) NOT NULL,
  `tag_id` int(8) unsigned NOT NULL,
  PRIMARY KEY (`city_id`,`tag_id`),
  KEY `tag_id` (`tag_id`),
  CONSTRAINT `city_tag_map_ibfk_1` FOREIGN KEY (`city_id`) REFERENCES `city_list` (`city_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `city_tag_map_ibfk_2` FOREIGN KEY (`tag_id`) REFERENCES `city_tag` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Table structure for table `city_variables`
--

DROP TABLE IF EXISTS `city_variables`;
CREATE TABLE `city_variables` (
  `cv_city_id` int(9) NOT NULL,
  `cv_variable_id` smallint(5) unsigned NOT NULL DEFAULT '0',
  `cv_value` text NOT NULL,
  PRIMARY KEY (`cv_variable_id`,`cv_city_id`),
  KEY `cv_city_id_archive` (`cv_city_id`),
  KEY `cv_variable_id` (`cv_variable_id`,`cv_value`(300))
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Table structure for table `city_variables_groups`
--

DROP TABLE IF EXISTS `city_variables_groups`;
CREATE TABLE `city_variables_groups` (
  `cv_group_id` int(11) NOT NULL AUTO_INCREMENT,
  `cv_group_name` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`cv_group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Table structure for table `city_variables_pool`
--

DROP TABLE IF EXISTS `city_variables_pool`;
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

--
-- Table structure for table `city_verticals`
--

DROP TABLE IF EXISTS `city_verticals`;
CREATE TABLE `city_verticals` (
  `vertical_id` int(9) NOT NULL,
  `vertical_name` varchar(255) DEFAULT NULL,
  `vertical_url` text,
  `vertical_short` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`vertical_id`),
  KEY `vertical_name_idx` (`vertical_name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Table structure for table `city_visualization`
--

DROP TABLE IF EXISTS `city_visualization`;
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

--
-- Table structure for table `dmca_request`
--

DROP TABLE IF EXISTS `dmca_request`;
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

--
-- Table structure for table `dumps`
--

DROP TABLE IF EXISTS `dumps`;
CREATE TABLE `dumps` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dump_wiki_id` int(9) NOT NULL,
  `dump_wiki_dbname` varchar(64) NOT NULL,
  `dump_wiki_url` varchar(255) NOT NULL,
  `dump_user_id` int(9) DEFAULT '0',
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

--
-- Table structure for table `founder_emails_event`
--

DROP TABLE IF EXISTS `founder_emails_event`;
CREATE TABLE `founder_emails_event` (
  `feev_id` int(11) NOT NULL AUTO_INCREMENT,
  `feev_wiki_id` int(11) NOT NULL,
  `feev_timestamp` varchar(14) DEFAULT NULL,
  `feev_type` varchar(32) DEFAULT NULL,
  `feev_data` blob NOT NULL,
  PRIMARY KEY (`feev_id`),
  KEY `feev_wiki_id` (`feev_wiki_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Table structure for table `founder_progress_bar_tasks`
--

DROP TABLE IF EXISTS `founder_progress_bar_tasks`;
CREATE TABLE `founder_progress_bar_tasks` (
  `wiki_id` int(10) NOT NULL,
  `task_id` int(10) NOT NULL,
  `task_count` int(10) DEFAULT '0',
  `task_completed` tinyint(1) NOT NULL DEFAULT '0',
  `task_skipped` tinyint(1) NOT NULL DEFAULT '0',
  `task_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`wiki_id`,`task_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Table structure for table `garbage_collector`
--

DROP TABLE IF EXISTS `garbage_collector`;
CREATE TABLE `garbage_collector` (
  `gc_id` int(11) NOT NULL AUTO_INCREMENT,
  `gc_filename` varchar(285) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL DEFAULT '',
  `gc_timestamp` varchar(14) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL DEFAULT '',
  `gc_wiki_id` int(9) DEFAULT NULL,
  PRIMARY KEY (`gc_id`),
  KEY `gc_timestamp` (`gc_timestamp`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Table structure for table `messages_status`
--

DROP TABLE IF EXISTS `messages_status`;
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

--
-- Table structure for table `messages_text`
--

DROP TABLE IF EXISTS `messages_text`;
CREATE TABLE `messages_text` (
  `msg_id` int(7) unsigned NOT NULL AUTO_INCREMENT,
  `msg_sender_id` int(10) unsigned NOT NULL,
  `msg_text` mediumtext NOT NULL,
  `msg_mode` tinyint(4) NOT NULL DEFAULT '0',
  `msg_removed` tinyint(4) NOT NULL DEFAULT '0',
  `msg_expire` datetime DEFAULT NULL,
  `msg_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `msg_recipient_user_id` int(5) unsigned DEFAULT NULL,
  `msg_group_name` varchar(255) DEFAULT NULL,
  `msg_wiki_name` varchar(255) DEFAULT NULL,
  `msg_hub_id` int(9) DEFAULT NULL,
  `msg_cluster_id` int(9) DEFAULT NULL,
  `msg_lang` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`msg_id`),
  KEY `removed_mode_expire_date` (`msg_removed`,`msg_mode`,`msg_expire`,`msg_date`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Table structure for table `page`
--

DROP TABLE IF EXISTS `page`;
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

--
-- Table structure for table `page_wikia_props`
--

DROP TABLE IF EXISTS `page_wikia_props`;
CREATE TABLE `page_wikia_props` (
  `page_id` int(10) NOT NULL,
  `propname` int(10) NOT NULL,
  `props` blob NOT NULL,
  PRIMARY KEY (`page_id`,`propname`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Table structure for table `phalanx`
--

DROP TABLE IF EXISTS `phalanx`;
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

--
-- Table structure for table `revision`
--

DROP TABLE IF EXISTS `revision`;
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

--
-- Table structure for table `shared_newtalks`
--

DROP TABLE IF EXISTS `shared_newtalks`;
CREATE TABLE `shared_newtalks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sn_user_id` int(5) unsigned DEFAULT NULL,
  `sn_anon_ip` varbinary(16) DEFAULT NULL,
  `sn_wiki` varchar(31) DEFAULT NULL,
  `sn_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_user_ip_wiki` (`sn_wiki`),
  KEY `idx_user_id_wiki` (`sn_user_id`,`sn_wiki`),
  KEY `idx_anon_ip_wiki` (`sn_anon_ip`,`sn_wiki`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Table structure for table `spoofuser`
--

DROP TABLE IF EXISTS `spoofuser`;
CREATE TABLE `spoofuser` (
  `su_name` varchar(255) NOT NULL DEFAULT '',
  `su_normalized` varchar(255) DEFAULT NULL,
  `su_legal` tinyint(1) DEFAULT NULL,
  `su_error` text,
  `su_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`su_name`),
  KEY `su_normalized` (`su_normalized`,`su_name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Table structure for table `text`
--

DROP TABLE IF EXISTS `text`;
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

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `user_id` int(5) unsigned NOT NULL AUTO_INCREMENT,
  `user_name` varchar(255) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL DEFAULT '',
  `user_real_name` varchar(255) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL DEFAULT '',
  `user_email` tinytext NOT NULL,
  `user_touched` char(14) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL DEFAULT '',
  `user_token` char(32) CHARACTER SET latin1 COLLATE latin1_bin DEFAULT '',
  `user_email_authenticated` char(14) CHARACTER SET latin1 COLLATE latin1_bin DEFAULT NULL,
  `user_email_token` char(32) CHARACTER SET latin1 COLLATE latin1_bin DEFAULT NULL,
  `user_email_token_expires` char(14) CHARACTER SET latin1 COLLATE latin1_bin DEFAULT NULL,
  `user_registration` varchar(16) DEFAULT NULL,
  `user_editcount` int(11) DEFAULT NULL,
  `user_birthdate` date DEFAULT NULL,
  `user_options` blob NOT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `user_name` (`user_name`),
  KEY `user_email_token` (`user_email_token`),
  KEY `user_email` (`user_email`(40))
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Table structure for table `user_email_log`
--

DROP TABLE IF EXISTS `user_email_log`;
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

--
-- Table structure for table `user_fbconnect`
--

DROP TABLE IF EXISTS `user_fbconnect`;
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

--
-- Table structure for table `user_former_groups`
--

DROP TABLE IF EXISTS `user_former_groups`;
CREATE TABLE `user_former_groups` (
  `ufg_user` int(10) unsigned NOT NULL DEFAULT '0',
  `ufg_group` varbinary(32) NOT NULL DEFAULT '',
  UNIQUE KEY `ufg_user_group` (`ufg_user`,`ufg_group`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Table structure for table `user_groups`
--

DROP TABLE IF EXISTS `user_groups`;
CREATE TABLE `user_groups` (
  `ug_user` int(5) unsigned NOT NULL DEFAULT '0',
  `ug_group` varbinary(32) NOT NULL DEFAULT '',
  PRIMARY KEY (`ug_user`,`ug_group`),
  KEY `ug_group` (`ug_group`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Table structure for table `user_properties`
--

DROP TABLE IF EXISTS `user_properties`;
CREATE TABLE `user_properties` (
  `up_user` int(11) NOT NULL,
  `up_property` varbinary(255) DEFAULT NULL,
  `up_value` blob,
  UNIQUE KEY `user_properties_user_property` (`up_user`,`up_property`),
  KEY `user_properties_property` (`up_property`)
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
  `task_log` text,
  `task_added` char(14) NOT NULL,
  PRIMARY KEY (`task_id`),
  KEY `task_added_idx` (`task_added`),
  KEY `task_status` (`task_status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Table structure for table `wikia_tasks_log`
--

DROP TABLE IF EXISTS `wikia_tasks_log`;
CREATE TABLE `wikia_tasks_log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `task_id` int(11) NOT NULL,
  `log_timestamp` char(14) NOT NULL,
  `log_line` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `new_fk_constraint` (`task_id`),
  CONSTRAINT `new_fk_constraint` FOREIGN KEY (`task_id`) REFERENCES `wikia_tasks` (`task_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- Dump completed on 2017-12-07 11:39:18
