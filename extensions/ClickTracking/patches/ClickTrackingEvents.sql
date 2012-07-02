--
-- Schema for ClickTrackingEvents
--
-- Used to keep track of the various click events by ID
--

CREATE TABLE IF NOT EXISTS /*_*/click_tracking_events (
	-- event name
	event_name VARBINARY(255) unique,

	-- day
	id INTEGER PRIMARY KEY AUTO_INCREMENT
) /*$wgDBTableOptions*/;
