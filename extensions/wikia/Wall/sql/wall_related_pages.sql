CREATE TABLE `wall_related_pages` (
  `comment_id` int(10) unsigned NOT NULL,
  `page_id` int(10) unsigned NOT NULL,
  `order_index` int(10) unsigned NOT NULL,
  `add_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  KEY `comment_id_idx` (`comment_id`),
  KEY `page_id_idx` (`page_id`)
) ENGINE=InnoDB;

alter table wall_related_pages add last_update timestamp;

alter table wall_related_pages drop key page_id_idx;

alter table wall_related_pages add key page_id_idx (`page_id`, `last_update`);