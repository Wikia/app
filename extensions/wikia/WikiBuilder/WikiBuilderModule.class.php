<?php
class WikiBuilderModule extends WikiaController {

	public function executeIndex() {
		global $wgSuppressWikiHeader, $wgSuppressPageHeader, $wgSuppressFooter, $wgSuppressAds, $wgUser;
		wfProfileIn( __METHOD__ );

		$wgSuppressWikiHeader = true;
		$wgSuppressPageHeader = true;
		$wgSuppressFooter = true;
		$wgSuppressAds = true;

		//messages used in JS
		$messages['owb-unable-to-edit-description'] = wfMsgForContent('owb-unable-to-edit-description');
		$messages['owb-status-saving'] = wfMsgForContent('owb-status-saving');
		$messages['owb-readonly-try-again'] = wfMsgForContent('owb-readonly-try-again');
		$messages['owb-status-saving'] = wfMsgForContent('owb-status-saving');
		$messages['owb-status-saving'] = wfMsgForContent('owb-status-saving');
		$messages['owb-new-pages-text'] = wfMsgForContent('owb-new-pages-text');
		$messages['owb-error-saving-articles'] = wfMsgForContent('owb-error-saving-articles');
		$messages['owb-unable-to-edit-description'] = wfMsgForContent('owb-unable-to-edit-description');
		$messages['owb-api-error-title'] = wfMsgForContent('owb-api-error-title');
		$messages['owb-api-error'] = wfMsgForContent('owb-api-error');

		$this->messages = $messages;
		$this->userName = $wgUser->getName();

		wfProfileOut( __METHOD__ );
	}
}