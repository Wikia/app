<?php

class MercuryApiHooks {

	const SERVICE_API_ROOT = '/';
	const SERVICE_API_BASE = 'api/mercury/';
	const SERVICE_API_ARTICLE = 'article/';
	const SERVICE_API_CURATED_CONTENT = 'main/section/';

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

		if ( $title->inNamespaces( NS_MAIN ) ) {
			// Mercury API call from Ember.js to Hapi.js e.g.
			// http://elderscrolls.wikia.com/api/mercury/article/Morrowind
			$urls[] =
				$wgServer .
				self::SERVICE_API_ROOT .
				self::SERVICE_API_BASE .
				self::SERVICE_API_ARTICLE .
				$title->getPartialURL();

			// Mercury API call from Hapi.js to MediaWiki e.g.
			// http://elderscrolls.wikia.com/wikia.php?controller=MercuryApi&method=getArticle&title=Morrowind
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

	static public function onCuratedContentSave( $sections ) {
		global $wgServer;

		// Purge main page cache, so Mercury gets fresh data.
		Title::newMainPage()->purgeSquid();

		$urls = [ ];
		WikiaDataAccess::cachePurge( MercuryApiController::curatedContentDataMemcKey() );

		foreach ( $sections as $section ) {
			if ( !empty( $section['featured'] ) ) {
				continue;
			}

			$sectionTitle = $section['title'];

			WikiaDataAccess::cachePurge( MercuryApiController::curatedContentDataMemcKey( $sectionTitle ) );

			// We have to double encode because Ember's RouteRecognizer does decodeURI while processing path.
			$doubleEncodedTitle = self::encodeURI( self::encodeURIQueryParam( $sectionTitle ) );

			// Mercury opened directly with URL
			$urls[] =
				$wgServer .
				self::SERVICE_API_ROOT .
				self::SERVICE_API_CURATED_CONTENT .
				$doubleEncodedTitle;

			// API request from Ember to Hapi
			$urls[] =
				$wgServer .
				self::SERVICE_API_ROOT .
				self::SERVICE_API_BASE .
				self::SERVICE_API_CURATED_CONTENT .
				$doubleEncodedTitle;

			// Request from Hapi to MediaWiki
			$encodedTitle = self::encodeURIQueryParam( $sectionTitle );
			$urls[] = MercuryApiController::getUrl( 'getCuratedContentSection', [ 'section' => $encodedTitle ] );
		}

		( new SquidUpdate( array_unique( $urls ) ) )->doUpdate();

		return true;
	}

	/**
	 * @desc Analogue to JavaScript encodeURI
	 *
	 * @param string $str
	 *
	 * @return string
	 */
	private static function encodeURI( $str ) {
		// http://php.net/manual/en/function.rawurlencode.php
		// https://developer.mozilla.org/en/JavaScript/Reference/Global_Objects/encodeURI
		$unescaped = [
			'%2D' => '-',
			'%5F' => '_',
			'%2E' => '.',
			'%21' => '!',
			'%7E' => '~',
			'%2A' => '*',
			'%27' => "'",
			'%28' => '(',
			'%29' => ')'
		];
		$reserved = [
			'%3B' => ';',
			'%2C' => ',',
			'%2F' => '/',
			'%3F' => '?',
			'%3A' => ':',
			'%40' => '@',
			'%26' => '&',
			'%3D' => '=',
			'%2B' => '+',
			'%24' => '$'
		];
		$score = [
			'%23' => '#'
		];

		return strtr( rawurlencode( $str ), array_merge( $reserved, $unescaped, $score ) );
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
