CREATE TABLE /*$wgDBprefix*/city_cats (
  `cat_id` int(9) NOT NULL auto_increment,
  `cat_name` varchar(255) default NULL,
  `cat_url` text,
  `cat_short` varchar(255) default NULL,
  PRIMARY KEY  (`cat_id`),
  KEY `cat_name_idx` (`cat_name`)
) ENGINE=InnoDB;

