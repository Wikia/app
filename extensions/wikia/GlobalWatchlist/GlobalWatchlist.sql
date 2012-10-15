CREATE TABLE global_watchlist (
 `gwa_id` INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
 `gwa_user_id` INT(11),
 `gwa_city_id` INT(11),
 `gwa_namespace` INT(11),
 `gwa_title` VARCHAR(255),
	`gwa_rev_id` INT(11),
	`gwa_timestamp` varchar(14),
	KEY `user_id` (`gwa_user_id`)
) ENGINE=InnoDB;
