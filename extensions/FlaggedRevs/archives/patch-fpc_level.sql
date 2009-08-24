-- The protection level (Sysop, autoconfirmed, etc) for autoreview
ALTER TABLE /*$wgDBprefix*/flaggedpage_config
	ADD fpc_level varbinary(60) NULL;
