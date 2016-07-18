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

		// exclude 700 (NS_TOPLIST), 701 (NS_TOPLIST_TALK)
		// if TopList extension which defines them is disabled
		if(empty(F::app()->wg->enableTopListsExt)) {
			if(!in_array(700,$excludes)) {
				$excludes []= 700;
			}
			if(!in_array(701,$excludes)) {
				$excludes []= 701;
			}
		}

		return $excludes;
	}
}
