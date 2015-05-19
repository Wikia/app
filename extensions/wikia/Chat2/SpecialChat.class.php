<?php

class SpecialChat extends UnlistedSpecialPage {

	public function __construct() {
		parent::__construct( 'Chat', 'chat' );
	}

	public function execute() {
		wfProfileIn( __METHOD__ );
		global $wgUser, $wgOut;

		// check if logged in
		if ( $wgUser->isLoggedIn() ) {
			if ( Chat::canChat( $wgUser ) ) {
				ChatHelper::info( __METHOD__ . ': Method called - success' );
				Wikia::setVar( 'OasisEntryControllerName', 'Chat' );
				Chat::logChatWindowOpenedEvent();
			} else {
				ChatHelper::info( __METHOD__ . ': Method called - banned' );
				$wgOut->showErrorPage( 'chat-you-are-banned', 'chat-you-are-banned-text' );
			}
		} else {
			// TODO: FIXME: Make a link on this page which lets the user login.
			// TODO: FIXME: Make a link on this page which lets the user login.

			ChatHelper::info( __METHOD__ . ': Method called - logged out' );
			// $wgOut->permissionRequired( 'chat' ); // this is a really useless message, don't use it.
			$wgOut->showErrorPage( 'chat-no-login', 'chat-no-login-text' );

		}

		wfProfileOut( __METHOD__ );
	}
}
