<?php

class CategoryPaginationHooks {
	const PARAMS_DISABLING_PAGINATION = [ 'from', 'pagefrom', 'pageuntil' ];

	/**
	 * @static
	 * @param Title $title
	 * @param Article $article
	 * @return bool
	 */
	static public function onArticleFromTitle( &$title, &$article ) {
		$app = F::app();

		// Only do anything with category pages on Oasis
		if ( !$app->checkSkin( 'oasis' ) || $title->getNamespace() != NS_CATEGORY ) {
			return true;
		}

		// New pagination doesn't support the from param (yet)
		foreach ( self::PARAMS_DISABLING_PAGINATION as $param ) {
			if ( $app->wg->Request->getVal( $param ) ) {
				return true;
			}
		}

		$article = new CategoryPaginationPage( $title );

		return true;
	}
}
