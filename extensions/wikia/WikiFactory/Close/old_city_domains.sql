CREATE TABLE `archive`.`old_city_domains` (
  `city_id` int(10) unsigned NOT NULL,
  `city_domain` varchar(255) NOT NULL default 'wikia.com',
  `city_timestamp` varchar(14) NOT NULL default '19700101000000',
  `city_new_id` int(10) unsigned default NULL,
  PRIMARY KEY  (`city_id`,`city_domain`,`city_timestamp`),
  KEY `city_domains_idx` (`city_domain`),
  KEY `city_domains_timestamp_idx` (`city_domain`, `city_timestamp`),
  KEY `city_new_id_idx` (`city_new_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1
