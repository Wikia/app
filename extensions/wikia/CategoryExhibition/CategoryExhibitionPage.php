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

	protected $mCategoryViewerClass = 'CategoryExhibitionViewer';

	function closeShowCategory() {
		$viewer = new $this->mCategoryViewerClass( $this->getContext()->getTitle(), $this->getContext() );
		$this->getContext()->getOutput()->addHTML( $viewer->getHTML() );
	}
}

class CategoryExhibitionViewer extends CategoryViewer {
	var	$title, $limit, $from, $until,
		$articles, $articles_start_char,
		$children, $children_start_char,
		$showGallery, $gallery,
		$skin;

	/**
	 * Format the category data list.
	 *
	 * @return string HTML output
	 */
	function getHTML() {
		wfProfileIn( __METHOD__ );

		$r = $this->getPagesSection().
			$this->getSubcategorySection().
			$this->getBlogsSection().
			$this->getMediaSection();

		// Give a proper message if category is empty
		if ( $r == '' ) {
			$r = $this->msg( 'category-empty' )->parse();
		}

		wfProfileOut( __METHOD__ );
		return $r;
	}

	function getSubcategorySection() {
		$oSection = new CategoryExhibitionSectionSubcategories( $this->title);
		return $oSection->getSectionHTML();
	}

	function getPagesSection() {
		$oSection = new CategoryExhibitionSectionPages( $this->title );
		return $oSection->getSectionHTML();
	}

	function getMediaSection() {
		$oSection = new CategoryExhibitionSectionMedia( $this->title );
		return $oSection->getSectionHTML();
	}

	function getBlogsSection(){
		$oSection = new CategoryExhibitionSectionBlogs( $this->title );
		return $oSection->getSectionHTML();
	}

	function getSection( $oSection, $paginatorVariable ){
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
