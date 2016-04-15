<?php

class ChatRailController extends WikiaController {
	const MAX_CHATTERS = 6;
	const AVATAR_SIZE = 50;
	const CHAT_WINDOW_FEATURES = 'width=600,height=600,menubar=no,status=no,location=no,toolbar=no,scrollbars=no,resizable=yes';

	/**
	 * Render chat rail module placeholder. Content will be ajax-loaded for freshness.
	 */
	public function placeholder() {
		foreach ( ChatWidget::getTemplateVars( false ) as $name => $value ) {
			$this->setVal( $name, $value );
		}

		// As most the markup for this is the same as for the chat parser tag, we're reusing the tag template
		$this->response->getView()->setTemplatePath( dirname( __FILE__ ) . '/templates/entryPointTag.tmpl.php' );
	}

	public function executeAnonLoginSuccess() {
		wfProfileIn( __METHOD__ );

		if ( !empty( $this->totalInRoom ) ) {
			$this->buttonText = wfMessage( 'chat-join-the-chat' )->text();
			Chat::info( __METHOD__ . ': Method called - existing room' );
		} else {
			$this->buttonText = wfMessage( 'chat-start-a-chat' )->text();
			Chat::info( __METHOD__ . ': Method called - new room' );
		}
		$this->linkToSpecialChat = SpecialPage::getTitleFor( "Chat" )->escapeLocalUrl();

		wfProfileOut( __METHOD__ );
	}

	public function executeGetUsers() {
		wfProfileIn( __METHOD__ );
		$this->users = ChatWidget::getUsersInfo();
		Chat::info( __METHOD__ . ': Method called - ' . ( count( $this->users ) ) . ' user(s)', [
			'chatters' => count( $this->users ),
		] );
		$this->response->setCacheValidity( ChatWidget::CHAT_USER_LIST_CACHE_TTL );
		wfProfileOut( __METHOD__ );
	}

}
