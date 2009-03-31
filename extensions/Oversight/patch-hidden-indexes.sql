ALTER TABLE /*$wgDBprefix*/hidden
  ADD INDEX (hidden_user_text,hidden_timestamp);
