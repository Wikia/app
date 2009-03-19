-- SQL schema for the WikiaNewtalk extension
-- this table should go into your $wgSharedDB

CREATE TABLE IF NOT EXISTS `shared_newtalks` (
  `sn_user_id` int(5) unsigned default NULL,
  `sn_user_ip` varchar(255) default '',
  `sn_wiki` varchar(31) default NULL,
  `sn_date` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  KEY `sn_user_id_sn_user_ip_sn_wiki_idx` (`sn_user_id`,`sn_user_ip`,`sn_wiki`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
