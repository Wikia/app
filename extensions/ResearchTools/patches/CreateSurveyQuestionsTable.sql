-- Questions
CREATE TABLE /*_*/research_tools_survey_questions (
  -- ID
  rtsq_id INTEGER UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
  -- Survey, foreign key to research_tools_surveys
  rtsq_survey INTEGER UNSIGNED NOT NULL,
  -- Type, the name of a widget type such as "string", or "checkbox"
  rtsq_type VARBINARY(32) NOT NULL DEFAULT 'string',
  -- Text
  rtsq_text VARBINARY(255) NOT NULL DEFAULT '',
  -- Example
  rtsq_example VARBINARY(255) NOT NULL DEFAULT '',
  -- Help
  rtsq_help VARBINARY(255) NOT NULL DEFAULT ''
) /*$wgDBTableOptions*/;
