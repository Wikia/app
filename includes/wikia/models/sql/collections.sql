CREATE table wikia_homepage_collections (
	id int UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
	lang_code varchar(8) NOT NULL,
	sort tinyint  UNSIGNED NOT NULL DEFAULT 0,
	name varchar(255) NOT NULL,
	sponsor_hero_image varchar(255) DEFAULT NULL,
	sponsor_image varchar(255) DEFAULT NULL,
	sponsor_url varchar(255) DEFAULT NULL,
	enabled tinyint(1) UNSIGNED NOT NULL DEFAULT 0);
ALTER TABLE wikia_homepage_collections ADD INDEX (lang_code);