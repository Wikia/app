<?php

/**
 * Main Category Gallery class
 */
class CategoryExhibitionSectionPages extends CategoryExhibitionSection {

	public $urlParameter = 'page'; // contains section url variable that stores pagination
	public $templateName = 'page';

	public function getSectionHTML(){
		global $wgCategoryExhibitionPagesSectionRows, $wgOut;
		$this->loadPaginationVars();
		$oTmpl = $this->getTemplateForNameSpace( $this->getExcludes(), $wgCategoryExhibitionPagesSectionRows * 4, true );
		$wgOut->addHeadItem( 'Paginator', $oTmpl->mVars['paginatorHead'] );
		return $this->executeTemplate( $oTmpl );
	}

	public function getSectionAxHTML( $paginatorPosition, $sUrl ){
		global $wgCategoryExhibitionPagesSectionRows;
		$this->loadPaginationVars();
		$this->isFromAjax = true;
		$this->paginatorPosition = $paginatorPosition;
		$this->sUrl = $sUrl;
		$oTmpl = $this->getTemplateForNameSpace( $this->getExcludes(), $wgCategoryExhibitionPagesSectionRows * 4, true );
		return $this->executeTemplate( $oTmpl );
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
