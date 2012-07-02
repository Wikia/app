CREATE TABLE IF NOT EXISTS /*$wgDBprefix*/el_archive_blacklist (
  `bl_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `bl_type` tinyint(4) NOT NULL,
  `bl_url` varchar(10000) NOT NULL,
  `bl_expiry` int(11) unsigned NOT NULL,
  `bl_reason` varchar(255) NOT NULL,
  PRIMARY KEY (`bl_id`)
) /*$wgDBTableOptions*/;

CREATE TABLE IF NOT EXISTS /*$wgDBprefix*/el_archive_log (
  `log_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `log_result` tinyint(4) NOT NULL,
  `log_url` varchar(10000) NOT NULL,
  `log_time` int(11) unsigned NOT NULL,
  `log_http_code` varchar(255) NOT NULL,
  PRIMARY KEY (`log_id`)
) /*$wgDBTableOptions*/;

CREATE TABLE IF NOT EXISTS /*$wgDBprefix*/el_archive_queue (
  `queue_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `page_id` int(11) unsigned NOT NULL,
  `url` varchar(10000) NOT NULL,
  `delay_time` int(11) unsigned NOT NULL,
  `insertion_time` int(11) unsigned NOT NULL,
  `in_progress` varchar(50) NOT NULL,
  PRIMARY KEY (`queue_id`)
) /*$wgDBTableOptions*/;

CREATE TABLE IF NOT EXISTS /*$wgDBprefix*/el_archive_link_history (
  `hist_id` int(11) unsigned NOT NULL,
  `hist_page_id` int(11) unsigned NOT NULL,
  `hist_url` varchar(10000) NOT NULL,
  `hist_insertion_time` int(11) unsigned NOT NULL,
  PRIMARY KEY (`hist_id`)
) /*$wgDBTableOptions*/;

CREATE TABLE IF NOT EXISTS /*$wgDBprefix*/el_archive_resource (
  `resource_id` int(11) NOT NULL,
  `el_id` int(11) NOT NULL,
  `resource_url` varchar(10000) NOT NULL,
  `resource_location` varchar(10000) NOT NULL,
  PRIMARY KEY (`resource_id`)
) /*$wgDBTableOptions*/;
