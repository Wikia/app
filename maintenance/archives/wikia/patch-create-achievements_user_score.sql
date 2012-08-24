CREATE TABLE /*$wgDBprefix*/ach_user_score (
	`user_id` int(5) unsigned NOT NULL,
	`score` int(10) unsigned NOT NULL,
	UNIQUE KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
