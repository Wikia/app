ALTER TABLE /*$wgDBprefix*/code_rev
	MODIFY `cr_status`
	VARCHAR(25) NOT NULL DEFAULT 'new';

INSERT INTO /*$wgDBprefix*/updatelog( ul_key ) VALUES( 'make cr_status varchar' );