--- Additional table for the SharedUserRights extension
--- To be added to $wgSharedDB

CREATE TABLE `shared_user_groups` (
  `sug_user` int(5) unsigned NOT NULL default '0',
  `sug_group` char(16) NOT NULL default '',
  PRIMARY KEY  (`sug_user`,`sug_group`),
  KEY `sug_group` (`sug_group`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
