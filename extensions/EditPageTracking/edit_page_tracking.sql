-- Tables for EditPageTracking extension
-- Note: Rows are deliberately not always unique, because we might want to track more than one event
CREATE TABLE /*_*/edit_page_tracking (
	-- User ID
	ept_user bigint unsigned not null,
	-- Timestamp when the edit form was viewed
	ept_timestamp varbinary(14) not null,
	-- Page that the edit form was viewed for
	-- Not used at the moment, but useful for statistics
	ept_namespace int not null,
	ept_title varbinary(255) not null
) /*$wgDBTableOptions*/;

CREATE INDEX /*i*/user_timestamp ON /*_*/edit_page_tracking (ept_user, ept_timestamp);
