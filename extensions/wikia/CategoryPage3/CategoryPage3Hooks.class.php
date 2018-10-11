<?php

class CategoryPage3Hooks {

	const COOKIE_NAME = 'category-page-layout';

	/**
	 * @param $categoryInserts
	 * @param $categoryDeletes
	 * @param $title
	 * @return bool
	 * @throws MWException
	 */
	static public function onAfterCategoriesUpdate( $categoryInserts, $categoryDeletes, $title ): bool {
		$categories = $categoryInserts + $categoryDeletes;

		foreach ( array_keys( $categories ) as $categoryTitle ) {
			$title = Title::newFromText( $categoryTitle, NS_CATEGORY );

			CategoryPage3CacheHelper::setTouched( $title );
		}

		return true;
	}

	/**
	 * @param Title $title
	 * @param Article $article
	 * @return bool
	 */
	static public function onArticleFromTitle( $title, &$article ): bool {
		if ( !$title || !$title->inNamespace( NS_CATEGORY ) ) {
			return true;
		}

		$request = $article->getContext()->getRequest();
		$cookie = $request->getCookie( self::COOKIE_NAME, '' );

		if ( !empty( $cookie ) ) {
			switch ( $cookie ) {
				case CategoryPageWithLayoutSelector::LAYOUT_MEDIAWIKI:
					$article = new CategoryPageMediawiki( $title );
					break;
				case CategoryPageWithLayoutSelector::LAYOUT_CATEGORY_EXHIBITION:
					//TODO
					//$article = new CategoryExhibitionPage( $title );
					//break;
				default:
					$article = new CategoryPage3( $title );
			}
		} else {
			$article = new CategoryPage3( $title );
		}

		return true;
	}
}
