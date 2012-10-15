-- Storage for reactions
CREATE TABLE /*_*/thread_reaction (
	tr_thread int unsigned NOT NULL,
	tr_user int unsigned NOT NULL,
	tr_user_text varbinary(255) NOT NULL,
	tr_type varbinary(64) NOT NULL,
	tr_value int NOT NULL,
	
	PRIMARY KEY (tr_thread,tr_user,tr_user_text,tr_type,tr_value),
	KEY (tr_user,tr_user_text,tr_type,tr_value)
) /*$wgDBTableOptions*/;
