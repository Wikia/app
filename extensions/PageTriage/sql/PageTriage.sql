
-- mapping table for users to revisions
-- this information persists forever.
CREATE TABLE /*_*/pagetriage (
	ptr_user int UNSIGNED NOT NULL,
	ptr_recentchanges_id int NOT NULL,
	ptr_timestamp varbinary(14) NOT NULL
) /*$wgDBTableOptions*/;

CREATE UNIQUE INDEX /*i*/ptr_user_rc ON /*_*/pagetriage (ptr_user,ptr_recentchanges_id);

-- this stores when a page was checked.  we'll be interested in that sometimes.
CREATE INDEX /*i*/ptr_timestamp ON /*_*/pagetriage (ptr_timestamp);

-- This table exists to prevent concurrency problems when multiple people are doing
-- page triage at the same time.
-- Unlike the above table, this one has rows deleted from it regularly.
-- If it's cleared, it'll lead to edit conflicts for a few minutes but it's not a big deal.
CREATE TABLE /*_*/pagetriage_checkouts (
	ptc_id int UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
	ptc_user int UNSIGNED NOT NULL,
	ptc_recentchanges_id int NOT NULL,	
	ptc_timestamp varbinary(14) NOT NULL
) /*$wgDBTableOptions*/;

-- this index is for retrieving data
CREATE INDEX /*i*/ptc_user_rc ON /*_*/pagetriage_checkouts (ptc_user,ptc_recentchanges_id);

-- this index is for enforcing one checkout per page.
CREATE UNIQUE INDEX /*i*/ptc_recentchanges_id ON /*_*/pagetriage_checkouts (ptc_recentchanges_id);
