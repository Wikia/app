-- Storage for "pending" relationships from import
CREATE TABLE /*_*/thread_pending_relationship (
	tpr_thread int unsigned NOT NULL,
	tpr_relationship varbinary(64) NOT NULL,
	tpr_title varbinary(255) NOT NULL,
	tpr_type varbinary(32) NOT NULL,
	PRIMARY KEY (tpr_thread,tpr_relationship)
) /*$wgDBTableOptions*/;
