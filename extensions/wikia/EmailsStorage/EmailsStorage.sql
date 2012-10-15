-- DATABASE: DATAWARE

CREATE TABLE /*$wgDBprefix*/emails_storage (
	-- primary key
	`entry_id` int(10) NOT NULL auto_increment,
	-- type of an entry (scavenger hunt, trivia, ...)
	`source_id` int(10) NOT NULL,
	-- hunt / quiz ID
	`page_id` int(10) NOT NULL,
	-- wiki ID
	`city_id` int(9) NOT NULL,
	-- email address
	`email` tinytext,
	-- user ID (zero when anon)
	`user_id` int(10) unsigned,
	-- beacon ID (set for both anons and logged-in)
	`beacon_id` char(10),
	-- feedback provided by the user
	`feedback` varchar(255),
	-- when entry was added
	`timestamp` char(14),
    PRIMARY KEY (`entry_id`)
) ENGINE=InnoDB;

CREATE INDEX emails_storage_entry_source
	ON emails_storage(source_id);

CREATE INDEX emails_storage_entry_timestamp
	ON emails_storage(city_id);
