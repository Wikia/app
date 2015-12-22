<?php

namespace Wikia\ContentReview\Models;

use FluentSql\Exception\SqlException,
	Wikia\ContentReview\ContentReviewStatusesService;

class ReviewModel extends ContentReviewBaseModel {

	/**
	 * Possible states a review can be in
	 */
	const 	CONTENT_REVIEW_STATUS_UNREVIEWED = 1,
			CONTENT_REVIEW_STATUS_IN_REVIEW = 2,
			CONTENT_REVIEW_STATUS_APPROVED = 3,
			CONTENT_REVIEW_STATUS_REJECTED = 4,
			CONTENT_REVIEW_STATUS_AUTOAPPROVED = 5;

	public function getPagesStatuses( $wikiId ) {
		$db = $this->getDatabaseForRead();

		$pagesStatuses = ( new \WikiaSQL() )
			->SELECT( 'page_id', 'revision_id', 'status' )
			->FROM( self::CONTENT_REVIEW_STATUS_TABLE )
			->WHERE( 'wiki_id' )->EQUAL_TO( $wikiId )
			->ORDER_BY( [ 'page_id', 'ASC' ], [ 'revision_id', 'DESC' ] )
			->runLoop( $db, function ( &$pagesStatuses, $row ) {
				$pagesStatuses[$row->page_id][(int)$row->status] = (int)$row->revision_id;
			} );

		return $pagesStatuses;
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
				if ( (int)$row->status === self::CONTENT_REVIEW_STATUS_UNREVIEWED ) {
					$reviewId = (int)$row->review_id;
				} else {
					$reviewId = null;
				}
			} );

		if ( empty( $reviewId ) ) {
			$reviewId = null;
		}

		return $reviewId;
	}

	/**
	 * Add page to content review queue
	 *
	 * @param int $wikiId
	 * @param int $pageId
	 * @param int $revisionId
	 * @param int $submitUserId
	 * @return bool
	 * @throws \FluentSql\Exception\SqlException
	 */
	public function submitPageForReview( $wikiId, $pageId, $revisionId, $submitUserId ) {
		$db = $this->getDatabaseForWrite();

		( new \WikiaSQL() )
			->INSERT( self::CONTENT_REVIEW_STATUS_TABLE )
			// wiki_id, page_id and status are a unique key
			->SET( 'wiki_id', $wikiId )
			->SET( 'page_id', $pageId )
			->SET( 'revision_id', $revisionId )
			->SET( 'status', self::CONTENT_REVIEW_STATUS_UNREVIEWED )
			->SET( 'submit_user_id', $submitUserId )
			// submit_time has a default value set to CURRENT_TIMESTAMP
			// review_user_id is NULL
			// review_start is NULL
			->ON_DUPLICATE_KEY_UPDATE(
				[ 'revision_id' => $revisionId ]
			)
			->run( $db );

		$affectedRows = $db->affectedRows();

		if ( $affectedRows === 0 ) {
			throw new SqlException( 'The INSERT operation failed.' );
		}

		$db->commit( __METHOD__ );

		return true;
	}

	/**
	 * Remove review request after review is completed (approved, rejected)
	 *
	 * @param int $wikiId
	 * @param int $pageId
	 * @param int $revisionId
	 * @param int $status
	 * @return bool
	 * @throws \FluentSql\Exception\SqlException
	 */
	public function updateCompletedReview( $wikiId, $pageId, $revisionId, $status ) {
		$db = $this->getDatabaseForWrite();

		( new \WikiaSQL() )
			->DELETE()
			->FROM( self::CONTENT_REVIEW_STATUS_TABLE )
			->WHERE( 'wiki_id' )->EQUAL_TO( $wikiId )
				->AND_( 'page_id' )->EQUAL_TO( $pageId )
				->AND_( 'status' )->EQUAL_TO( $status )
			->run( $db );

		( new \WikiaSQL() )
			->UPDATE( self::CONTENT_REVIEW_STATUS_TABLE )
			->SET( 'status', $status )
			->WHERE( 'wiki_id' )->EQUAL_TO( $wikiId )
				->AND_( 'page_id' )->EQUAL_TO( $pageId )
				->AND_( 'revision_id' )->EQUAL_TO( $revisionId )
			->run( $db );

		$affectedRows = $db->affectedRows();

		if ( $affectedRows === 0 ) {
			throw new SqlException( 'The DELETE and UPDATE operation failed.' );
		}

		$db->commit( __METHOD__ );

		return true;
	}

	public function updateRevisionStatus( $wiki_id, $page_id, $oldStatus, $status, $reviewerId  ) {
		$db = $this->getDatabaseForWrite();

		( new \WikiaSQL() )
			->UPDATE( self::CONTENT_REVIEW_STATUS_TABLE )
			->SET( 'status', $status )
			->SET( 'review_user_id', $reviewerId )
			->SET( 'review_start', wfTimestamp( TS_DB ) )
			->WHERE( 'wiki_id' )->EQUAL_TO( $wiki_id )
			->AND_( 'page_id' )->EQUAL_TO( $page_id )
			->AND_( 'status' )->EQUAL_TO( $oldStatus )
			->run( $db );

		$affectedRows = $db->affectedRows();

		if ( $affectedRows === 0 ) {
			throw new SqlException( 'The UPDATE operation failed.' );
		}

		return $status;
	}

	public function getContentToReviewFromDatabase() {
		$db = $this->getDatabaseForRead();

		$content = ( new \WikiaSQL() )
			->SELECT( self::CONTENT_REVIEW_STATUS_TABLE . '.*', self::CONTENT_REVIEW_CURRENT_REVISIONS_TABLE . '.revision_id AS reviewed_id' )
			->FROM( self::CONTENT_REVIEW_STATUS_TABLE )
			->LEFT_JOIN( self::CONTENT_REVIEW_CURRENT_REVISIONS_TABLE )
			->ON( self::CONTENT_REVIEW_STATUS_TABLE . '.wiki_id', self::CONTENT_REVIEW_CURRENT_REVISIONS_TABLE . '.wiki_id' )
				->AND_( self::CONTENT_REVIEW_STATUS_TABLE . '.page_id', self::CONTENT_REVIEW_CURRENT_REVISIONS_TABLE . '.page_id' )
			->WHERE( 'status' )->IN( self::CONTENT_REVIEW_STATUS_UNREVIEWED, self::CONTENT_REVIEW_STATUS_IN_REVIEW )
			->ORDER_BY( ['submit_time', 'asc'], ['status', 'desc'] )
			->runLoop( $db, function ( &$content, $row ) {
				$key = implode( ':', [ $row->wiki_id, $row->page_id, $row->status ] );
				$content[$key] = get_object_vars( $row );
			} );

		return $content;
	}

	public function getAllReviewsOfPage( $wikiId, $pageId ) {
		$db = $this->getDatabaseForRead();

		$reviews = ( new \WikiaSQL() )
			->SELECT( 'revision_id', 'status' )
			->FROM( self::CONTENT_REVIEW_STATUS_TABLE )
			->WHERE( 'wiki_id' )->EQUAL_TO( $wikiId )
			->AND_( 'page_id' )->EQUAL_TO( $pageId )
			->runLoop( $db, function ( &$reviews, $row ) {
				$reviews[] = [
					'revision_id' => (int)$row->revision_id,
					'status' => (int)$row->status,
				];
			} );

		return $reviews;
	}

	/**
	 * Retrieves a row from content_review_status table for a given based on a desired status.
	 * If there is no review of the given page of the given status - a false is returned.
	 *
	 * @param $wiki_id
	 * @param $page_id
	 * @param $status
	 * @return bool|array Returns an array that resembles a row from the content_review_status table,
	 * or `false` if no is found.
	 */
	public function getReviewOfPageByStatus( $wiki_id, $page_id, $status ) {
		$db = $this->getDatabaseForRead();

		$content = ( new \WikiaSQL() )
			->SELECT_ALL()
			->FROM( self::CONTENT_REVIEW_STATUS_TABLE )
			->WHERE( 'wiki_id' )->EQUAL_TO( $wiki_id )
			->AND_( 'page_id' )->EQUAL_TO( $page_id )
			->AND_( 'status' )->EQUAL_TO( $status )
			->runLoop( $db, function ( &$content, $row ) {
				$content = get_object_vars( $row );
			} );

		return $content;
	}

	public function getRevisionInfo( $wikiId, $pageId, $revisionId ) {
		$db = $this->getDatabaseForRead();

		$revisionInfo = ( new \WikiaSQL() )
			->SELECT_ALL()
			->FROM( self::CONTENT_REVIEW_STATUS_TABLE )
			->WHERE( 'wiki_id' )->EQUAL_TO( $wikiId )
			->AND_( 'page_id' )->EQUAL_TO( $pageId )
			->AND_( 'revision_id' )->EQUAL_TO( $revisionId )
			->runLoop( $db, function ( &$revisionInfo, $row ) {
				$revisionInfo = [
					'wikiId' => (int)$row->wiki_id,
					'pageId' => (int)$row->page_id,
					'status' => (int)$row->status,
				];
			} );

		return $revisionInfo;
	}

	public function getStatusName( $status, $revisionId ) {
		switch( $status ) {
			case self::CONTENT_REVIEW_STATUS_UNREVIEWED:
			case self::CONTENT_REVIEW_STATUS_IN_REVIEW:
				$statusName = ContentReviewStatusesService::STATUS_AWAITING;
				break;
			case self::CONTENT_REVIEW_STATUS_APPROVED:
				$statusName = ContentReviewStatusesService::STATUS_APPROVED;
				break;
			case self::CONTENT_REVIEW_STATUS_REJECTED:
				$statusName = ContentReviewStatusesService::STATUS_REJECTED;
				break;
			default: $statusName = ContentReviewStatusesService::STATUS_NONE;
		}

		// Distinguish none from unsubmitted
		if ( $statusName == ContentReviewStatusesService::STATUS_NONE && !empty( $revisionId ) ) {
			$statusName = ContentReviewStatusesService::STATUS_UNSUBMITTED;
		}

		return $statusName;
	}

	/**
	 * Deletes all reviews information on a given page.
	 * Used for cleaning up data on deleted articles.
	 * @param $wikiId
	 * @param $pageId
	 * @return bool|mixed
	 */
	public function deleteReviewsOfPage( $wikiId, $pageId ) {
		$reviews = $this->getAllReviewsOfPage( $wikiId, $pageId );

		// Quit early if there are no reviews to delete.
		if ( empty( $reviews ) ) {
			return true;
		}

		$db = $this->getDatabaseForWrite();

		$result = ( new \WikiaSQL() )
			->DELETE()
			->FROM( self::CONTENT_REVIEW_STATUS_TABLE )
			->WHERE( 'wiki_id' )->EQUAL_TO( $wikiId )
			->AND_( 'page_id' )->EQUAL_TO( $pageId )
			->run( $db );

		if ( $result ) {
			$db->commit();
		}

		return $result;
	}
}
