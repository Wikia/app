-- Add timestamp column of first unreviewed rev for flaggedrevs
ALTER TABLE /*$wgDBprefix*/flaggedpages 
  ADD fp_pending_since varbinary(14) NULL,
  ADD INDEX fp_pending_since (fp_pending_since);
