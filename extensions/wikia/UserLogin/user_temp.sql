CREATE TABLE `user_temp` (
  `user_id` int(5) unsigned NOT NULL DEFAULT 0,
  `user_wiki_id` int(11) NOT NULL DEFAULT 0,
  `user_name` varchar(255) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL DEFAULT '',
  `user_password` tinyblob NOT NULL,
  `user_email` tinytext NOT NULL,
  `user_registration` varchar(16) DEFAULT NULL,
  `user_birthdate` date DEFAULT NULL,
  `user_source` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`user_id`, `user_wiki_id`),
  UNIQUE KEY `user_name` (`user_name`),
  KEY `user_email` (`user_email`(40)),
  KEY `user_registration` (`user_registration`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;