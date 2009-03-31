CREATE TABLE /*$wgDBprefix*/globalblocks (
	gb_id int NOT NULL auto_increment,
	gb_address varchar(255) NOT NULL,
	gb_by varchar(255) NOT NULL,
	gb_by_wiki varbinary(255) NOT NULL,
	gb_reason TINYBLOB NOT NULL,
	gb_timestamp binary(14) NOT NULL,
	gb_anon_only bool NOT NULL default 0,
	gb_expiry varbinary(14) NOT NULL default '',
	gb_range_start varbinary(32) NOT NULL, -- Needs 32, not 8 for IPv6 support
	gb_range_end varbinary(32) NOT NULL,
	
	PRIMARY KEY gb_id (gb_id),

	UNIQUE INDEX gb_address (gb_address, gb_anon_only),

	INDEX gb_range (gb_range_start, gb_range_end),
	INDEX gb_timestamp (gb_timestamp),
	INDEX gb_expiry (gb_expiry)
) /*$wgDBTableOptions*/;
