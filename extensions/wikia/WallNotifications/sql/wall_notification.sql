# Table that stores user notifications

CREATE TABLE `wall_notification` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,     # user identifier
  `wiki_id` int(11) NOT NULL,     # wiki/city id
  `is_read` int(11) NOT NULL,     # set to one once user read the message
  `is_reply` int(11) NOT NULL,    # set to 1 for replies in threads
  `author_id` int(11) NOT NULL,   # user id of the author
  `unique_id` int(11) NOT NULL,   # article identifier, not that for replies this is an id of the main article
  `entity_key` char(30) NOT NULL, # it's a <wiki_id>_<revision_id>, note that current implementation does an explode on it to use a part of this field
  `is_hidden` int(11) NOT NULL DEFAULT '0', # set to 1 when the notification shouldn't be displayed (like the thread was removed, but it can be restored)
  `notifyeveryone` int(1) NOT NULL DEFAULT '0', # set to 1 for highlighted forum threads
  PRIMARY KEY (`id`),
  KEY `unique_id` (`unique_id`),
  KEY `user` (`user_id`,`wiki_id`),
  KEY `user_wiki_unique` (`user_id`,`wiki_id`,`unique_id`)
) ENGINE=InnoDB;
