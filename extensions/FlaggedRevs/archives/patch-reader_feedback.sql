-- This stores reader feedback data to curb double-voting
CREATE TABLE /*$wgDBprefix*/reader_feedback (
  -- Foreign key to revision.rev_id
  rfb_rev_id integer unsigned NOT NULL,
  -- Foreign key to user.user_id
  rfb_user integer unsigned NOT NULL,
  rfb_ip varchar(255) NOT NULL default '',
  -- No double voting!
  PRIMARY KEY (rfb_rev_id,rfb_user,rfb_ip)
) /*$wgDBTableOptions*/;

-- This stores reader feedback data for a page over time
CREATE TABLE /*$wgDBprefix*/reader_feedback_history (
  -- Foreign key to page.page_id
  rfh_page_id integer NOT NULL,
  rfh_tag char(20) NOT NULL default '',
  rfh_total integer unsigned NOT NULL default 0,
  rfh_count integer unsigned NOT NULL default 0,
  -- MW date of the day this average corresponds to
  rfh_date char(14) NOT NULL default '',
  PRIMARY KEY (rfh_page_id,rfh_tag,rfh_date)
) /*$wgDBTableOptions*/;

-- This stores reader feedback data
CREATE TABLE /*$wgDBprefix*/reader_feedback_pages (
  -- Foreign key to page.page_id
  rfp_page_id integer unsigned NOT NULL,
  rfp_tag char(20) NOT NULL default '',
  -- Value in last few days (14)
  rfp_ave_val real NOT NULL default 0,
  -- And said total (used as threshold)
  rfp_count integer unsigned NOT NULL default 0,
  rfp_touched char(14) NOT NULL default '',
  PRIMARY KEY (rfp_page_id,rfp_tag),
  INDEX rfp_tag_val_page (rfp_tag,rfp_ave_val,rfp_page_id)
) /*$wgDBTableOptions*/;

