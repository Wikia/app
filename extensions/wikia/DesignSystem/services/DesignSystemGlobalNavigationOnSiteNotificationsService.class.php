<?php

class DesignSystemGlobalNavigationOnSiteNotificationsService extends WikiaService {

	public function Index() {
		if ( $this->isLoggedIn() && $this->areNotificationsEnabled() ) {
			$this->addAssets();

			return true;
		} else {
			return false;
		}
	}

	private function isLoggedIn() {
		global $wgUser;

		return $wgUser->isLoggedIn();
	}

	private function areNotificationsEnabled() {
		global $wgEnableOnSiteNotifications;

		return !empty( $wgEnableOnSiteNotifications );
	}

	private function addAssets() {
		OasisController::addSkinAssetGroup( 'design_system_on_site_notifications_js' );
	}

}
