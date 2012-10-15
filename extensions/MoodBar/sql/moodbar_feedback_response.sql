CREATE TABLE /*_*/moodbar_feedback_response (
	mbfr_id int unsigned NOT NULL PRIMARY KEY auto_increment, -- Primary key

	mbfr_mbf_id int unsigned NOT NULL, -- Primary key of moodbar_feedback table

	-- User who provided the response
	mbfr_user_id int unsigned NOT NULL, -- User ID, or zero
	mbfr_user_ip varbinary(40) NULL, -- If anonymous, user's IP address

	mbfr_commenter_editcount int unsigned NOT NULL, -- number of edit for the user who writes the feedback
	mbfr_user_editcount int unsigned NOT NULL, -- number of edit for the responder

	-- The response itself
	mbfr_response_text text NOT NULL,

	-- Options and context
	mbfr_timestamp varchar(14) binary NOT NULL, -- When response was received
	mbfr_anonymous tinyint unsigned NOT NULL DEFAULT 0, -- Anonymity
	mbfr_system_type varchar(64) binary NULL, -- Operating System
	mbfr_user_agent varchar(255) binary NULL, -- User-Agent header
	mbfr_locale varchar(32) binary NULL, -- The locale of the user's browser
	mbfr_editing tinyint unsigned NOT NULL, -- Whether or not the user was editing
	mbfr_enotif_sent tinyint unsigned not null default 0 -- Whether or not a notification email was sent
) /*$wgDBTableOptions*/;

CREATE INDEX /*i*/mbfr_mbf_id ON /*_*/moodbar_feedback_response (mbfr_mbf_id);
CREATE INDEX /*i*/mbfr_mbf_mbfr_id ON /*_*/moodbar_feedback_response (mbfr_mbf_id, mbfr_id);
CREATE INDEX /*i*/mbfr_user_id ON /*_*/moodbar_feedback_response (mbfr_user_id);
