<?php

class SpecialWikiaQuiz extends UnlistedSpecialPage {

	public function __construct() {
		wfLoadExtensionMessages('WikiaQuiz');
		parent::__construct('WikiaQuiz', 'wikiaquiz');
	}

	public function execute() {
		global $wgOut, $wgExtensionsPath, $wgUser;
		wfProfileIn( __METHOD__ );

		//wfLoadExtensionMessages('WikiBuilder');

		//$wgOut->setPageTitle(wfMsg('owb-title'));
		$wgOut->addHtml(wfRenderModule('WikiaQuiz', 'SampleQuiz'));
		$wgOut->addStyle(AssetsManager::getInstance()->getSassCommonURL('extensions/wikia/WikiaQuiz/css/WikiaQuiz.scss'));
		$wgOut->addStyle('http://fonts.googleapis.com/css?family=Chewy');
		//$wgOut->addScript('<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js"></script>');
		$wgOut->addScript('<script src="'.$wgExtensionsPath.'/wikia/WikiaQuiz/js/WikiaQuiz.js"></script>');

		wfProfileOut( __METHOD__ );
	}
}
