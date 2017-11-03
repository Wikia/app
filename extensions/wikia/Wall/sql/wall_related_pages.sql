CREATE TABLE `wall_related_pages` (
  `comment_id` int(10) unsigned NOT NULL,
  `page_id` int(10) unsigned NOT NULL,
  `order_index` int(10) unsigned NOT NULL,
  `add_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `last_update` timestamp,
  UNIQUE KEY `unique_key` (`comment_id`,`page_id`),
  KEY `page_id_idx` (`page_id`,`last_update`)
) ENGINE=InnoDB;
