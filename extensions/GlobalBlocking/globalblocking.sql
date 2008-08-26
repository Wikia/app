CREATE TABLE /*$wgDBprefix*/globalblocks (
	gb_id int NOT NULL auto_increment,
	gb_address TINYBLOB NOT NULL,
	gb_by TINYBLOB NOT NULL,
	gb_by_wiki TINYBLOB NOT NULL,
	gb_reason TINYBLOB NOT NULL,
	gb_timestamp binary(14) NOT NULL,
	gb_anon_only bool NOT NULL default 0,
	gb_expiry varbinary(14) NOT NULL default '',
	gb_range_start tinyblob NOT NULL,
	gb_range_end tinyblob NOT NULL,
	PRIMARY KEY gb_id (gb_id),

	UNIQUE INDEX gb_address (gb_address(255), gb_anon_only),

	INDEX gb_range (gb_range_start(8), gb_range_end(8)),
	INDEX gb_timestamp (gb_timestamp),
	INDEX gb_expiry (gb_expiry)
) /*$wgDBTableOptions*/;
