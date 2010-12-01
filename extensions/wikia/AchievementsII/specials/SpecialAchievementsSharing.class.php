<?php

class SpecialAchievementsSharing extends SpecialPage {

	function __construct() {
		wfLoadExtensionMessages('AchievementsII');
		parent::__construct('AchievementsSharing');
	}

	function execute() {
		wfProfileIn(__METHOD__);
		
		global $wgOut, $wgRequest;

		$articleID = $wgRequest->getInt('articleid');
		
		$title = Title::newFromID($articleID);
		
		if($title->exists()) {
			if(strpos($_SERVER['HTTP_USER_AGENT'], 'facebook') === false && strpos($_SERVER['HTTP_USER_AGENT'], 'bitlybot') === false) {		
				$sharerID = $wgRequest->getInt('userid');
				$viewerIP = wfGetIP();
				$awardingService = new AchAwardingService();
				$awardingService->processSharing($articleID, $sharerID, $viewerIP);
			}
		} else {
			$title = Title::newMainPage();
		}
		
		$wgOut->redirect($title->getLocalURL(), 303);

		wfProfileOut(__METHOD__);
	}
}
