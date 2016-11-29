<?php

class ImageCountGetter extends WikiaModel {

	const QUESTIONABLE = 'questionable';
	const REJECTED     = 'rejected';
	const UNREVIEWED   = 'unreviewed';
	const INVALID      = 'invalid';


	/**
	 * Fix this so it returns a count of all available images to see AND all
	 * images already assigned to this user, but that they haven't taken an
	 * action on
	 * @return array
	 * @throws DBUnexpectedError
	 * @throws MWException
	 */
	public function getImageCounts( $reviewerId ) {
		$counts = $this->mergeCounts(
			$this->getUnassignedImageCounts(),
			$this->getUsersInProgressImageCounts( $reviewerId )
		);

		return [
			self::QUESTIONABLE => $counts[ ImageReviewStates::QUESTIONABLE ] ?? 0,
			self::REJECTED => $counts[ ImageReviewStates::REJECTED ] ?? 0,
			self::UNREVIEWED => $counts[ ImageReviewStates::UNREVIEWED ] ?? 0,
			self::INVALID => $counts[ ImageReviewStates::INVALID_IMAGE ] ?? 0
		];
	}

	private function getUnassignedImageCounts() {
		$db = $this->getDatawareDB();
		$counts = ( new WikiaSQL() )
			->SELECT()
			->FIELD( 'state' )
			->COUNT( '*' )->AS_( 'total' )
			->FROM( 'image_review' )
			->WHERE( 'top_200' )->EQUAL_TO( '0' )
			->AND_( 'state' )->IN(
				[
					ImageReviewStates::QUESTIONABLE,
					ImageReviewStates::REJECTED,
					ImageReviewStates::UNREVIEWED,
					ImageReviewStates::INVALID_IMAGE,
				]
			)
			->GROUP_BY( 'state' )
			->runLoop( $db, function( &$counts, $row ) {
				$counts[$row->state] = $row->total;
			} );

		return $counts;
	}

	private function getUsersInProgressImageCounts( $reviewerId ) {
		$db = $this->getDatawareDB();
		$counts = ( new WikiaSQL() )
			->SELECT()
			->FIELD( 'state' )
			->COUNT( '*' )->AS_( 'total' )
			->FROM( 'image_review' )
			->WHERE( 'top_200' )->EQUAL_TO( '0' )
			->AND_( 'state' )->IN(
				[
					ImageReviewStates::QUESTIONABLE_IN_REVIEW,
					ImageReviewStates::REJECTED_IN_REVIEW
				]
			)
			->AND_( 'reviewer_id' )->EQUAL_TO( $reviewerId )
			->GROUP_BY( 'state' )
			->runLoop( $db, function( &$counts, $row ) {
				$counts[$row->state] = $row->total;
			} );

		return $counts;
	}

	private function mergeCounts( array $unassignedImageCounts, array $usersInProgressImageCounts ) : array {
		$unassignedImageCounts[ImageReviewStates::REJECTED] +=
			$usersInProgressImageCounts[ImageReviewStates::REJECTED_IN_REVIEW] ?? 0;

		$unassignedImageCounts[ImageReviewStates::QUESTIONABLE] +=
			$usersInProgressImageCounts[ImageReviewStates::QUESTIONABLE_IN_REVIEW] ?? 0;

		return $unassignedImageCounts;
	}
}
