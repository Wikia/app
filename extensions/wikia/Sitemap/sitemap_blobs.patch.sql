CREATE TABLE sitemap_blobs (
	`sbl_ns_id` INT NOT NULL,
	`sbl_page_id` INT NOT NULL,
	`sbl_updated` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	`sbl_content` LONGBLOB,
	PRIMARY KEY (`sbl_ns_id`, `sbl_page_id`)
) ENGINE = InnoDB;
