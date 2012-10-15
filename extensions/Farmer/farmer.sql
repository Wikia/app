--
-- Schema for Farmer extension
--

-- Store each wiki in the wiki farm
CREATE TABLE farmer_wiki (
	fw_id INT NOT NULL auto_increment PRIMARY KEY,
	fw_name VARCHAR(32) UNIQUE,
	fw_title VARCHAR(255),
	fw_description BLOB,
	fw_creator VARCHAR(255),
	fw_parameters BLOB,
	fw_permissions BLOB
) /*$wgDBTableOptions*/;

-- Store information about each extension availabe in the farm
CREATE TABLE farmer_extension (
	fe_id INT NOT NULL auto_increment PRIMARY KEY,
	fe_name VARCHAR(255) UNIQUE,
	fe_description BLOB,
	fe_path VARCHAR(255)
) /*$wgDBTableOptions*/;

-- Store relation beetween wiki and extensions
CREATE TABLE farmer_wiki_extension (
	fwe_wiki INT NOT NULL,
	fwe_extension INT NOT NULL
) /*$wgDBTableOptions*/;

CREATE INDEX farmer_wiki_extension_wiki ON farmer_wiki_extension ( fwe_wiki );
CREATE INDEX farmer_wiki_extension_extension ON farmer_wiki_extension ( fwe_extension );
ALTER TABLE farmer_wiki_extension
	ADD CONSTRAINT farmer_wiki_extension_wiki_extension PRIMARY KEY ( fwe_wiki, fwe_extension );
