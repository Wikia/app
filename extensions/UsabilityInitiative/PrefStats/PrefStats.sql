--
-- Schema for PrefStats
--

CREATE TABLE IF NOT EXISTS /*_*/prefstats (
	-- User ID
	ps_user int NOT NULL,

	-- Preference name
	ps_pref varbinary(32) NOT NULL,

	-- Preference value
	ps_value blob NOT NULL,

	-- Timestamp the user enabled the preference
	ps_start binary(14) NOT NULL,

	-- Timestamp the user disabled the preference, or NULL if still enabled
	ps_end binary(14) NULL,

	-- Number of seconds the user had the preference enabled,
	-- or 0 if still enabled
	ps_duration int unsigned
) /*$wgDBTableOptions*/;

CREATE UNIQUE INDEX /*i*/ps_user_pref_start ON /*_*/prefstats (ps_user, ps_pref, ps_start);
CREATE INDEX /*i*/ps_pref_duration_start ON /*_*/prefstats (ps_pref, ps_duration, ps_start);
