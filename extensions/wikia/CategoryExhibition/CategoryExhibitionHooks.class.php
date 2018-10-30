<?php

/**
 * Helper class for Category Exhibition
 *
 * @author Jakub
 */
class CategoryExhibitionHooks {
	const EXHIBITION_LIMIT = 2000;

	/**
	 * Return true if the exhibition category type should be disabled on this page
	 *
	 * @param Title $title
	 * @param WikiPage $wikiPage
	 * @return bool
	 */
	static public function isExhibitionDisabledForTitle( $title, $wikiPage ) {
		if ( !$wikiPage || MagicWord::get( CATEXHIBITION_DISABLED )->match( $wikiPage->getRawText() ) > 0 ) {
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
	 * @throws MWException
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
