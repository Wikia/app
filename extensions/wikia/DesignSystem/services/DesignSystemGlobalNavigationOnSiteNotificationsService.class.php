<?php

class DesignSystemGlobalNavigationOnSiteNotificationsService extends WikiaService {

	public function Index() {
		$isLoggedIn = $this->isLoggedIn();
		$this->response->setVal( 'loggedIn', $isLoggedIn );

		if ( $isLoggedIn && $this->areNotificationsEnabled() ) {
			$this->addAssets();

			return true;
		} else {
			return false;
		}
	}

	private function isLoggedIn() {
		global $wgUser;
		$loggedIn = $wgUser->isLoggedIn();

		return $loggedIn;
	}

	private function areNotificationsEnabled() {
		global $wgEnableOnSiteNotifications;

		return !empty( $wgEnableOnSiteNotifications );
	}

	private function addAssets() {
		OasisController::addSkinAssetGroup( 'on_site_notifications_js' );
	}

}
