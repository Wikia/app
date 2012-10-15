ALTER TABLE /*$wgDBprefix*/code_rev
	ADD cr_diff mediumblob NULL,
	ADD cr_flags tinyblob NOT NULL;
