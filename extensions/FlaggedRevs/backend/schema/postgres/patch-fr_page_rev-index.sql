-- Add file metadata for flaggedrevs of image pages
ALTER TABLE flaggedrevs
  ADD COLUMN fr_rev_timestamp TIMESTAMPTZ NOT NULL,
  DROP COLUMN fr_text;
  DROP COLUMN fr_comment;
  DROP PRIMARY KEY;
  ADD PRIMARY KEY (fr_rev_id);

CREATE INDEX page_rev ON flaggedrevs (fr_page_id,fr_rev_id);
CREATE INDEX page_time ON flaggedrevs (fr_page_id,fr_rev_timestamp);
CREATE INDEX page_qal_time ON flaggedrevs (fr_page_id,fr_quality,fr_rev_timestamp);
