<?php
/**
 * Created by PhpStorm.
 * User: jakubjastrzebski
 * Date: 31/05/2017
 * Time: 18:31
 */

namespace Wikia\PageHeader;

use RequestContext;
use WikiaApp;
use HtmlHelper;

class Categories {
	public function __construct( WikiaApp $app ) {
		$context = RequestContext::getMain();
		$categoryLinks = $context->getOutput()->getCategoryLinks();
		$normalCategoryLinks = $categoryLinks['normal'] ?? [];

		$visibleCategoriesLimit = 4;
		if ( count( $normalCategoryLinks ) > 4 ) {
			$visibleCategoriesLimit = 3;
		}
		$categories = array_slice( $normalCategoryLinks, 0, $visibleCategoriesLimit );
		$visibleCategories = $this->extendWithTrackingAttribute( $categories, 'categories-top' );
		$extendedCategories = array_slice( $normalCategoryLinks, $visibleCategoriesLimit );
		$moreCategories = $this->extendWithTrackingAttribute( $extendedCategories, 'categories-top-more' );

		$title = $app->wg->title;

		//$this->setVal( 'visibleCategories', $visibleCategories );
		$this->visibleCategories = $visibleCategories;
		//$this->setVal( 'inCategoriesText', wfMessage( 'pph-in-categories' )->escaped() ); //TODO
		$this->inCategoriesText = wfMessage( 'page-header-in-categories' )->escaped();
		//$this->setVal( 'moreCategoriesText', wfMessage( 'pph-categories-more' )->numParams( count( $moreCategories ) )->text() );
		$this->moreCategoriesText = wfMessage( 'page-header-categories-more' )->numParams( count( $moreCategories ) )->text();
		//$this->setVal( 'moreCategoriesSeparator', wfMessage( 'pph-categories-more-separator' )->text() );
		$this->moreCategoriesSeparator = wfMessage( 'page-header-categories-more-separator' )->text();
		//$this->setVal( 'moreCategoriesLength', count( $moreCategories ) );
		$this->moreCategoriesLength = count( $moreCategories );
		//$this->setVal( 'moreCategories', new Categories( $this->app ) );
		$this->moreCategories = $moreCategories;

		//No this class
		//$this->setVal( 'curatedContentButton', $this->getEditMainPage() );
		//$this->curatedContentButton = $this->getEditMainPage();
		////$this->setVal( 'languageList', $this->getLanguages() );
		//$this->languageList = $this->getLanguages();
	}

	public function hasVisibleCategories() {

		return count($this->visibleCategories) > 0;
	}

	private function extendWithTrackingAttribute( $categories, $prefix ): array {
		return array_map(
			function ( $link, $key ) use ( $prefix ) {
				$domLink = HtmlHelper::createDOMDocumentFromText( $link );
				$link = $domLink->getElementsByTagName( 'a' );
				if ( $link->length >= 1 ) {
					$link->item( 0 )->setAttribute( 'data-tracking', "{$prefix}-{$key}" );
				}

				return HtmlHelper::getBodyHtml( $domLink );
			},
			$categories,
			array_keys( $categories )
		);
	}

}
