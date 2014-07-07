-- (c) Aaron Schulz, 2007-2011, GPL
-- Replace /*_*/ with the proper prefix
-- Replace /*$wgDBTableOptions*/ with the correct options

-- Add page tracking table for flagged revisions
CREATE TABLE IF NOT EXISTS /*_*/flaggedpages (
  -- Foreign key to page.page_id
  fp_page_id integer unsigned NOT NULL PRIMARY KEY,
  -- Is the stable version synced?
  fp_reviewed bool NOT NULL default '0',
  -- When (or NULL) the first edit after the stable version was made
  fp_pending_since varbinary(14) NULL,
  -- Foreign key to flaggedrevs.fr_rev_id
  fp_stable integer unsigned NOT NULL,
  -- The highest quality of the page's reviewed revisions.
  -- Note that this may not be set to display by default though.
  fp_quality tinyint(1) default NULL
) /*$wgDBTableOptions*/;

CREATE INDEX /*i*/fp_reviewed_page ON /*_*/flaggedpages (fp_reviewed,fp_page_id);
CREATE INDEX /*i*/fp_quality_page ON /*_*/flaggedpages (fp_quality,fp_page_id);
CREATE INDEX /*i*/fp_pending_since ON /*_*/flaggedpages (fp_pending_since);

-- Add tracking table for edits needing review (for all levels)
CREATE TABLE IF NOT EXISTS /*_*/flaggedpage_pending (
  -- Foreign key to page.page_id
  fpp_page_id integer unsigned NOT NULL,
  -- The quality tier (0=checked, 1=quality, 2=pristine)
  fpp_quality tinyint(1) NOT NULL,
  -- The last rev ID with this quality
  fpp_rev_id integer unsigned NOT NULL,
  -- Time of the first edit after the last revision reviewed to this level
  fpp_pending_since varbinary(14) NOT NULL,
  
  PRIMARY KEY (fpp_page_id,fpp_quality)
) /*$wgDBTableOptions*/;

CREATE INDEX /*i*/fpp_quality_pending
	ON /*_*/flaggedpage_pending (fpp_quality,fpp_pending_since);

-- This stores all of our revision reviews; it is the main table
-- The template/file version data is stored in the next two tables
CREATE TABLE IF NOT EXISTS /*_*/flaggedrevs (
  -- Foreign key to revision.rev_id
  fr_rev_id integer unsigned NOT NULL PRIMARY KEY,
  -- Timestamp of revision reviewed (revision.rev_timestamp)
  fr_rev_timestamp varbinary(14) NOT NULL default '',
  -- Foreign key to page.page_id
  fr_page_id integer unsigned NOT NULL,
  -- Foreign key to user.user_id
  fr_user integer unsigned NOT NULL,
  -- Timestamp of review
  fr_timestamp varbinary(14) NOT NULL,
  -- Store the precedence level
  fr_quality tinyint(1) NOT NULL default 0,
  -- Store tag metadata as newline separated, 
  -- colon separated tag:value pairs
  fr_tags mediumblob NOT NULL,
  -- Comma-separated list of flags:
  -- dynamic: no text, templates must be fetched
  -- auto: revision reviewed automatically
  -- utf8: in UTF-8
  fr_flags tinyblob NOT NULL,
  -- Parameters for revisions of File pages:
  -- Name of included image (NULL if n/a)
  fr_img_name varchar(255) binary NULL default NULL,
  -- Timestamp of file (when uploaded) (NULL if n/a)
  fr_img_timestamp varbinary(14) NULL default NULL,
  -- Statistically unique SHA-1 key (NULL if n/a)
  fr_img_sha1 varbinary(32) NULL default NULL
) /*$wgDBTableOptions*/;

CREATE INDEX /*i*/page_rev ON /*_*/flaggedrevs (fr_page_id,fr_rev_id);
CREATE INDEX /*i*/page_time ON /*_*/flaggedrevs (fr_page_id,fr_rev_timestamp);
CREATE INDEX /*i*/page_qal_rev ON /*_*/flaggedrevs (fr_page_id,fr_quality,fr_rev_id);
CREATE INDEX /*i*/page_qal_time ON /*_*/flaggedrevs (fr_page_id,fr_quality,fr_rev_timestamp);
CREATE INDEX /*i*/fr_img_sha1 ON /*_*/flaggedrevs (fr_img_sha1);

-- This stores all of our transclusion revision pointers
CREATE TABLE IF NOT EXISTS /*_*/flaggedtemplates (
  ft_rev_id integer unsigned NOT NULL,
  -- Namespace and title of included page
  ft_namespace int NOT NULL default '0',
  ft_title varchar(255) binary NOT NULL default '',
  -- Revisions ID used when reviewed
  ft_tmp_rev_id integer unsigned NULL,
  
  PRIMARY KEY (ft_rev_id,ft_namespace,ft_title)
) /*$wgDBTableOptions*/;

-- This stores all of our image revision pointers
CREATE TABLE IF NOT EXISTS /*_*/flaggedimages (
  fi_rev_id integer unsigned NOT NULL,
  -- Name of included image
  fi_name varchar(255) binary NOT NULL default '',
  -- Timestamp of image used when reviewed
  fi_img_timestamp varbinary(14) NULL,
  -- Statistically unique SHA-1 key
  fi_img_sha1 varbinary(32) NOT NULL default '',
  
  PRIMARY KEY (fi_rev_id,fi_name)
) /*$wgDBTableOptions*/;

-- This stores settings on how to select the stable/default revision
CREATE TABLE IF NOT EXISTS /*_*/flaggedpage_config (
  -- Foreign key to page.page_id
  fpc_page_id integer unsigned NOT NULL PRIMARY KEY,
  -- Integers to represent what to show by default:
  -- 0: quality -> stable
  -- 1: latest reviewed
  -- 2: pristine -> quality -> stable
  fpc_select integer NOT NULL,
  -- Override the page?
  fpc_override bool NOT NULL,
  -- The protection level (Sysop, etc) for autoreview/review
  fpc_level varbinary(60) NULL,
  -- Field for time-limited settings
  fpc_expiry varbinary(14) NOT NULL default 'infinity'
) /*$wgDBTableOptions*/;

CREATE INDEX /*i*/fpc_expiry ON /*_*/flaggedpage_config (fpc_expiry);

-- Track includes/links only in stable versions
CREATE TABLE IF NOT EXISTS /*_*/flaggedrevs_tracking (
  ftr_from integer unsigned NOT NULL default '0',
  ftr_namespace int NOT NULL default '0',
  ftr_title varchar(255) binary NOT NULL default ''
) /*$wgDBTableOptions*/;

CREATE UNIQUE INDEX /*i*/from_namespace_title
	ON /*_*/flaggedrevs_tracking (ftr_from,ftr_namespace,ftr_title);
CREATE INDEX /*i*/namespace_title_from
	ON /*_*/flaggedrevs_tracking (ftr_namespace,ftr_title,ftr_from);

-- This stores user demotions and stats
CREATE TABLE IF NOT EXISTS /*_*/flaggedrevs_promote (
  -- Foreign key to user.user_id
  frp_user_id integer unsigned NOT NULL PRIMARY KEY,
  frp_user_params mediumblob NOT NULL
) /*$wgDBTableOptions*/;

-- This stores overall stats
CREATE TABLE /*_*/flaggedrevs_statistics (
  -- Timestamp stat was recorded
  frs_timestamp varbinary(14) NOT NULL,
  -- Stat key name, colons separate paramaters
  frs_stat_key varchar(255) NOT NULL,
  -- Stat value as an integer
  frs_stat_val bigint NOT NULL,
  PRIMARY KEY(frs_stat_key,frs_timestamp)
) /*$wgDBTableOptions*/;
CREATE INDEX /*i*/frs_timestamp ON /*_*/flaggedrevs_statistics (frs_timestamp);
