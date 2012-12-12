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

		$this->response->addAsset('extensions/wikia/AdminDashboard/css/AdminDashboard.scss');
		$this->response->addAsset('extensions/wikia/AdminDashboard/js/AdminDashboard.js');

		if( $this->wg->EnableVideoToolExt && $this->wg->EnableSpecialVideosExt ) {
		//FB#68272
			$this->response->addAsset('extensions/wikia/VideoHandlers/js/AddVideo.js');
		}
		
		$this->adminDashboardUrl = Title::newFromText('AdminDashboard', NS_SPECIAL)->getFullURL("tab=$this->tab");
		$this->adminDashboardUrlGeneral = Title::newFromText('AdminDashboard', NS_SPECIAL)->getFullURL("tab=general");
		$this->adminDashboardUrlAdvanced = Title::newFromText('AdminDashboard', NS_SPECIAL)->getFullURL("tab=advanced");
	}
	
}
