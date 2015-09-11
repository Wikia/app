<?php

namespace Wikia\ContentReview\Models;


class ReviewLogModel extends ContentReviewBaseModel {

	/**
	 * Backup completed review in log table
	 *
	 * @param Array $review
	 * @param int $status
	 * @return bool
	 * @throws \FluentSql\Exception\SqlException
	 */
	public function backupCompletedReview( $review, $status, $reviewUserId ) {
		$db = $this->getDatabaseForWrite();

		( new \WikiaSQL() )
			->INSERT( self::CONTENT_REVIEW_LOG_TABLE )
			->SET( 'wiki_id', $review['wiki_id'] )
			->SET( 'page_id', $review['page_id'] )
			->SET( 'revision_id', $review['revision_id'] )
			->SET( 'status', $status )
			->SET( 'submit_user_id', $review['submit_user_id'] )
			->SET( 'submit_time', $review['submit_time'] )
			->SET( 'review_user_id', $reviewUserId )
			->SET( 'review_start', $review['review_start'] )
			// review_end has a default value set to CURRENT_TIMESTAMP
			->run( $db );

		$affectedRows = $db->affectedRows();

		if ( $affectedRows === 0 ) {
			throw new \FluentSql\Exception\SqlException( 'The INSERT operation failed.' );
		}

		return true;
	}

	public function getArchivedReviewForWiki( $wikiId ) {
		$db = $this->getDatabaseForRead();

		$reviews = ( new \WikiaSQL() )
			->SELECT_ALL()
			->FROM( self::CONTENT_REVIEW_LOG_TABLE )
			->WHERE( 'wiki_id' )->EQUAL_TO( $wikiId )
			->ORDER_BY( ['review_end', 'desc'] )
			->runLoop( $db, function ( &$reviews, $row ) {
				$reviews[] = get_object_vars( $row );
			} );

		return $reviews;
	}
}