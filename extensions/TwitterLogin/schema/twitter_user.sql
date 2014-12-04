CREATE TABLE IF NOT EXISTS `twitter_user` ( 
	`tl_user_id` int(10) unsigned NOT NULL, 
	`tl_twitter_id` varchar(255) NOT NULL, 
	PRIMARY KEY  (`tl_user_id`),
	UNIQUE KEY `tl_twitter_id` (`tl_twitter_id`)
); 
