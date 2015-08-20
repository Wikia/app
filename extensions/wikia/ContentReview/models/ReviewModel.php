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
			// wiki_id, page_id and revision_id are a unique key
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
			throw new \FluentSql\Exception\SqlException( 'The INSERT operation failed.' );
		}

		$db->commit();

		return true;
	}

	public function updateRevisionStatus( $wiki_id, $page_id, $status ) {

			$db = $this->getDatabaseForWrite();

			( new \WikiaSQL() )
				->UPDATE( self::CONTENT_REVIEW_STATUS_TABLE )
				->SET( 'status', $status )
				->WHERE( 'wiki_id' )->EQUAL_TO( $wiki_id )
				->AND_( 'page_id')->EQUAL_TO( $page_id )
				->run( $db );

			$db->commit();

			return $status;

	}

	public function getContentToReviewFromDatabase() {
		$db = $this->getDatabaseForRead();

		$data = ( new \WikiaSQL() )

			->SELECT( 'content_review_status.*', 'current_reviewed_revisions.revision_id AS reviewed_id' )
			->FROM( self::CONTENT_REVIEW_STATUS_TABLE  )
			->LEFT_JOIN( self::CONTENT_REVIEW_CURRENT_REVISIONS_TABLE )
				->ON( 'content_review_status.wiki_id', 'current_reviewed_revisions.wiki_id' )
			->AND_('content_review_status.page_id', 'current_reviewed_revisions.page_id' );


		$content = $data->runLoop( $db, function( &$content, $row ) {
			$content[] = get_object_vars( $row );
		} );


		return $content;
	}
}
