<?php

namespace Wikia\PageHeader;

use CategoryHelper;
use RequestContext;
use Title;

class Categories {
	const VISIBLE_CATEGORIES_LIMIT = 4;

	public $categories = [];
	public $inCategoriesText;
	public $moreCategoriesText;
	public $moreCategoriesSeparator;
	public $visibleCategories;
	public $visibleCategoriesLength;

	public function __construct() {
		$categories = $this->getCategories();

		$this->categories = $categories;
		$this->visibleCategories = $this->getVisibleCategories( $categories );
		$this->moreCategories = $this->getMoreCategories( $categories );

		$this->setTexts();
	}

	public function hasVisibleCategories() {
		return count( $this->categories ) > 0;
	}

	public function hasMoreCategories() {
		return count( $this->categories ) > self::VISIBLE_CATEGORIES_LIMIT;
	}

	public function setTexts() {
		$this->inCategoriesText = wfMessage( 'page-header-categories-in' )->escaped();
		$this->moreCategoriesText = wfMessage( 'page-header-categories-more' )
			->numParams( count( $this->moreCategories ) )
			->escaped();
	}

	private function getCategories() {
		$categories = [ ];
		$categoryNames = RequestContext::getMain()->getOutput()->getCategories();

		foreach ( $categoryNames as $categoryName ) {
			$categoryTitle = Title::newFromText( $categoryName, NS_CATEGORY );

			if ( !$categoryTitle->isKnown() || CategoryHelper::getCategoryType( $categoryName ) === 'hidden' ) {
				continue;
			}

			array_push( $categories, $categoryTitle );
		}

		return $categories;
	}

	/**
	 * Prepare the HTML here instead of the template so we can avoid having space before the commas
	 * without using HTML comments or ugly formatting
	 *
	 * @param $categories Title[]
	 *
	 * @return string
	 */
	private function getVisibleCategories( $categories ) {
		$categoriesArray = array_slice( $categories, 0, self::VISIBLE_CATEGORIES_LIMIT - 1 );
		$categoriesLinks = [];

		/**
		 * @var $category Title
		 */
		foreach ( $categoriesArray as $category ) {
			$categoriesLinks[] = '<a href="' . $category->getLocalURL() . '">' . $category->getText() . '</a>';
		}

		$categoriesText = join( ', ', $categoriesLinks );

		if ( $this->hasMoreCategories() ) {
			$categoriesText .= wfMessage( 'page-header-categories-more-separator' )->escaped();
		}

		return $categoriesText;
	}

	private function getMoreCategories( $categories ) {
		return $this->hasMoreCategories() ? array_slice( $categories, self::VISIBLE_CATEGORIES_LIMIT - 1 ) : [];
	}
}
