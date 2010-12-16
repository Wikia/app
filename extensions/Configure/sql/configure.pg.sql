--
-- Postgres' SQL schema for Configure extension
--

-- Information about each configuration version
CREATE SEQUENCE config_version_cv_id_seq;
CREATE TABLE config_version (

	-- Primary key, used for joins with config_setting table
	cv_id INTEGER NOT NULL PRIMARY KEY DEFAULT nextval( 'config_version_cv_id_seq' ),

	-- wiki concerned by this version
	cv_wiki TEXT NOT NULL,

	-- TS_POSTGRES timestamp of the version
	cv_timestamp TIMESTAMPTZ NOT NULL,

	-- Whether this is the latest version for cv_wiki, will be used to get
	-- all curent version when loading all the configuration at startup
	cv_is_latest SMALLINT NOT NULL DEFAULT 0,
	
	-- Who made the revision, name and wiki ID
	cv_user_text TEXT NOT NULL,
	cv_user_wiki TEXT NOT NULL,
	
	-- Reason
	cv_reason TEXT NOT NULL
);
CREATE INDEX cv_timestamp ON config_version( cv_timestamp );
CREATE INDEX cv_is_latest ON config_version( cv_is_latest );

-- Configuration settings
CREATE TABLE config_setting (

	-- foreign key to config_version.cv_id, used for joins
	cs_id INTEGER NOT NULL REFERENCES config_version( cv_id ) ON DELETE CASCADE,

	-- setting's name
	cs_name TEXT NOT NULL,

	-- setting's value, in php serialized format
	cs_value TEXT
);
ALTER TABLE config_setting ADD CONSTRAINT cs_id_name PRIMARY KEY ( cs_id, cs_name );
CREATE INDEX cs_id ON config_setting( cs_id );
