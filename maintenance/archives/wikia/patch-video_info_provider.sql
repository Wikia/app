ALTER TABLE /*$wgDBprefix*/video_info
  ADD `provider` varchar(255) DEFAULT NULL AFTER video_id;
