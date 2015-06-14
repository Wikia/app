CREATE TABLE `city_list_cats` (
  `city_id` int(9) NOT NULL DEFAULT '0',
  `city_dbname` varchar(64) NOT NULL DEFAULT 'notreal',
  `city_created` datetime DEFAULT NULL,
  `city_founding_user` int(5) DEFAULT NULL,
  `city_title` varchar(255) DEFAULT NULL,
  `city_lang` varchar(8) NOT NULL DEFAULT 'en',
  `city_last_timestamp` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `city_public` int(1) NOT NULL DEFAULT '1',
  `date_created` date DEFAULT NULL,
  `count_created` int(8) unsigned NOT NULL,
  `cat_name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (city_id),
  UNIQUE KEY `city_dbname_inx` (city_dbname),
  KEY `city_founding_user_inx` (city_founding_user),
  KEY `date_created_inx` (date_created),
  KEY `cat_name_inx` (cat_name)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `multilookup` (
  `ml_city_id` int(9) unsigned NOT NULL,
  `ml_ip` int(10) NOT NULL,
  `ml_count` int(6) unsigned NOT NULL default 0,
  `ml_ts` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (ml_city_id, ml_ip),
  KEY `multilookup_ts_inx` (ml_ip, ml_ts)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `events_local_users` (
  `wiki_id` int(8) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `user_name` varchar(255) NOT NULL DEFAULT '',
  `last_ip` int(10) unsigned NOT NULL DEFAULT '0',
  `edits` int(11) unsigned NOT NULL DEFAULT '0',
  `editdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `last_revision` int(11) NOT NULL DEFAULT '0',
  `cnt_groups` smallint(4) NOT NULL DEFAULT '0',
  `single_group` char(25) NOT NULL DEFAULT '',
  `all_groups` mediumtext NOT NULL,
  `user_is_blocked` tinyint(1) DEFAULT '0',
  `user_is_closed` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`wiki_id`,`user_id`,`user_name`),
  KEY `user_edits` (`user_id`,`edits`,`wiki_id`),
  KEY `user_id` (`user_id`),
  KEY `edits` (`edits`),
  KEY `wiki_id` (`wiki_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
