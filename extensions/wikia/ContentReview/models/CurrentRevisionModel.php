<?php

namespace Wikia\ContentReview\Models;

class CurrentRevisionModel extends ContentReviewBaseModel {

	public function getLatestReviewedRevision( $wikiId, $pageId ) {
		$db = $this->getDatabaseForRead();

		$revisionData = ( new \WikiaSQL() )
			->SELECT( 'revision_id', 'touched' )
			->FROM( self::CONTENT_REVIEW_CURRENT_REVISIONS_TABLE )
			->WHERE( 'wiki_id' )->EQUAL_TO( $wikiId )
				->AND_( 'page_id' )->EQUAL_TO( $pageId )
			->runLoop( $db, function( &$revisionData, $row ) {
				$revisionData = [
					'revision_id' => $row->revision_id,
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
}
