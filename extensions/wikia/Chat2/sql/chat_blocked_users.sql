CREATE TABLE `chat_blocked_users` ( 
  `cbu_user_id`  int(11) NOT NULL DEFAULT 0,
  `cbu_blocked_user_id` int(11) NOT NULL DEFAULT 0, 
  UNIQUE KEY `cbu_user_id` (`cbu_user_id`,`cbu_blocked_user_id`)
) ENGINE=INNODB DEFAULT CHARSET=BINARY;
