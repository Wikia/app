<?php

class SpecialAchievementsSharing extends UnlistedSpecialPage {

	function __construct() {
		parent::__construct('AchievementsSharing');
	}

	function execute( $par ) {
		wfProfileIn(__METHOD__);

		global $wgOut, $wgRequest;

		if ( wfReadOnly() ) {
			$wgOut->readOnlyPage();
			wfProfileOut( __METHOD__ );
			return;
		}

		$articleID = $wgRequest->getInt('articleid');

		$title = Title::newFromID($articleID);

		if( !is_null( $title ) && $title->exists()) {
			if(strpos($_SERVER['HTTP_USER_AGENT'], 'facebook') === false && strpos($_SERVER['HTTP_USER_AGENT'], 'bitlybot') === false) {
				$sharerID = $wgRequest->getInt('userid');
				$viewerIP = $wgRequest->getIP();
				$awardingService = new AchAwardingService();
				$awardingService->processSharing($articleID, $sharerID, $viewerIP);
			}
		} else {
			$title = Title::newMainPage();
		}

		// this works only for Wikia and only in current varnish configuration
		if (!headers_sent()) {
			header('X-Pass-Cache-Control: no-store, private, no-cache, must-revalidate');
		}

		$wgOut->redirect($title->getLocalURL());

		wfProfileOut(__METHOD__);
	}
}
