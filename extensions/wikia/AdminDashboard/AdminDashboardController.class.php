<?php

class AdminDashboardController extends WikiaController {

	// Render the Admin Dashboard chrome
	public function executeChrome () {
		global $wgRequest, $wgTitle;

		$resolvedAlias = SpecialPageFactory::resolveAlias( $wgTitle->getDBKey() );

		$this->tab = $wgRequest->getVal( 'tab', '' );
		if (
			( empty( $this->tab ) && $this->isAdminDashboardTitle() ) ||
			( !empty( $this->tab ) && !in_array( $this->tab, [ 'general', 'advanced' ] ) ) ||
			AdminDashboardLogic::isGeneralApp( array_shift( $resolvedAlias ) )
		) {
			$this->tab = 'general';
		} elseif ( empty( $this->tab ) ) {
			$this->tab = 'advanced';
		}

		$this->response->addAsset('extensions/wikia/AdminDashboard/css/AdminDashboard.scss');
		$this->response->addAsset('extensions/wikia/AdminDashboard/js/AdminDashboard.js');

		$this->isAdminDashboard = $this->isAdminDashboardTitle();
		$this->adminDashboardUrl = Title::newFromText('AdminDashboard', NS_SPECIAL)->getFullURL( [ 'tab' => $this->tab ] );
		$this->adminDashboardUrlGeneral = Title::newFromText('AdminDashboard', NS_SPECIAL)->getFullURL( [ 'tab' => 'general' ] );
		$this->adminDashboardUrlAdvanced = Title::newFromText('AdminDashboard', NS_SPECIAL)->getFullURL( [ 'tab' => 'advanced' ] );
	}

	public function executeRail () {
		if (!$this->isAdminDashboardTitle()) {
			$this->skipRendering();
		}
	}

	private function isAdminDashboardTitle() {
		global $wgTitle;
		$adminDashboardTitle = SpecialPage::getTitleFor( 'AdminDashboard' );
		return $wgTitle->getText() == $adminDashboardTitle->getText();
	}

}
