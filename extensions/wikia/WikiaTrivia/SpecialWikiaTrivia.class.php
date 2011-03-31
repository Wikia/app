<?php

class SpecialWikiaTrivia extends UnlistedSpecialPage {

	public function __construct() {
		wfLoadExtensionMessages('WikiaTrivia');
		parent::__construct('WikiaTrivia', 'WikiaTrivia');
	}

	public function execute() {
		global $wgOut, $wgExtensionsPath, $wgUser;
		wfProfileIn( __METHOD__ );

		//wfLoadExtensionMessages('WikiBuilder');

		//$wgOut->setPageTitle(wfMsg('owb-title'));
		$wgOut->addHtml(wfRenderModule('WikiaTrivia'));
		$wgOut->addStyle(F::app()->getAssetsManager()->getSassCommonURL('extensions/wikia/WikiaTrivia/css/WikiaTrivia.scss'));
		$wgOut->addStyle('http://fonts.googleapis.com/css?family=Chewy');
		$wgOut->addScript('<script src="'.$wgExtensionsPath.'/wikia/WikiaTrivia/js/WikiaTrivia.js"></script>');

		wfProfileOut( __METHOD__ );
	}
}