<?php

class DesignSystemGlobalNavigationWallNotificationsService extends GlobalNavigationWallNotificationsController {
	protected function addAssets() {
		$this->getContext()->getOutput()->addModules( 'ext.designSystem.wallNotifications' );
	}
}
