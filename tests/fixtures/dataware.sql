CREATE TABLE `pages` (
  `page_wikia_id` int unsigned NOT NULL,
  `page_id` int unsigned NOT NULL,
  `page_namespace` int unsigned NOT NULL DEFAULT '0',
  `page_title` varchar(255) NOT NULL,
  `page_is_content` tinyint unsigned NOT NULL DEFAULT '0',
  `page_is_redirect` tinyint unsigned NOT NULL DEFAULT '0',
  `page_latest` int unsigned NOT NULL DEFAULT '0',
  `page_last_edited` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`page_wikia_id`,`page_id`)
);

CREATE INDEX `page_title_namespace_latest_idx` ON `pages` (`page_title`,`page_namespace`,`page_latest`);
