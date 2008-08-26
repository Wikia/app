--
-- Table structure for table `archive`
--

DROP TABLE IF EXISTS `archive`;
CREATE TABLE `archive` (
  `ar_namespace` int(11) NOT NULL default '0',
  `ar_title` varchar(255) default NULL,
  `ar_text` mediumblob NOT NULL,
  `ar_comment` tinyblob NOT NULL,
  `ar_user` int(5) unsigned NOT NULL default '0',
  `ar_user_text` varchar(255) default NULL,
  `ar_timestamp` varchar(14) default NULL,
  `ar_minor_edit` tinyint(1) NOT NULL default '0',
  `ar_flags` tinyblob NOT NULL,
  `ar_rev_id` int(8) unsigned default NULL,
  `ar_text_id` int(8) unsigned default NULL,
  KEY `name_title_timestamp` (`ar_namespace`,`ar_title`,`ar_timestamp`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Table structure for table `categorylinks`
--

DROP TABLE IF EXISTS `categorylinks`;
CREATE TABLE `categorylinks` (
  `cl_from` int(8) unsigned NOT NULL default '0',
  `cl_to` varchar(255) default NULL,
  `cl_sortkey` varchar(86) default NULL,
  `cl_timestamp` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  UNIQUE KEY `cl_from` (`cl_from`,`cl_to`),
  KEY `cl_timestamp` (`cl_to`,`cl_timestamp`),
  KEY `cl_sortkey` (`cl_to`(247),`cl_sortkey`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Table structure for table `externallinks`
--

DROP TABLE IF EXISTS `externallinks`;
CREATE TABLE `externallinks` (
  `el_from` int(8) unsigned NOT NULL default '0',
  `el_to` blob NOT NULL,
  `el_index` blob NOT NULL,
  KEY `el_from` (`el_from`,`el_to`(40)),
  KEY `el_to` (`el_to`(60),`el_from`),
  KEY `el_index` (`el_index`(60))
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Table structure for table `filearchive`
--

DROP TABLE IF EXISTS `filearchive`;
CREATE TABLE `filearchive` (
  `fa_id` int(11) NOT NULL auto_increment,
  `fa_name` varchar(255) default NULL,
  `fa_archive_name` varchar(255) default NULL,
  `fa_storage_group` varchar(16) default NULL,
  `fa_storage_key` varchar(64) default NULL,
  `fa_deleted_user` int(11) default NULL,
  `fa_deleted_timestamp` char(14) default '',
  `fa_deleted_reason` text character set latin1,
  `fa_size` int(8) unsigned default '0',
  `fa_width` int(5) default '0',
  `fa_height` int(5) default '0',
  `fa_metadata` mediumblob,
  `fa_bits` int(3) default '0',
  `fa_media_type` enum('UNKNOWN','BITMAP','DRAWING','AUDIO','VIDEO','MULTIMEDIA','OFFICE','TEXT','EXECUTABLE','ARCHIVE') character set latin1 default NULL,
  `fa_major_mime` enum('unknown','application','audio','image','text','video','message','model','multipart') character set latin1 default 'unknown',
  `fa_minor_mime` varchar(32) default NULL,
  `fa_description` tinyblob,
  `fa_user` int(5) unsigned default '0',
  `fa_user_text` varchar(255) default NULL,
  `fa_timestamp` char(14) default '',
  PRIMARY KEY  (`fa_id`),
  KEY `fa_name` (`fa_name`,`fa_timestamp`),
  KEY `fa_storage_group` (`fa_storage_group`,`fa_storage_key`),
  KEY `fa_deleted_timestamp` (`fa_deleted_timestamp`),
  KEY `fa_deleted_user` (`fa_deleted_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Table structure for table `hitcounter`
--

DROP TABLE IF EXISTS `hitcounter`;
CREATE TABLE `hitcounter` (
  `hc_id` int(10) unsigned NOT NULL default '0'
) ENGINE=MEMORY DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci MAX_ROWS=25000;

--
-- Table structure for table `image`
--

DROP TABLE IF EXISTS `image`;
CREATE TABLE `image` (
  `img_name` varchar(255) NOT NULL default '',
  `img_size` int(8) unsigned NOT NULL default '0',
  `img_width` int(5) NOT NULL default '0',
  `img_height` int(5) NOT NULL default '0',
  `img_metadata` mediumblob NOT NULL,
  `img_bits` int(3) NOT NULL default '0',
  `img_media_type` enum('UNKNOWN','BITMAP','DRAWING','AUDIO','VIDEO','MULTIMEDIA','OFFICE','TEXT','EXECUTABLE','ARCHIVE') default NULL,
  `img_major_mime` enum('unknown','application','audio','image','text','video','message','model','multipart') NOT NULL default 'unknown',
  `img_minor_mime` varchar(32) default NULL,
  `img_description` tinyblob NOT NULL,
  `img_user` int(5) unsigned NOT NULL default '0',
  `img_user_text` varchar(255) default NULL,
  `img_timestamp` varchar(14) default NULL,
  PRIMARY KEY  (`img_name`),
  KEY `img_size` (`img_size`),
  KEY `img_timestamp` (`img_timestamp`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Table structure for table `imagelinks`
--

DROP TABLE IF EXISTS `imagelinks`;
CREATE TABLE `imagelinks` (
  `il_from` int(8) unsigned NOT NULL default '0',
  `il_to` varchar(255) default NULL,
  UNIQUE KEY `il_from` (`il_from`,`il_to`),
  KEY `il_to` (`il_to`,`il_from`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Table structure for table `interwiki`
--

DROP TABLE IF EXISTS `interwiki`;
CREATE TABLE `interwiki` (
  `iw_prefix` char(32) default NULL,
  `iw_url` char(127) default NULL,
  `iw_local` tinyint(1) NOT NULL default '0',
  `iw_trans` tinyint(1) NOT NULL default '0',
  UNIQUE KEY `iw_prefix` (`iw_prefix`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Table structure for table `ipblocks`
--

DROP TABLE IF EXISTS `ipblocks`;
CREATE TABLE `ipblocks` (
  `ipb_id` int(8) NOT NULL auto_increment,
  `ipb_address` tinyblob NOT NULL,
  `ipb_user` int(8) unsigned NOT NULL default '0',
  `ipb_by` int(8) unsigned NOT NULL default '0',
  `ipb_reason` tinyblob NOT NULL,
  `ipb_timestamp` char(14) NOT NULL default '',
  `ipb_auto` tinyint(1) NOT NULL default '0',
  `ipb_anon_only` tinyint(1) NOT NULL default '0',
  `ipb_create_account` tinyint(1) NOT NULL default '1',
  `ipb_expiry` char(14) NOT NULL default '',
  `ipb_range_start` tinyblob NOT NULL,
  `ipb_range_end` tinyblob NOT NULL,
  `ipb_enable_autoblock` tinyint(1) NOT NULL default '1',
  PRIMARY KEY  (`ipb_id`),
  UNIQUE KEY `ipb_address_unique` (`ipb_address`(255),`ipb_user`,`ipb_auto`),
  KEY `ipb_user` (`ipb_user`),
  KEY `ipb_range` (`ipb_range_start`(8),`ipb_range_end`(8)),
  KEY `ipb_timestamp` (`ipb_timestamp`),
  KEY `ipb_expiry` (`ipb_expiry`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Table structure for table `job`
--

DROP TABLE IF EXISTS `job`;
CREATE TABLE `job` (
  `job_id` int(9) unsigned NOT NULL auto_increment,
  `job_cmd` varchar(255) default NULL,
  `job_namespace` int(11) NOT NULL,
  `job_title` varchar(255) default NULL,
  `job_params` blob NOT NULL,
  PRIMARY KEY  (`job_id`),
  KEY `job_cmd` (`job_cmd`,`job_namespace`,`job_title`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Table structure for table `language`
--

DROP TABLE IF EXISTS `language`;
CREATE TABLE `language` (
  `language_id` int(10) NOT NULL auto_increment,
  `dialect_of_lid` int(10) NOT NULL default '0',
  `iso639_2` varchar(10) default NULL,
  `iso639_3` varchar(10) default NULL,
  `wikimedia_key` varchar(10) default NULL,
  PRIMARY KEY  (`language_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `language`
--


/*!40000 ALTER TABLE `language` DISABLE KEYS */;
LOCK TABLES `language` WRITE;
INSERT INTO `language` VALUES (84,0,'','','bg'),(85,0,'eng','','en'),(86,0,'fre','','fr'),(87,0,'spa','','es'),(88,0,'','','ru'),(89,0,'dut','','nl'),(90,0,'','','cs'),(91,0,'swe','','sv'),(92,0,'','','sl'),(93,0,'','','pl'),(94,0,'por','','pt'),(95,0,'nor','','no'),(96,0,'baq','','eu'),(97,0,'','','sk'),(98,0,'','','et'),(99,0,'fin','','fi'),(100,0,'ita','','it'),(101,0,'ger','','de'),(102,0,'hun','','hu'),(103,0,'dan','','da'),(104,0,'','','en-US'),(105,0,'','','el'),(106,0,'heb','','he');
UNLOCK TABLES;
/*!40000 ALTER TABLE `language` ENABLE KEYS */;

--
-- Table structure for table `language_names`
--

DROP TABLE IF EXISTS `language_names`;
CREATE TABLE `language_names` (
  `language_id` int(10) NOT NULL default '0',
  `name_language_id` int(10) NOT NULL default '0',
  `language_name` varchar(255) default NULL,
  PRIMARY KEY  (`language_id`,`name_language_id`),
  KEY `language_id` (`language_id`),
  KEY `language_id_2` (`language_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `language_names`
--


/*!40000 ALTER TABLE `language_names` DISABLE KEYS */;
LOCK TABLES `language_names` WRITE;
INSERT INTO `language_names` VALUES (84,85,'Bulgarian'),(84,101,'Bulgarisch'),(85,85,'English'),(85,101,'Englisch'),(86,85,'French'),(86,101,'FranzÃ¶sisch'),(87,85,'Spanish'),(87,101,'Spanisch'),(88,85,'Russian'),(88,101,'Russisch'),(89,85,'Dutch'),(89,101,'NiederlÃ¤ndisch'),(90,85,'Czech'),(90,101,'Tschechisch'),(91,85,'Swedish'),(91,101,'Schwedisch'),(92,85,'Slovenian'),(92,101,'Slowenisch'),(93,85,'Polish'),(93,101,'Polnisch'),(94,85,'Portuguese'),(94,101,'Portugiesisch'),(95,85,'Norwegian'),(95,101,'Norwegisch'),(96,85,'Basque'),(96,101,'Baskisch'),(97,85,'Slovak'),(97,101,'Slowakische Sprache'),(98,85,'Estonian'),(98,101,'Estnisch'),(99,85,'Finnish'),(99,101,'Finnisch'),(100,85,'Italian'),(100,101,'Italienisch'),(101,85,'German'),(101,101,'Deutsch'),(102,85,'Hungarian'),(102,101,'Ungarisch'),(103,85,'Dansk'),(103,101,'DÃ¤nisch'),(104,85,'English (United States)'),(104,101,'Englisch (USA)'),(105,85,'Greek'),(105,101,'Griechisch');
UNLOCK TABLES;
/*!40000 ALTER TABLE `language_names` ENABLE KEYS */;

--
-- Table structure for table `logging`
--

DROP TABLE IF EXISTS `logging`;
CREATE TABLE `logging` (
  `log_type` varchar(10) default NULL,
  `log_action` varchar(10) default NULL,
  `log_timestamp` varchar(14) default NULL,
  `log_user` int(10) unsigned NOT NULL default '0',
  `log_namespace` int(11) NOT NULL default '0',
  `log_title` varchar(255) default NULL,
  `log_comment` varchar(255) default NULL,
  `log_params` blob NOT NULL,
  `log_id` int(10) unsigned NOT NULL auto_increment,
  PRIMARY KEY  (`log_id`),
  KEY `type_time` (`log_type`,`log_timestamp`),
  KEY `user_time` (`log_user`,`log_timestamp`),
  KEY `page_time` (`log_namespace`,`log_title`,`log_timestamp`),
  KEY `times` (`log_timestamp`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Table structure for table `math`
--

DROP TABLE IF EXISTS `math`;
CREATE TABLE `math` (
  `math_inputhash` varchar(16) default NULL,
  `math_outputhash` varchar(16) default NULL,
  `math_html_conservativeness` tinyint(1) NOT NULL default '0',
  `math_html` text,
  `math_mathml` text,
  UNIQUE KEY `math_inputhash` (`math_inputhash`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Table structure for table `namespace`
--

DROP TABLE IF EXISTS `namespace`;
CREATE TABLE `namespace` (
  `ns_id` int(8) NOT NULL default '0',
  `ns_system` varchar(80) default NULL,
  `ns_subpages` tinyint(1) NOT NULL default '0',
  `ns_search_default` tinyint(1) NOT NULL default '0',
  `ns_target` varchar(200) default NULL,
  `ns_parent` int(8) default NULL,
  `ns_hidden` tinyint(1) default NULL,
  `ns_class` varchar(255) default NULL,
  `ns_count` tinyint(1) default NULL,
  PRIMARY KEY  (`ns_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `namespace`
--


/*!40000 ALTER TABLE `namespace` DISABLE KEYS */;
LOCK TABLES `namespace` WRITE;
INSERT INTO `namespace` VALUES (-2,'NS_MEDIA',0,0,NULL,NULL,NULL,NULL,0),(-1,'NS_SPECIAL',0,0,NULL,NULL,NULL,NULL,0),(0,'NS_MAIN',0,1,NULL,NULL,NULL,NULL,1),(1,'NS_TALK',1,0,NULL,0,NULL,NULL,0),(2,'NS_USER',1,0,NULL,NULL,NULL,NULL,0),(3,'NS_USER_TALK',1,0,NULL,2,NULL,NULL,0),(4,'NS_PROJECT',0,0,NULL,NULL,NULL,NULL,0),(5,'NS_PROJECT_TALK',1,0,NULL,4,NULL,NULL,0),(6,'NS_FILE',0,0,NULL,NULL,NULL,NULL,0),(7,'NS_FILE_TALK',1,0,NULL,6,NULL,NULL,0),(8,'NS_MEDIAWIKI',0,0,NULL,NULL,NULL,NULL,0),(9,'NS_MEDIAWIKI_TALK',1,0,NULL,8,NULL,NULL,0),(10,'NS_TEMPLATE',0,0,NULL,NULL,NULL,NULL,0),(11,'NS_TEMPLATE_TALK',1,0,NULL,10,NULL,NULL,0),(12,'NS_HELP',0,0,NULL,NULL,NULL,NULL,0),(13,'NS_HELP_TALK',1,0,NULL,12,NULL,NULL,0),(14,'NS_CATEGORY',0,0,NULL,NULL,NULL,NULL,0),(15,'NS_CATEGORY_TALK',1,0,NULL,14,NULL,NULL,0),(16,'NS_EXPRESSION',0,0,NULL,NULL,NULL,'OmegaWiki',0),(17,'NS_EXPRESSION_TALK',0,0,NULL,16,NULL,NULL,0),(24,'NS_DEFINEDMEANING',0,0,NULL,NULL,NULL,'DefinedMeaning',0),(25,'NS_DEFINEDMEANING_TALK',0,0,NULL,24,NULL,NULL,0);
UNLOCK TABLES;
/*!40000 ALTER TABLE `namespace` ENABLE KEYS */;

--
-- Table structure for table `namespace_names`
--

DROP TABLE IF EXISTS `namespace_names`;
CREATE TABLE `namespace_names` (
  `ns_id` int(8) NOT NULL default '0',
  `ns_name` varchar(200) default NULL,
  `ns_default` tinyint(1) NOT NULL default '0',
  `ns_canonical` tinyint(1) default NULL,
  UNIQUE KEY `ns_name` (`ns_name`),
  KEY `ns_id` (`ns_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `namespace_names`
--


/*!40000 ALTER TABLE `namespace_names` DISABLE KEYS */;
LOCK TABLES `namespace_names` WRITE;
INSERT INTO `namespace_names` VALUES (14,'Category',1,0),(15,'Category_talk',1,0),(6,'File',1,0),(7,'File_talk',1,0),(12,'Help',1,0),(13,'Help_talk',1,0),(6,'Image',0,0),(7,'Image_talk',0,0),(-2,'Media',1,0),(8,'MediaWiki',1,0),(9,'MediaWiki_talk',1,0),(4,'Project',0,1),(5,'Project_talk',0,1),(6,'Sound',0,0),(7,'Sound_talk',0,0),(-1,'Special',1,0),(1,'Talk',1,0),(10,'Template',1,0),(11,'Template_talk',1,0),(2,'User',1,0),(3,'User_talk',1,0),(6,'Video',0,0),(7,'Video_talk',0,0),(4,'Wikdevelop',1,0),(5,'Wikdevelop_talk',1,0),(16,'Expression',1,0),(17,'Expression_talk',1,0),(24,'DefinedMeaning',1,0),(25,'DefinedMeaning_talk',1,0);
UNLOCK TABLES;
/*!40000 ALTER TABLE `namespace_names` ENABLE KEYS */;

--
-- Table structure for table `objectcache`
--

DROP TABLE IF EXISTS `objectcache`;
CREATE TABLE `objectcache` (
  `keyname` varchar(255) default NULL,
  `value` mediumblob,
  `exptime` datetime default NULL,
  UNIQUE KEY `keyname` (`keyname`),
  KEY `exptime` (`exptime`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Table structure for table `oldimage`
--

DROP TABLE IF EXISTS `oldimage`;
CREATE TABLE `oldimage` (
  `oi_name` varchar(255) default NULL,
  `oi_archive_name` varchar(255) default NULL,
  `oi_size` int(8) unsigned NOT NULL default '0',
  `oi_width` int(5) NOT NULL default '0',
  `oi_height` int(5) NOT NULL default '0',
  `oi_bits` int(3) NOT NULL default '0',
  `oi_description` tinyblob NOT NULL,
  `oi_user` int(5) unsigned NOT NULL default '0',
  `oi_user_text` varchar(255) default NULL,
  `oi_timestamp` varchar(14) default NULL,
  KEY `oi_name` (`oi_name`(10))
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Table structure for table `page`
--

DROP TABLE IF EXISTS `page`;
CREATE TABLE `page` (
  `page_id` int(8) unsigned NOT NULL auto_increment,
  `page_namespace` int(11) NOT NULL default '0',
  `page_title` varchar(255) default NULL,
  `page_restrictions` tinyblob,
  `page_counter` bigint(20) unsigned NOT NULL default '0',
  `page_is_redirect` tinyint(1) unsigned NOT NULL default '0',
  `page_is_new` tinyint(1) unsigned NOT NULL default '0',
  `page_random` double unsigned NOT NULL default '0',
  `page_touched` varchar(14) default NULL,
  `page_latest` int(8) unsigned NOT NULL default '0',
  `page_len` int(8) unsigned NOT NULL default '0',
  PRIMARY KEY  (`page_id`),
  UNIQUE KEY `page_unique` (`page_title`,`page_namespace`),
  KEY `page_random` (`page_random`),
  KEY `page_len` (`page_len`),
  KEY `name_title` (`page_namespace`,`page_title`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Table structure for table `page_restrictions`
--

DROP TABLE IF EXISTS `page_restrictions`;
CREATE TABLE `page_restrictions` (
  `pr_page` int(8) NOT NULL,
  `pr_type` varchar(255) NOT NULL default '',
  `pr_level` varchar(255) default NULL,
  `pr_cascade` tinyint(4) NOT NULL,
  `pr_user` int(8) default NULL,
  `pr_expiry` char(14) character set latin1 collate latin1_bin default NULL,
  PRIMARY KEY  (`pr_page`,`pr_type`),
  KEY `pr_page` (`pr_page`),
  KEY `pr_typelevel` (`pr_type`,`pr_level`),
  KEY `pr_level` (`pr_level`),
  KEY `pr_cascade` (`pr_cascade`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Table structure for table `pagelinks`
--

DROP TABLE IF EXISTS `pagelinks`;
CREATE TABLE `pagelinks` (
  `pl_from` int(8) unsigned NOT NULL default '0',
  `pl_namespace` int(11) NOT NULL default '0',
  `pl_title` varchar(255) default NULL,
  UNIQUE KEY `pl_from` (`pl_from`,`pl_namespace`,`pl_title`),
  KEY `pl_namespace` (`pl_namespace`,`pl_title`,`pl_from`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Table structure for table `querycache`
--

DROP TABLE IF EXISTS `querycache`;
CREATE TABLE `querycache` (
  `qc_type` char(32) NOT NULL default '',
  `qc_value` int(5) unsigned NOT NULL default '0',
  `qc_namespace` int(11) NOT NULL default '0',
  `qc_title` char(255) NOT NULL default '',
  KEY `qc_type` (`qc_type`,`qc_value`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Table structure for table `querycache_info`
--

DROP TABLE IF EXISTS `querycache_info`;
CREATE TABLE `querycache_info` (
  `qci_type` varchar(32) default NULL,
  `qci_timestamp` char(14) NOT NULL default '19700101000000',
  UNIQUE KEY `qci_type` (`qci_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Table structure for table `querycachetwo`
--

DROP TABLE IF EXISTS `querycachetwo`;
CREATE TABLE `querycachetwo` (
  `qcc_type` char(32) NOT NULL,
  `qcc_value` int(5) unsigned NOT NULL default '0',
  `qcc_namespace` int(11) NOT NULL default '0',
  `qcc_title` char(255) NOT NULL default '',
  `qcc_namespacetwo` int(11) NOT NULL default '0',
  `qcc_titletwo` char(255) NOT NULL default '',
  KEY `qcc_type` (`qcc_type`,`qcc_value`),
  KEY `qcc_title` (`qcc_type`,`qcc_namespace`,`qcc_title`),
  KEY `qcc_titletwo` (`qcc_type`,`qcc_namespacetwo`,`qcc_titletwo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Table structure for table `recentchanges`
--

DROP TABLE IF EXISTS `recentchanges`;
CREATE TABLE `recentchanges` (
  `rc_id` int(8) unsigned NOT NULL auto_increment,
  `rc_timestamp` varchar(14) default NULL,
  `rc_cur_time` varchar(14) default NULL,
  `rc_user` int(10) unsigned NOT NULL default '0',
  `rc_user_text` varchar(255) default NULL,
  `rc_namespace` int(11) NOT NULL default '0',
  `rc_title` varchar(255) default NULL,
  `rc_comment` varchar(255) default NULL,
  `rc_minor` tinyint(3) unsigned NOT NULL default '0',
  `rc_bot` tinyint(3) unsigned NOT NULL default '0',
  `rc_new` tinyint(3) unsigned NOT NULL default '0',
  `rc_cur_id` int(10) unsigned NOT NULL default '0',
  `rc_this_oldid` int(10) unsigned NOT NULL default '0',
  `rc_last_oldid` int(10) unsigned NOT NULL default '0',
  `rc_type` tinyint(3) unsigned NOT NULL default '0',
  `rc_moved_to_ns` tinyint(3) unsigned NOT NULL default '0',
  `rc_moved_to_title` varchar(255) default NULL,
  `rc_patrolled` tinyint(3) unsigned NOT NULL default '0',
  `rc_ip` varchar(15) default NULL,
  `rc_old_len` int(10) default NULL,
  `rc_new_len` int(10) default NULL,
  PRIMARY KEY  (`rc_id`),
  KEY `rc_timestamp` (`rc_timestamp`),
  KEY `rc_namespace_title` (`rc_namespace`,`rc_title`),
  KEY `rc_cur_id` (`rc_cur_id`),
  KEY `new_name_timestamp` (`rc_new`,`rc_namespace`,`rc_timestamp`),
  KEY `rc_ip` (`rc_ip`),
  KEY `rc_ns_usertext` (`rc_namespace`,`rc_user_text`),
  KEY `rc_user_text` (`rc_user_text`,`rc_timestamp`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Table structure for table `redirect`
--

DROP TABLE IF EXISTS `redirect`;
CREATE TABLE `redirect` (
  `rd_from` int(8) unsigned NOT NULL default '0',
  `rd_namespace` int(11) NOT NULL default '0',
  `rd_title` varchar(255) default NULL,
  PRIMARY KEY  (`rd_from`),
  KEY `rd_ns_title` (`rd_namespace`,`rd_title`,`rd_from`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Table structure for table `revision`
--

DROP TABLE IF EXISTS `revision`;
CREATE TABLE `revision` (
  `rev_id` int(8) unsigned NOT NULL auto_increment,
  `rev_page` int(8) unsigned NOT NULL default '0',
  `rev_text_id` int(8) unsigned NOT NULL default '0',
  `rev_comment` tinyblob NOT NULL,
  `rev_user` int(5) unsigned NOT NULL default '0',
  `rev_user_text` varchar(255) default NULL,
  `rev_timestamp` varchar(14) default NULL,
  `rev_minor_edit` tinyint(1) unsigned NOT NULL default '0',
  `rev_deleted` tinyint(1) unsigned NOT NULL default '0',
  PRIMARY KEY  (`rev_page`,`rev_id`),
  UNIQUE KEY `rev_id` (`rev_id`),
  KEY `rev_timestamp` (`rev_timestamp`),
  KEY `page_timestamp` (`rev_page`,`rev_timestamp`),
  KEY `user_timestamp` (`rev_user`,`rev_timestamp`),
  KEY `usertext_timestamp` (`rev_user_text`,`rev_timestamp`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Table structure for table `script_log`
--

DROP TABLE IF EXISTS `script_log`;
CREATE TABLE `script_log` (
  `script_id` int(11) NOT NULL auto_increment,
  `time` datetime NOT NULL,
  `script_name` varchar(128) default NULL,
  `comment` varchar(128) default NULL,
  PRIMARY KEY  (`script_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Table structure for table `searchindex`
--

DROP TABLE IF EXISTS `searchindex`;
CREATE TABLE `searchindex` (
  `si_page` int(8) unsigned NOT NULL default '0',
  `si_title` varchar(255) default NULL,
  `si_text` mediumtext character set latin1 NOT NULL,
  UNIQUE KEY `si_page` (`si_page`),
  FULLTEXT KEY `si_title` (`si_title`),
  FULLTEXT KEY `si_text` (`si_text`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Table structure for table `site_stats`
--

DROP TABLE IF EXISTS `site_stats`;
CREATE TABLE `site_stats` (
  `ss_row_id` int(8) unsigned NOT NULL default '0',
  `ss_total_views` bigint(20) unsigned default '0',
  `ss_total_edits` bigint(20) unsigned default '0',
  `ss_good_articles` bigint(20) unsigned default '0',
  `ss_total_pages` bigint(20) default '-1',
  `ss_users` bigint(20) default '-1',
  `ss_admins` int(10) default '-1',
  `ss_images` int(10) default '0',
  UNIQUE KEY `ss_row_id` (`ss_row_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Table structure for table `templatelinks`
--

DROP TABLE IF EXISTS `templatelinks`;
CREATE TABLE `templatelinks` (
  `tl_from` int(8) unsigned NOT NULL default '0',
  `tl_namespace` int(11) NOT NULL default '0',
  `tl_title` varchar(255) default NULL,
  UNIQUE KEY `tl_from` (`tl_from`,`tl_namespace`,`tl_title`),
  KEY `tl_namespace` (`tl_namespace`,`tl_title`,`tl_from`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Table structure for table `text`
--

DROP TABLE IF EXISTS `text`;
CREATE TABLE `text` (
  `old_id` int(8) unsigned NOT NULL auto_increment,
  `old_text` mediumblob NOT NULL,
  `old_flags` tinyblob NOT NULL,
  PRIMARY KEY  (`old_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Table structure for table `trackbacks`
--

DROP TABLE IF EXISTS `trackbacks`;
CREATE TABLE `trackbacks` (
  `tb_id` int(11) NOT NULL default '0',
  `tb_page` int(11) default NULL,
  `tb_title` varchar(255) default NULL,
  `tb_url` varchar(255) default NULL,
  `tb_ex` text,
  `tb_name` varchar(255) default NULL,
  PRIMARY KEY  (`tb_id`),
  KEY `tb_page` (`tb_page`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Table structure for table `transcache`
--

DROP TABLE IF EXISTS `transcache`;
CREATE TABLE `transcache` (
  `tc_url` varchar(255) default NULL,
  `tc_contents` text,
  `tc_time` int(11) NOT NULL default '0',
  UNIQUE KEY `tc_url_idx` (`tc_url`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `user_id` int(8) unsigned NOT NULL auto_increment,
  `user_name` varchar(255) default NULL,
  `user_real_name` varchar(255) default NULL,
  `user_password` tinyblob NOT NULL,
  `user_newpassword` tinyblob NOT NULL,
  `user_email` tinytext NOT NULL,
  `user_options` blob NOT NULL,
  `user_touched` varchar(14) default NULL,
  `user_token` varchar(32) default NULL,
  `user_email_authenticated` varchar(14) default NULL,
  `user_email_token` varchar(32) default NULL,
  `user_email_token_expires` varchar(14) default NULL,
  `user_registration` char(14) default NULL,
  `user_newpass_time` char(14) default NULL,
  `user_editcount` int(11) default NULL,
  PRIMARY KEY  (`user_id`),
  UNIQUE KEY `user_name` (`user_name`),
  KEY `user_email_token` (`user_email_token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Table structure for table `user_groups`
--

DROP TABLE IF EXISTS `user_groups`;
CREATE TABLE `user_groups` (
  `ug_user` int(5) unsigned NOT NULL default '0',
  `ug_group` char(16) NOT NULL default '',
  PRIMARY KEY  (`ug_user`,`ug_group`),
  KEY `ug_group` (`ug_group`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Table structure for table `user_newtalk`
--

DROP TABLE IF EXISTS `user_newtalk`;
CREATE TABLE `user_newtalk` (
  `user_id` int(5) NOT NULL default '0',
  `user_ip` varchar(40) default NULL,
  KEY `user_id` (`user_id`),
  KEY `user_ip` (`user_ip`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Table structure for table `watchlist`
--

DROP TABLE IF EXISTS `watchlist`;
CREATE TABLE `watchlist` (
  `wl_user` int(5) unsigned NOT NULL default '0',
  `wl_namespace` int(11) NOT NULL default '0',
  `wl_title` varchar(255) default NULL,
  `wl_notificationtimestamp` varchar(14) default NULL,
  UNIQUE KEY `wl_user` (`wl_user`,`wl_namespace`,`wl_title`),
  KEY `namespace_title` (`wl_namespace`,`wl_title`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Table structure for table `wikidata_sets`
--

DROP TABLE IF EXISTS `wikidata_sets`;
CREATE TABLE `wikidata_sets` (
  `set_prefix` varchar(20) default NULL,
  `set_fallback_name` varchar(255) default NULL,
  `set_dmid` int(10) default NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
