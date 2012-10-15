CREATE TABLE IF NOT EXISTS `phalanx` (
-- unique ID of blocker
  `p_id` int(6) unsigned NOT NULL auto_increment,
-- last author of block (editing the block will change the author)
  `p_author_id` int(6) NOT NULL,
-- block content (plain text or regex)
  `p_text` blob NOT NULL,
-- block type (mask of 16 bits determining which module will use that block)
  `p_type` smallint(1) unsigned NOT NULL,
-- date of creation or last edit of this block
  `p_timestamp` binary(14) NOT NULL default '',
-- expiration date (null for infinity block)
  `p_expire` binary(14),
-- 0 - filter is loose, can be anywhere in tested string; 1 - filter is exact - start and end match start and end of tested string
  `p_exact` tinyint(1) NOT NULL default '0',
-- block type (0 - plain text; 1 - regex)
  `p_regex` tinyint(1) NOT NULL default '0',
-- case sensitiveness (0 - case insensitive; 1 - case sensitive)
  `p_case` tinyint(1) NOT NULL default '0',
-- reason of block - filled by creator
  `p_reason` tinyblob NOT NULL,
-- language to which the block applies - just for Answers for legacy reasons
  `p_lang` varchar(10),
  PRIMARY KEY (`p_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `phalanx_stats` (
-- foreign key to phalanx.p_id
  `ps_blocker_id` int(6) unsigned NOT NULL,
-- type of match
  `ps_blocker_type` smallint(1) unsigned NOT NULL,
-- date of match of block
  `ps_timestamp` binary(14) NOT NULL default '',
-- blocked user (can be IP for anons)
  `ps_blocked_user` varchar(255) binary NOT NULL default '',
-- wiki_id where block matched
  `ps_wiki_id` int(9) NOT NULL,
  KEY `ps_blocker_id_idx` (`ps_blocker_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
