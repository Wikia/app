<?php

/**
 * Main Category Gallery class
 */
class CategoryExhibitionSectionPages extends CategoryExhibitionSection {

	public $urlParameter = 'page'; // contains section url variable that stores pagination
	public $templateName = 'page';
	
	public function getSectionHTML(){
		global $wgCategoryExhibitionPagesSectionRows;
		$this->loadPaginationVars();
		$oTmpl = $this->getTemplateForNameSpace( NS_MAIN, $wgCategoryExhibitionPagesSectionRows * 4 );
		return $this->executeTemplate( $oTmpl );
	}

	public function getSectionAxHTML( $paginatorPosition, $sUrl ){
		global $wgCategoryExhibitionPagesSectionRows;
		$this->loadPaginationVars();
		$this->isFromAjax = true;
		$this->paginatorPosition = $paginatorPosition;
		$this->sUrl = $sUrl;
		$oTmpl = $this->getTemplateForNameSpace( NS_MAIN, $wgCategoryExhibitionPagesSectionRows * 4 );
		return $this->executeTemplate( $oTmpl );
	}
}