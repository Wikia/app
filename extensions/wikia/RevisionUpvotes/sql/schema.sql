CREATE TABLE IF NOT EXISTS `upvote_revisions` (
	`upvote_id` INT unsigned NOT NULL AUTO_INCREMENT,
	`wiki_id` INT unsigned NOT NULL,
	`revision_id` INT unsigned NOT NULL,
	`page_id` INT unsigned NOT NULL,
	`user_id` INT unsigned NOT NULL,
	PRIMARY KEY (`upvote_id`),
	UNIQUE KEY `upvote_revision_unique` (`wiki_id`, `revision_id`)
) ENGINE = INNODB CHARACTER SET utf8 COLLATE utf8_unicode_ci;
CREATE INDEX `upvote_revision_user_idx` ON `upvote_revisions` (`user_id`);

CREATE TABLE IF NOT EXISTS `upvote` (
	`id` INT unsigned NOT NULL AUTO_INCREMENT,
	`upvote_id` INT unsigned NOT NULL,
	`from_user` INT unsigned NOT NULL,
	`date` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (`id`),
	UNIQUE KEY `upvote_rev_user_unique` (`upvote_id`, `from_user`)
) ENGINE = INNODB CHARACTER SET utf8 COLLATE utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS `upvote_users` (
	`user_id` INT unsigned NOT NULL,
	`total` MEDIUMINT unsigned DEFAULT 0,
	`new` MEDIUMINT unsigned DEFAULT 0,
	`notified` BOOLEAN NOT NULL DEFAULT FALSE,
	`should_notify` BOOLEAN NOT NULL DEFAULT TRUE,
	`last_notified` TIMESTAMP DEFAULT NULL,
	PRIMARY KEY (`user_id`)
) ENGINE = INNODB CHARACTER SET utf8 COLLATE utf8_unicode_ci;
