<?php
/**
 * Created by PhpStorm.
 * User: jakubjastrzebski
 * Date: 31/05/2017
 * Time: 18:31
 */

namespace Wikia\PageHeader;

use WikiaApp;

class Categories {
	public function __construct( WikiaApp $app ) {

		$categoryLinks = $this->getContext()->getOutput()->getCategoryLinks();
		$normalCategoryLinks = $categoryLinks['normal'] ?? [];

		$visibleCategoriesLimit = 4;
		if ( count( $normalCategoryLinks ) > 4 ) {
			$visibleCategoriesLimit = 3;
		}
		$categories = array_slice( $normalCategoryLinks, 0, $visibleCategoriesLimit );
		//$visibleCategories = $this->extendWithTrackingAttribute( $categories, 'categories-top' );
		//$extendedCategories = array_slice( $normalCategoryLinks, $visibleCategoriesLimit );
		//$moreCategories = $this->extendWithTrackingAttribute( $extendedCategories, 'categories-top-more' );

//		$title = $app->wg->title;
//		$this->setVal( 'inCategoriesText', wfMessage( 'pph-in-categories' )->escaped() );
//		//$this->setVal( 'visibleCategories', $visibleCategories );
//		$this->setVal( 'moreCategoriesText', wfMessage( 'pph-categories-more' )->numParams( count( $moreCategories ) )->text() );
//		$this->setVal( 'moreCategoriesSeparator', wfMessage( 'pph-categories-more-separator' )->text() );
//		$this->setVal( 'moreCategoriesLength', count( $moreCategories ) );
//		$this->setVal( 'moreCategories', $moreCategories );
//		$this->setVal( 'curatedContentButton', $this->getEditMainPage() );
//		$this->setVal( 'languageList', $this->getLanguages() );
//	}
//
//private function extendWithTrackingAttribute( $categories, $prefix ): array {
//	return array_map( function ( $link, $key ) use ( $prefix ) {
//		$domLink = HtmlHelper::createDOMDocumentFromText( $link );
//		$link = $domLink->getElementsByTagName( 'a' );
//		if ( $link->length >= 1 ) {
//			$link->item( 0 )->setAttribute( 'data-tracking', "{$prefix}-{$key}" );
//		}
//
//		return HtmlHelper::getBodyHtml( $domLink );
//	}, $categories, array_keys( $categories ) );
}
}
