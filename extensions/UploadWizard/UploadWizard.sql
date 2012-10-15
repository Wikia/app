-- MySQL version of the database schema for the Upload Wizard extension.
-- Licence: GNU GPL v2+
-- Author: Jeroen De Dauw < jeroendedauw@gmail.com >

-- Upload wizard campaigns
CREATE TABLE IF NOT EXISTS /*$wgDBprefix*/uw_campaigns (
  campaign_id              SMALLINT unsigned   NOT NULL auto_increment PRIMARY KEY,
  campaign_name            VARCHAR(255)        NOT NULL,
  campaign_enabled         TINYINT             NOT NULL default '0'
) /*$wgDBTableOptions*/;

-- Upload wizard campaign config
CREATE TABLE IF NOT EXISTS /*$wgDBprefix*/uw_campaign_conf (
  cc_campaign_id           SMALLINT unsigned   NOT NULL,
  cc_property              VARCHAR(255)        NULL,
  cc_value                 BLOB                NULL
) /*$wgDBTableOptions*/;
