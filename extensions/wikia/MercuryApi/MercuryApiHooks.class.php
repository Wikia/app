<?php

class MercuryApiHooks {

	/**
	 * @desc Increase user's contributions if user is in the hash, otherwise, get number of user's contribution from DB
	 *
	 * @param int $articleId
	 * @param int $userId
	 * @param array $contributions
	 * @return array Resulting arrray
	 */
	private static function addUserToResult( $articleId, $userId, Array $contributions ) {
		if ( isset( $contributions[ $userId ] ) ) {
			$contributions[ $userId ]++;
		} else {
			$mercuryApi = new MercuryApi();
			$contributions[ $userId ] = $mercuryApi->getNumberOfUserContribForArticle( $articleId, $userId );
			arsort( $contributions );
		}
		return $contributions;
	}

	/**
	 * @desc Keep track of article contribution to update the top contributors data if available
	 *
	 * @param WikiPage $wikiPage
	 * @param User $user
	 * @param $text
	 * @param $summary
	 * @param $minoredit
	 * @param $watchthis
	 * @param $sectionanchor
	 * @param $flags
	 * @param $revision
	 * @param $status
	 * @param $baseRevId
	 * @return bool
	 */
	public static function onArticleSaveComplete( WikiPage $wikiPage, User $user, $text, $summary, $minoredit, $watchthis,
												  $sectionanchor, &$flags, $revision, &$status, $baseRevId ) {
		if ( !$user->isAnon() ) {
			$articleId = $wikiPage->getId();
			if ( $articleId ) {
				$userId = $user->getId();
				$key = MercuryApi::getTopContributorsKey( $articleId );
				$memCache = F::app()->wg->Memc;
				$result = $memCache->get( $key );
				// Update the data only if the key is not empty
				if ( $result ) {
					$memCache->set( $key, self::addUserToResult( $articleId, $userId, $result ),
						MercuryApi::CACHE_TIME_TOP_CONTRIBUTORS );
				}
			}
		}
		return true;
	}

	/**
	 * @desc Purge the contributors data to guarantee that it will be refreshed next time it is required
	 *
	 * @param WikiPage $wikiPage
	 * @param User $user
	 * @param $revision
	 * @param $current
	 * @return bool
	 */
	public static function onArticleRollbackComplete( WikiPage $wikiPage, User $user, $revision, $current ) {
		$articleId = $wikiPage->getId();
		$key = MercuryApi::getTopContributorsKey( $articleId );
		WikiaDataAccess::cachePurge( $key );
		return true;
	}
}
