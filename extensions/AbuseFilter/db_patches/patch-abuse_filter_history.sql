-- Patch to add abuse_filter_history table

CREATE TABLE /*$wgDBprefix*/abuse_filter_history (
	afh_id BIGINT unsigned NOT NULL AUTO_INCREMENT,
	afh_filter BIGINT unsigned NOT NULL,
	afh_user BIGINT unsigned NOT NULL,
	afh_user_text varchar(255) binary NOT NULL,
	afh_timestamp binary(14) NOT NULL,
	afh_pattern BLOB NOT NULL,
	afh_comments BLOB NOT NULL,
	afh_flags TINYBLOB NOT NULL,
	afh_public_comments TINYBLOB,
	afh_actions BLOB,
	
	PRIMARY KEY (afh_id),
	KEY (afh_filter),
	KEY (afh_user),
	KEY (afh_user_text),
	KEY (afh_timestamp)
) /*$wgDBTableOptions*/;
