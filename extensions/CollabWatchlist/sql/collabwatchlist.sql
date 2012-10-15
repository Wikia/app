-- (c) Florian Hackenberger, 2009, GPL
-- Table structure for `CollabWatchlist`
-- Replace /*$wgDBprefix*/ with the proper prefix
-- Replace /*$wgDBTableOptions*/ with the correct options


-- Add table defining a collaborative watchlist
CREATE TABLE IF NOT EXISTS /*$wgDBprefix*/collabwatchlist (
  -- The id of the collaborative watchlist
  cw_id integer unsigned  NOT NULL PRIMARY KEY AUTO_INCREMENT,
  -- The name of the collaborative watchlist (unique)
  cw_name varbinary(255) NOT NULL,
  -- Starting date in standard YMDHMS form.
  cw_start binary(14) NOT NULL default ''
) /*$wgDBTableOptions*/;

CREATE UNIQUE INDEX cw_name ON /*$wgDBprefix*/collabwatchlist (cw_name);
