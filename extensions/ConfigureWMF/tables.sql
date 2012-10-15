-- Tables for ConfigureWMF extension

CREATE TABLE config_overrides (
	-- Wiki or tag of wiki to be applied
	-- Existing tags: private, fishbowl, default
	cfg_target varchar(255) binary not null,

	-- Configuration internal ID
	cfg_name varchar(255) binary not null,

	-- Configuration itself, serialize()'d array
	cfg_value mediumblob not null,

	-- User who last changed this override
	cfg_user_text varchar(255) not null,

	-- Last change timestamp
	cfg_timestamp binary(14) not null,

	PRIMARY KEY (cfg_target,cfg_name),
	KEY (cfg_target)
) /*$wgDBTableOptions*/;