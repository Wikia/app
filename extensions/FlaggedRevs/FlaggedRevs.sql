-- (c) Aaron Schulz, 2007-2009, GPL
-- Table structure for table `Flagged Revisions`
-- Replace /*$wgDBprefix*/ with the proper prefix
-- Replace /*$wgDBTableOptions*/ with the correct options

-- Add page tracking table for flagged revisions
CREATE TABLE IF NOT EXISTS /*$wgDBprefix*/flaggedpages (
  -- Foreign key to page.page_id
  fp_page_id integer unsigned NOT NULL,
  -- Is the stable version synced?
  fp_reviewed bool NOT NULL default '0',
  -- When (or NULL) the first edit after the stable version was made
  fp_pending_since char(14) NULL,
  -- Foreign key to flaggedrevs.fr_rev_id
  fp_stable integer unsigned NOT NULL,
  -- The highest quality of the page's reviewed revisions.
  -- Note that this may not be set to display by default though.
  fp_quality tinyint(1) default NULL,
  
  PRIMARY KEY (fp_page_id),
  INDEX fp_reviewed_page (fp_reviewed,fp_page_id),
  INDEX fp_quality_page (fp_quality,fp_page_id),
  INDEX fp_pending_since (fp_pending_since)
) /*$wgDBTableOptions*/;

-- Add tracking table for edits needing review (for all levels)
CREATE TABLE IF NOT EXISTS /*$wgDBprefix*/flaggedpage_pending (
  -- Foreign key to page.page_id
  fpp_page_id integer unsigned NOT NULL,
  -- The quality tier (0=stable, 1=quality, 2=pristine)
  fpp_quality tinyint(1) NOT NULL,
  -- The last rev ID with this quality
  fpp_rev_id integer unsigned NOT NULL,
  -- Time (or NULL) of the first edit after the last revision reviewed to this level
  fpp_pending_since char(14) NOT NULL,
  
  PRIMARY KEY (fpp_page_id,fpp_quality),
  INDEX fpp_quality_pending (fpp_quality,fpp_pending_since)
) /*$wgDBTableOptions*/;

-- This stores all of our revision reviews; it is the main table
-- The template/file version data is stored in the next two tables
CREATE TABLE IF NOT EXISTS /*$wgDBprefix*/flaggedrevs (
  -- Foreign key to page.page_id
  fr_page_id integer unsigned NOT NULL,
  -- Foreign key to revision.rev_id
  fr_rev_id integer unsigned NOT NULL,
  -- Foreign key to user.user_id
  fr_user int(5) NOT NULL,
  fr_timestamp char(14) NOT NULL,
  fr_comment mediumblob NOT NULL,
  -- Store the precedence level
  fr_quality tinyint(1) NOT NULL default 0,
  -- Store tag metadata as newline separated, 
  -- colon separated tag:value pairs
  fr_tags mediumblob NOT NULL,
  -- Store the text with all transclusions resolved
  -- This will trade space for speed
  fr_text mediumblob NOT NULL,
  -- Comma-separated list of flags:
  -- dynamic: no text, templates must be fetched
  -- auto: revision patrolled automatically
  -- utf8: in UTF-8
  fr_flags tinyblob NOT NULL,
  -- Parameters for revisions of Image pages:
  -- Name of included image (NULL if n/a)
  fr_img_name varchar(255) binary NULL default NULL,
  -- Timestamp of file (when uploaded) (NULL if n/a)
  fr_img_timestamp char(14) NULL default NULL,
  -- Statistically unique SHA-1 key (NULL if n/a)
  fr_img_sha1 varbinary(32) NULL default NULL,
  
  PRIMARY KEY (fr_page_id,fr_rev_id),
  INDEX fr_img_sha1 (fr_img_sha1),
  INDEX page_qal_rev (fr_page_id,fr_quality,fr_rev_id)
) /*$wgDBTableOptions*/;

-- This stores all of our transclusion revision pointers
CREATE TABLE IF NOT EXISTS /*$wgDBprefix*/flaggedtemplates (
  ft_rev_id integer unsigned NOT NULL,
  -- Namespace and title of included page
  ft_namespace int NOT NULL default '0',
  ft_title varchar(255) binary NOT NULL default '',
  -- Revisions ID used when reviewed
  ft_tmp_rev_id integer unsigned NULL,
  
  PRIMARY KEY (ft_rev_id,ft_namespace,ft_title)
) /*$wgDBTableOptions*/;

-- This stores all of our image revision pointers
CREATE TABLE IF NOT EXISTS /*$wgDBprefix*/flaggedimages (
  fi_rev_id integer unsigned NOT NULL,
  -- Name of included image
  fi_name varchar(255) binary NOT NULL default '',
  -- Timestamp of image used when reviewed
  fi_img_timestamp char(14) NOT NULL default '',
  -- Statistically unique SHA-1 key
  fi_img_sha1 varbinary(32) NOT NULL default '',
  
  PRIMARY KEY (fi_rev_id,fi_name)
) /*$wgDBTableOptions*/;

-- This stores settings on how to select the stable/default revision
CREATE TABLE IF NOT EXISTS /*$wgDBprefix*/flaggedpage_config (
  -- Foreign key to page.page_id
  fpc_page_id integer unsigned NOT NULL,
  -- Integers to represent what to show by default:
  -- 0: quality -> stable
  -- 1: latest reviewed
  -- 2: pristine -> quality -> stable
  fpc_select integer NOT NULL,
  -- Override the page?
  fpc_override bool NOT NULL,
  -- The protection level (Sysop, etc) for autoreview
  fpc_level varbinary(60) NULL,
  -- Field for time-limited settings
  fpc_expiry varbinary(14) NOT NULL default 'infinity',
  
  PRIMARY KEY (fpc_page_id),
  INDEX (fpc_expiry)
) /*$wgDBTableOptions*/;

-- Track includes/links only in stable versions
CREATE TABLE IF NOT EXISTS /*$wgDBprefix*/flaggedrevs_tracking (
  ftr_from integer unsigned NOT NULL default '0',
  ftr_namespace int NOT NULL default '0',
  ftr_title varchar(255) binary NOT NULL default '',
  PRIMARY KEY (ftr_from,ftr_namespace,ftr_title),
  INDEX namespace_title_from (ftr_namespace,ftr_title,ftr_from)
) /*$wgDBTableOptions*/;

-- This stores user demotions and stats
CREATE TABLE IF NOT EXISTS /*$wgDBprefix*/flaggedrevs_promote (
  -- Foreign key to user.user_id
  frp_user_id integer unsigned NOT NULL,
  frp_user_params mediumblob NOT NULL,
  
  PRIMARY KEY (frp_user_id)
) /*$wgDBTableOptions*/;

-- This stores reader feedback data to curb double-voting
CREATE TABLE IF NOT EXISTS /*$wgDBprefix*/reader_feedback (
  -- Foreign key to revision.rev_id
  rfb_rev_id integer unsigned NOT NULL,
  -- Foreign key to user.user_id
  rfb_user integer unsigned NOT NULL,
  rfb_ip varchar(255) NOT NULL default '',
  rfb_timestamp char(14) NOT NULL default '',
  -- Vote info
  rfb_ratings mediumblob NOT NULL,
  -- No double voting!
  PRIMARY KEY (rfb_rev_id,rfb_user,rfb_ip)
) /*$wgDBTableOptions*/;

-- This stores reader feedback data for a page over time
CREATE TABLE IF NOT EXISTS /*$wgDBprefix*/reader_feedback_history (
  -- Foreign key to page.page_id
  rfh_page_id integer unsigned NOT NULL,
  rfh_tag char(20) NOT NULL default '',
  rfh_total integer unsigned NOT NULL default 0,
  rfh_count integer unsigned NOT NULL default 0,
  -- MW date of the day this average corresponds to
  rfh_date char(14) NOT NULL default '',
  PRIMARY KEY (rfh_page_id,rfh_tag,rfh_date)
) /*$wgDBTableOptions*/;

-- This stores reader feedback data for pages
CREATE TABLE IF NOT EXISTS /*$wgDBprefix*/reader_feedback_pages (
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
