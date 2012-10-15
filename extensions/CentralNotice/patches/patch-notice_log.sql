-- Update to allow for logging of changes to campaign settings.

CREATE TABLE IF NOT EXISTS /*$wgDBprefix*/cn_notice_log (
	`notlog_id` int unsigned NOT NULL PRIMARY KEY auto_increment,
	`notlog_timestamp` binary(14) NOT NULL,
	`notlog_user_id` int unsigned NOT NULL,
	`notlog_action` enum('created','modified','removed') NOT NULL DEFAULT 'modified',
	`notlog_not_id` int unsigned NOT NULL,
	`notlog_not_name` varchar(255) DEFAULT NULL,
	`notlog_begin_projects` varchar(255) DEFAULT NULL,
	`notlog_end_projects` varchar(255) DEFAULT NULL,
	`notlog_begin_languages` text,
	`notlog_end_languages` text,
	`notlog_begin_countries` text,
	`notlog_end_countries` text,
	`notlog_begin_start` char(14) DEFAULT NULL,
	`notlog_end_start` char(14) DEFAULT NULL,
	`notlog_begin_end` char(14) DEFAULT NULL,
	`notlog_end_end` char(14) DEFAULT NULL,
	`notlog_begin_enabled` tinyint(1) DEFAULT NULL,
	`notlog_end_enabled` tinyint(1) DEFAULT NULL,
	`notlog_begin_preferred` tinyint(1) DEFAULT NULL,
	`notlog_end_preferred` tinyint(1) DEFAULT NULL,
	`notlog_begin_locked` tinyint(1) DEFAULT NULL,
	`notlog_end_locked` tinyint(1) DEFAULT NULL,
	`notlog_begin_geo` tinyint(1) DEFAULT NULL,
	`notlog_end_geo` tinyint(1) DEFAULT NULL,
	`notlog_begin_banners` text,
	`notlog_end_banners` text
) /*$wgDBTableOptions*/;
CREATE INDEX /*i*/notlog_timestamp ON /*_*/cn_notice_log (notlog_timestamp);
CREATE INDEX /*i*/notlog_user_id ON /*_*/cn_notice_log (notlog_user_id, notlog_timestamp);
CREATE INDEX /*i*/notlog_not_id ON /*_*/cn_notice_log (notlog_not_id, notlog_timestamp);