-- Add tracking table for edits needing review (for all levels)
CREATE TABLE IF NOT EXISTS /*$wgDBprefix*/flaggedpage_pending (
  -- Foreign key to page.page_id
  fpp_page_id integer unsigned NOT NULL,
  -- The quality tier (0=stable, 1=quality, 2=pristine)
  fpp_quality tinyint(1) NOT NULL,
  -- The last rev ID with this quality
  fpp_rev_id integer unsigned NOT NULL,
  -- Time (or NULL) of the first edit after the last revision reviewed to this level
  fpp_pending_since varbinary(14) NOT NULL,
  
  PRIMARY KEY (fpp_page_id,fpp_quality),
  INDEX fpp_quality_pending (fpp_quality,fpp_pending_since)
) /*$wgDBTableOptions*/;

