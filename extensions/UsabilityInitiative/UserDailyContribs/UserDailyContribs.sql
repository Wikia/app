--
-- Schema for UserDailyContribs
--
-- Used in clicktracking to determine how active the user is
--

CREATE TABLE IF NOT EXISTS /*_*/user_daily_contribs (
	-- user id
	user_id integer NOT NULL default 0,

	-- day
	day DATE NOT NULL,

	-- contributions on that day by that user
	contribs integer NOT NULL default 0,

	-- a unique entry for a given user_id and day
	PRIMARY KEY(user_id, day)
) /*$wgDBTableOptions*/;