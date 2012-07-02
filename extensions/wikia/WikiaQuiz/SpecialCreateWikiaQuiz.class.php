<?php

class SpecialCreateWikiaQuiz extends SpecialPage {

	function __construct() {
		parent::__construct("CreateQuiz", "", false);
	}

	public function execute ($subpage) {
		global $wgOut, $wgUser, $wgBlankImgUrl, $wgJsMimeType, $wgExtensionsPath, $wgStylePath, $wgStyleVersion;

		// Boilerplate special page permissions
		if ($wgUser->isBlocked()) {
			$wgOut->blockedPage();
			return;
		}
		if (!$wgUser->isAllowed('wikiaquiz')) {
			$this->displayRestrictionError();
			return;
		}
		if (wfReadOnly() && !wfAutomaticReadOnly()) {
			$wgOut->readOnlyPage();
			return;
		}

		$wgOut->addScript('<script src="'.$wgStylePath.'/common/jquery/jquery-ui-1.8.14.custom.js"></script>');
		$wgOut->addScript('<script src="'.$wgExtensionsPath.'/wikia/WikiaQuiz/js/CreateWikiaQuiz.js"></script>');

		$wgOut->addStyle(AssetsManager::getInstance()->getSassCommonURL('/extensions/wikia/WikiaQuiz/css/WikiaQuizBuilder.scss'));

		if( $subpage != '' ) {
			// We came here from the edit link, go into edit mode
			$wgOut->addHtml(wfRenderModule('WikiaQuiz', 'EditQuiz', array('title' => $subpage)));
		} else {
			$wgOut->addHtml(wfRenderModule('WikiaQuiz', 'CreateQuiz'));
		}
	}
}
?>
