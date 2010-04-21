CREATE TABLE `blog_listing_relation` ( 
  `blr_relation`  VARBINARY(255) NOT NULL DEFAULT '',
  `blr_title` VARBINARY(255) NOT NULL DEFAULT '',
  `blr_type` ENUM('cat','user'),
  UNIQUE KEY `wl_user` (`blr_relation`,`blr_title`,`blr_type`),
  KEY `type_relation` (`blr_relation`,`blr_type`)
) ENGINE=INNODB DEFAULT CHARSET=BINARY;


alter table watchlist add wl_created TIMESTAMP DEFAULT NOW();