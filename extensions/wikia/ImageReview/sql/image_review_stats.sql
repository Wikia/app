CREATE TABLE `image_review` (
  `reviewer_id` int(11) NOT NULL,
  `wiki_id` int(11) NOT NULL,
  `page_id` int(11) NOT NULL,
  `review_state` int(11) NOT NULL DEFAULT '0',
  `review_end` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  KEY (`reviewer_id`),
  KEY `stats_idx` (`reviewer_id`,`state`),
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
