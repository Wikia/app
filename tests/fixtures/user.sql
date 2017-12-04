--
-- The user table contains basic account information,
-- authentication keys, etc.
--
-- Some multi-wiki sites may share a single central user table
-- between separate wikis using the $wgSharedDB setting.
--
-- Note that when a external authentication plugin is used,
-- user table entries still need to be created to store
-- preferences and to key tracking information in the other
-- tables.
--
CREATE TABLE /*_*/user (
  user_id int unsigned NOT NULL PRIMARY KEY AUTO_INCREMENT,

  -- Usernames must be unique, must not be in the form of
  -- an IP address. _Shouldn't_ allow slashes or case
  -- conflicts. Spaces are allowed, and are _not_ converted
  -- to underscores like titles. See the User::newFromName() for
  -- the specific tests that usernames have to pass.
  user_name varchar(255) binary NOT NULL default '',

  -- Optional 'real name' to be displayed in credit listings
  user_real_name varchar(255) binary NOT NULL default '',

  -- Note: email should be restricted, not public info.
  -- Same with passwords.
  user_email tinytext NOT NULL,

  -- This is a timestamp which is updated when a user
  -- logs in, logs out, changes preferences, or performs
  -- some other action requiring HTML cache invalidation
  -- to ensure that the UI is updated.
  user_touched binary(14) NOT NULL default '',

  -- A pseudorandomly generated value that is stored in
  -- a cookie when the "remember password" feature is
  -- used (previously, a hash of the password was used, but
  -- this was vulnerable to cookie-stealing attacks)
  user_token binary(32) NOT NULL default '',

  -- Initially NULL; when a user's e-mail address has been
  -- validated by returning with a mailed token, this is
  -- set to the current timestamp.
  user_email_authenticated binary(14),

  -- Randomly generated token created when the e-mail address
  -- is set and a confirmation test mail sent.
  user_email_token binary(32),

  -- Expiration date for the user_email_token
  user_email_token_expires binary(14),

  -- Timestamp of account registration.
  -- Accounts predating this schema addition may contain NULL.
  user_registration binary(14),

  -- Count of edits and edit-like actions.
  --
  -- *NOT* intended to be an accurate copy of COUNT(*) WHERE rev_user=user_id
  -- May contain NULL for old accounts if batch-update scripts haven't been
  -- run, as well as listing deleted edits and other myriad ways it could be
  -- out of sync.
  --
  -- Meant primarily for heuristic checks to give an impression of whether
  -- the account has been used much.
  --
  user_editcount int,

  user_birthdate date default NULL
) /*$wgDBTableOptions*/;

CREATE UNIQUE INDEX /*i*/user_name ON /*_*/user (user_name);
CREATE INDEX /*i*/user_email_token ON /*_*/user (user_email_token);
CREATE INDEX /*i*/user_email ON /*_*/user (user_email(50));
