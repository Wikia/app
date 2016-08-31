<?php

class DesignSystemGlobalNavigationService extends WikiaService {
	public function index() {

		$this->response->addAsset( 'extensions/wikia/GlobalNavigation/styles/GlobalNavigationNotifications.scss' );
		$this->response->addAsset( 'wall_notifications_global_navigation_js' );
	}
}
