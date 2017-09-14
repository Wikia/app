<?php

/**
 * Main Category Gallery class
 */
class CategoryExhibitionSectionBlogs extends CategoryExhibitionSection {
	protected function generateSectionData() {
		global $wgCategoryExhibitionBlogsSectionRows;
		$this->sectionId = 'mw-blogs';
		$this->headerMessage = wfMessage( 'category-exhibition-blogs-header' );
		$this->generateData( 500, $wgCategoryExhibitionBlogsSectionRows * 4 );
	}
}
