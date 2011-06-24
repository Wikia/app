CREATE TABLE founder_progress_bar_tasks (
        `wiki_id` int(10) NOT NULL,
        `task_id` int(10) NOT NULL,
        `task_count` int(10) DEFAULT '0',
		`task_completed` tinyint(1) NOT NULL DEFAULT '0',
        `task_skipped` tinyint(1) NOT NULL DEFAULT '0',
		`task_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY ( `wiki_id`, `task_id` )
) ENGINE=InnoDB;