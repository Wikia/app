CREATE TABLE `user_login_history` (
  `user_id` int(5) unsigned NOT NULL,
  `city_id` int(9) unsigned default '0',
  `ulh_timestamp` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `ulh_from` tinyint(4) default '0',
  KEY `idx_user_login_history_timestamp` (`ulh_timestamp`),
  KEY `idx_user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `user_history` (
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
