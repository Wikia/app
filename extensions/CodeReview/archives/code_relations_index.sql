ALTER TABLE /*$wgDBprefix*/code_relations
	ADD key /*i*/repo_to_from (cf_repo_id, cf_to, cf_from);
