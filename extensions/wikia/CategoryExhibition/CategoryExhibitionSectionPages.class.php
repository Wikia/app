<?php

/**
 * Main Category Gallery class
 */
class CategoryExhibitionSectionPages extends CategoryExhibitionSection {

	public $urlParameter = 'page'; // contains section url variable that stores pagination
	public $templateName = 'page';
	
	public function getSectionHTML(){
		$this->loadPaginationVars();
		$oTmpl = $this->getTemplateForNameSpace( NS_MAIN );
		return $this->executeTemplate( $oTmpl );
	}

	public function getSectionAxHTML( $paginatorPosition, $sUrl ){
		$this->isFromAjax = true;
		$this->paginatorPosition = $paginatorPosition;
		$this->sUrl = $sUrl;
		$oTmpl = $this->getTemplateForNameSpace( NS_MAIN );
		return $this->executeTemplate( $oTmpl );
	}
}