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
			$contributions[ $userId ] = MercuryApi::getNumberOfUserContribForArticle( $articleId, $userId );
			asort( $contributions );
		}
		return $contributions;
	}

	/**
	 * @desc Keep track of article contribution to update the top contributors data if available
	 *
	 * @param Article $article
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
	 */
	public static function onArticleSaveComplete( Article $article, User $user, $text, $summary, $minoredit, $watchthis,
												  $sectionanchor, &$flags, $revision, &$status, $baseRevId ) {
		if ( !$user->isAnon() ) {
			$articleId = $article->getTitle()->getArticleId();
			$userId = $user->getId();
			$key = getTopContributorsKey( $articleId );
			$wg = F::app()->wg;
			$result = $wg->Memc->get( $key );
			// Update the data only if the key is not empty
			if ( $result ) {
				$wg->Memc->set( $key, self::addUserToResult( $articleId, $userId, $result ),
					MercuryApi::CACHE_TIME_TOP_CONTRIBUTORS );
			}
		}
	}

	/**
	 * @desc Purge the contributors data to guarantee that it will be refreshed next time it is required
	 *
	 * @param Article $article
	 * @param User $user
	 * @param $revision
	 * @param $current
	 */
	public static function onArticleRollbackComplete( Article $article, User $user, $revision, $current ) {
		$articleId = $article->getTitle()->getArticleId();
		$key = getTopContributorsKey( $articleId );
		WikiaDataAccess::cachePurge( $key );
	}
} 