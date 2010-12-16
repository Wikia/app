--
-- SQL schema update for Configure extension
-- for people that applied configure.sql in version < 0.10.7
--

-- Add new fields
ALTER TABLE config_version

	-- Who made the revision, name and wiki ID
	ADD cv_user_text varchar(255) NOT NULL,
	ADD cv_user_wiki varbinary(255) NOT NULL,
	
	-- Reason
	ADD cv_reason TINYBLOB NOT NULL;
