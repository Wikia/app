DROP TABLE IF EXISTS `user_tracker`;
CREATE TABLE user_tracker (
	`utr_user_id` INT(11) NOT NULL DEFAULT 0,
	`utr_user_hash` VARCHAR(32),
	`utr_source` TINYINT(3) unsigned NOT NULL,
	KEY `hash` (`utr_user_hash`),
	KEY `user_id` (`utr_user_id`)
);
