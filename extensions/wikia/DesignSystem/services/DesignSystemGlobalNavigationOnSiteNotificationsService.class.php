<?php

class DesignSystemGlobalNavigationOnSiteNotificationsService extends WikiaService {
	const NOTIFICATION_TITLE_LIMIT = 48;

	public function Index() {
		global $wgUser;
		$loggedIn = $wgUser->isLoggedIn();
		$this->response->setVal( 'loggedIn', $loggedIn );
		if ( $loggedIn ) {
			$this->response->setVal( 'prehide', false );
		}
	}

}
