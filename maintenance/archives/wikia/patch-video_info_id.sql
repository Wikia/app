ALTER TABLE /*$wgDBprefix*/video_info
  ADD `video_id` varchar(255) NOT NULL DEFAULT '' AFTER video_title;
