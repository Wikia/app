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
		$oTmpl = $this->getTemplateForNameSpace( array( 500, NS_FILE, NS_VIDEO, NS_CATEGORY ), $wgCategoryExhibitionPagesSectionRows * 4, true );
		return $this->executeTemplate( $oTmpl );
	}

	public function getSectionAxHTML( $paginatorPosition, $sUrl ){
		global $wgCategoryExhibitionPagesSectionRows, $wgContentNamespaces;
		$this->loadPaginationVars();
		$this->isFromAjax = true;
		$this->paginatorPosition = $paginatorPosition;
		$this->sUrl = $sUrl;
		$oTmpl = $this->getTemplateForNameSpace( array( 500, NS_FILE, NS_VIDEO, NS_CATEGORY ), $wgCategoryExhibitionPagesSectionRows * 4, true );
		return $this->executeTemplate( $oTmpl );
	}

	protected function getTitleForElement( $oTitle ){
		return $oTitle->getPrefixedText();
	}
}
