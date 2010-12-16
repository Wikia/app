CREATE TABLE `contribution_tracking` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `contribution_id` int(10) unsigned default NULL,
  `note` text,
  `referrer` varchar(4096) default NULL,
  `anonymous` tinyint(1) unsigned NOT NULL,
  `utm_source` varchar(128) default NULL,
  `utm_medium` varchar(128) default NULL,
  `utm_campaign` varchar(128) default NULL,
  `optout` tinyint(1) unsigned NOT NULL,
  `language` varchar(8) default NULL,
  `ts` char(14) default NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `contribution_id` (`contribution_id`),
  KEY `ts` (`ts`)
) /*wgDBTableOptions/*; 
