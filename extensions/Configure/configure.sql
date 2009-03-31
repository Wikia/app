--
-- SQL schema for Configure extension
--

-- Information about each configuration version
CREATE TABLE config_version (

	-- Primary key, used for joins with config_setting table
	cv_id int(11) NOT NULL auto_increment,

	-- wiki concerned by this version
	cv_wiki varbinary(32) NOT NULL,

	-- TS_MV timestamp of the version
	cv_timestamp varbinary(14) NOT NULL,

	-- Whether this is the latest version for cv_wiki, will be used to get
	-- all curent version when loading all the configuration at startup
	cv_is_latest tinyint NOT NULL DEFAULT 0,
	
	-- Who made the revision, name and wiki ID
	cv_user_text varchar(255) NOT NULL,
	cv_user_wiki varbinary(255) NOT NULL,
	
	-- Reason - not used yet but maybe in the future.
	cv_reason TINYBLOB NOT NULL,

	PRIMARY KEY ( cv_id ),
	KEY cv_timestamp( cv_timestamp ),
	KEY cv_is_latest( cv_is_latest )
) /*$wgDBTableOptions*/;

-- Configuration settings
CREATE TABLE config_setting (

	-- foreign key to config_version.cv_id, used for joins
	cs_id int(11) NOT NULL,

	-- setting's name
	cs_name varbinary(255) NOT NULL,

	-- setting's value, in php serialized format
	cs_value blob,

	PRIMARY KEY ( cs_id, cs_name ),
	KEY cs_id( cs_id )
) /*$wgDBTableOptions*/;
