<?php

/**
 * ArticleComments
 *
 * A ArticleComments extension for MediaWiki
 * Adding comment functionality on article pages
 *
 * @author Jakub Kurcek  <jakub@wikia.inc>
 * @copyright Copyright (C) 2010 Jakub Kurcek, Wikia Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 * @package MediaWiki
 *
 */

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
	 * Returns section html.
	 *
	 * @param $class string
	 * @return string
	 */

	static private function getSection( $class ){
		global $wgRequest;
		
		$pageText = $wgRequest->getVal( 'articleId' );
		$iPaginatorPosition = (int)$wgRequest->getVal( 'page' );
		$oCategoryTitle = Title::newFromText( $pageText, NS_CATEGORY );
		if ( !is_object( $oCategoryTitle ) ){
			return '';
		}
		$oSection = new $class( $oCategoryTitle );
		$sUrl = $oCategoryTitle->getFullURL();

		$result = $oSection->getSectionAxHTML( $iPaginatorPosition, $sUrl );
		
		return $result;
	}

}