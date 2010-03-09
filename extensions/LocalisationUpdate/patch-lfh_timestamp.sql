-- Patch that adds lfh_timestamp field and index

ALTER TABLE /*_*/localisation_file_hash ADD lfh_timestamp varchar(14) NOT NULL;
CREATE INDEX /*i*/lfh_timestamp ON /*_*/localisation_file_hash (lfh_timestamp);
