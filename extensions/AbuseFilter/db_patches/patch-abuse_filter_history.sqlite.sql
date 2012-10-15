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
	afh_actions BLOB
) /*$wgDBTableOptions*/;
CREATE INDEX afh_filter ON /*$wgDBprefix*/abuse_filter_history (afh_filter);
CREATE INDEX afh_user ON /*$wgDBprefix*/abuse_filter_history (afh_user);
CREATE INDEX afh_user_text ON /*$wgDBprefix*/abuse_filter_history (afh_user_text);
CREATE INDEX afh_timestamp ON /*$wgDBprefix*/abuse_filter_history (afh_timestamp);
