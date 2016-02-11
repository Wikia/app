<?php

/**
 * This is a mock right now
 * TODO implement model CE-3359
 */
class RevisionUpvotesService {

	/**
	 * @param int $wikiId
	 * @param int $revisionId
	 * @param int $userId
	 */
	public function getCount( $wikiId, $revisionId, $userId = 0 ) {
		return [
			'count' => 128,
			'user_upvoted' => true
		];
	}
}
