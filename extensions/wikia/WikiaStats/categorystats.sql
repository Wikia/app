CREATE TABLE `category_edits` (
  `ce_cat_id` int(10) unsigned NOT NULL,
  `ce_page_id` int(8) unsigned NOT NULL,
  `ce_page_ns` int(6) unsigned NOT NULL,
  `ce_user_id` int(10) unsigned NOT NULL,
  `ce_date` DATE NOT NULL,
  `ce_count` int(10) unsigned NOT NULL,
  PRIMARY KEY (`ce_cat_id`,`ce_page_id`,`ce_page_ns`,`ce_user_id`,`ce_date`),
  KEY `cat_date` (`ce_cat_id`, `ce_date`),
  KEY `cat_user_date` (`ce_cat_id`, `ce_date`, `ce_user_id`),
  KEY `cat_page_date` (`ce_cat_id`,`ce_page_id`,`ce_count`,`ce_date`),
  KEY `cat_user` (`ce_cat_id`,`ce_user_id`),
  KEY `user_pages` (`ce_page_id`,`ce_user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `category_user_edits` (
  `cue_cat_id` int(10) unsigned NOT NULL,
  `cue_user_id` int(10) unsigned NOT NULL,
  `cue_count` int(10) unsigned NOT NULL,
  PRIMARY KEY (`cue_cat_id`,`cue_user_id`),
  KEY (`cue_user_id`, `cue_count`),
  KEY `cat_user` (`cue_cat_id`,`cue_user_id`),
  KEY (`cue_cat_id`,`cue_count`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*
DROP FUNCTION IF EXISTS category_edits_inc;
CREATE FUNCTION category_edits_inc( __pageid__ INTEGER, __page_ns__ SMALLINT, __userid__ INTEGER, __inc__ INTEGER ) RETURNS INTEGER
BEGIN
	DECLARE __done__ INT DEFAULT 0;
	DECLARE __catid__ INT DEFAULT 0;
	DECLARE __date__ DATE DEFAULT CAST(now() AS DATE);
	DECLARE __rows__ INT DEFAULT 0;

	DECLARE CUR_CATEGORY CURSOR FOR 
		SELECT cat_id FROM categorylinks, category 
		WHERE cl_to = cat_title and cl_from = __pageid__;
	DECLARE CONTINUE HANDLER FOR NOT FOUND SET __done__ = 1;

	OPEN CUR_CATEGORY;
		REPEAT
    		FETCH CUR_CATEGORY INTO __catid__;
			IF NOT __done__ THEN
				SET __rows__ = __rows__ + 1;
				INSERT INTO category_edits 
					(ce_cat_id, ce_page_id, ce_page_ns, ce_user_id, ce_date, ce_count) 
				VALUES 
					(__catid__, __pageid__, __page_ns__, __userid__, __date__, __inc__)
				ON DUPLICATE KEY 
					UPDATE ce_count = ce_count + __inc__;
			END IF;
		UNTIL __done__ END REPEAT;
	CLOSE CUR_CATEGORY;
	
	RETURN __rows__;
END;

DROP FUNCTION IF EXISTS category_edits_rev_inc;
CREATE FUNCTION category_edits_rev_inc( __pageid__ INTEGER, __page_ns__ SMALLINT ) RETURNS INTEGER
BEGIN
	DECLARE __done__ INT DEFAULT 0;
	DECLARE __userid__ INT DEFAULT 0;
	DECLARE __rows__ INT DEFAULT 0;
	DECLARE __rowsinc__ INT DEFAULT 0;

	DECLARE CUR_REVISION CURSOR FOR 
		SELECT rev_user FROM revision where rev_page = __pageid__ and rev_deleted = 0 and rev_user > 0;
	DECLARE CONTINUE HANDLER FOR NOT FOUND SET __done__ = 1;

	OPEN CUR_REVISION;
		REPEAT
    		FETCH CUR_REVISION INTO __userid__;
			IF NOT __done__ THEN
				SELECT category_edits_inc( __pageid__, __page_ns__, __userid__, 1 ) INTO __rowsinc__;
				SET __rows__ = __rows__ + __rowsinc__;
			END IF;
		UNTIL __done__ END REPEAT;
	CLOSE CUR_REVISION;
	
	RETURN __rows__;
END;

*/
