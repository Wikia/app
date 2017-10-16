CREATE TABLE `user_email_log` (
	`user_id` int unsigned NOT NULL,
	`old_email` tinytext NOT NULL,
	`new_email` tinytext NOT NULL,
	`changed_by_id` int unsigned NOT NULL,
	`changed_by_ip` char(40) NOT NULL,
	`changed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
	KEY (`user_id`, `old_email`(40)),
	KEY (`user_id`, `new_email`(40))
) ENGINE=InnoDB;
