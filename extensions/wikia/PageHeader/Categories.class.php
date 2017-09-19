<?php

namespace Wikia\PageHeader;

use CategoryHelper;
use Html;
use RequestContext;
use Title;

class Categories {
	const VISIBLE_CATEGORIES_LIMIT = 4;

	/**
	 * @var Title[]
	 */
	public $categories;

	/**
	 * @var string
	 */
	public $inCategoriesText;

	/**
	 * @var string
	 */
	public $moreCategoriesText;

	/**
	 * @var string
	 */
	public $visibleCategoriesHTML;

	public function __construct() {
		$categories = $this->getCategories();

		$this->categories = $categories;
		$this->visibleCategoriesHTML = $this->getVisibleCategoriesHTML( $categories );
		$this->moreCategories = $this->getMoreCategories( $categories );

		$this->inCategoriesText = wfMessage( 'page-header-categories-in' )->escaped();
		$this->moreCategoriesText = wfMessage( 'page-header-categories-more' )
			->numParams( count( $this->moreCategories ) )
			->escaped();
	}

	/**
	 * @return bool
	 */
	public function hasVisibleCategories() {
		$requestContext = RequestContext::getMain();

		if ( $requestContext->canUseWikiPage() && $requestContext->getWikiPage()->getTitle()->isMainPage() ) {
			return false;
		}

		return count( $this->categories ) > 0;
	}

	/**
	 * @return bool
	 */
	public function hasMoreCategories() {
		return count( $this->categories ) > self::VISIBLE_CATEGORIES_LIMIT;
	}

	/**
	 * @return Title[]
	 */
	private function getCategories() {
		$categories = [];
		$categoryNames = RequestContext::getMain()->getOutput()->getCategories();

		foreach ( $categoryNames as $categoryName ) {
			$categoryTitle = Title::newFromText( $categoryName, NS_CATEGORY );

			if ( CategoryHelper::getCategoryType( $categoryName ) === 'hidden' ) {
				continue;
			}

			array_push( $categories, $categoryTitle );
		}

		return $categories;
	}

	/**
	 * Prepare the HTML here instead of the template
	 * so we can avoid having spaces before the commas
	 * without using HTML comments or ugly formatting
	 *
	 * @param $categories Title[]
	 *
	 * @return string
	 */
	private function getVisibleCategoriesHTML( $categories ) {
		$categoriesLinks = [];
		$categoriesArray = $this->hasMoreCategories() ?
			array_slice( $categories, 0, self::VISIBLE_CATEGORIES_LIMIT - 1 ) :
			$categories;

		/**
		 * @var $category Title
		 */
		foreach ( $categoriesArray as $i => $category ) {
			$categoriesLinks[] = Html::element(
				'a',
				[
					'href' => $category->getLocalURL(),
					'data-tracking' => 'categories-top-' . $i
				],
				$category->getText()
			);
		}

		$categoriesHTML = join( ', ', $categoriesLinks );

		if ( $this->hasMoreCategories() ) {
			$categoriesHTML .= wfMessage( 'page-header-categories-more-separator' )->escaped();
		}

		return $categoriesHTML;
	}

	/**
	 * @param $categories Title[]
	 *
	 * @return array
	 */
	private function getMoreCategories( $categories ) {
		return $this->hasMoreCategories() ? array_slice( $categories, self::VISIBLE_CATEGORIES_LIMIT - 1 ) : [];
	}
}
