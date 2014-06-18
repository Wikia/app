CREATE TABLE `city_visualization_xwiki` (
  `city_id` int(11) DEFAULT NULL,
  `city_lang_code` char(8) NOT NULL DEFAULT 'en',
  `city_vertical` int(11) DEFAULT NULL,
  `city_headline` varchar(255) DEFAULT NULL,
  `city_description` text,
  `city_flags` smallint(8) DEFAULT '0',
  PRIMARY KEY `cvx_cid_lc` (`city_id`,`city_lang_code`),
  KEY `cvx_cid_cf_ce` (`city_id`,`city_flags`),
  CONSTRAINT `city_visualization_xwiki_ibfk_1` FOREIGN KEY (`city_id`) REFERENCES `city_list` (`city_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1
