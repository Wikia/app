-- (c) Aaron Schulz, 2007

ALTER TABLE /*$wgDBprefix*/account_requests
	ADD acr_type tinyint(255) default 0,
	DROP INDEX acr_deleted_reg,
	ADD INDEX acr_type_del_reg (acr_type,acr_deleted,acr_registration);

-- This stores all of credential information
-- When accounts are confirmed, the identity info goes here
CREATE TABLE /*$wgDBprefix*/account_credentials (
  -- Revision ID #
  acd_id int unsigned NOT NULL auto_increment,
  -- Foreign key to user.user_id
  acd_user_id int unsigned NOT NULL,
  -- Optional 'real name' to be displayed in credit listings
  acd_real_name varchar(255) binary NOT NULL default '',
  -- Note: email should be restricted, not public info.
  -- Same with passwords.
  acd_email tinytext NOT NULL,
  -- Initially NULL; when a user's e-mail address has been
  -- validated by returning with a mailed token, this is
  -- set to the current timestamp.
  acd_email_authenticated binary(14) default NULL,
  -- A little about this user
  acd_bio mediumblob NOT NULL,
  -- Private info for reviewers to look at when considering request
  acd_notes mediumblob NOT NULL,
  -- Links to recognize/identify this user, CSV, may not be public
  acd_urls mediumblob NOT NULL,
  -- IP address
  acd_ip VARCHAR(255) NULL default '',
  -- Name of attached file (.pdf,.doc,.txt etc...)
  acd_filename VARCHAR(255) NULL,
  acd_storage_key VARCHAR(64) NULL,
  -- Areas of interest
  acd_areas mediumblob NOT NULL,
  
  -- Timestamp of account registration.
  acd_registration char(14) NOT NULL,
  
  -- Timestamp of acceptance
  acd_accepted binary(14),
  -- The user who accepted it
  acd_user int unsigned NOT NULL default 0,
  -- Reason given in email
  acd_comment varchar(255) NOT NULL default '',
  
  PRIMARY KEY (acd_user_id,acd_id),
  UNIQUE KEY (acd_id)
  
) TYPE=InnoDB;
