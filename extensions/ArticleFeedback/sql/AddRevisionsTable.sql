-- Aggregate rating table for a revision
CREATE TABLE IF NOT EXISTS /*_*/article_feedback_revisions (
  -- Foreign key to page.page_id
  afr_page_id integer unsigned NOT NULL,
  -- Revision that totals are relevant to
  afr_revision integer unsigned NOT NULL,
  -- Rating ID, mapped to a name in $wgArticleFeedbackRatingTypes
  afr_rating_id integer unsigned NOT NULL,
  -- Sum (total) of all the ratings for this article revision
  afr_total integer unsigned NOT NULL,
  -- Number of ratings
  afr_count integer unsigned NOT NULL,
  -- One rating row per page
  PRIMARY KEY (afr_page_id, afr_rating_id, afr_revision)
) /*$wgDBTableOptions*/;
