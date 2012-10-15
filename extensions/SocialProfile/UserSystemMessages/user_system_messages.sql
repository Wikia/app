CREATE TABLE /*_*/user_system_messages (
  `um_id` int(11) NOT NULL PRIMARY KEY auto_increment,
  `um_user_id` int(11) NOT NULL default '0',
  `um_user_name` varchar(255) NOT NULL default '',
  `um_message` varchar(255) NOT NULL default '',
  `um_type` int(5) default '0',
  `um_date` datetime default NULL
) /*$wgDBTableOptions*/;
CREATE INDEX /*i*/up_user_id ON /*_*/user_system_messages (`um_user_id`);
