<?php

class DesignSystemGlobalNavigationOnSiteNotificationsService extends WikiaService {

	public function Index() {
		$context = $this->getContext();

		if ( $context->getUser()->isLoggedIn() ) {
			$context->getOutput()->addModules( 'ext.designSystem.onSiteNotifications' );
			return true;
		}

		return false;
	}
}
