<?php

class SpecialChat extends UnlistedSpecialPage {

	public function __construct() {
		parent::__construct( 'Chat', 'chat' );
	}

	public function execute() {
		wfProfileIn( __METHOD__ );
		global $wgCityId;
		$output = $this->getOutput();
		$user = $this->getUser();

		// check if logged in
		if ( $user->isLoggedIn() ) {
			if ( Chat::canChat( $user ) ){
				Wikia::setVar( 'OasisEntryControllerName', 'Chat' );
				Chat::logChatWindowOpenedEvent();
			} else {
				$output->showErrorPage( 'chat-you-are-banned', 'chat-you-are-banned-text' );
			}
		} else {
			// TODO: FIXME: Make a link on this page which lets the user login.
			// TODO: FIXME: Make a link on this page which lets the user login.
			
			// $wgOut->permissionRequired( 'chat' ); // this is a really useless message, don't use it.
			$output->showErrorPage( 'chat-no-login', 'chat-no-login-text' );

		}

		wfProfileOut( __METHOD__ );
	}
}
