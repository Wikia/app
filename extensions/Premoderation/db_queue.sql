CREATE TABLE IF NOT EXISTS /*_*/pm_queue (
	pmq_id BIGINT unsigned NOT NULL PRIMARY KEY AUTO_INCREMENT,
	pmq_page_last_id INT unsigned NOT NULL,
	pmq_page_ns INT NOT NULL,
	pmq_page_title VARCHAR(255) BINARY NOT NULL,
	pmq_user INT unsigned NOT NULL DEFAULT 0,
	pmq_user_text VARCHAR(255) BINARY NOT NULL DEFAULT '',
	pmq_timestamp BINARY(14) NOT NULL DEFAULT '',
	pmq_minor TINYINT unsigned NOT NULL DEFAULT 0,	
	pmq_summary TINYBLOB NOT NULL,
	pmq_len INT unsigned,
	pmq_text MEDIUMBLOB NOT NULL,
	pmq_flags tinyblob NOT NULL,
	pmq_ip VARBINARY(40) NOT NULL DEFAULT '',
	pmq_updated BINARY(14) DEFAULT NULL,
	pmq_updated_user INT unsigned DEFAULT NULL,
	pmq_updated_user_text VARCHAR(255) BINARY DEFAULT NULL,
	pmq_status VARBINARY(40) NOT NULL DEFAULT ''
) /*$wgDBTableOptions*/;
CREATE INDEX /*i*/pmq_user ON /*_*/pm_queue (pmq_user);