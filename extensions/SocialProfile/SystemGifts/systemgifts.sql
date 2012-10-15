CREATE TABLE /*_*/user_system_gift (
  `sg_id` int(11) NOT NULL PRIMARY KEY auto_increment,
  `sg_gift_id` int(5) unsigned NOT NULL default '0',
  `sg_user_id` int(11) unsigned NOT NULL default '0',
  `sg_user_name` varchar(255) NOT NULL default '',
  `sg_status` int(2) default '1',
  `sg_date` datetime default NULL
) /*$wgDBTableOptions*/;
CREATE INDEX /*i*/sg_user_id    ON /*_*/user_system_gift (`sg_user_id`);
CREATE INDEX /*i*/sg_gift_id    ON /*_*/user_system_gift (`sg_gift_id`);

CREATE TABLE /*_*/system_gift (
  `gift_id` int(11) NOT NULL PRIMARY KEY auto_increment,
  `gift_name` varchar(255) NOT NULL default '',
  `gift_description` text,
  `gift_given_count` int(11) default '0',
  `gift_category` int(11) default '0',
  `gift_threshold` int(15) default '0',
  `gift_createdate` datetime default NULL
) /*$wgDBTableOptions*/;
CREATE INDEX /*i*/giftcategoryidx  ON /*_*/system_gift (`gift_category`);
CREATE INDEX /*i*/giftthresholdidx ON /*_*/system_gift (`gift_threshold`);
