CREATE TABLE `user_login_history` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(5) unsigned NOT NULL,
  `city_id` int(9) unsigned DEFAULT '0',
  `ulh_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ulh_from` tinyint(4) DEFAULT '0',
  `ulh_rememberme` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_user_login_history_wikia_timestamp` (`city_id`,`user_id`,`ulh_timestamp`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `user_login_history_summary` (
  `user_id` int(8) unsigned NOT NULL,
  `ulh_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
