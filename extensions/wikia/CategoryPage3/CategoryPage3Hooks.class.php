<?php

class CategoryPage3Hooks {

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

		$article = new CategoryPage3( $title );

		return true;
	}
}
