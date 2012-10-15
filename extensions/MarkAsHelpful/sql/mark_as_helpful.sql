CREATE TABLE /*_*/mark_as_helpful (
	mah_id int unsigned NOT NULL PRIMARY KEY auto_increment, -- Primary key

	mah_type varbinary(32) NOT NULL, -- the object type that is being marked as helpful
	mah_item int unsigned NOT NULL, -- the object item that is being marked as helpful
	mah_user_id int unsigned NOT NULL, -- User ID
	mah_user_editcount int unsigned NOT NULL, -- number of edit for the user

	mah_namespace int,
	mah_title varchar(255) binary,

	-- Options and context
	mah_timestamp varchar(14) binary NOT NULL, -- When response was received
	mah_system_type varchar(64) binary NULL, -- Operating System
	mah_user_agent varchar(255) binary NULL, -- User-Agent header
	mah_locale varchar(32) binary NULL -- The locale of the user's browser
) /*$wgDBTableOptions*/;

CREATE UNIQUE INDEX /*i*/mah_type_item_user_id ON /*_*/mark_as_helpful (mah_type, mah_item, mah_user_id);
