CREATE TABLE `city_visualization_images` (
  `city_id` int(11) NOT NULL,
  `image_index` int(11) DEFAULT '1',
  `image_name` varchar(255) NOT NULL,
  `image_reviewed` tinyint(1) DEFAULT '0',
  KEY `cv_ir` (`image_reviewed`),
  KEY `city_visualization_images_ifbk_1` (`city_id`),
  CONSTRAINT `city_visualization_images_ifbk_1` FOREIGN KEY (`city_id`) REFERENCES `city_visualization` (`city_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
