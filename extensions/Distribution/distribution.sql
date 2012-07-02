-- MySQL version of the database schema for the Distribution extension.

-- Packages can contain multiple units, either pointing to the units themselves,
-- which will get the latest version, or a specific version.
CREATE TABLE IF NOT EXISTS /*$wgDBprefix*/distribution_packages (
  package_id               INT(8) unsigned   NOT NULL auto_increment PRIMARY KEY
  --need to figure out how to best link units/versions here,
  --this (aka package functionality) is not needed in the initial version though.
) /*$wgDBTableOptions*/;

-- Units are individual extensions, or mw core. They contain data non-specific to
-- the different versions, as this is stored in distribution_unit_versions.
CREATE TABLE IF NOT EXISTS /*$wgDBprefix*/distribution_units (
  unit_id                 INT(8) unsigned   NOT NULL auto_increment PRIMARY KEY,
  unit_name               VARCHAR(255)      NOT NULL,
  unit_url                VARCHAR(255)      NULL,
  -- Latest stable release id.
  unit_current            INT(8) unsigned   NOT NULL,
  -- Select info of the latest release to avoid extra lookups.
  current_version_nr      VARCHAR(20)       NOT NULL,
  current_desc            BLOB              NOT NULL,
  current_authors         BLOB              NOT NULL
  -- early adoptor stuff can be here
) /*$wgDBTableOptions*/;

CREATE UNIQUE INDEX unit_name ON /*$wgDBprefix*/distribution_units (unit_name);

-- Specific versions of units.
CREATE TABLE IF NOT EXISTS /*$wgDBprefix*/distribution_unit_versions (
  version_id               INT(8) unsigned   NOT NULL auto_increment PRIMARY KEY,
  
  version_unit_id          INT(8) unsigned   NOT NULL,
  FOREIGN KEY (version_unit_id) REFERENCES /*$wgDBprefix*/distribution_units(unit_id),  
  
  --might want to have this as int to compare?
  version_nr               VARCHAR(20)       NOT NULL,
  
  --enum with release status (alpha, beta, rc, supported, deprecated, ...)
  version_status           TINYINT unsigned  NOT NULL,
  
  version_release_date     CHAR(14) binary   NOT NULL default '',
  
  version_directory        VARCHAR(255)      NOT NULL, 
  version_entrypoint       VARCHAR(255)      NOT NULL,  
  
  version_desc             BLOB              NOT NULL,
  --work with an extra table to be able to filter on authors?
  version_authors          BLOB              NOT NULL
  --... more stuff be here, but let's not bother for an initial version.
  
  --dependency info
  --compatibility info
) /*$wgDBTableOptions*/;

CREATE TABLE IF NOT EXISTS /*_*/distribution_mwreleases (
  mwr_id int(10) unsigned NOT NULL PRIMARY KEY AUTO_INCREMENT,
  mwr_name varchar(255) NOT NULL,
  mwr_number varchar(32) NOT NULL,
  mwr_reldate varbinary(32) DEFAULT NULL,
  mwr_eoldate varbinary(32) DEFAULT NULL,
  mwr_branch varchar(32) NOT NULL,
  mwr_tag varchar(32) NOT NULL,
  mwr_announcement varchar(255) DEFAULT NULL,
  mwr_supported int(1) NOT NULL
) /*$wgDBTableOptions*/;