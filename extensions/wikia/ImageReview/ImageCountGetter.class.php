<?php

class ImageCountGetter extends WikiaModel {

	const STATES_TO_COUNT = [
		ImageReviewStatuses::STATE_QUESTIONABLE,
		ImageReviewStatuses::STATE_REJECTED,
		ImageReviewStatuses::STATE_UNREVIEWED,
		ImageReviewStatuses::STATE_INVALID_IMAGE,
	];

	public function getImageCounts() {
		$db = $this->getDatawareDB();

		$where = [];
		$where[] = 'state in (' . $db->makeList( self::STATES_TO_COUNT ) . ')';
		$where[] = 'top_200=0';

		// select by reviewer, state and total count with rollup and then pick the data we want out
		$results = $db->select(
			[ 'image_review' ],
			[ 'state', 'count(*) as total' ],
			$where,
			__METHOD__,
			[ 'GROUP BY' => 'state' ]
		);

		$counts = [];
		while ($row = $db->fetchObject($results)) {
			$counts[$row->state] = $row->total;
		}

		return [
			ImageReviewStatsCache::STATS_UNREVIEWED => $counts[ ImageReviewStatuses::STATE_UNREVIEWED ] ?? 0,
			ImageReviewStatsCache::STATS_QUESTIONABLE => $counts[ ImageReviewStatuses::STATE_QUESTIONABLE ] ?? 0,
			ImageReviewStatsCache::STATS_REJECTED => $counts[ ImageReviewStatuses::STATE_REJECTED ] ?? 0,
			ImageReviewStatsCache::STATS_INVALID => $counts[ ImageReviewStatuses::STATE_INVALID_IMAGE ] ?? 0
		];
	}
}
