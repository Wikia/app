<?php

class ImageCountGetter extends WikiaModel {

	const QUESTIONABLE = 'questionable';
	const REJECTED     = 'rejected';
	const UNREVIEWED   = 'unreviewed';
	const INVALID      = 'invalid';

	const STATES_TO_COUNT = [
		ImageReviewStates::QUESTIONABLE,
		ImageReviewStates::REJECTED,
		ImageReviewStates::UNREVIEWED,
		ImageReviewStates::INVALID_IMAGE,
	];

	/**
	 * Fix this so it returns a count of all available images to see AND all
	 * images already assigned to this user, but that they haven't taken an
	 * action on
	 * @return array
	 * @throws DBUnexpectedError
	 * @throws MWException
	 */
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
			self::QUESTIONABLE => $counts[ ImageReviewStates::QUESTIONABLE ] ?? 0,
			self::REJECTED => $counts[ ImageReviewStates::REJECTED ] ?? 0,
			self::UNREVIEWED => $counts[ ImageReviewStates::UNREVIEWED ] ?? 0,
			self::INVALID => $counts[ ImageReviewStates::INVALID_IMAGE ] ?? 0
		];
	}
}
