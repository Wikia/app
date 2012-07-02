-- MySQL version of the database schema for the AdManager extension.
CREATE TABLE IF NOT EXISTS /*_*/ad (
  ad_id 				INT unsigned 	NOT NULL AUTO_INCREMENT PRIMARY KEY,
  ad_page_id            INT(10) unsigned    NOT NULL, 
  ad_zone               INT(4) unsigned,
  ad_page_is_category        BOOLEAN
) /*$wgDBTableOptions*/;

CREATE TABLE IF NOT EXISTS /*_*/adzones (
  ad_zone_id 				INT(4) unsigned 	NOT NULL PRIMARY KEY
) /*$wgDBTableOptions*/;