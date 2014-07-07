ALTER TABLE /*_*/flaggedrevs 
  ADD COLUMN fr_rev_timestamp varbinary(14) NOT NULL default '',
  DROP COLUMN fr_text,
  DROP COLUMN fr_comment,
-- Old (fr_page_id,fr_rev_id) key
  DROP PRIMARY KEY;

-- Take the first row of any duplicates on new key
ALTER IGNORE TABLE /*_*/flaggedrevs ADD PRIMARY KEY (fr_rev_id);

CREATE INDEX /*i*/page_rev ON /*_*/flaggedrevs (fr_page_id,fr_rev_id);
CREATE INDEX /*i*/page_time ON /*_*/flaggedrevs (fr_page_id,fr_rev_timestamp);
CREATE INDEX /*i*/page_qal_time ON /*_*/flaggedrevs (fr_page_id,fr_quality,fr_rev_timestamp);
