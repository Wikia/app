CREATE table `wikia_homepage_collections_city_visualization` (
	`collection_id` int UNSIGNED NOT NULL,
	`city_id` int UNSIGNED NOT NULL,
	PRIMARY KEY (`city_id`,`collection_id`),
	CONSTRAINT `fk_wikia_homepage_collections` FOREIGN KEY (`collection_id`) REFERENCES `wikia_homepage_collections` (`id`) ON DELETE CASCADE
);