-- (c) Florian Hackenberger, 2009, GPL
-- Table structure for `CollabWatchlist`
-- Replace /*$wgDBprefix*/ with the proper prefix
-- Replace /*$wgDBTableOptions*/ with the correct options

-- Add table defining the collaborative watchlist users
CREATE TABLE IF NOT EXISTS /*$wgDBprefix*/collabwatchlistuser (
  -- The id of this entry
  rlu_id integer unsigned  NOT NULL PRIMARY KEY AUTO_INCREMENT,
  -- Foreign key to collabwatchlist.cw_id
  cw_id integer unsigned NOT NULL,
  -- Foreign key to user.user_id
  user_id int(10) unsigned NOT NULL,
  -- Type of user
  rlu_type integer NOT NULL DEFAULT 1
) /*$wgDBTableOptions*/;

CREATE UNIQUE INDEX rl_id ON /*$wgDBprefix*/collabwatchlistuser (rl_id, user_id);