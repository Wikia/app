-- Responses
CREATE TABLE /*_*/research_tools_survey_responses (
  -- ID
  rtsr_id INTEGER UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
  -- Time of response
  rtsr_time BINARY(14),
  -- User infrormation
  rtsr_user_text VARBINARY(255) NOT NULL DEFAULT '',
  rtsr_user_anon_token VARBINARY(32) NOT NULL DEFAULT '',
  -- Keys to the primary key fields in research_tools_surveys
  rtsr_survey INTEGER UNSIGNED NOT NULL
) /*$wgDBTableOptions*/;
CREATE UNIQUE INDEX /*i*/rtsr_survey_key ON /*_*/research_tools_survey_responses (
	rtsr_user_text,
	rtsr_user_anon_token,
	rtsr_survey
);
