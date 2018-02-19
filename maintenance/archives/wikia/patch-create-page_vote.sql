-- page_vote for article voting
CREATE TABLE /*$wgDBprefix*/page_vote (
	`article_id` int(8) unsigned NOT NULL,
	`user_id` int(5) unsigned NOT NULL,
	`vote` int(2) NOT NULL,
	`ip` varbinary(32) DEFAULT NULL,
	`time` datetime NOT NULL,
	KEY `article_user_idx` (`article_id`, `user_id`)
) ENGINE=InnoDB;
