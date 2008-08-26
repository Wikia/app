/* required table */

CREATE TABLE IF NOT EXISTS `imagetags` (
  `unique_id` int(10) unsigned NOT NULL auto_increment,
  `img_page_id` int(10) unsigned NOT NULL,
  `img_name` varchar(255) character set utf8 collate utf8_unicode_ci NOT NULL,
  `article_tag` varchar(255) character set utf8 collate utf8_unicode_ci NOT NULL,
  `tag_rect` varchar(30) character set ascii collate ascii_bin NOT NULL,
  `user_text` varchar(255) character set utf8 collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`unique_id`)
) ENGINE=InnoDB;
