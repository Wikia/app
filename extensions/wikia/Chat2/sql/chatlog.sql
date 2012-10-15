CREATE TABLE `chatlog` (
	`wiki_id` int(8) unsigned NOT NULL,
	`user_id` int(8) unsigned NOT NULL,
	`log_id` int(8) unsigned NOT NULL AUTO_INCREMENT,
	`event_type` tinyint(2) unsigned NOT NULL DEFAULT '6',
	`event_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	PRIMARY KEY (`log_id`),
	KEY `wikilog` (`wiki_id`,`log_id`),
	KEY `event_date` (`wiki_id`,`event_date`),
	KEY `users` (`user_id`,`wiki_id`,`event_type`),
	KEY `wiki_users` (`wiki_id`,`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;