-- Additional table for the GlobalUserrights extension
-- To be added to $wgSharedDB
-- replace /*$wgSharedPrefix*/ with $wgSharedPrefix

CREATE TABLE /*$wgSharedPrefix*/global_user_groups (
  -- Key to user_id
  gug_user int unsigned NOT NULL default '0',
  -- Group name
  gug_group varbinary(16) NOT NULL default '',

  PRIMARY KEY  (gug_user,gug_group),
  KEY (gug_group)
) /*$wgDBTableOptions*/;
