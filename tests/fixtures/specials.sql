CREATE TABLE `events_local_users` (
  `wiki_id` int(8) NOT NULL,
  `user_id` int(10) NOT NULL,
  `edits` int(11) NOT NULL DEFAULT '0',
  `editdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_revision` int(11) NOT NULL DEFAULT '0',
  `cnt_groups` smallint(4) NOT NULL DEFAULT '0',
  `single_group` varchar(255) NOT NULL DEFAULT '',
  `all_groups` mediumtext NOT NULL,
  `user_is_blocked` tinyint(1) DEFAULT '0',
  `user_is_closed` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`wiki_id`,`user_id`)
);

CREATE INDEX `user_edits` ON `events_local_users` (`user_id`,`edits`,`wiki_id`);
