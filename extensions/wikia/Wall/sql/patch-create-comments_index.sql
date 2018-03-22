CREATE TABLE IF NOT EXISTS /*$wgDBprefix*/comments_index (
  `parent_page_id` int(10) unsigned NOT NULL,
  `comment_id` int(10) unsigned NOT NULL,
  `parent_comment_id` int(10) unsigned NOT NULL DEFAULT '0',
  `last_child_comment_id` int(10) unsigned NOT NULL DEFAULT '0',
  `archived` tinyint(1) NOT NULL DEFAULT '0',
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  `removed` tinyint(1) NOT NULL DEFAULT '0',
  `first_rev_id` int(10) unsigned NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `last_rev_id` int(10) unsigned NOT NULL DEFAULT '0',
  `last_touched` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`parent_page_id`,`comment_id`),
  KEY `parent_page_id` (`parent_page_id`,`archived`,`deleted`,`removed`,`parent_comment_id`),
  KEY `comment_id` (`comment_id`,`archived`,`deleted`,`removed`),
  KEY `parent_comment_id` (`parent_comment_id`,`archived`,`deleted`,`removed`),
  KEY `last_touched` (`last_touched`,`archived`,`deleted`,`removed`,`parent_comment_id`,`parent_page_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
