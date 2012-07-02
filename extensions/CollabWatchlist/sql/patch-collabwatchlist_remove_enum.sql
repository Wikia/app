-- Remove enums

ALTER TABLE /*$wgDBprefix*/collabwatchlistuser
  ADD COLUMN rlu_type_new integer NOT NULL DEFAULT 1;
UPDATE /*$wgDBprefix*/collabwatchlistuser
  SET rlu_type_new = 1 WHERE rlu_type = 'OWNER' OR rlu_type = 1;
UPDATE /*$wgDBprefix*/collabwatchlistuser
  SET rlu_type_new = 2 WHERE rlu_type = 'USER' OR rlu_type = 2;
UPDATE /*$wgDBprefix*/collabwatchlistuser
  SET rlu_type_new = 3 WHERE rlu_type = 'TRUSTED_EDITOR' OR rlu_type = 3;
ALTER TABLE /*$wgDBprefix*/collabwatchlistuser
  DROP COLUMN rlu_type;
ALTER TABLE /*$wgDBprefix*/collabwatchlistuser
  CHANGE rlu_type_new rlu_type integer NOT NULL DEFAULT 1;

