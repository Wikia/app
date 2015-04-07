<?php

class MercuryApiHooks {

	const SERVICE_API_BASE = '/api/v1/';
	const SERVICE_API_ARTICLE = 'article/';

	/**
	 * @desc Get number of user's contribution from DB
	 *
	 * @param int $articleId
	 * @param int $userId
	 * @param array $contributions
	 * @return array Resulting array
	 */
	private static function getNumberOfContributionsForUser( $articleId, $userId, Array $contributions ) {
		$mercuryApi = new MercuryApi();
		$contributions[ $userId ] = $mercuryApi->getNumberOfUserContribForArticle( $articleId, $userId );
		arsort( $contributions );
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
				$key = MercuryApi::getTopContributorsKey( $articleId, MercuryApiController::NUMBER_CONTRIBUTORS );
				$memCache = F::app()->wg->Memc;
				$contributions = $memCache->get( $key );
				// Update the data only if the key is not empty
				if ( $contributions ) {
					if ( isset( $contributions[ $userId ] ) ) {
						// If user is known increase the number of contributions
						$contributions[ $userId ]++;
					} else {
						// Get the number User's contributions from database
						$contributions = self::getNumberOfContributionsForUser( $articleId, $userId, $contributions );
					}
					$memCache->set( $key, $contributions, MercuryApi::CACHE_TIME_TOP_CONTRIBUTORS );
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
		$key = MercuryApi::getTopContributorsKey( $articleId, MercuryApiController::NUMBER_CONTRIBUTORS );
		WikiaDataAccess::cachePurge( $key );
		return true;
	}

	/**
	 * @desc Add Mercury Article API urls to the purge urls list
	 *
	 * @param Title $title
	 * @param array $urls
	 * @return bool
	 */
	static public function onTitleGetSquidURLs( Title $title, Array &$urls ) {
		global $wgServer;

		if( $title->inNamespaces( NS_MAIN ) ) {
			// Mercury API call from Ember to Hapi
			$urls[] = $wgServer . self::SERVICE_API_BASE . self::SERVICE_API_ARTICLE . $title->getPartialURL();
			// Mercury API call from Hapi to MediaWiki
			$urls[] = MercuryApiController::getUrl( 'getArticle', [ 'title' => $title->getPartialURL() ] );
		}
		return true;
	}

	/**
	 * @desc Add instant global for disabling ads on Mercury
	 *
	 * @param array $vars
	 * @return bool
	 */
	static public function onInstantGlobalsGetVariables( array &$vars ) {
		$vars[] = 'wgSitewideDisableAdsOnMercury';
		return true;
	}
}
