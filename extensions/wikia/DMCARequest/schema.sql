CREATE TABLE IF NOT EXISTS /*_*/dmca_request (
	dmca_id INT unsigned NOT NULL AUTO_INCREMENT,
	dmca_date timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
	dmca_requestor_type TINYINT unsigned NOT NULL,
	dmca_fullname VARCHAR(255) NOT NULL,
	dmca_email VARCHAR(255) NOT NULL,
	dmca_address VARCHAR(1000) NOT NULL,
	dmca_telephone VARCHAR(20) NOT NULL DEFAULT '',
	dmca_original_urls TEXT NOT NULL,
	dmca_infringing_urls TEXT NOT NULL,
	dmca_comments TEXT NOT NULL,
	dmca_signature VARCHAR(255) NOT NULL,
	dmca_action_taken VARCHAR(7) NOT NULL,
	dmca_ce_id INT unsigned,
	PRIMARY KEY(`dmca_id`),
	KEY dmca_date (`dmca_date`),
	KEY dmca_email (`dmca_email`)
) /*$wgDBTableOptions*/;
