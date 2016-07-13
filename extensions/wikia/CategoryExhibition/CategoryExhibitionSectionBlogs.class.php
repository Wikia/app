<?php

/**
 * Main Category Gallery class
 */
class CategoryExhibitionSectionBlogs extends CategoryExhibitionSection {

	public $urlParameter = 'blogs'; // contains section url variable that stores pagination
	public $templateName = 'blogs';

	public function getSectionHTML(){

		global $wgCategoryExhibitionBlogsSectionRows;
		$oTmpl = $this->getTemplateForNameSpace( 500, $wgCategoryExhibitionBlogsSectionRows * 4 );
		return $this->executeTemplate( $oTmpl );
	}

	public function getSectionAxHTML( $paginatorPosition, $sUrl ){

		global $wgCategoryExhibitionBlogsSectionRows;
		$this->isFromAjax = true;
		$this->paginatorPosition = $paginatorPosition;
		$this->sUrl = $sUrl;
		$oTmpl = $this->getTemplateForNameSpace( 500, $wgCategoryExhibitionBlogsSectionRows * 4 );
		return $this->executeTemplate( $oTmpl );
	}
}