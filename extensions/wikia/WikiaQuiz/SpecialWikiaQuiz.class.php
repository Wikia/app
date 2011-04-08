<?php

class SpecialWikiaQuiz extends UnlistedSpecialPage {

	public function __construct() {
		wfLoadExtensionMessages('WikiaQuiz');
		parent::__construct('WikiaQuiz', 'wikiaquiz');
	}

	public function execute() {
		global $wgOut, $wgExtensionsPath, $wgUser, $wgRequest;
		wfProfileIn( __METHOD__ );

		//wfLoadExtensionMessages('WikiBuilder');
		$wgOut->setPageTitle(wfMsg('Sample Quiz'));
		if ($wgRequest->getVal('v') == '2') {	
			$wgOut->addHtml(wfRenderModule('WikiaQuiz', 'SampleQuiz2'));
			$wgOut->addStyle(AssetsManager::getInstance()->getSassCommonURL('extensions/wikia/WikiaQuiz/css/WikiaQuiz2.scss'));
			$wgOut->addScript('<script src="'.$wgExtensionsPath.'/wikia/WikiaQuiz/js/WikiaQuiz2.js"></script>');
		} else {
			$wgOut->addHtml(wfRenderModule('WikiaQuiz', 'SampleQuiz'));
			$wgOut->addStyle(AssetsManager::getInstance()->getSassCommonURL('extensions/wikia/WikiaQuiz/css/WikiaQuiz.scss'));
			$wgOut->addStyle('http://fonts.googleapis.com/css?family=Chewy');
			$wgOut->addScript('<script src="'.$wgExtensionsPath.'/wikia/WikiaQuiz/js/WikiaQuiz.js"></script>');
		}

		wfProfileOut( __METHOD__ );
	}
}
