CREATE TABLE IF NOT EXISTS /*_*/pm_whitelist (
	pmw_ip VARBINARY(40) NOT NULL PRIMARY KEY DEFAULT ''
) /*$wgDBTableOptions*/;