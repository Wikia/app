-- Table to hold temporary "assignments" of recent changes
-- when using the Patroller extension.
CREATE TABLE /*$wgDBprefix*/patrollers (
  ptr_change int(8) NOT NULL,
  ptr_timestamp varchar(14) NOT NULL,
  UNIQUE KEY ptr_change (ptr_change),
  KEY ptr_timestamp (ptr_timestamp)
) TYPE=MEMORY;