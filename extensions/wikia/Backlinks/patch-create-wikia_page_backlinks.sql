CREATE TABLE /*$wgDBprefix*/wikia_page_backlinks (
	`source_page_id` UNSIGNED INT NOT NULL,
	`target_page_id` UNSIGNED INT NOT NULL,
	`backlink_text` VARBINARY(255),
	`count` INT,
	PRIMARY KEY (`source_page_id`, `target_page_id`, `backlink_text`),
	KEY `wikia_page_backlinks_source_page_id` (`source_page_id`),
	KEY `wikia_page_backlinks_target_page_id` (`target_page_id`)
) ENGINE = InnoDB;
