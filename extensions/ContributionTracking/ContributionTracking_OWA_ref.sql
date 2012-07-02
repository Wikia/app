--
-- Schema for OWA_ref
--
-- Used to normalize target pages for OWA "conversions"
--

CREATE TABLE IF NOT EXISTS /*_*/contribution_tracking_owa_ref (
	-- URL of event
	url VARBINARY(255) unique,

	-- event ID
	id INTEGER AUTO_INCREMENT PRIMARY KEY
) /*$wgDBTableOptions*/;

