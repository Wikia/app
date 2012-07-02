ALTER TABLE /*$wgDBprefix*/code_comment
	ADD key /*i*/cc_author (cc_repo_id, cc_user_text, cc_timestamp);
