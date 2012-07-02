ALTER TABLE /*$wgDBprefix*/code_paths
	MODIFY `cp_action`
	CHAR(1) NOT NULL;

INSERT INTO /*$wgDBprefix*/updatelog( ul_key ) VALUES( 'make cp_action char' );