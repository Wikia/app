--
-- This file should only contain Wikia-specific tables,
-- which are meant to be created in _local_ databases.

-- Note that this file is subject to move to /wikia subdirectory.

CREATE TABLE IF NOT EXISTS `page_vote` (
  `article_id` int(8) unsigned NOT NULL,
  `user_id` int(5) unsigned NOT NULL,
  `unique_id` varchar(32) NOT NULL DEFAULT '',
  `vote` int(2) NOT NULL,
  `ip` varchar(32) NOT NULL,
  `time` datetime NOT NULL,
  KEY `user_id` (`user_id`,`article_id`),
  KEY `article_id` (`article_id`),
  KEY `unique_vote` (`unique_id`, `article_id`)
) ENGINE=InnoDB;

CREATE TABLE `page_visited` (
	`article_id` int(9) not null, 
	`count` int(8) NOT NULL, 
	`prev_diff` int(8) NOT NULL DEFAULT 0, 
	PRIMARY KEY (`article_id`), 
	KEY `page_visited_cnt_inx` (`count`), 
	KEY `pv_changes` (`prev_diff`,`article_id`)
) ENGINE=InnoDB;
