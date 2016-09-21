<?php

namespace Wikia\ContentReview\Models;

use \FluentSql\Exception\SqlException;

class CurrentRevisionModel extends ContentReviewBaseModel {

	/**
	 * Approve revision
	 *
	 * @param int $wikiId
	 * @param int $pageId
	 * @param int $revisionId
	 * @return bool
	 * @throws \FluentSql\Exception\SqlException
	 */
	public function approveRevision( $wikiId, $pageId, $revisionId ) {
		$db = $this->getDatabaseForWrite();

		( new \WikiaSQL() )
			->INSERT( self::CONTENT_REVIEW_CURRENT_REVISIONS_TABLE )
			->SET( 'wiki_id', $wikiId )
			->SET( 'page_id', $pageId )
			->SET( 'revision_id', $revisionId )
			// touched has a default value set to CURRENT_TIMESTAMP
			->ON_DUPLICATE_KEY_UPDATE(
				[ 'revision_id' => $revisionId, 'touched' => wfTimestamp( TS_DB ) ]
			)
			->run( $db );;

		$affectedRows = $db->affectedRows();

		if ( $affectedRows === 0 ) {
			throw new SqlException( 'The INSERT operation failed.' );
		}

		$db->commit( __METHOD__ );

		return true;
	}

	public function getLatestReviewedRevision( $wikiId, $pageId ) {
		$db = $this->getDatabaseForRead();

		$revisionData = ( new \WikiaSQL() )
			->SELECT( 'revision_id', 'touched' )
			->FROM( self::CONTENT_REVIEW_CURRENT_REVISIONS_TABLE )
			->WHERE( 'wiki_id' )->EQUAL_TO( $wikiId )
				->AND_( 'page_id' )->EQUAL_TO( $pageId )
			->runLoop( $db, function( &$revisionData, $row ) {
				$revisionData = [
					'revision_id' => (int)$row->revision_id,
					'touched' => $row->touched,
				];
			} );

		if ( empty( $revisionData ) ) {
			$revisionData = [
				'revision_id' => null,
				'touched' => null,
			];
		}

		return $revisionData;
	}

	public function getLatestReviewedRevisionForWiki( $wikiId ) {
		$db = $this->getDatabaseForRead();

		$revisionData = ( new \WikiaSQL() )
			->SELECT( 'page_id', 'revision_id', 'touched' )
			->FROM( self::CONTENT_REVIEW_CURRENT_REVISIONS_TABLE )
			->WHERE( 'wiki_id' )->EQUAL_TO( $wikiId )
			->runLoop( $db, function( &$revisionData, $row ) {
				$revisionData[$row->page_id] = [
					'page_id' => (int)$row->page_id,
					'revision_id' => (int)$row->revision_id,
					'touched' => $row->touched,
					'ts' => wfTimestamp( TS_UNIX, $row->touched )
				];
			} );

		return $revisionData;
	}

	/**
	 * Deletes current revision for a given page.
	 * Used for cleaning up data on deleted articles.
	 * @param $wikiId
	 * @param $pageId
	 * @return bool|mixed
	 * @throws \FluentSql\Exception\SqlException
	 */
	public function deleteCurrentRevisionOfPage( $wikiId, $pageId ) {
		$currentRevision = $this->getLatestReviewedRevision( $wikiId, $pageId );

		// Quit early if there is no current revision for the page
		if ( $currentRevision['revision_id'] === null ) {
			return true;
		}

		$dbw = $this->getDatabaseForWrite();

		$result = ( new \WikiaSQL() )
			->DELETE()
			->FROM( self::CONTENT_REVIEW_CURRENT_REVISIONS_TABLE )
			->WHERE( 'wiki_id' )->EQUAL_TO( $wikiId )
			->AND_( 'page_id' )->EQUAL_TO( $pageId )
			->run( $dbw );

		if ( $result ) {
			$dbw->commit();
		}

		return $result;
	}
}
