CREATE TABLE `image_review_stats` (
  `reviewer_id` int(11) NOT NULL,
  `wiki_id` int(11) NOT NULL,
  `page_id` int(11) NOT NULL,
  `review_state` int(11) NOT NULL DEFAULT '0',
  `review_end` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  KEY `reviewer_idx` (`reviewer_id`),
  KEY `state_idx` (`reviewer_id`,`review_state`),
  KEY `image_idx` (`wiki_id`,`page_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
