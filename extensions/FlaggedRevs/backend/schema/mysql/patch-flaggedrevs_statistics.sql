-- old format --
DROP TABLE IF EXISTS /*_*/flaggedrevs_stats;
DROP TABLE IF EXISTS /*_*/flaggedrevs_stats2;

-- This stores overall stats
CREATE TABLE /*_*/flaggedrevs_statistics (
    -- Timestamp stat was recorded
	frs_timestamp varbinary(14) NOT NULL,
    -- Stat key name, colons separate paramaters
    frs_stat_key varchar(255) NOT NULL,
    -- Stat value as an integer
    frs_stat_val bigint NOT NULL,
    PRIMARY KEY(frs_stat_key,frs_timestamp)
) /*$wgDBTableOptions*/;
CREATE INDEX /*i*/frs_timestamp ON /*_*/flaggedrevs_statistics (frs_timestamp);
