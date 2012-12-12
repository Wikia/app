CREATE TABLE /*$wgDBprefix*/ach_user_badges (
	`user_id` int(5) unsigned NOT NULL,
	`badge_type_id` int(10) signed NOT NULL,
	`badge_lap` int DEFAULT NULL,
	`badge_level` tinyint(3) unsigned NOT NULL,
	`date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
	`notified` tinyint(1) NOT NULL DEFAULT '0',
	KEY `id` (`user_id`),
	KEY `badge_count` (`badge_type_id`,`badge_lap`),
	KEY `level_date2` (`badge_level`,`date`,`badge_lap`),
	KEY `user_badge` (`user_id`,`badge_type_id`,`badge_lap`),
	KEY `user_date_lap` (`user_id`,`date`,`badge_lap`),
	KEY `notified_id` (`user_id`,`notified`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
