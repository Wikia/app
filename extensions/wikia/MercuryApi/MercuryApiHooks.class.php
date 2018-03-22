<?php

class MercuryApiHooks {

	private static $mobileHiddenSectionOpened = false;

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
	 * @return bool
	 */
	public static function onArticleSaveComplete( WikiPage $wikiPage, User $user ) {
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
	 * @param $categoryInserts
	 * @param $categoryDeletes
	 * @return bool
	 */
	static public function onAfterCategoriesUpdate( $categoryInserts, $categoryDeletes ) {
		$categories = $categoryInserts + $categoryDeletes;

		foreach ( array_keys( $categories ) as $categoryName ) {
			$categoryTitle = Title::newFromText( $categoryName, NS_CATEGORY );
			MercuryApiCategoryCacheHelper::setTouched( $categoryTitle->getDBkey() );
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
			$sectionLabel = $section['label'] ?? "";

			if ( empty( $sectionLabel ) || !empty( $section['featured'] ) ) {
				continue;
			}

			WikiaDataAccess::cachePurge( MercuryApiMainPageHandler::curatedContentDataMemcKey( $sectionLabel ) );

			// Request from browser to MediaWiki
			$encodedTitle = self::encodeURIQueryParam( $sectionLabel );
			$urls[] = MercuryApiController::getUrl( 'getCuratedContentSection' ) . '&section=' . $encodedTitle;
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

	/**
	 * @desc Adds <section class="mobile-hidden"></section> wrapper for sections
	 * @param $skin
	 * @param $level
	 * @param $attribs
	 * @param $anchor
	 * @param $text
	 * @param $link
	 * @param $legacyAnchor
	 * @param $ret
	 */
	public static function onMakeHeadline( $skin, $level, $attribs, $anchor, $text, $link, $legacyAnchor, &$ret ){
		global $wgArticleAsJson;

		// this is pseudo-versioning query param for collapsible sections (XW-4393)
		// should be removed after all App caches are invalidated
		if ( !empty( RequestContext::getMain()->getRequest()->getVal( 'collapsibleSections' ) ) &&
		     $wgArticleAsJson && $level == 2
		) {
			if ( self::$mobileHiddenSectionOpened ) {
				$ret = '</section>' . $ret;
			} else {
				self::$mobileHiddenSectionOpened = true;
			}
			$id = "{$anchor}-collapsible-section";
			$ret .= '<section id="' . $id .
			        '" aria-pressed="false" aria-expanded="false" class="mobile-hidden">';
		}
	}

	/**
	 * @desc Closes last section
	 * @param Parser $parser
	 * @param $text
	 */
	public static function onParserBeforeTidy( Parser $parser, &$text ) {
		global $wgArticleAsJson;

		// this is pseudo-versioning query param for collapsible sections (XW-4393)
		// should be removed after all App caches are invalidated
		if ( !empty( RequestContext::getMain()->getRequest()->getVal( 'collapsibleSections' ) ) &&
		     $wgArticleAsJson && self::$mobileHiddenSectionOpened
		) {
			$text .= '</section>';
		}
	}
}
