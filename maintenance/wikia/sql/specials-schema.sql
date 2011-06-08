CREATE TABLE `city_list_count` (
  `city_created` date NOT NULL,
  `count_created` int(8) unsigned NOT NULL,
  PRIMARY KEY `city_created` 
) ENGINE=InnoDB DEFAULT CHARSET=utf8


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
) ENGINE=InnoDB DEFAULT CHARSET=utf8
