-- (c) Florian Hackenberger, 2009, GPL
-- Table structure for `CollabWatchlist`
-- Replace /*$wgDBprefix*/ with the proper prefix
-- Replace /*$wgDBTableOptions*/ with the correct options

-- Associates a specific tag (ct_tag) with a recent changes entry (ct_rc_id)
-- and a specific collabwatchlist (cw_id)
CREATE TABLE IF NOT EXISTS /*$wgDBprefix*/collabwatchlistrevisiontag (
  -- See change_tag.ct_tag
  ct_tag varbinary(255) NOT NULL,
  -- See change_tag.ct_rc_id
  ct_rc_id int NOT NULL default 0,
  -- Foreign key to collabwatchlist.cw_id
  cw_id integer unsigned NOT NULL,
  -- Foreign key to user.user_id
  user_id int(10) unsigned NOT NULL,
  
  -- Comment for the tag
  rrt_comment varchar(255)
  
) /*$wgDBTableOptions*/;

CREATE UNIQUE INDEX ct_tag on /*$wgDBprefix*/collabwatchlistrevisiontag (ct_tag, ct_rc_id, cw_id);