-- Message group workflow states
CREATE TABLE /*$wgDBprefix*/translate_groupreviews (
  -- The length we need to accommodate "page-" + the full pagename including
  -- prefix. That could be 255 + prefix (length not limited), but page
  -- translation section pages limit that to shorter, because it needs to
  -- accommodate /sectionname/languagecode suffix to the page name.
  tgr_group varchar(200) binary NOT NULL,
  tgr_lang varchar(20) binary NOT NULL,
  -- Any of user configured values from $wgTranslateWorkflowStates
  tgr_state varbinary(32) NOT NULL,

	PRIMARY KEY (tgr_group, tgr_lang)
) /*$wgDBTableOptions*/;
