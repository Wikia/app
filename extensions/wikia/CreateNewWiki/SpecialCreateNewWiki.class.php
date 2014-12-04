<?php

class SpecialCreateNewWiki extends UnlistedSpecialPage {

	public function __construct() {
		parent::__construct('CreateNewWiki', 'createnewwiki');
	}

	public function execute() {
		global $wgUser, $wgOut, $wgExtensionsPath;
		wfProfileIn( __METHOD__ );

		if ( wfReadOnly() ) {
			$wgOut->readOnlyPage();
			wfProfileOut(__METHOD__);
			return;
		}

		if (!$wgUser->isAllowed('createnewwiki')) {
			$this->displayRestrictionError();
			wfProfileOut( __METHOD__ );
			return;
		}

		$wgOut->setPageTitle(wfMsg('cnw-title'));
		$wgOut->addHtml(F::app()->renderView('CreateNewWiki', 'Index'));
		$wgOut->addStyle(AssetsManager::getInstance()->getSassCommonURL('extensions/wikia/CreateNewWiki/css/CreateNewWiki.scss'));
		$wgOut->addScript('<script src="'.$wgExtensionsPath.'/wikia/ThemeDesigner/js/ThemeDesigner.js"></script>');
		$wgOut->addScript('<script src="'.$wgExtensionsPath.'/wikia/AjaxLogin/AjaxLogin.js"></script>');
		$wgOut->addScript('<script src="'.$wgExtensionsPath.'/wikia/CreateNewWiki/js/CreateNewWiki.js"></script>');
		$wgOut->addScript('<script src="'.$wgExtensionsPath.'/wikia/CreateNewWiki/js/CreateNewWikiSupplemental.js"></script>');
		$wgOut->addModules('wikia.stringhelper');
		$wgOut->addStyle(AssetsManager::getInstance()->getSassCommonURL('extensions/wikia/UserLogin/css/UserLoginModal.scss'));

		wfProfileOut( __METHOD__ );
	}

}
