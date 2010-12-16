--
-- Schema for OptIn
--

CREATE TABLE IF NOT EXISTS /*_*/optin_survey (
	-- User ID
	ois_user int NOT NULL,

	-- Timestamp
	ois_timestamp binary(14) NOT NULL,
	
	-- Survey type (out or feedback)
	ois_type varchar(16) NOT NULL,

	-- Question ID (key in $wgOptInSurvey)
	ois_question varchar(16) NOT NULL,

	-- Answer ID (key in $wgOptInSurvey[ois_question]['answers'])
	ois_answer text NULL,

	-- Optional text associated with the answer
	ois_answer_data text NULL
) /*$wgDBTableOptions*/;

CREATE UNIQUE INDEX /*i*/ois_user_timestamp_question ON /*_*/optin_survey (ois_user, ois_timestamp, ois_question);
