--
-- Track script inclusions.
--
CREATE TABLE /*_*/scriptlinks (
  -- Key to the page_id of the page containing the link.
  sl_from int unsigned NOT NULL default 0,

  -- Key to page_title of the target page.
  -- The target page may or may not exist, and due to renames
  -- and deletions may refer to different page records as time
  -- goes by.
  sl_to varchar(255) binary NOT NULL default ''
) /*$wgDBTableOptions*/;

CREATE UNIQUE INDEX /*i*/sl_from ON /*_*/scriptlinks (sl_from,sl_to);
CREATE UNIQUE INDEX /*i*/sl_title ON /*_*/scriptlinks (sl_to,sl_from);
