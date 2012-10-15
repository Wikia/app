ALTER TABLE /*$wgDBprefix*/code_prop_changes
	ADD KEY /*i*/cpc_author (cpc_repo_id, cpc_user_text, cpc_timestamp);