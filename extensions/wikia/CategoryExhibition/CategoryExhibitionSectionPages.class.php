<?php

/**
 * Main Category Gallery class
 */
class CategoryExhibitionSectionPages extends CategoryExhibitionSection {

	public $urlParameter = 'page'; // contains section url variable that stores pagination
	public $templateName = 'page';
	
	public function getSectionHTML(){
		global $wgCategoryExhibitionPagesSectionRows, $wgContentNamespaces;
		$this->loadPaginationVars();
		$oTmpl = $this->getTemplateForNameSpace( $wgContentNamespaces, $wgCategoryExhibitionPagesSectionRows * 4 );
		return $this->executeTemplate( $oTmpl );
	}

	public function getSectionAxHTML( $paginatorPosition, $sUrl ){
		global $wgCategoryExhibitionPagesSectionRows, $wgContentNamespaces;
		$this->loadPaginationVars();
		$this->isFromAjax = true;
		$this->paginatorPosition = $paginatorPosition;
		$this->sUrl = $sUrl;
		$oTmpl = $this->getTemplateForNameSpace( $wgContentNamespaces, $wgCategoryExhibitionPagesSectionRows * 4 );
		return $this->executeTemplate( $oTmpl );
	}
}
