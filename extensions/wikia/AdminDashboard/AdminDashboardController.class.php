<?php

class AdminDashboardController extends WikiaController {
		
	// Render the Admin Dashboard chrome
	public function executeChrome () {
		global $wgRequest, $wgTitle;
		
		$adminDashboardTitle = Title::newFromText('AdminDashboard', NS_SPECIAL);
		$this->isAdminDashboard = $wgTitle->getText() == $adminDashboardTitle->getText();

		$this->tab = $wgRequest->getVal("tab", "");
		if(empty($this->tab) && $this->isAdminDashboard) {
			$this->tab = 'general';
		} else if(AdminDashboardLogic::isGeneralApp(array_shift(SpecialPageFactory::resolveAlias($wgTitle->getDBKey())))) {
			$this->tab = 'general';
		} else if(empty($this->tab)) {
			$this->tab = 'advanced';
		}

		if( $this->wg->User->isLoggedIn() ) {
		//fix for fb#49394 -- the page for anons looks better without this stylesheet
			$this->wg->Out->addStyle(AssetsManager::getInstance()->getSassCommonURL('extensions/wikia/AdminDashboard/css/AdminDashboard.scss'));
		}
		
		$this->wg->Out->addScriptFile($this->wg->ExtensionsPath . '/wikia/AdminDashboard/js/AdminDashboard.js');
		
		$this->adminDashboardUrl = Title::newFromText('AdminDashboard', NS_SPECIAL)->getFullURL("tab=$this->tab");
		$this->adminDashboardUrlGeneral = Title::newFromText('AdminDashboard', NS_SPECIAL)->getFullURL("tab=general");
		$this->adminDashboardUrlAdvanced = Title::newFromText('AdminDashboard', NS_SPECIAL)->getFullURL("tab=advanced");
		
	}
	
}
