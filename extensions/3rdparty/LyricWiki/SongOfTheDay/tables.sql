-- Creates the table for the extension SOTD
DROP TABLE IF EXISTS sotdnoms;
CREATE TABLE sotdnoms (
	sn_id int NOT NULL PRIMARY KEY AUTO_INCREMENT,

	sn_userid int NOT NULL default 0,
	sn_username varchar(255) NOT NULL,
	sn_artist varchar(255) NOT NULL,
	sn_song varchar(255) NOT NULL,
	sn_reason mediumtext NOT NULL,
	sn_video char(11) NOT NULL default '',
	sn_audio char(7) NOT NULL default '',
	sn_prefdate int default NULL,
	sn_occasion varchar(255) NOT NULL default '',
	sn_nomdate int NOT NULL,
	sn_token char(32) NOT NULL,
	sn_status tinyint NOT NULL default 0
);