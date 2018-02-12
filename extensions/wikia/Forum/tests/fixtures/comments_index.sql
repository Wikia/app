CREATE TABLE IF NOT EXISTS /*$wgDBprefix*/comments_index (
  `parent_page_id` int(10) NOT NULL,
  `comment_id` int(10) NOT NULL,
  `parent_comment_id` int(10) NOT NULL DEFAULT '0',
  `last_child_comment_id` int(10) NOT NULL DEFAULT '0',
  `archived` tinyint(1) NOT NULL DEFAULT '0',
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  `removed` tinyint(1) NOT NULL DEFAULT '0',
  `first_rev_id` int(10) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `last_rev_id` int(10) NOT NULL DEFAULT '0',
  `last_touched` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`parent_page_id`,`comment_id`)
);

CREATE INDEX `parent_page_id` ON comments_index (`parent_page_id`,`archived`,`deleted`,`removed`,`parent_comment_id`);
CREATE INDEX `comment_id` ON comments_index (`comment_id`,`archived`,`deleted`,`removed`);
CREATE INDEX `parent_comment_id` ON comments_index (`parent_comment_id`,`archived`,`deleted`,`removed`);
CREATE INDEX `last_touched` ON comments_index (`last_touched`,`archived`,`deleted`,`removed`,`parent_comment_id`,`parent_page_id`);
