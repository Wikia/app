CREATE TABLE IF NOT EXISTS /*$wgDBprefix*/cn_notices (
	`not_id` int NOT NULL PRIMARY KEY auto_increment,
	`not_name` varchar(255) NOT NULL,
	`not_start` char(14) NOT NULL,
	`not_end` char(14) NOT NULL,
	`not_enabled` bool NOT NULL default '0',
	`not_preferred` bool NOT NULL default '0',
	`not_locked` bool NOT NULL default '0',
	`not_language` varchar(32) NOT NULL,
	`not_project` varchar(255) NOT NULL
) /*$wgDBTableOptions*/;

CREATE TABLE IF NOT EXISTS /*$wgDBprefix*/cn_assignments (
	`asn_id` int NOT NULL PRIMARY KEY auto_increment,
	`not_id` int NOT NULL,
	`tmp_id` int NOT NULL,
	`tmp_weight` int NOT NULL
) /*$wgDBTableOptions*/;

-- FIXME: make tmp_name UNIQUE
CREATE TABLE IF NOT EXISTS /*$wgDBprefix*/cn_templates (
	`tmp_id` int NOT NULL PRIMARY KEY auto_increment,
	`tmp_name` varchar(255) default NULL,
	`tmp_display_anon` bool NOT NULL DEFAULT 1,
	`tmp_display_account` bool NOT NULL DEFAULT 1
) /*$wgDBTableOptions*/;

CREATE TABLE IF NOT EXISTS /*$wgDBprefix*/cn_notice_languages (
	`nl_notice_id` int unsigned NOT NULL,
	`nl_language` varchar(32) NOT NULL
) /*$wgDBTableOptions*/;
CREATE UNIQUE INDEX /*i*/nl_notice_id_language ON /*$wgDBprefix*/cn_notice_languages (nl_notice_id, nl_language);

CREATE TABLE IF NOT EXISTS /*$wgDBprefix*/cn_notice_projects (
	`np_notice_id` int unsigned NOT NULL,
	`np_project` varchar(32) NOT NULL
) /*$wgDBTableOptions*/;
CREATE UNIQUE INDEX /*i*/np_notice_id_project ON /*$wgDBprefix*/cn_notice_projects (np_notice_id, np_project);
