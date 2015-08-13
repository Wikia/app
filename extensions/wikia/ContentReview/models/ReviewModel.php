<?php

namespace Wikia\ContentReview\Models;

use Wikia\Util\GlobalStateWrapper;

class ReviewModel extends \WikiaModel {
	/**
	 * Names of tables used by the extension
	 */
	const CONTENT_REVIEW_STATUS_TABLE = 'content_review_status';
	const CONTENT_REVIEW_STATUS_UNREVIEWED = 0;
	const CONTENT_REVIEW_STATUS_IN_REVIEW = 1;
	const CONTENT_REVIEW_STATUS_APPROVED = 2;
	const CONTENT_REVIEW_STATUS_REJECTED = 3;

	public function getPageStatus( $wikiId, $pageId ) {
		try {
			$db = $this->getDatabaseForRead();

			$status = null;

			( new \WikiaSQL() )
				->SELECT( 'status' )
				->FROM( self::CONTENT_REVIEW_STATUS_TABLE )
				->WHERE( 'wiki_id' )->EQUAL_TO( $wikiId )
					->AND_( 'page_id' )->EQUAL_TO( $pageId )
				->ORDER_BY( 'submit_time' )->DESC()
				->LIMIT( 1 )
				->runLoop( $db, function ( &$status, $row ) {
					$status = $row->status;
				} );

			return $status;
		} catch ( \Exception $e ) {
			if ( $db !== null ) {
				$db->rollback;
			}

			throw $e;
		}
	}

	public function getCurrentUnreviewedId( $wikiId, $pageId ) {
		try {
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

			if ( !$reviewId > 0 ) {
				$reviewId = null;
			}

			return $reviewId;
		} catch ( \Exception $e ) {
			if ( $db !== null ) {
				$db->rollback;
			}

			throw $e;
		}
	}

	public function markPageAsUnreviewed( $wikiId, $pageId, $revisionId, $submitUserId ) {
		try {
			$db = $this->getDatabaseForWrite();

			( new \WikiaSQL() )
				->INSERT( self::CONTENT_REVIEW_STATUS_TABLE )
				// review_id is auto_increment
				->SET( 'wiki_id', $wikiId )
				->SET( 'page_id', $pageId )
				->SET( 'revision_id', $revisionId )
				->SET( 'status', self::CONTENT_REVIEW_STATUS_UNREVIEWED )
				->SET( 'submit_user_id', $submitUserId )
				// submit_time has a default value set to CURRENT_TIMESTAMP
				// review_user_id is NULL
				// review_time is NULL
				->run( $db );

			$reviewId = $db->insertId();
			if ( !$reviewId > 0 ) {
				throw new \Exception( 'The INSERT operation failed.' );
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

	/**
	 * Connects to a database with an intent of performing SELECT queries
	 * @return \DatabaseBase
	 */
	private function getDatabaseForRead() {
		return $this->getDatabase( DB_SLAVE );
	}

	/**
	 * Connects to a database with an intent of performing INSERT, UPDATE and DELETE queries
	 * @return \DatabaseBase
	 */
	private function getDatabaseForWrite() {
		return $this->getDatabase( DB_MASTER );
	}

	/**
	 * Get connection to flags database
	 *
	 * Flags database is encoded in utf-8, while in most cases MW communicate with
	 * databases using latin1, so sometimes we get strings in wrong encoding.
	 * The only way to force utf-8 communication (adding SET NAMES utf8) is setting
	 * global variable wgDBmysql5.
	 *
	 * @see https://github.com/Wikia/app/blob/dev/includes/db/DatabaseMysqlBase.php#L113
	 *
	 * @param int $dbType master or slave
	 * @return \DatabaseBase
	 */
	private function getDatabase( $dbType ) {
		$wrapper = new GlobalStateWrapper( [
			'wgDBmysql5' => true
		] );

		$db = $wrapper->wrap( function () use ( $dbType ) {
			return wfGetDB( $dbType, [], $this->wg->ContentReviewDB );
		} );

		return $db;
	}
}
