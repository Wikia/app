CREATE TABLE `city_visualization` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `city_id` int(11) DEFAULT NULL,
  `city_lang_code` char(8) NOT NULL DEFAULT 'en',
  `city_vertical` int(11) DEFAULT NULL,
  `city_headline` varchar(255) DEFAULT NULL,
  `city_description` text,
  `city_main_image` varchar(255) DEFAULT NULL,
  `city_flags` smallint(8) DEFAULT '0',
  `city_images` text,
  PRIMARY KEY (`id`),
  KEY `cv_cid_cf_ce` (`city_id`,`city_flags`),
  CONSTRAINT `city_visualization_ibfk_1` FOREIGN KEY (`city_id`) REFERENCES `city_list` (`city_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;