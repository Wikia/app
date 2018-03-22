<?php

class SpecialChat extends UnlistedSpecialPage {

	public function __construct() {
		parent::__construct( 'Chat', 'chat' );
	}

	public function execute( $par ) {
		$this->setHeaders();

		$user = $this->getUser();
		$out = $this->getOutput();

		if ( $user->isLoggedIn() ) {
			// Check that the user is not blocked or banned from chat
			if ( Chat::canChat( $user ) ) {
				Wikia::setVar( 'OasisEntryControllerName', 'Chat' );
				$out->addModules( 'ext.Chat2' );
				Chat::addConnectionLogEntry();
			} else {
				$out->showErrorPage( 'chat-you-are-banned', 'chat-you-are-banned-text' );
			}
		} else {
			$out->showErrorPage( 'chat-no-login', 'chat-no-login-text' );
		}
	}
}
