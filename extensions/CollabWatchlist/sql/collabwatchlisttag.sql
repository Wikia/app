-- (c) Florian Hackenberger, 2009, GPL
-- Table structure for `CollabWatchlist`
-- Replace /*$wgDBprefix*/ with the proper prefix
-- Replace /*$wgDBTableOptions*/ with the correct options

-- Add table defining the tags which are allowed on a collab watchlist
CREATE TABLE IF NOT EXISTS /*$wgDBprefix*/collabwatchlisttag (
  -- Foreign key to collabwatchlist.cw_id
  cw_id integer unsigned NOT NULL,
  -- The name of the collabwatchlist tag (unique)
  rt_name varbinary(255) NOT NULL,
  -- Description of the tag
  rt_description tinyblob NOT NULL default ''

) /*$wgDBTableOptions*/;

CREATE UNIQUE INDEX cw_id ON /*$wgDBprefix*/collabwatchlisttag (cw_id, rt_name);