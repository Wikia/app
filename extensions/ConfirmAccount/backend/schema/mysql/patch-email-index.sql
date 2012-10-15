-- (c) Aaron Schulz, 2007

ALTER TABLE /*$wgDBprefix*/account_requests
	ADD UNIQUE INDEX acr_email(acr_email(255));
