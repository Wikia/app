--
-- Table structure for table `user_relationship`
--

CREATE TABLE /*$wgDBprefix*/user_relationship (
  `r_id` int(11) NOT NULL auto_increment,
  `r_user_id` int(5) unsigned NOT NULL default '0',
  `r_user_name` varchar(255) NOT NULL default '',
  `r_user_id_relation` int(5) unsigned NOT NULL default '0',
  `r_user_name_relation` varchar(255) NOT NULL default '',
  `r_type` int(2) default NULL,
  `r_date` datetime default NULL,
  PRIMARY KEY  (`r_id`),
  KEY `r_user_id` (`r_user_id`),
  KEY `r_user_id_relation` (`r_user_id_relation`)
)DEFAULT CHARSET=utf8;

--
-- Table structure for table `user_relationship_request`
--

CREATE TABLE /*$wgDBprefix*/user_relationship_request (
  `ur_id` int(11) NOT NULL auto_increment,
  `ur_user_id_from` int(5) unsigned NOT NULL default '0',
  `ur_user_name_from` varchar(255) NOT NULL default '',
  `ur_user_id_to` int(5) unsigned NOT NULL default '0',
  `ur_user_name_to` varchar(255) NOT NULL default '',
  `ur_status` int(2) default '0',
  `ur_type` int(2) default NULL,
  `ur_message` varchar(255) default NULL,
  `ur_date` datetime default NULL,
  PRIMARY KEY  (`ur_id`),
  KEY `ur_user_id_from` (`ur_user_id_from`),
  KEY `ur_user_id_to` (`ur_user_id_to`)
) DEFAULT CHARSET=utf8;
