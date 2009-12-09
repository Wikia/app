CREATE TABLE `category_user_edits` (
  `cue_cat_id` int(10) unsigned NOT NULL,
  `cue_user_id` int(10) unsigned NOT NULL,
  `cue_count` int(10) unsigned NOT NULL,
  PRIMARY KEY  (`cue_cat_id`,`cue_user_id`),
  KEY `cue_user_id` (`cue_user_id`,`cue_count`),
  KEY `cue_user_count` (`cue_cat_id`,`cue_count`),
  KEY `cat_user` (`cue_cat_id`,`cue_user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE `category_edits` (
  `ce_cat_id` int(10) unsigned NOT NULL,
  `ce_page_id` int(8) unsigned NOT NULL,
  `ce_page_ns` int(6) unsigned NOT NULL,
  `ce_user_id` int(10) unsigned NOT NULL,
  `ce_date` date NOT NULL,
  `ce_count` int(10) unsigned NOT NULL,
  PRIMARY KEY  (`ce_cat_id`,`ce_page_id`,`ce_page_ns`,`ce_user_id`,`ce_date`),
  KEY `cat_date` (`ce_cat_id`,`ce_date`),
  KEY `cat_user_date` (`ce_cat_id`,`ce_date`,`ce_user_id`),
  KEY `cat_page_date` (`ce_cat_id`,`ce_page_id`,`ce_count`,`ce_date`),
  KEY `cat_user` (`ce_cat_id`,`ce_user_id`),
  KEY `user_pages` (`ce_page_id`,`ce_user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
