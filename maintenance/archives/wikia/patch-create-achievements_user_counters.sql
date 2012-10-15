CREATE TABLE /*$wgDBprefix*/ach_user_counters (
	`user_id` int(5) unsigned NOT NULL,
	`data` text NOT NULL,
	PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
