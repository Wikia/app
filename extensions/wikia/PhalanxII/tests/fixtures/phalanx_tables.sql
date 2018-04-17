CREATE TABLE `phalanx` (
  `p_id` int(6)  NOT NULL,
  `p_author_id` int(6) NOT NULL,
  `p_text` blob NOT NULL,
  `p_ip_hex` varchar(35) DEFAULT NULL,
  `p_type` smallint(1)  NOT NULL,
  `p_timestamp` binary(14) NOT NULL DEFAULT '\0\0\0\0\0\0\0\0\0\0\0\0\0\0',
  `p_expire` binary(14) DEFAULT NULL,
  `p_exact` tinyint(1) NOT NULL DEFAULT '0',
  `p_regex` tinyint(1) NOT NULL DEFAULT '0',
  `p_case` tinyint(1) NOT NULL DEFAULT '0',
  `p_reason` tinyblob NOT NULL,
  `p_lang` varchar(10) DEFAULT NULL,
  `p_comment` tinyblob NOT NULL,
  PRIMARY KEY (`p_id`)
);

CREATE INDEX `p_ip_hex` ON `phalanx` (`p_ip_hex`);
CREATE INDEX `p_lang` ON `phalanx` (`p_lang`,`p_type`);

CREATE TABLE `phalanx_stats` (
  `ps_id` int(11) NOT NULL,
  `ps_blocker_id` int(8)  NOT NULL,
  `ps_blocker_type` smallint(1)  NOT NULL,
  `ps_timestamp` binary(14) NOT NULL DEFAULT '\0\0\0\0\0\0\0\0\0\0\0\0\0\0',
  `ps_blocked_user_id` int(11) DEFAULT NULL,
  `ps_blocked_user` varchar(255) NOT NULL DEFAULT '',
  `ps_wiki_id` int(9) NOT NULL,
  `ps_blocker_hit` smallint(1)  NOT NULL,
  `ps_referrer` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`ps_id`)
);

CREATE INDEX `wiki_id` ON `phalanx_stats` (`ps_wiki_id`,`ps_timestamp`);
CREATE INDEX `blocker_id` ON `phalanx_stats` (`ps_blocker_id`,`ps_timestamp`);
