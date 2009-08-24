--
-- Postgres' SQL schema update for Configure extension
-- for people that applied configure.pg.sql in version < 0.12.5
--

-- Add foreign key constraint
ALTER TABLE config_setting ADD CONSTRAINT config_setting_cs_id_fkey
	FOREIGN KEY ( cs_id ) REFERENCES config_version( cv_id ) ON DELETE CASCADE;
