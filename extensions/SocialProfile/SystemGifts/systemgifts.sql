CREATE TABLE /*$wgDBprefix*/user_system_gift (
  `sg_id` int(11) NOT NULL auto_increment,
  `sg_gift_id` int(5) unsigned NOT NULL default '0',
  `sg_user_id` int(11) unsigned NOT NULL default '0',
  `sg_user_name` varchar(255) NOT NULL default '',
  `sg_status` int(2) default '1',
  `sg_date` datetime default NULL,
  PRIMARY KEY  (`sg_id`),
  KEY `sg_user_id` (`sg_user_id`),
  KEY `sg_gift_id` (`sg_gift_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE /*$wgDBprefix*/system_gift (
  `gift_id` int(11) NOT NULL auto_increment,
  `gift_name` varchar(255) NOT NULL default '',
  `gift_description` text,
  `gift_given_count` int(11) default '0',
  `gift_category` int(11) default '0',
  `gift_threshold` int(15) default '0',
  `gift_createdate` datetime default NULL,
  PRIMARY KEY  (`gift_id`),
  KEY `giftcategoryidx` (`gift_category`),
  KEY `giftthresholdidx` (`gift_threshold`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;