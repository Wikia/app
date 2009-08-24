ALTER TABLE /*$wgDBprefix*/code_relations
	ADD key (cf_repo_id, cf_to, cf_from);
