<?php

class RevisionUpvotesService {

	/**
	 * @param int $wikiId
	 * @param int $revisionId
	 */
	public function getCount( $wikiId, $revisionId ) {
		$db = $this->getDatabaseForRead();

		/* @var ResultWrapper $wrap  */
		$wrap = ( new \WikiaSQL() )
			->SELECT( 'count(*)' )->AS_( 'upvotes_count' )
			->FROM( 'upvote_revisions' )
			->WHERE( 'wiki_id' )->EQUAL_TO( $wikiId )
			->AND_( 'revision_id' )->EQUAL_TO( $revisionId )
			->run( $db );

		return $wrap->current()->upvotes_count;
	}

	/**
	 * @param int $wikiId
	 * @param int $revisionId
	 * @param int $userId
	 */
	public function userUpvoted( $wikiId, $revisionId, $userId ) {
		$db = $this->getDatabaseForRead();

		/* @var ResultWrapper $wrap  */
		$wrap = ( new \WikiaSQL() )
			->SELECT( 'upvote_id' )
			->FROM( 'upvote_revisions' )
			->WHERE( 'wiki_id' )->EQUAL_TO( $wikiId )
			->AND_( 'revision_id' )->EQUAL_TO( $revisionId )
			->AND_( 'from_user' )->EQUAL_TO( $userId )
			->LIMIT( 1 )
			->run( $db );

		return (bool)$wrap->current();
	}

	/**
	 * Connects to a database with an intent of performing SELECT queries
	 * @return \DatabaseBase
	 */
	protected function getDatabaseForRead() {
		return wfGetDB( DB_SLAVE, [], F::app()->wg->UpvotesDB );
	}
}
