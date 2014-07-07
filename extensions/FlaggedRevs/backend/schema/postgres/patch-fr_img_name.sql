BEGIN;

ALTER TABLE flaggedrevs 
  -- Name of included image
  ADD fr_img_name TEXT NULL default NULL,
  -- Timestamp of file (when uploaded)
  ADD fr_img_timestamp TIMESTAMPTZ NULL default NULL,
  -- Statistically unique SHA-1 key
  ADD fr_img_sha1 TEXT NULL default NULL;
  
CREATE INDEX fr_img_sha1 ON flaggedrevs (fr_img_sha1);

DROP INDEX fr_namespace_title;
CREATE INDEX page_qal_rev ON flaggedrevs (fr_page_id,fr_quality,fr_rev_id);

COMMIT;
