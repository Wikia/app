-- DATABASE: DATAWARE

CREATE TABLE /*$wgDBprefix*/scavenger_hunt_games (
	`game_id` int(10) NOT NULL auto_increment,
	`wiki_id` int(10) NOT NULL,
	`game_name` varchar(255) NOT NULL,
	`game_is_enabled` tinyint(1) DEFAULT 0,
	`game_data` blob,
    PRIMARY KEY ( `game_id` )
) ENGINE=InnoDB;

CREATE TABLE /*$wgDBprefix*/scavenger_hunt_entries (
	`entry_id` int(10) NOT NULL auto_increment,
	`game_id` int(10) NOT NULL,
	`user_id` int(10),
	`entry_name` varchar(255),
	`entry_email` varchar(255),
	`entry_answer` varchar(255),
    PRIMARY KEY ( `entry_id` )
) ENGINE=InnoDB;