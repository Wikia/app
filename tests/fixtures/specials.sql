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

CREATE TABLE IF NOT EXISTS local_user_groups (
    user_id int(5) NOT NULL,
	wiki_id int NOT NULL,
	group_name varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
	expiry datetime
) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE INDEX ix_local_user_groups ON local_user_groups (user_id, wiki_id);
