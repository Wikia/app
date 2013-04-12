CREATE TABLE `webmaster_sitemaps` (
  `wiki_id` int(9) unsigned NOT NULL DEFAULT '0',
  `user_id` SMALLINT unsigned DEFAULT NULL,
  `upload_date` date DEFAULT NULL,
  PRIMARY KEY (wiki_id, user_id),
  KEY `user_inx` (user_id),
  KEY `date_inx` (upload_date)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `webmaster_user_accounts` (
  `user_id` SMALLINT unsigned NOT NULL DEFAULT '0',
  `user_name` varchar(100) DEFAULT NULL,
  `user_password` varchar(100) DEFAULT NULL,
  `wikis_number` SMALLINT unsigned NOT NULL DEFAULT '0'
  PRIMARY KEY (user_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
