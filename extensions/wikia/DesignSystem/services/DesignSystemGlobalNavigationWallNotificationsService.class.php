<?php

class DesignSystemGlobalNavigationWallNotificationsService extends GlobalNavigationWallNotificationsController {
	protected function addAssets() {
		$this->response->addAsset( 'extensions/wikia/GlobalNavigation/styles/GlobalNavigationNotifications.scss' );
		$this->response->addAsset( 'extensions/wikia/DesignSystem/scripts/DesignSystemGlobalNavigationNotifications.js' );
	}
}
