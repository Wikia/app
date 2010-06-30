-- INDEX for archive table
ALTER TABLE /*$wgDBprefix*/archive
	ADD KEY `page_revision` (`ar_page_id`, `ar_rev_id`);
