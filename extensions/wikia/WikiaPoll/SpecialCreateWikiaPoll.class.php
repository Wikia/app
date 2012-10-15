<?php

class SpecialCreateWikiaPoll extends SpecialPage {

	function __construct() {
		parent::__construct("CreatePoll", "", false);
	}

	public function execute ($subpage) {
		global $wgOut, $wgUser, $wgExtensionsPath, $wgResourceBasePath;

		// Boilerplate special page permissions
		if ($wgUser->isBlocked()) {
			throw new UserBlockedError( $this->getUser()->mBlock );
		}
		if (wfReadOnly() && !wfAutomaticReadOnly()) {
			$wgOut->readOnlyPage();
			return;
		}
		if (!$wgUser->isAllowed('createpage') || !$wgUser->isAllowed('edit')) {
			$this->displayRestrictionError();
			return;
		}

		$wgOut->addScript('<script src="'.$wgResourceBasePath.'/resources/wikia/libraries/jquery-ui/jquery-ui-1.8.14.custom.js"></script>');
		$wgOut->addScript('<script src="'.$wgExtensionsPath.'/wikia/WikiaPoll/js/CreateWikiaPoll.js"></script>');

		$wgOut->addStyle(AssetsManager::getInstance()->getSassCommonURL('/extensions/wikia/WikiaPoll/css/CreateWikiaPoll.scss'));

		if( $subpage != '' ) {
			// We came here from the edit link, go into edit mode
			$wgOut->addHtml(F::app()->renderView('WikiaPoll', 'SpecialPageEdit', array('title' => $subpage)));
		} else {
			$wgOut->addHtml(F::app()->renderView('WikiaPoll', 'SpecialPage'));
		}
	}
}
