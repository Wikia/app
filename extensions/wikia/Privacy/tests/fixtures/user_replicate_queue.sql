CREATE TABLE IF NOT EXISTS `user_replicate_queue` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(5) unsigned NOT NULL,
  `retries_count` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
);
