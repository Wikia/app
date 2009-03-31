CREATE TABLE /*$wgDBprefix*/user_gift (
  `ug_id` int(11) NOT NULL auto_increment,
  `ug_gift_id` int(5) unsigned NOT NULL default '0',
  `ug_user_id_to` int(5) unsigned NOT NULL default '0',
  `ug_user_name_to` varchar(255) NOT NULL default '',
  `ug_user_id_from` int(5) unsigned NOT NULL default '0',
  `ug_user_name_from` varchar(255) NOT NULL default '',
  `ug_status` int(2) default '1',
  `ug_type` int(2) default NULL,
  `ug_message` varchar(255) default NULL,
  `ug_date` datetime default NULL,
  PRIMARY KEY  (`ug_id`),
  KEY `ug_user_id_from` (`ug_user_id_from`),
  KEY `ug_user_id_to` (`ug_user_id_to`)
) ENGINE=InnoDB;

CREATE TABLE /*$wgDBprefix*/gift (
  `gift_id` int(11) unsigned NOT NULL auto_increment,
  `gift_access` int(5) NOT NULL default '0',
  `gift_creator_user_id` int(11) NOT NULL default '0',
  `gift_creator_user_name` varchar(255) NOT NULL default '',
  `gift_name` varchar(255) NOT NULL default '',
  `gift_description` text,
  `gift_given_count` int(5) default '0',
  `gift_createdate` datetime default NULL,
  PRIMARY KEY  (`gift_id`)
) ENGINE=InnoDB;