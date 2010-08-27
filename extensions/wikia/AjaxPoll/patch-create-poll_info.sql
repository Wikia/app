-- poll_info vote for ajax poll

CREATE TABLE /*$wgDBprefix*/poll_info (
  `poll_id` varchar(32) NOT NULL default '',
  `poll_txt` text,
  `poll_date` datetime default NULL,
  `poll_title` varchar(255) default NULL,
  `poll_domain` varchar(10) default NULL,
  PRIMARY KEY  (`poll_id`)
) ENGINE=InnoDB ;