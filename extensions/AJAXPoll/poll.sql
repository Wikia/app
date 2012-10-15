CREATE TABLE IF NOT EXISTS /*_*/poll_info (
  `poll_id` varchar(32) NOT NULL PRIMARY KEY default '',
  `poll_txt` text,
  `poll_date` datetime default NULL,
  `poll_title` varchar(255) default NULL
) /*$wgDBTableOptions*/;

CREATE TABLE IF NOT EXISTS /*_*/poll_vote (
  `poll_id` varchar(32) NOT NULL default '',
  `poll_user` varchar(255) NOT NULL default '',
  `poll_ip` varchar(255) default NULL,
  `poll_answer` int(3) default NULL,
  `poll_date` datetime default NULL,
  PRIMARY KEY  (`poll_id`,`poll_user`)
) /*$wgDBTableOptions*/;