-- old format --
DROP TABLE IF EXISTS flaggedrevs_stats;
DROP TABLE IF EXISTS flaggedrevs_stats2;

CREATE TABLE flaggedrevs_statistics (
	frs_timestamp TIMESTAMPTZ NOT NULL,
    frs_stat_key TEXT NOT NULL,
    frs_stat_val BIGINT NOT NULL,
    PRIMARY KEY(frs_stat_key,frs_timestamp)
) /*$wgDBTableOptions*/;
CREATE INDEX frs_timestamp ON flaggedrevs_statistics (frs_timestamp);
