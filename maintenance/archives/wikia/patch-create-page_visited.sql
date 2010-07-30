-- page_visited for page views stats
CREATE TABLE /*$wgDBprefix*/page_visited (
	`article_id` int(9) not null,
	`count` int(8) NOT NULL,
	`prev_diff` int(8) NOT NULL DEFAULT 0,
	PRIMARY KEY (`article_id`),
	KEY `page_visited_cnt_inx` (`count`),
	KEY `pv_changes` (`prev_diff`,`article_id`)
) ENGINE=InnoDB;
