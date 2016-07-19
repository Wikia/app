CREATE TABLE `chat_ban_users` (
  `cbu_wiki_id` int(10) NOT NULL DEFAULT '0',
  `cbu_user_id` int(10) NOT NULL DEFAULT '0',
  `cbu_admin_user_id` int(10) NOT NULL DEFAULT '0',
  `reason` varbinary(255) DEFAULT NULL,
  `start_date` varbinary(14) DEFAULT NULL,
  `end_date` varbinary(14) DEFAULT NULL,
  UNIQUE KEY `cbu_user_id` (`cbu_wiki_id`,`cbu_user_id`),
  KEY `wiki_start_date` (`cbu_wiki_id`,`start_date`)
) ENGINE=InnoDB DEFAULT CHARSET=binary;