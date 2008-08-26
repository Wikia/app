-- Patch to create local table for whitelisted global blocks
-- Andrew Garrett, April 2008

CREATE TABLE /*$wgDBprefix*/global_block_whitelist (
	gbw_id	int(11) NOT NULL, -- Key to gb_id in globalblocks database.
	gbw_by	int(11) NOT NULL, -- Key to user_id
	gbw_reason TINYBLOB NOT NULL,
	gbw_expiry binary(14) NOT NULL,
	PRIMARY KEY (gbw_id),
	KEY (gbw_by)	
) /*$wgDBTableOptions*/;