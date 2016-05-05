<?php

class MercuryApiHooks {

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
				$key = MercuryApi::getTopContributorsKey( $articleId, MercuryApiArticleHandler::NUMBER_CONTRIBUTORS );
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
		$key = MercuryApi::getTopContributorsKey( $articleId, MercuryApiArticleHandler::NUMBER_CONTRIBUTORS );
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
		if ( $title->inNamespaces( NS_MAIN ) ) {
			// Request from browser to MediaWiki
			// TODO: Remove one of these two below when it is decided if we do the switch to getPage() or drop it.
			$urls[] = MercuryApiController::getUrl( 'getArticle', [ 'title' => $title->getPartialURL() ] );
			$urls[] = MercuryApiController::getUrl( 'getPage', [ 'title' => $title->getPartialURL() ] );
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

	static public function onCuratedContentSave( $sections ) {
		// Purge main page cache, so Mercury gets fresh data.
		Title::newMainPage()->purgeSquid();

		$urls = [ ];
		WikiaDataAccess::cachePurge( MercuryApiMainPageHandler::curatedContentDataMemcKey() );

		foreach ( $sections as $section ) {
			if ( !empty( $section['featured'] ) ) {
				continue;
			}

			$sectionTitle = $section['title'];

			WikiaDataAccess::cachePurge( MercuryApiMainPageHandler::curatedContentDataMemcKey( $sectionTitle ) );

			// Request from browser to MediaWiki
			$encodedTitle = self::encodeURIQueryParam( $sectionTitle );
			$urls[] = MercuryApiController::getUrl( 'getCuratedContentSection', [ 'section' => $encodedTitle ] );
		}

		( new SquidUpdate( array_unique( $urls ) ) )->doUpdate();

		return true;
	}

	/**
	 * @desc Analogue to JavaScript encodeURIComponent
	 *
	 * @param string $str
	 *
	 * @return string
	 */
	private static function encodeURIQueryParam( $str ) {
		return strtr( rawurlencode( $str ), [ '%21' => '!', '%27' => "'", '%28' => '(', '%29' => ')', '%2A' => '*' ] );
	}
}
