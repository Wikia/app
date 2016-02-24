<?php

abstract class SpecialBlogPage extends SpecialPage {

	protected $mFormData = array();
	protected $mFormErrors = array();
	protected $mPreviewTitle = '';

	/** @var BlogArticle */
	protected $mPostArticle = null;

	abstract protected function renderForm();
	abstract protected function parseFormData();
	abstract protected function save();

	protected function getCategoriesAsText ( $aCategories ) {
		global $wgContLang;

		$sText = '';
		$sCategoryNSName = $wgContLang->getFormattedNsText( NS_CATEGORY );

		foreach ( $aCategories as $sCategory ) {
			if ( !empty( $sCategory ) ) {
				$sText .= "\n[[" . $sCategoryNSName . ":" . $sCategory . "]]";
			}
		}

		return $sText;
	}


	public function setFormData( $sKey, $value ) {
		$this->mFormData[$sKey] = $value;
	}

	public function setFormErrors( $sKey, $value ) {
		$this->mFormErrors[$sKey] = $value;
	}

}
