<?php
/**
 * Special handling for category description pages
 * Modelled after ImagePage.php
 *
 */

if( !defined( 'MEDIAWIKI' ) )
	die( 1 );

/**
 */
class CategoryExhibitionPage extends CategoryPageII {

	var $viewerClass = 'CategoryExhibitionViewer';

	function closeShowCategory() {
		global $wgOut, $wgRequest;
		$viewer = new $this->viewerClass( $this->mTitle );
		$wgOut->addHTML( $viewer->getHTML() );
	}
}

class CategoryExhibitionViewer extends CategoryPageIIViewer {
	var	$title, $limit, $from, $until,
		$articles, $articles_start_char,
		$children, $children_start_char,
		$showGallery, $gallery,
		$skin;

	/** Category object for this page */
	private $cat;

	function __construct( $title, $from = '', $until = '' ) {
		global $wgCategoryPagingLimit;
		$this->title = $title;
		$this->from = $from;
		$this->until = $until;
		$this->limit = $wgCategoryPagingLimit;
		$this->cat = Category::newFromTitle( $title );
	}

	/**
	 * Format the category data list.
	 *
	 * @return string HTML output
	 * @private
	 */
	function getHTML() {
		global $wgOut, $wgCategoryMagicGallery, $wgCategoryPagingLimit;
		wfProfileIn( __METHOD__ );

		$r = $this->getPagesSection().
			$this->getSubcategorySection().
			$this->getBlogsSection().
			$this->getMediaSection();
			
		// Give a proper message if category is empty
		if ( $r == '' ) {
			$r = wfMsgExt( 'category-empty', array( 'parse' ) );
		}

		wfProfileOut( __METHOD__ );
		return $r;
	}

	function getSubcategorySection() {
		$oSection = new CategoryExhibitionSectionSubcategories( $this->cat->getTitle() );
		return $oSection->getSectionHTML();
	}

	function getPagesSection() {
		$oSection = new CategoryExhibitionSectionPages( $this->cat->getTitle() );
		return $oSection->getSectionHTML();
	}

	function getMediaSection() {
		$oSection = new CategoryExhibitionSectionMedia( $this->cat->getTitle() );
		return $oSection->getSectionHTML();
	}

	function getBlogsSection(){
		$oSection = new CategoryExhibitionSectionBlogs( $this->cat->getTitle() );
		return $oSection->getSectionHTML();
	}

	function getSection( $oSection, $paginatorVariable ){
		$categoryTitle = $this->cat->getTitle();
		return $oSection->getSectionHTML();
	}

	function getOtherSection() {
		$r = "";
		wfRunHooks( "CategoryViewer::getOtherSection", array( &$this, &$r ) );
		return $r;
	}

	function getCategoryBottom() {
		if( $this->until != '' ) {
			return $this->pagingLinks( $this->title, $this->nextPage, $this->until, $this->limit );
		} elseif( $this->nextPage != '' || $this->from != '' ) {
			return $this->pagingLinks( $this->title, $this->from, $this->nextPage, $this->limit );
		} else {
			return '';
		}
	}

}
