CREATE TABLE magcloud_collection (
 mco_hash VARCHAR(32) NOT NULL PRIMARY KEY,
 mco_user_id INT(11) DEFAULT 0,
 mco_wiki_id INT(11) DEFAULT 0,
 mco_updated DATETIME,
 mco_articles TEXT DEFAULT NULL,
 mco_cover TEXT DEFAULT NULL
);

CREATE TABLE magcloud_collection_log (
	mcl_publish_hash VARCHAR(32),
	mcl_publish_timestamp INT,
	mcl_publish_token TEXT,
	mcl_publish_code INT,
	mcl_publish_msg TEXT,
	mcl_publish_raw_result TEXT,
	mcl_timestamp INT
);
