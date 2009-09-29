CREATE TABLE magcloud_collection (
 mco_hash VARCHAR(32) NOT NULL PRIMARY KEY,
 mco_user_id INT(11) DEFAULT 0,
 mco_wiki_id INT(11) DEFAULT 0,
 mco_updated DATETIME,
 mco_articles TEXT DEFAULT NULL,
 mco_cover TEXT DEFAULT NULL
);