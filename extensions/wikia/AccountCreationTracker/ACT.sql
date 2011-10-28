CREATE TABLE user_tracker (
	`utr_user_id` INT(11) NOT NULL DEFAULT 0,
	`utr_user_hash` VARCHAR(32),
	KEY `hash` (`utr_user_hash`)
);
