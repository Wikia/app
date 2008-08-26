-- Add file metadata for flaggedrevs of image pages
ALTER TABLE /*$wgDBprefix*/flaggedrevs 
  -- Name of included image
  ADD fr_img_name varchar(255) binary NULL default NULL,
  -- Timestamp of file (when uploaded)
  ADD fr_img_timestamp char(14) NULL default NULL,
  -- Statistically unique SHA-1 key
  ADD fr_img_sha1 varbinary(32) NULL default NULL,
  ADD INDEX fr_img_sha1 (fr_img_sha1);
