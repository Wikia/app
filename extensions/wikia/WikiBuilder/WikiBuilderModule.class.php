<?php
class WikiBuilderModule extends Module {

	var $messages;
	var $userName;
	var $wgBlankImgUrl;
	var $wgExtensionsPath;
	var $wgLanguageCode;
	var $wgOasisThemes;
	var $wgStylePath;
	var $wgWikiPaymentAdsFreePrice;

	public function executeIndex() {
		global $wgOut, $wgSuppressWikiHeader, $wgSuppressPageHeader, $wgSuppressFooter, $wgSuppressAds, $wgUser;
		wfProfileIn( __METHOD__ );

		$wgSuppressWikiHeader = true;
		$wgSuppressPageHeader = true;
		$wgSuppressFooter = true;
		$wgSuppressAds = true;

		//messages used in JS
		$this->messages['owb-unable-to-edit-description'] = wfMsgForContent('owb-unable-to-edit-description');
		$this->messages['owb-status-saving'] = wfMsgForContent('owb-status-saving');
		$this->messages['owb-readonly-try-again'] = wfMsgForContent('owb-readonly-try-again');
		$this->messages['owb-status-saving'] = wfMsgForContent('owb-status-saving');
		$this->messages['owb-status-saving'] = wfMsgForContent('owb-status-saving');
		$this->messages['owb-new-pages-text'] = wfMsgForContent('owb-new-pages-text');
		$this->messages['owb-error-saving-articles'] = wfMsgForContent('owb-error-saving-articles');
		$this->messages['owb-unable-to-edit-description'] = wfMsgForContent('owb-unable-to-edit-description');
		$this->messages['owb-api-error-title'] = wfMsgForContent('owb-api-error-title');
		$this->messages['owb-api-error'] = wfMsgForContent('owb-api-error');

		$this->userName = $wgUser->getName();

		wfProfileOut( __METHOD__ );
	}
}