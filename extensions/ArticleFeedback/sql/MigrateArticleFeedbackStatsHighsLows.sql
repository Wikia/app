-- migrate data from article_feedback_stats_highs_lows into article_feedback_stats
INSERT INTO /*_*/article_feedback_stats (
	afs_page_id,
	afs_orderable_data,
	afs_data,
	afs_ts,
	afs_stats_type_id
) 
SELECT 
	afshl_page_id,
	afshl_avg_overall,
	afshl_avg_ratings,
	afshl_ts,
	afst_id
FROM 
	/*_*/article_feedback_stats_highs_lows,
	/*_*/article_feedback_stats_types
WHERE 
	/*_*/article_feedback_stats_types.afst_type='highs_and_lows';

-- get rid of article_feedback_stats_highs_lows as it is no longer necessary
DROP TABLE /*_*/article_feedback_stats_highs_lows;
