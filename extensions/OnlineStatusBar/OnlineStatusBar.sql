CREATE TABLE /*$wgDBprefix*/online_status (
	`username` varchar(255) NOT NULL default '',
	`timestamp` binary(14) NOT NULL default '19700101000000',
	PRIMARY KEY USING HASH (`username`)
) ENGINE=MEMORY;

