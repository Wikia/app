-- SQL tables for LocalisationUpdate extension
CREATE TABLE /*$wgDBprefix*/localisation (
  lo_key varchar(255) NOT NULL,
  lo_language varchar(10) NOT NULL,
  lo_value mediumblob NOT NULL,

  PRIMARY KEY (lo_language, lo_key)
) /*$wgDBTableOptions*/;

CREATE TABLE /*$wgDBprefix*/localisation_file_hash (
  lfh_file varchar(250) NOT NULL,
  lfh_hash varchar(50) NOT NULL,
  lfh_timestamp varchar(14) NOT NULL
) /*$wgDBTableOptions*/;

CREATE UNIQUE INDEX /*i*/lfh_file ON
	/*$wgDBprefix*/localisation_file_hash (lfh_file);
CREATE INDEX /*i*/lfh_file_hash ON
	/*$wgDBprefix*/localisation_file_hash (lfh_file, lfh_hash);
CREATE INDEX /*i*/lfh_timestamp ON
	/*$wgDBprefix*/localisation_file_hash (lfh_timestamp);