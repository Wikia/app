-- (c) Aaron Schulz, 2007

-- Table structure for table `Confirm account`
-- Replace /*$wgDBprefix*/ with the proper prefix

-- This stores all of our reviews,
-- the corresponding tags are stored in the tag table
CREATE TABLE IF NOT EXISTS /*_*/account_requests (
  acr_id int unsigned NOT NULL auto_increment PRIMARY KEY,
  -- Usernames must be unique, must not be in the form of
  -- an IP address. _Shouldn't_ allow slashes or case
  -- conflicts. Spaces are allowed, and are _not_ converted
  -- to underscores like titles. See the User::newFromName() for
  -- the specific tests that usernames have to pass.
  acr_name varchar(255) binary NOT NULL default '',
  -- Optional 'real name' to be displayed in credit listings
  acr_real_name varchar(255) binary NOT NULL default '',
  -- Note: email should be restricted, not public info.
  -- Same with passwords.
  acr_email tinytext NOT NULL,
  -- Initially NULL; when a user's e-mail address has been
  -- validated by returning with a mailed token, this is
  -- set to the current timestamp.
  acr_email_authenticated varbinary(14) default NULL,
  -- Randomly generated token created when the e-mail address
  -- is set and a confirmation test mail sent.
  acr_email_token binary(32),
  -- Expiration date for the user_email_token
  acr_email_token_expires varbinary(14),
  -- A little about this user
  acr_bio mediumblob NOT NULL,
  -- Private info for reviewers to look at when considering request
  acr_notes mediumblob NOT NULL,
  -- Links to recognize/identify this user, CSV, may not be public
  acr_urls mediumblob NOT NULL,
  -- IP address
  acr_ip VARCHAR(255) NULL default '',
  -- Name of attached file (.pdf,.doc,.txt etc...)
  acr_filename VARCHAR(255) NULL,
  acr_storage_key VARCHAR(64) NULL,
  -- Prospective account access level
  acr_type tinyint(255) unsigned NOT NULL default 0,
  -- Areas of interest
  acr_areas mediumblob NOT NULL,

  -- Timestamp of account registration.
  acr_registration varbinary(14) NOT NULL,

  -- Flag for rejected accounts
  acr_deleted bool NOT NULL,
  -- Time of rejection (if rejected)
  acr_rejected varbinary(14),
  -- Time request was put on hold (if held)
  acr_held varbinary(14),
  -- The user who rejected/held it
  acr_user int unsigned NOT NULL default 0,
  -- Reason
  acr_comment varchar(255) NOT NULL default ''
) /*$wgDBTableOptions*/;

CREATE UNIQUE INDEX /*i*/acr_name ON /*_*/account_requests (acr_name);
CREATE UNIQUE INDEX /*i*/acr_email ON /*_*/account_requests (acr_email(255));
CREATE INDEX /*i*/acr_email_token ON /*_*/account_requests (acr_email_token);
CREATE INDEX /*i*/acr_type_del_reg ON /*_*/account_requests (acr_type,acr_deleted,acr_registration);

-- This stores all of credential information
-- When accounts are confirmed, the identity info goes here
CREATE TABLE IF NOT EXISTS /*_*/account_credentials (
  -- Revision ID #
  acd_id int unsigned NOT NULL auto_increment PRIMARY KEY,
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
  acd_email_authenticated varbinary(14) default NULL,
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
  acd_registration varbinary(14) NOT NULL,

  -- Timestamp of acceptance
  acd_accepted varbinary(14),
  -- The user who accepted it
  acd_user int unsigned NOT NULL default 0,
  -- Reason given in email
  acd_comment varchar(255) NOT NULL default ''
) /*$wgDBTableOptions*/;

CREATE UNIQUE INDEX /*i*/acd_user_id ON /*_*/account_credentials (acd_user_id,acd_id);
