--
-- Schema for ClickTracking
--

CREATE TABLE IF NOT EXISTS /*_*/click_tracking (
	-- Timestamp
	action_time char(14) NOT NULL,

	-- session id
	session_id varbinary(255) NOT NULL,

	-- true if the user is logged in
	is_logged_in tinyint NOT NULL,

	-- total user contributions
	user_total_contribs integer,

	-- user contributions over a specified timespan of granularity 1
	user_contribs_span1 integer,
	
	-- user contributions over a specified timespan of granularity 2
	user_contribs_span2 integer,
	
	-- user contributions over a specified timespan of granularity 3
	user_contribs_span3 integer,

	-- namespace being edited
	namespace integer NOT NULL,

	-- event ID (not unique)
	event_id integer NOT NULL,
	
	-- additional info for each click, such as state information
	additional_info varbinary(255)
	
) /*$wgDBTableOptions*/;

CREATE INDEX /*i*/click_tracking_action_time ON /*_*/click_tracking (action_time);
CREATE INDEX /*i*/click_tracking_event_id ON /*_*/click_tracking (event_id);
CREATE INDEX /*i*/click_tracking_session_id ON /*_*/click_tracking (session_id);
