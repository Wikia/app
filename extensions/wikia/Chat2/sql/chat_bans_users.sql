CREATE TABLE `chat_ban_users` ( 
  `cbu_wiki_id` int(10) NOT NULL DEFAULT 0,
  `cbu_user_id`  int(10) NOT NULL DEFAULT 0, 
  `cbu_admin_user_id`  int(10) NOT NULL DEFAULT 0, 
  `start_date` varchar(14),
  `end_date` varchar(14),
  `reason` varchar(255),
  UNIQUE KEY `cbu_user_id` (`cbu_wiki_id`,`cbu_user_id`),
  KEY `wiki_start_date` (`cbu_wiki_id`,`start_date`)
) ENGINE=INNODB DEFAULT CHARSET=BINARY;
