<?php

class ImageCountGetter extends WikiaModel {

	const QUESTIONABLE = 'questionable';
	const REJECTED     = 'rejected';
	const UNREVIEWED   = 'unreviewed';
	const INVALID      = 'invalid';


	public function getImageCounts( $reviewerId ) {
		return $this->mergeCounts(
			$this->getCountOfAllUnassignedImages(),
			$this->getCountOfThisUsersInProgressImages( $reviewerId )
		);
	}

	/**
	 * Get count of all images which have yet to be assigned a reviewer. This is for
	 * both images that haven't gone through the first screening where they are marked
	 * as questionable, rejected, or approved by the first level reviewers, and for
	 * those images marked rejected or questionable which haven't been assigned to a staff
	 * member to make the final call.
	 * @return bool|mixed
	 * @throws Exception
	 */
	private function getCountOfAllUnassignedImages() {
		return ( new WikiaSQL() )
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
			->runLoop( $this->getDatawareDB(), function( &$counts, $row ) {
				$counts[$row->state] = $row->total;
			} );
	}

	/**
	 * Get counts for all images this user has in outstanding reviews. These are images
	 * which have been assigned to the user, but which they haven't made an action on
	 * (eg, marking the image as approved, rejected, questionable, etc). These images
	 * are hidden from all other users since they have been assigned to this user as part
	 * of creating the review.
	 * @param $reviewerId
	 * @return bool|mixed
	 * @throws Exception
	 */
	private function getCountOfThisUsersInProgressImages( $reviewerId ) {
		return ( new WikiaSQL() )
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
			->runLoop( $this->getDatawareDB(), function( &$counts, $row ) {
				$counts[$row->state] = $row->total;
			} );
	}

	/**
	 * Combine the counts for the unassignedImageCounts, and usersInProgressImageCounts. This ensures
	 * that users see the proper counts for rejected, questionable, and unreviwed for them personally.
	 * @param array $unassignedImageCounts
	 * @param array $usersInProgressImageCounts
	 * @return array
	 */
	private function mergeCounts( array $unassignedImageCounts, array $usersInProgressImageCounts ) : array {
		$totalCounts = [
			self::QUESTIONABLE => 0,
			self::REJECTED => 0,
			self::UNREVIEWED => 0,
			self::INVALID => 0
		];

		$totalCounts[self::QUESTIONABLE] += $unassignedImageCounts[ImageReviewStates::QUESTIONABLE] ?? 0;
		$totalCounts[self::QUESTIONABLE] += $usersInProgressImageCounts[ImageReviewStates::QUESTIONABLE_IN_REVIEW] ?? 0;

		$totalCounts[self::REJECTED] += $unassignedImageCounts[ImageReviewStates::REJECTED] ?? 0;
		$totalCounts[self::REJECTED] += $usersInProgressImageCounts[ImageReviewStates::REJECTED_IN_REVIEW] ?? 0;

		$totalCounts[self::UNREVIEWED] += $unassignedImageCounts[ImageReviewStates::UNREVIEWED] ?? 0;
		$totalCounts[self::INVALID] += $usersInProgressImageCounts[ImageReviewStates::INVALID_IMAGE] ?? 0;

		return $totalCounts;
	}
}
