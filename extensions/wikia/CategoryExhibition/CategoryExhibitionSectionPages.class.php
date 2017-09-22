<?php

/**
 * Main Category Gallery class
 */
class CategoryExhibitionSectionPages extends CategoryExhibitionSection {
	protected function generateSectionData(){
		global $wgCategoryExhibitionPagesSectionRows;
		$this->sectionId = 'mw-pages';
		$this->headerMessage = wfMessage( 'category-exhibition-page-header', $this->categoryTitle->getText() );
		return $this->generateData( $this->getExcludes(), $wgCategoryExhibitionPagesSectionRows * 4, true );
	}

	protected function getTitleForElement( $oTitle ){
		return $oTitle->getPrefixedText();
	}

	protected function getExcludes() {
		$excludes = array (
			500, NS_FILE, NS_CATEGORY
		);

		return $excludes;
	}
}
