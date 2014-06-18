CREATE TABLE `city_visualization_images_xwiki` (
  `city_id` int(11) NOT NULL,
  `city_lang_code` varchar(8) DEFAULT NULL,
  `image_type` int(11) DEFAULT '0',
  `image_index` int(11) DEFAULT '1',
  `image_name` varchar(255) NOT NULL,
  `image_review_status` tinyint(3) unsigned DEFAULT NULL,
  `last_edited` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `review_start` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `review_end` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `reviewer_id` int(11) DEFAULT NULL,
  KEY `city_visualization_images_xwiki_ifbk_1` (`city_id`),
  KEY `cvix_image_type` (`image_type`),
  KEY `cvix_image_review_status` (`image_review_status`),
  KEY `cvix_city_lang_code` (`city_lang_code`),
  CONSTRAINT `city_visualization_images_xwiki_ifbk_1` FOREIGN KEY (`city_id`) REFERENCES `city_visualization_xwiki` (`city_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1
