CREATE TABLE /*_*/user_register_track (
  `ur_user_id` int(10) unsigned NOT NULL PRIMARY KEY default '0',
  `ur_user_name` varchar(255) default NULL,
  `ur_user_id_referral` int(10) unsigned default '0',
  `ur_user_name_referral` varchar(255) default NULL,
  `ur_from` int(5) default '0',
  `ur_date` datetime default NULL
) /*$wgDBTableOptions*/;