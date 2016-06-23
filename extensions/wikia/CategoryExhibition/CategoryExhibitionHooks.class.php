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
		if ( !F::app()->checkSkin( 'oasis' ) || !$title || $title->getNamespace() != NS_CATEGORY ) {
			return true;
		}

		$magicWord = MagicWord::get( CATEXHIBITION_DISABLED );
		$disabled = ( 0 < $magicWord->match( $article->getRawText() ) );
		
		if ( $disabled || !self::isCategoryExhibitionEnabled( $title ) ) {
			return true;
		}

		$urlParams = new CategoryUrlParams( F::app()->wg->Request, F::app()->wg->User );

		if ( $urlParams->getDisplayType() === 'page' ) {
			$article = new CategoryPageII( $title );
		} else {
			$article = new CategoryExhibitionPage( $title );
		}

		return true;
	}

	/**
	 * @return boolean
	 */
	static private function isCategoryExhibitionEnabled( $title ) {
		static $categoryExhibitionEnabled = null;

		if ( !is_null( $categoryExhibitionEnabled ) ) {
			return $categoryExhibitionEnabled;
		}

		$categoryExhibitionEnabled = false;
		$oTmpArticle = new Article( $title );
		if ( !is_null( $oTmpArticle ) ) {
			if ( $title->isRedirect() ) {
				$rdTitle = $oTmpArticle->getRedirectTarget();
			} else {
				$rdTitle = $title;
			}

			if ( !is_null( $rdTitle ) && ( $rdTitle->getNamespace() == NS_CATEGORY ) ) {
				$sCategoryDBKey = $rdTitle->getDBkey();

				if ( CategoryDataService::getArticleCount( $sCategoryDBKey ) <= self::EXHIBITION_LIMIT ) {
					$categoryExhibitionEnabled = true;
				}
			}
		}

		return $categoryExhibitionEnabled;
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
	 */
	static public function onInternalParseBeforeLinks( &$parser, &$text, &$strip_state ) {
		global $wgRTEParserEnabled;
		if ( empty( $wgRTEParserEnabled ) ) {
			MagicWord::get( 'CATEXHIBITION_DISABLED' )->matchAndRemove( $text );
		}
		return true;
	}

	/**
	 * Hook entry when article is change
	 */
	static public function onArticleSaveComplete( &$article, &$user, $text, $summary, $minoredit, $watchthis, $sectionanchor, &$flags, $revision, &$status, $baseRevId, &$redirect ) {
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
