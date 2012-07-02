-- (c) Florian Hackenberger, 2009, GPL
-- Table structure for `CollabWatchlist`
-- Replace /*$wgDBprefix*/ with the proper prefix
-- Replace /*$wgDBTableOptions*/ with the correct options

-- Add table defining the categories for collaborative watchlists
CREATE TABLE IF NOT EXISTS /*$wgDBprefix*/collabwatchlistcategory (
  -- Foreign key to collabwatchlist.cw_id
  cw_id integer unsigned NOT NULL,
  -- Foreign key to page.page_id
  cat_page_id integer unsigned NOT NULL,
  -- Whether the category is subtracted from or added to the collaborative watchlist
  subtract boolean DEFAULT false
) /*$wgDBTableOptions*/;