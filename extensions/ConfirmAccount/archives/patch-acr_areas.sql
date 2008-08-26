-- (c) Aaron Schulz, 2007

ALTER TABLE /*$wgDBprefix*/account_requests
	ADD acr_areas mediumblob NOT NULL;

ALTER TABLE /*$wgDBprefix*/account_credentials
	ADD acd_areas mediumblob NOT NULL;
