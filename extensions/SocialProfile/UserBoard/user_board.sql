--
-- Table structure for table `user_board`
--

CREATE TABLE /*$wgDBprefix*/user_board (
  `ub_id` int(11) NOT NULL auto_increment,
  `ub_user_id` int(11) NOT NULL default '0',
  `ub_user_name` varchar(255) NOT NULL default '',
  `ub_user_id_from` int(11) NOT NULL default '0',
  `ub_user_name_from` varchar(255) NOT NULL default '',
  `ub_message` text NOT NULL,
  `ub_type` int(5) default '0',
  `ub_date` datetime default NULL,
  PRIMARY KEY  (`ub_id`),
  KEY `ub_user_id` (`ub_user_id`),
  KEY `ub_user_id_from` (`ub_user_id_from`),
  KEY `ub_type` (`ub_type`)
) DEFAULT CHARSET=utf8;
