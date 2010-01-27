<?php

/**
 * @package MediaWiki
 * @ingroup WikiFactory
 * @author Krzysztof Krzyżaniak (eloy) <eloy@wikia.com> for Wikia Inc.
 * @copyright (C) 2010, Wikia Inc.
 * @licence GNU General Public Licence 2.0 or later
 */

# use tables
#
#CREATE TABLE `city_tag` (
#  `id` int(8) unsigned NOT NULL AUTO_INCREMENT,
#  `name` varchar(255) DEFAULT NULL,
#  PRIMARY KEY (`id`),
#  UNIQUE KEY `city_tag_name_uniq` (`name`)
#) ENGINE=InnoDB DEFAULT;
#
#
#CREATE TABLE `city_tag_map` (
#  `city_id` int(9) NOT NULL,
#  `tag_id` int(8) unsigned NOT NULL,
#  PRIMARY KEY (`city_id`,`tag_id`),
#  KEY `tag_id` (`tag_id`),
#  CONSTRAINT `city_tag_map_ibfk_1` FOREIGN KEY (`city_id`) REFERENCES `city_list` (`city_id`) ON DELETE CASCADE ON UPDATE CASCADE,
#  CONSTRAINT `city_tag_map_ibfk_2` FOREIGN KEY (`tag_id`) REFERENCES `city_tag` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
#) ENGINE=InnoDB
