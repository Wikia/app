CREATE TABLE /*_*/approved_revs (
	page_id int default NULL,
	rev_id int default NULL
) /*$wgDBTableOptions*/;

CREATE UNIQUE INDEX approved_revs_page_id ON /*_*/approved_revs (page_id);
