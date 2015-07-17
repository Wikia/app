<?php

/**
 * Helper class for Category Exhibition
 *
 * @author Jakub
 */
class CategoryExhibitionHelper {

	/**
	 * @static
	 * @param Title $title
	 * @param Article $article
	 * @return bool
	 */
	static public function onArticleFromTitle( &$title, &$article ){
		if ( F::app()->checkSkin( 'wikiamobile' ) || F::app()->checkSkin( 'monobook' ) ) {
			return true;
		}

		if ( $title->getNamespace() != NS_CATEGORY ) {
			return true;
		}

		$categoryExhibition = new CategoryExhibitionSection( $title );
		$categoryExhibition->setDisplayTypeFromParam();
		$categoryExhibition->setSortTypeFromParam();
		$displayType = $categoryExhibition->getDisplayType();
		if ( $displayType == 'exhibition' ){
			$article = new CategoryExhibitionPage( $title );
		} else {
			$article = new CategoryPageII( $title );
		}

		$magicWord = MagicWord::get( CATEXHIBITION_DISABLED );
		$disabled = ( 0 < $magicWord->match( $article->getRawText() ) );
		if ( $disabled || !$categoryExhibition->isCategoryExhibitionEnabled() ) {
			$article = false;
		}

		return true;
	}

	/**
	 * Hook entry for adding parser magic words
	 */
	static public function onLanguageGetMagic(&$magicWords, $langCode){
		$magicWords[CATEXHIBITION_DISABLED] = array( 0, '__NOCATEGORYEXHIBITION__' );
		return true;
	}

	/**
	 * Hook entry for removing the magic words from displayed text
	 */
	static public function onInternalParseBeforeLinks(&$parser, &$text, &$strip_state) {
		global $wgRTEParserEnabled;
		if (empty($wgRTEParserEnabled)) {
			MagicWord::get('CATEXHIBITION_DISABLED')->matchAndRemove($text);
		}
		return true;
	}

	/**
	 * Hook entry when article is change
	 *
	 * @param Article $article
	 */
	static public function onArticleSaveComplete(  &$article, &$user, $text, $summary, $minoredit, $watchthis, $sectionanchor, &$flags, $revision, &$status, $baseRevId, &$redirect ) {
		$title = $article->getTitle();

		$ce = new CategoryExhibitionSection(null);
		$ce->setTouched($title);

		return true;
	}

	/**
	 * @static
	 * @param $categoryInserts
	 * @param $categoryDeletes
	 * @param Title $title
	 * @return bool
	 */
	static public function onAfterCategoriesUpdate($categoryInserts, $categoryDeletes, $title) {
		$ce = new CategoryExhibitionSection(null);
		$categores = $categoryInserts + $categoryDeletes;

		foreach(array_keys($categores) as $value) {
			$title = Title::newFromText($value, NS_CATEGORY);
			$ce->setTouched($title);
		}

		return true;
	}
}
