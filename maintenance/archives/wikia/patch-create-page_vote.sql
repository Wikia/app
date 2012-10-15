-- page_vote for article voting
CREATE TABLE /*$wgDBprefix*/page_vote (
	`article_id` int(8) unsigned NOT NULL,
	`user_id` int(5) unsigned NOT NULL,
	`unique_id` varchar(32) NOT NULL DEFAULT '',
	`vote` int(2) NOT NULL,
	`ip` varbinary(32) NOT NULL,
	`time` datetime NOT NULL,
	KEY `user_id` (`user_id`,`article_id`),
	KEY `article_id` (`article_id`),
	KEY `unique_vote` (`unique_id`, `article_id`)
) ENGINE=InnoDB;
