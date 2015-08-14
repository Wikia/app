<?php

namespace Wikia\ContentReview\Models;

class ReviewModel extends ContentReviewBaseModel {

	/**
	 * Possible states a review can be in
	 */
	const CONTENT_REVIEW_STATUS_UNREVIEWED = 1;
	const CONTENT_REVIEW_STATUS_IN_REVIEW = 2;
	const CONTENT_REVIEW_STATUS_APPROVED = 3;
	const CONTENT_REVIEW_STATUS_REJECTED = 4;

	public function getPageStatus( $wikiId, $pageId ) {
		$db = $this->getDatabaseForRead();

		$status = ( new \WikiaSQL() )
			->SELECT( 'revision_id', 'status' )
			->FROM( self::CONTENT_REVIEW_STATUS_TABLE )
			->WHERE( 'wiki_id' )->EQUAL_TO( $wikiId )
				->AND_( 'page_id' )->EQUAL_TO( $pageId )
			->ORDER_BY( 'submit_time' )->DESC()
			->LIMIT( 1 )
			->runLoop( $db, function ( &$status, $row ) {
				$status = [
					'revision_id' => $row->revision_id,
					'status' => $row->status,
				];
			} );

		if ( empty( $status ) ) {
			$status = [
				'revision_id' => null,
				'status' => null,
			];
		}

		return $status;
	}

	public function getCurrentUnreviewedId( $wikiId, $pageId ) {
		$db = $this->getDatabaseForRead();

		$reviewId = ( new \WikiaSQL() )
			->SELECT( 'review_id', 'status' )
			->FROM( self::CONTENT_REVIEW_STATUS_TABLE )
			->WHERE( 'wiki_id' )->EQUAL_TO( $wikiId )
			->AND_( 'page_id' )->EQUAL_TO( $pageId )
			->ORDER_BY( 'submit_time' )->DESC()
			->LIMIT( 1 )
			->runLoop( $db, function ( &$reviewId, $row ) {
				if ( intval( $row->status ) === self::CONTENT_REVIEW_STATUS_UNREVIEWED ) {
					$reviewId = $row->review_id;
				} else {
					$reviewId = null;
				}
			} );

		if ( empty( $reviewId ) ) {
			$reviewId = null;
		}

		return $reviewId;
	}

	public function submitPageForReview( $wikiId, $pageId, $revisionId, $submitUserId ) {
		try {
			$db = $this->getDatabaseForWrite();

			( new \WikiaSQL() )
				->INSERT( self::CONTENT_REVIEW_STATUS_TABLE )
				// wiki_id, page_id and revision_id are a unique key
				->SET( 'wiki_id', $wikiId )
				->SET( 'page_id', $pageId )
				->SET( 'revision_id', $revisionId )
				->SET( 'status', self::CONTENT_REVIEW_STATUS_UNREVIEWED )
				->SET( 'submit_user_id', $submitUserId )
				// submit_time has a default value set to CURRENT_TIMESTAMP
				// review_user_id is NULL
				// review_start is NULL
				->run( $db );

			$affectedRows = $db->affectedRows();

			if ( $affectedRows === 0 ) {
				throw new \Exception( 'The INSERT operation failed.' );
			} else {
				$status = true;
			}

			$db->commit();

			return [
				'status' => $status,
			];
		} catch ( \Exception $e ) {
			if ( $db !== null ) {
				$db->rollback;
			}

			throw $e;
		}
	}

	public function updateReviewById( $reviewId, $revisionId, $submitUserId ) {
		try {
			$db = $this->getDatabaseForWrite();

			( new \WikiaSQL() )
				->UPDATE( self::CONTENT_REVIEW_STATUS_TABLE )
				->SET( 'revision_id', $revisionId )
				->SET( 'submit_user_id', $submitUserId )
				->SET( 'submit_time', 'DEFAULT', true )
				->WHERE( 'review_id' )->EQUAL_TO( $reviewId )
				->run( $db );

			if ( $db->affectedRows() === 0 ) {
				throw new \Exception( 'The UPDATE operation failed.' );
			}

			$db->commit();

			return $reviewId;
		} catch ( \Exception $e ) {
			if ( $db !== null ) {
				$db->rollback;
			}

			throw $e;
		}
	}
}
