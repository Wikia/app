CREATE TABLE IF NOT EXISTS `ach_user_score` (
	`user_id` int(5) unsigned NOT NULL,
	`score` int(10) unsigned NOT NULL,
	UNIQUE KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


CREATE TABLE IF NOT EXISTS `ach_user_counters` (
	`user_id` int(5) unsigned NOT NULL,
	`data` text NOT NULL,
	PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


CREATE TABLE IF NOT EXISTS `ach_user_badges` (
	`user_id` int(5) unsigned NOT NULL,
	`badge_type_id` int(10) signed NOT NULL,
	`badge_lap` int(11) DEFAULT NULL,
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


CREATE TABLE IF NOT EXISTS `ach_user_badges_notified` (
	`user_id` int(5) unsigned NOT NULL,
	`lastseen` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (`user_id`),
	KEY `user_id_lastseen` (`user_id`,`lastseen`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


CREATE TABLE IF NOT EXISTS `ach_custom_badges` (
	`id` int(10) signed NOT NULL AUTO_INCREMENT PRIMARY KEY,
	`cat` varchar(255),
	`enabled` tinyint(1) NOT NULL DEFAULT 0,
	`type` tinyint(1) NOT NULL,
	`sponsored` TINYINT(1) NOT NULL DEFAULT 0,
	`badge_tracking_url` VARCHAR(255) DEFAULT NULL,
	`hover_tracking_url` VARCHAR(255) DEFAULT NULL,
	`click_tracking_url` VARCHAR(255) DEFAULT NULL,
	KEY `type` (`type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


CREATE TABLE IF NOT EXISTS `ach_ranking_snapshots` (
	`date` DATETIME NOT NULL ,
	`data` TEXT NOT NULL
) ENGINE = INNODB CHARACTER SET utf8 COLLATE utf8_unicode_ci;