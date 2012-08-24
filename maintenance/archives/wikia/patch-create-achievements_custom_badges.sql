CREATE TABLE /*$wgDBprefix*/ach_custom_badges (
	`id` int(10) signed NOT NULL AUTO_INCREMENT PRIMARY KEY,
	`cat` varchar(255),
	`enabled` tinyint(1) NOT NULL DEFAULT 0,
	`type` tinyint(1) NOT NULL,
	`sponsored` TINYINT(1) NOT NULL DEFAULT 0,
	`badge_tracking_url` VARCHAR(255) DEFAULT NULL,
	`hover_tracking_url` VARCHAR(255) DEFAULT NULL,
	`click_tracking_url` VARCHAR(255) DEFAULT NULL,
	KEY `id` (`id`),
	KEY `type` (`type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
