-- Message textdata
CREATE TABLE IF NOT EXISTS `messages_text`
(
	`msg_id`              int (7)  unsigned   NOT NULL    auto_increment,
	`msg_sender_id`       int (10) unsigned   NOT NULL,
	`msg_text`            mediumtext          NOT NULL,
	`msg_mode`            tinyint             NOT NULL    default 0,
	`msg_removed`         tinyint             NOT NULL    default 0,
	`msg_expire`          datetime,
	`msg_date`            timestamp           NOT NULL    default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
	`msg_recipient_user_id` int(5) unsigned DEFAULT NULL,
	`msg_group_name`      varchar (255), -- only for displaying in the history
	`msg_wiki_name`       varchar (255), -- only for displaying in the history
	`msg_hub_id`          int (9),
	`msg_cluster_id`      int (9),
	`msg_lang`            varchar (255),
	PRIMARY KEY (`msg_id`)
);
CREATE index removed_mode_expire_date ON messages_text (msg_removed,msg_mode,msg_expire,msg_date);
-- msg_mode: 0 = all users, 1 = selected users

-- Messages metadata
CREATE TABLE IF NOT EXISTS `messages_status`
(
	`msg_wiki_id`      int (9)  unsigned   NOT NULL    default 0,
	`msg_recipient_id` int (10) unsigned   NOT NULL    default 0,
	`msg_id`           int (7)  unsigned   NOT NULL,
	`msg_status`       tinyint             NOT NULL,
	`msg_date`         timestamp           NOT NULL    default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
	PRIMARY KEY (`msg_wiki_id`, `msg_recipient_id`, `msg_id`),
	KEY `msg_id` (`msg_id`),
	KEY `msg_wiki_id_idx` (`msg_wiki_id`)
);
CREATE INDEX msg_recipient_msg_id ON messages_status (msg_recipient_id, msg_id);
-- msg_status: 0 = unseen, 1 = seen, 2 = dismissed
