-- 
-- SQL for WhiteList extension
-- 
-- Table for storing working changes to pages that
-- users have yet to commit.
CREATE TABLE /*$wgDBPrefix*/whitelist (
  `wl_id` int(8) NOT NULL AUTO_INCREMENT,
  `wl_user_id` int(5) NOT NULL,
  `wl_page_title` varchar(255) NOT NULL,
  `wl_allow_edit` int(1) NOT NULL,
  `wl_expires_on` varchar(19) DEFAULT NULL,
  `wl_updated_by_user_id` int(5) NOT NULL,
  `wl_updated_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY  (`wl_id`)
) /*$wgDBTableOptions*/;
