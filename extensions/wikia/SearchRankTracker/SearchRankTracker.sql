CREATE TABLE `rank_entry` (
  `ren_id` int(11) NOT NULL auto_increment,
  `ren_city_id` int(11) default NULL,
  `ren_page_name` varchar(255) default NULL,
  `ren_page_url` varchar(255) default NULL,
		`ren_is_main_page` enum('0','1') default '0',
  `ren_phrase` varchar(255) default NULL,
  `ren_created` datetime default NULL,
  PRIMARY KEY  (`ren_id`),
  KEY `city_id` (`ren_city_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8

CREATE TABLE `rank_result` (
  `rre_id` int(11) NOT NULL auto_increment,
  `rre_ren_id` int(11) default NULL,
  `rre_engine` varchar(32) character set latin1 default NULL,
  `rre_date` datetime default NULL,
  `rre_rank` int(11) default NULL,
  PRIMARY KEY  (`rre_id`),
  KEY `entry_id` (`rre_ren_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8
