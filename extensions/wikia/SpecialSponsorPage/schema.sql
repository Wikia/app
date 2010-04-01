CREATE TABLE IF NOT EXISTS `advert_ads` (
  `ad_id` int(10) unsigned NOT NULL auto_increment,
  `wiki_db` varchar(255) NOT NULL,
  `page_id` int(10) unsigned NOT NULL,
  `page_original_url` text NOT NULL COMMENT 'the url when the page was sponsored',
  `ad_link_url` text NOT NULL,
  `ad_link_text` varchar(255) NOT NULL,
  `ad_text` text NOT NULL,
  `ad_price` decimal(10,2) NOT NULL,
  `ad_months` int(11) NOT NULL COMMENT 'duration ad runs for',
  `user_email` tinyblob NOT NULL,
  `ad_status` int(11) NOT NULL COMMENT 'moderation status',
  `last_pay_date` date NOT NULL COMMENT 'last completed paypal payment',
  PRIMARY KEY  (`ad_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;

CREATE TABLE IF NOT EXISTS `advert_pmts` (
  `pay_id` int(10) unsigned NOT NULL auto_increment,
  `ad_id` int(10) unsigned NOT NULL,
  `payer_email` varchar(255) NOT NULL,
  `pay_date` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `pay_amt` int(11) NOT NULL,
  `pay_type` varchar(50) NOT NULL COMMENT 'paypal payment type',
  `pay_status` varchar(50) NOT NULL,
  `pay_conf_msg` mediumtext NOT NULL,
  PRIMARY KEY  (`pay_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1; 
