<?php

class SiteWideMessagesController extends WikiaController  {

	const CACHE_VALIDITY_VARNISH = 10800; // 3 hours
	const CACHE_VALIDITY_BROWSER = 3600; // 1 hour

	public function getAnonMessages() {
		if ( $this->wg->User->isLoggedIn() ) {
			// Don't return anything if this happens
			$this->skipRendering();
			return;
		}

		$this->hasNotifications = $this->request->getBool( 'hasnotifications' );

		$msgs = SiteWideMessages::getAllAnonMessages( $this->wg->User, false, false );

		// Filter dismissed messages
		foreach ( $msgs as $msgId => $msgData ) {
			if ( isset( $_COOKIE[$this->wg->CookiePrefix . 'swm-' . $msgId] ) ) {
				unset( $msgs[$msgId] );
			}
		}

		$this->siteWideMessages = $msgs;
		$this->notificationType = NotificationsController::NOTIFICATION_SITEWIDE;

		$this->response->setCacheValidity( self::CACHE_VALIDITY_VARNISH, self::CACHE_VALIDITY_BROWSER );
	}

	public function dismissAnonMessage() {
		if ( !$this->wg->User->isLoggedIn() ) {
			$messageId = $this->request->getInt( 'messageid' );
			if ( $messageId > 0 ) {
				$this->wg->Request->response()->setcookie( 'swm-' . $messageId, 1, time() + 86400 /*24h*/ );
			}
		}
	}

}
