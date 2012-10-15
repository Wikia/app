ALTER TABLE /*$wgDBprefix*/code_prop_changes
	MODIFY `cpc_attrib`
	VARCHAR(10) NOT NULL;

INSERT INTO /*$wgDBprefix*/updatelog( ul_key ) VALUES( 'make cpc_attrib varchar' );