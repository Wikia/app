-- MySQL version of the database schema for the Semantic Watchlist extension.
-- Licence: GNU GPL v3+
-- Author: Jeroen De Dauw < jeroendedauw@gmail.com >

-- Watchlist groups
CREATE TABLE IF NOT EXISTS /*$wgDBprefix*/swl_groups (
  group_id                 SMALLINT unsigned   NOT NULL auto_increment PRIMARY KEY,
  group_name               VARCHAR(255)        NOT NULL,
  -- No need to have this stuff relational, so keep it simple.
  -- These fields keep multiple values, | separated.
  group_categories         BLOB                NOT NULL, -- Category names
  group_namespaces         BLOB                NOT NULL, -- Namespace IDs
  group_properties         BLOB                NOT NULL, -- Property names
  group_concepts           BLOB                NOT NULL -- Concept names
) /*$wgDBTableOptions*/;

-- Single value changes to a property.
CREATE TABLE IF NOT EXISTS /*$wgDBprefix*/swl_changes (
  change_id                INT(10) unsigned    NOT NULL auto_increment PRIMARY KEY,
  change_set_id            INT(10) unsigned    NOT NULL, -- Foreign key: swl_sets.set_id
  change_property          VARCHAR(255)        NOT NULL, -- Name of the property of which a value was changed
  change_old_value         BLOB                NULL, -- The old value of the property (null for an adittion)
  change_new_value         BLOB                NULL -- The new value of the property (null for a deletion)
) /*$wgDBTableOptions*/;

-- Individual edits to pages.
CREATE TABLE IF NOT EXISTS /*$wgDBprefix*/swl_edits (
  edit_id                  SMALLINT unsigned   NOT NULL auto_increment PRIMARY KEY,
  edit_user_name           VARCHAR(255)        NOT NULL, -- The person that made the modification (account name or ip)
  edit_page_id             INT(10) unsigned    NOT NULL, -- The id of the page the modification was on  
  edit_time                CHAR(14) binary     NOT NULL default '' -- The time the chages where made  
) /*$wgDBTableOptions*/;

-- Sets of changes. There can be many such sets for one edit, with overlapping changes.
CREATE TABLE IF NOT EXISTS /*$wgDBprefix*/swl_sets (
  set_id                   INT(10) unsigned    NOT NULL auto_increment PRIMARY KEY
) /*$wgDBTableOptions*/;

-- Links change sets their edits.
CREATE TABLE IF NOT EXISTS /*$wgDBprefix*/swl_sets_per_edit (
  spe_set_id               SMALLINT unsigned   NOT NULL, -- Foreign key: swl_sets.set_id
  spe_edit_id              INT(10) unsigned    NOT NULL, -- Edit ID
  PRIMARY KEY  (spe_set_id,spe_edit_id)
) /*$wgDBTableOptions*/;

-- Links change sets to watchlist groups.
CREATE TABLE IF NOT EXISTS /*$wgDBprefix*/swl_sets_per_group (
  spg_group_id             SMALLINT unsigned   NOT NULL, -- Foreign key: swl_groups.group_id
  spg_set_id               INT(10) unsigned    NOT NULL, -- Foreign key: swl_sets.set_id
  PRIMARY KEY  (spg_group_id,spg_set_id)
) /*$wgDBTableOptions*/;

-- Links users to watchlist groups.
CREATE TABLE IF NOT EXISTS /*$wgDBprefix*/swl_users_per_group (
  upg_group_id             SMALLINT unsigned   NOT NULL, -- Foreign key: swl_groups.group_id
  upg_user_id              INT(10) unsigned    NOT NULL, -- Foreign key: user.user_id
  PRIMARY KEY  (upg_group_id,upg_user_id)
) /*$wgDBTableOptions*/;