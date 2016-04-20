CREATE TABLE `city_visualization_images` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `city_id` int(11) NOT NULL,
  `page_id` int(8) NOT NULL,
  `city_lang_code` varchar(8) DEFAULT NULL,
  `image_index` int(11) DEFAULT '1',
  `image_name` varchar(255) NOT NULL,
  `image_review_status` tinyint(3) unsigned DEFAULT NULL,
  `last_edited` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `review_start` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `review_end` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `reviewer_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `city_visualization_images_ifbk_1` (`city_id`),
  KEY `cvi_image_review_status` (`image_review_status`),
  KEY `cvi_city_lang_code` (`city_lang_code`),
  CONSTRAINT `city_visualization_images_ifbk_1` FOREIGN KEY (`city_id`) REFERENCES `city_visualization` (`city_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;