<?php

class SpecialCreateWikiaQuiz extends SpecialPage {

	function __construct() {
		parent::__construct("CreateQuiz", "", false);
	}

	public function execute ($subpage) {
		global $wgOut, $wgUser, $wgExtensionsPath, $wgResourceBasePath;

		// Boilerplate special page permissions
		if ($wgUser->isBlocked()) {
			throw new UserBlockedError( $this->getUser()->mBlock );
		}
		if (!$wgUser->isAllowed('wikiaquiz')) {
			$this->displayRestrictionError();
			return;
		}
		if (wfReadOnly() && !wfAutomaticReadOnly()) {
			$wgOut->readOnlyPage();
			return;
		}

		$wgOut->addModules("wikia.jquery.ui");
		$wgOut->addScript('<script src="'.$wgExtensionsPath.'/wikia/WikiaQuiz/js/CreateWikiaQuiz.js"></script>');

		$wgOut->addStyle(AssetsManager::getInstance()->getSassCommonURL('/extensions/wikia/WikiaQuiz/css/WikiaQuizBuilder.scss'));

		if( $subpage != '' ) {
			// We came here from the edit link, go into edit mode
			$wgOut->addHtml(F::app()->renderView('WikiaQuiz', 'EditQuiz', array('title' => $subpage)));
		} else {
			$wgOut->addHtml(F::app()->renderView('WikiaQuiz', 'CreateQuiz'));
		}
	}
}
