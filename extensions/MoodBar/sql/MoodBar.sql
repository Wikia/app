CREATE TABLE /*_*/moodbar_feedback (
	mbf_id int unsigned NOT NULL PRIMARY KEY auto_increment, -- Primary key
	mbf_type varchar(32) binary NOT NULL, -- Type of feedback

	-- User who provided the feedback
	mbf_user_id int unsigned NOT NULL, -- User ID, or zero
	mbf_user_ip varchar(255) binary NULL, -- If anonymous, user's IP address
	mbf_user_editcount int unsigned NOT NULL, -- Edit count of the user

	-- Page where the feedback was received
	-- Nullable.
	mbf_namespace int,
	mbf_title varchar(255) binary,

	-- The feedback itself
	mbf_comment varchar(255) binary,

	-- Latest response id for this feedback
	mbf_latest_response int unsigned NOT NULL default 0,
	-- Options and context
	-- Whether or not the feedback item is hidden
	-- 0 = No; 255 = Yes (other values reserved for partial hiding)
	mbf_hidden_state tinyint unsigned not null default 0,
	mbf_anonymous tinyint unsigned not null default 0, -- Anonymity
	mbf_timestamp varchar(14) binary not null, -- When feedback was received
	mbf_system_type varchar(64) binary null, -- Operating System
	mbf_user_agent varchar(255) binary null, -- User-Agent header
	mbf_locale varchar(32) binary null, -- The locale of the user's browser
	mbf_editing tinyint unsigned not null, -- Whether or not the user was editing
	mbf_bucket varchar(128) binary null -- Bucket, for A/B testing
) /*$wgDBTableOptions*/;

-- A little overboard with the indexes perhaps, but we want to be able to dice this data a lot!
CREATE INDEX /*i*/mbf_type_timestamp_id ON /*_*/moodbar_feedback (mbf_type,mbf_timestamp, mbf_id);
CREATE INDEX /*i*/mbf_title_type_id ON /*_*/moodbar_feedback (mbf_namespace,mbf_title,mbf_type,mbf_timestamp, mbf_id);
-- CREATE INDEX /*i*/mbf_namespace_title_timestamp ON /*_*/moodbar_feedback (mbf_namespace, mbf_title, mbf_timestamp, mbf_id); --maybe in the future if we actually do per-page filtering
CREATE INDEX /*i*/mbf_userid_ip_timestamp_id ON /*_*/moodbar_feedback (mbf_user_id, mbf_user_ip, mbf_timestamp, mbf_id);
CREATE INDEX /*i*/mbf_type_userid_ip_timestamp_id ON /*_*/moodbar_feedback (mbf_type, mbf_user_id, mbf_user_ip, mbf_timestamp, mbf_id);
CREATE INDEX /*i*/mbf_timestamp_id ON /*_*/moodbar_feedback (mbf_timestamp, mbf_id);
CREATE INDEX /*i*/mbf_latest_response ON /*_*/moodbar_feedback (mbf_latest_response);
