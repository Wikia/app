CREATE TABLE founder_progress_bar (
        `wiki_id` int(10) NOT NULL,
        `action_id` int(10) NOT NULL,
        `action_count` int(10) DEFAULT '0',
		`action_completed` tinyint(1) NOT NULL DEFAULT '0',
        `action_skipped` tinyint(1) NOT NULL DEFAULT '0',
		`action_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
    PRIMARY KEY ( `game_id` )
) ENGINE=InnoDB;