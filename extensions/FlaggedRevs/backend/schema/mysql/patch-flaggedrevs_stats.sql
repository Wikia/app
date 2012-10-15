-- Various statistics about the reviewed namespaces
CREATE TABLE /*_*/flaggedrevs_stats (
	namespace int unsigned NOT NULL DEFAULT 0 PRIMARY KEY,
	total     int unsigned NOT NULL DEFAULT 0,
	reviewed  int unsigned NOT NULL DEFAULT 0,
	synced    int unsigned NOT NULL DEFAULT 0
) /*$wgDBTableOptions*/;

CREATE TABLE /*_*/flaggedrevs_stats2 (
	stat_id          int unsigned NOT NULL DEFAULT 1 PRIMARY KEY,
	ave_review_time  int unsigned NOT NULL DEFAULT 0,
	med_review_time  int unsigned NOT NULL DEFAULT 0,
	ave_pending_time int unsigned NOT NULL DEFAULT 0
) /*$wgDBTableOptions*/;
