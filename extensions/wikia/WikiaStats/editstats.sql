/*
* dataware
*/
CREATE TABLE `page_edits` (
  `pe_wikia_id` int(10) unsigned NOT NULL,
  `pe_page_id` int(10) unsigned NOT NULL,
  `pe_page_ns` int(6) unsigned NOT NULL,
  `pe_is_content` int(1) unsigned NOT NULL,
  `pe_date` DATE NOT NULL,
  `pe_anon_count` int(10) unsigned NOT NULL,
  `pe_all_count` int(10) unsigned NOT NULL,
  PRIMARY KEY (`pe_wikia_id`,`pe_page_id`,`pe_page_ns`,`pe_date`),
  KEY `pe_count_date` (`pe_is_content`,`pe_wikia_id`,`pe_page_id`,`pe_all_count`,`pe_anon_count`),
  KEY `pe_count` (`pe_wikia_id`,`pe_page_id`,`pe_all_count`,`pe_anon_count`),
  KEY `pe_date` (`pe_date`,`pe_all_count`,`pe_anon_count`),
  KEY `pe_wikia_date` (`pe_wikia_id`,`pe_date`,`pe_all_count`),
  KEY `pe_wikia_anon_date` (`pe_wikia_id`,`pe_date`,`pe_anon_count`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
