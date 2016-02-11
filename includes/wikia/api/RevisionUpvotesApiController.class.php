<?php

class RevisionUpvotesApiController extends WikiaApiController {

	/**
	 * Returns number of upvotes for revision on a wiki.
	 * If user provided returns info if revision was upvoted by that user
	 *
	 * @param int $wikiId wiki id (required)
	 * @param int $revisionId revision id to get data for (required)
	 * @param int $userId user that wants to get data (optional)
	 *
	 * @throws MissingParameterApiException
	 */
	public function getCount() {
		$request = $this->getRequest();

		$wikiId = $request->getInt( 'wikiId' );
		$userId = $request->getInt( 'userId' );
		$revisionId = $request->getInt( 'revisionId' );

		if ( empty( $wikiId ) ) {
			throw new MissingParameterApiException( 'wikiId' );
		}

		if ( empty( $revisionId ) ) {
			throw new MissingParameterApiException( 'revisionId' );
		}

		$upvotes = new RevisionUpvotesService();
		$upvotesCount = $upvotes->getCount( $wikiId, $revisionId );
		$userUpvoted = $upvotes->userUpvoted( $wikiId, $revisionId, $userId );

		$this->setResponseData( [
			'wiki_id' => $wikiId,
			'revision_id' => $revisionId,
			'upvotes_count' => $upvotesCount,
			'user_id' => $userId,
			'user_upvoted' => $userUpvoted,
		] );
	}
}
