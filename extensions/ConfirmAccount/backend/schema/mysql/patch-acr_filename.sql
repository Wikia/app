-- (c) Aaron Schulz, 2007

ALTER TABLE /*$wgDBprefix*/account_requests
	ADD acr_filename VARCHAR(255) NULL,
    ADD acr_storage_key VARCHAR(64) NULL,
    ADD acr_held binary(14),
    ADD acr_comment VARCHAR(255) NULL;
