CREATE TABLE IF NOT EXISTS /*_*/article_feedback_stats_types (
	afst_id integer unsigned NOT NULL PRIMARY KEY AUTO_INCREMENT,
	afst_type varbinary(255) NOT NULL
) /*$wgDBTableOptions*/;
CREATE UNIQUE INDEX /*i*/afst_type ON /*_*/article_feedback_stats_types( afst_type );

-- Pre-populate table with stat types
INSERT INTO /*_*/article_feedback_stats_types ( afst_type ) VALUES ( 'highs_and_lows' );
INSERT INTO /*_*/article_feedback_stats_types ( afst_type ) VALUES ( 'problems' );