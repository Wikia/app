<?php

class CategoryPaginationHooks {
	/**
	 * @static
	 * @param Title $title
	 * @param Article $article
	 * @return bool
	 */
	static public function onArticleFromTitle( &$title, &$article ) {
		// Only touch category pages on Oasis
		if ( !F::app()->checkSkin( 'oasis' ) || $title->getNamespace() != NS_CATEGORY ) {
			return true;
		}

		// New pagination doesn't support the from param (yet)
		if ( F::app()->wg->Request->getVal( 'from' ) ) {
			return true;
		}

		$article = new CategoryPaginationPage( $title );

		return true;
	}
}
