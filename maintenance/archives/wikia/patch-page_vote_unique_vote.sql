-- Unique key in page_vote

ALTER TABLE /*$wgDBprefix*/page_vote
  ADD KEY `unique_vote` (`unique_id`, `article_id`);
