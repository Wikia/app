<?php

class SiteWideMessagesController extends WikiaController  {

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
