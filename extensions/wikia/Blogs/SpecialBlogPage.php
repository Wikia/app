<?php

abstract class SpecialBlogPage extends SpecialPage {

	protected $mFormData = array();
	protected $mFormErrors = array();
	protected $mPreviewTitle = '';
	protected $mPostArticle = null;

	abstract protected function renderForm();
	abstract protected function parseFormData();
	abstract protected function save();

	protected function getCategoriesAsText ($aCategories) {
		global $wgContLang;

		$sText = '';
		$sCategoryNSName = $wgContLang->getFormattedNsText( NS_CATEGORY );

		foreach($aCategories as $sCategory) {
			if(!empty($sCategory)) {
				$sText .= "\n[[" . $sCategoryNSName . ":" . $sCategory . "]]";
			}
		}

		return $sText;
	}

	public static function alternateEditHook(&$oEditPage) {
		global $wgOut;
		$oTitle = $oEditPage->mTitle;
		if($oTitle->getNamespace() == NS_BLOG_LISTING) {
			$oSpecialPageTitle = Title::newFromText('CreateBlogListingPage', NS_SPECIAL);
			$wgOut->redirect($oSpecialPageTitle->getFullUrl("article=" . urlencode($oTitle->getText())));
		}
		if($oTitle->getNamespace() == NS_BLOG_ARTICLE && $oTitle->isSubpage() ) {
			$oSpecialPageTitle = Title::newFromText('CreateBlogPage', NS_SPECIAL);
			$wgOut->redirect($oSpecialPageTitle->getFullUrl("article=" . urlencode($oTitle->getText())));
		}
		return true;
	}

	public function setFormData($sKey, $value) {
		$this->mFormData[$sKey] = $value;
	}

}
