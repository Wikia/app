-- Remove the ct_id column which was introduced in a previous revision

ALTER TABLE /*$wgDBprefix*/collabwatchlistrevisiontag
  ADD ct_tag varbinary(255) NOT NULL;
ALTER TABLE /*$wgDBprefix*/collabwatchlistrevisiontag
  ADD ct_rc_id int NOT NULL default 0;
UPDATE /*$wgDBprefix*/collabwatchlistrevisiontag cwlrt set ct_rc_id = (select ct.ct_rc_id from change_tag ct where ct.ct_id = cwlrt.ct_id), ct_tag = (select ct.ct_tag from change_tag ct where ct.ct_id = cwlrt.ct_id);
ALTER TABLE /*$wgDBprefix*/change_tag
  DROP ct_id;
