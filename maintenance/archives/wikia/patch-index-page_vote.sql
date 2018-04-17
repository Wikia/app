ALTER TABLE `page_vote`
  DROP INDEX user_id,
  DROP INDEX article_id,
  DROP INDEX unique_vote,
  ADD UNIQUE INDEX article_user_idx (article_id, user_id);
