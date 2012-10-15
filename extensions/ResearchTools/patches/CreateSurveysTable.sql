-- Surveys
CREATE TABLE /*_*/research_tools_surveys (
  -- ID
  rts_id INTEGER UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
  -- Title
  rts_title VARBINARY(255) NOT NULL DEFAULT '',
  -- Description
  rts_description VARBINARY(255) NOT NULL DEFAULT ''
) /*$wgDBTableOptions*/;
