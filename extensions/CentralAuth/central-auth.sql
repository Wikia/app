
-- -- Some example steps for creating a new database for testing this:
-- CREATE DATABASE centralauth;
-- USE centralauth;
-- GRANT all on centralauth.* to 'wikiuser'@'localhost';
-- source central-auth.sql

--
-- This table simply lists all known usernames in the system.
-- If no record is present here when migration processing begins,
-- we know we have to sweep all the local databases and populate
-- the localnames table.
--
CREATE TABLE globalnames (
	gn_name varchar(255) binary not null,
	primary key (gn_name)
) /*$wgDBTableOptions*/;

--
-- For each known username in globalnames, the presence of an acount
-- on each local database is listed here.
--
-- Email and password information used for migration checks are grabbed
-- from local databases on demand when needed.
--
-- This is an optimization measure, so we don't have to poke on 600+
-- separate databases to look for unmigrated accounts every time we log in;
-- only existing databases not yet migrated have to be loaded.
--
CREATE TABLE localnames (
  ln_wiki varchar(255) binary not null,
  ln_name varchar(255) binary not null,

  primary key (ln_wiki, ln_name),
  key (ln_name, ln_wiki)
) /*$wgDBTableOptions*/;

--
-- Global account data.
--
CREATE TABLE globaluser (
  -- Internal unique ID for the authentication server
  gu_id int auto_increment,

  -- Username.
  gu_name varchar(255) binary,

  -- Timestamp and method used to create the global account
  gu_enabled varchar(14) not null,
  gu_enabled_method enum('opt-in', 'batch', 'auto', 'admin'),

  -- Local database name of the user's 'home' wiki.
  -- By default, the 'winner' of a migration check for old accounts
  -- or the account the user was first registered at for new ones.
  -- May be changed over time.
  gu_home_db varchar(255) binary,

  -- Registered email address, may be empty.
  gu_email varchar(255) binary,

  -- Timestamp when the address was confirmed as belonging to the user.
  -- NULL if not confirmed.
  gu_email_authenticated char(14) binary,

  -- Salt and hashed password
  -- For migrated passwords, the salt is the local user_id.
  gu_salt varchar(16) binary,
  gu_password tinyblob,

  -- If true, this account cannot be used to log in on any wiki.
  gu_locked bool not null default 0,

  -- If true, this account should be hidden from most public user lists.
  -- Used for "deleting" accounts without breaking referential integrity.
  gu_hidden bool not null default 0,

  -- Registration time
  gu_registration varchar(14) binary,

  -- Random key for password resets
  gu_password_reset_key tinyblob,
  gu_password_reset_expiration varchar(14) binary,
  
  -- Random key for crosswiki authentication tokens
  gu_auth_token varbinary(32) NULL,

  primary key (gu_id),
  unique key (gu_name),
  key (gu_email)
) /*$wgDBTableOptions*/;

--
-- Local linkage info, listing which wikis the username is attached
-- to the global account.
--
-- All local DBs will be swept on an opt-in check event.
--
CREATE TABLE localuser (
  lu_wiki varchar(255) binary not null,
  lu_name varchar(255) binary not null,

  -- Migration status/logging information, to help diagnose issues
  lu_attached_timestamp varchar(14) binary,
  lu_attached_method enum (
    'primary',
    'empty',
    'mail',
    'password',
    'admin',
    'new',
    'login'),

  primary key (lu_wiki, lu_name),
  key (lu_name, lu_wiki)
) /*$wgDBTableOptions*/;


-- Global user groups.
CREATE TABLE global_user_groups (
	gug_user int(11) not null,
	gug_group varchar(255) not null,
	
	PRIMARY KEY (gug_user,gug_group),
	KEY (gug_user),
	key (gug_group)
) /*$wgDBTableOptions*/;

-- Global group permissions.
CREATE TABLE global_group_permissions (
	ggp_group varchar(255) not null,
	ggp_permission varchar(255) not null,
	
	PRIMARY KEY (ggp_group, ggp_permission),
	KEY (ggp_group),
	KEY (ggp_permission)
) /*$wgDBTableOptions*/;

-- Sets of wikis (for things like restricting global groups)
-- May be defined in two ways: only specified wikis or all wikis except opt-outed
CREATE TABLE wikiset (
	-- ID of wikiset
	ws_id int auto_increment,
	-- Display name of wikiset
	ws_name varchar(255) not null,
	-- Type of set: opt-in or opt-out
	ws_type enum ('optin', 'optout'),
	-- Wikis in that set. Why isn't it a separate table?
	-- Because we can just use such simple list, we don't need complicated queries on it
	-- Let's suppose that max length of db name is 31 (32 with ","), then we have space for
	-- 2048 wikis. More than we need
	ws_wikis blob not null,
	
	PRIMARY KEY ws_id (ws_id),
	UNIQUE ws_name (ws_name)
) /*$wgDBTableOptions*/;

-- Allow certain global groups to have their permissions only on certain wikis
CREATE TABLE global_group_restrictions (
	-- Group to restrict
	ggr_group varchar(255) not null,
	-- Wikiset to use
	ggr_set int not null,

	PRIMARY KEY (ggr_group),
	KEY (ggr_set)
) /*$wgDBTableOptions*/;
