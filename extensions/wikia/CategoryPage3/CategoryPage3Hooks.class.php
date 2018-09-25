<?php

class CategoryPage3Hooks {
	/**
	 * @param Title $title
	 * @param Article $article
	 * @return bool
	 */
	static public function onArticleFromTitle( &$title, &$article ): bool {
		if ( !$title || $title->getNamespace() !== NS_CATEGORY ) {
			return true;
		}

		$article = new CategoryPage3( $title );

		return true;
	}
}
