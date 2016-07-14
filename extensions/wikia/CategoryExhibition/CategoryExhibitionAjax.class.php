<?php

class CategoryExhibitionAjax {

	static public function axGetArticlesPage() {
		return self::getSection( 'CategoryExhibitionSectionPages' );
	}

	static public function axGetMediaPage() {
		return self::getSection( 'CategoryExhibitionSectionMedia' );
	}

	static public function axGetSubcategoriesPage() {
		return self::getSection( 'CategoryExhibitionSectionSubcategories' );
	}

	static public function axGetBlogsPage() {
		return self::getSection( 'CategoryExhibitionSectionBlogs' );
	}

	/**
	 * Get one page of one section of a category listing as the following structure
	 * [  'page' => HTML of the requested page
	 *    'paginator' => HTML of the paginator ]
	 * 'articleId', 'page', 'sort', 'display' params will be read from URL.
	 *
	 * @param $class string
	 * @return array
	 */
	static private function getSection( $class ) {
		global $wgRequest;

		$pageTitle = $wgRequest->getVal( 'articleId' );
		$title = Title::newFromText( $pageTitle, NS_CATEGORY );
		if ( !is_object( $title ) ) {
			return '';
		}

		$urlParams = new CategoryUrlParams( $wgRequest );

		/** @var CategoryExhibitionSection $oSection */
		$oSection = new $class( $title, $urlParams );
		$results = $oSection->getTemplateVars();
		return [
			'page' => $results['items'],
			'paginator' => $results['paginator'],
		];
	}
}
