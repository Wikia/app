<?php

/**
 * Helper class for Category Exhibition
 *
 * @author Jakub
 */
class CategoryExhibitionHooks {
	const EXHIBITION_LIMIT = 2000;

	/**
	 * @static
	 * @param Title $title
	 * @param Article $article
	 * @return bool
	 */
	static public function onArticleFromTitle( &$title, &$article ) {
		$app = F::app();

		// Only touch category pages on Oasis
		if ( !$app->checkSkin( 'oasis' ) || !$title || $title->getNamespace() !== NS_CATEGORY ) {
			return true;
		}

		if ( self::isExhibitionDisabledForTitle( $title, $article ) ) {
			return true;
		}

		$urlParams = new CategoryUrlParams( $app->wg->Request, $app->wg->User );

		if ( $urlParams->getDisplayType() === 'page' ) {
			$article = new CategoryPageII( $title );
		} else {
			$article = new CategoryExhibitionPage( $title );
		}

		return true;
	}

	/**
	 * Return true if the exhibition category type should be disabled on this page
	 *
	 * @param Title $title
	 * @param Article $article
	 * @return bool
	 */
	static private function isExhibitionDisabledForTitle( $title, $article ) {
		if ( !$article || MagicWord::get( CATEXHIBITION_DISABLED )->match( $article->getRawText() ) > 0 ) {
			return true;
		}

		if ( $title->isRedirect() ) {
			$title = $article->getRedirectTarget();
		}

		if ( is_null( $title ) || $title->getNamespace() !== NS_CATEGORY ) {
			return true;
		}

		if ( CategoryDataService::getArticleCount( $title->getDBkey() ) > self::EXHIBITION_LIMIT ) {
			return true;
		}

		return false;
	}

	/**
	 * Hook entry for adding parser magic words
	 */
	static public function onLanguageGetMagic( &$magicWords, $langCode ) {
		$magicWords[CATEXHIBITION_DISABLED] = array( 0, '__NOCATEGORYEXHIBITION__' );
		return true;
	}

	/**
	 * Hook entry for removing the magic words from displayed text
	 * @param Parser $parser
	 * @param string $text
	 * @param $strip_state
	 * @return bool
	 */
	static public function onInternalParseBeforeLinks( Parser $parser, string &$text, &$strip_state ): bool {
		global $wgRTEParserEnabled;
		if ( empty( $wgRTEParserEnabled ) ) {
			MagicWord::get( 'CATEXHIBITION_DISABLED' )->matchAndRemove( $text );
		}
		return true;
	}

	/**
	 * Hook entry when article is change
	 * @param WikiPage $article
	 * @param User $user
	 * @param $text
	 * @param $summary
	 * @param $minoredit
	 * @param $watchthis
	 * @param $sectionanchor
	 * @param $flags
	 * @param Revision $revision
	 * @param Status $status
	 * @param $baseRevId
	 * @param $redirect
	 * @return bool
	 */
	static public function onArticleSaveComplete(
		WikiPage $article, User $user, $text, $summary, $minoredit, $watchthis, $sectionanchor,
		$flags, Revision $revision, Status &$status, $baseRevId, &$redirect
	): bool {
		$title = $article->getTitle();

		$cacheHelper = new CategoryExhibitionCacheHelper();
		$cacheHelper->setTouched( $title );

		return true;
	}

	/**
	 * @static
	 * @param $categoryInserts
	 * @param $categoryDeletes
	 * @param Title $title
	 * @return bool
	 */
	static public function onAfterCategoriesUpdate( $categoryInserts, $categoryDeletes, $title ) {
		$categories = $categoryInserts + $categoryDeletes;

		foreach ( array_keys( $categories ) as $catName ) {
			$title = Title::newFromText( $catName, NS_CATEGORY );

			$cacheHelper = new CategoryExhibitionCacheHelper();
			$cacheHelper->setTouched( $title );
		}

		return true;
	}
}
