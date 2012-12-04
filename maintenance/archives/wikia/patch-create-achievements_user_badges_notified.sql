CREATE TABLE /*$wgDBprefix*/ach_user_badges_notified (
	`user_id` int(5) unsigned NOT NULL,
	`lastseen` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (`user_id`),
	KEY `user_id_lastseen` (`user_id`,`lastseen`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
