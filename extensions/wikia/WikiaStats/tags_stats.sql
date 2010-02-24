
CREATE TABLE `tags_top_articles` (
  `ta_city_id` INT(10) UNSIGNED NOT NULL,
  `ta_tag_id` INT(10) UNSIGNED NOT NULL,
  `ta_page_id` INT(10) UNSIGNED NOT NULL,
  `ta_date` DATE NOT NULL,
  `ta_page_name` VARBINARY(255) DEFAULT NULL,
  `ta_page_url` VARBINARY(255) DEFAULT NULL,
  `ta_wikiname` VARBINARY(255) DEFAULT NULL,
  `ta_wikiurl` VARBINARY(255) DEFAULT NULL,
  `ta_count` INT(10) UNSIGNED NOT NULL,
  `ta_city_lang` VARBINARY(16) DEFAULT NULL,
  PRIMARY KEY (`ta_city_id`,`ta_page_id`,`ta_tag_id`,`ta_date`),
  KEY `ta_date` (`ta_date`),
  KEY `ta_tag_id` (`ta_tag_id`,ta_city_lang),
  KEY `city` (ta_city_id, ta_page_id)
) ENGINE=INNODB;


CREATE TABLE `tags_top_blogs` (
  `tb_city_id` INT(10) UNSIGNED NOT NULL,
  `tb_page_id` INT(10) UNSIGNED NOT NULL,
  `tb_tag_id` INT(10) UNSIGNED NOT NULL,
  `tb_date` DATE NOT NULL,
  `tb_page_name` VARBINARY(255) DEFAULT NULL,
  `tb_page_url` VARBINARY(255) DEFAULT NULL,
  `tb_wikiname` VARBINARY(255) DEFAULT NULL,
  `tb_wikiurl` VARBINARY(255) DEFAULT NULL,
  `tb_count` INT(10) UNSIGNED NOT NULL,
  `tb_city_lang` VARBINARY(16) DEFAULT NULL,
  PRIMARY KEY (`tb_city_id`,`tb_page_id`,`tb_tag_id`,`tb_date`),
  KEY `tb_tag_id` (`tb_tag_id`,`tb_city_lang`),
  KEY  `page` (tb_city_id, tb_page_id)
) ENGINE=INNODB;


CREATE TABLE `tags_top_users` (
  `tu_user_id` INT(10) UNSIGNED NOT NULL,
  `tu_tag_id` INT(10) UNSIGNED NOT NULL,
  `tu_date` DATE NOT NULL,
  `tu_count` INT(10) UNSIGNED NOT NULL,
  `tu_city_lang` VARBINARY(16) DEFAULT NULL,
  `tu_username` VARBINARY(255) DEFAULT NULL,
  `tu_groups` VARBINARY(255) DEFAULT NULL,
  PRIMARY KEY (`tu_user_id`,`tu_tag_id`,`tu_date`),
  KEY `tu_tag_id` (`tu_tag_id`,`tu_city_lang`),
  KEY `tu_date` (`tu_date`),
  KEY `tu_user_id` (tu_user_id)
) ENGINE=INNODB;



CREATE TABLE `tags_stats_filter` (
  `sf_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `sf_city_id` int(10) unsigned DEFAULT NULL,
  `sf_page_id` int(10) unsigned DEFAULT NULL,
  `sf_user_id` int(10) unsigned DEFAULT NULL,
  `sf_tag_id` int(10) unsigned NOT NULL,
  `sf_type` enum('blog','user','article','city') DEFAULT NULL,
  PRIMARY KEY (`sf_id`),
  UNIQUE KEY `sf_city_id` (`sf_city_id`,`sf_page_id`,`sf_user_id`,`sf_tag_id`,`sf_type`)
) ENGINE=InnoDB;
