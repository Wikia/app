-- Remove unnecessary primary key columns

ALTER TABLE /*$wgDBprefix*/collabwatchlistcategory
  DROP COLUMN rlc_id;
ALTER TABLE /*$wgDBprefix*/collabwatchlistrevisiontag
  DROP COLUMN rrt_id;
ALTER TABLE /*$wgDBprefix*/collabwatchlisttag
  DROP COLUMN rt_id;
