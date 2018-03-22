<?php

class ChatRailController extends WikiaController {
	const AVATAR_SIZE = 50;
	const CHAT_WINDOW_FEATURES = 'width=600,height=600,menubar=no,status=no,location=no,toolbar=no,scrollbars=no,resizable=yes';

	/**
	 * Render chat rail module placeholder. Content will be ajax-loaded for freshness.
	 */
	public function placeholder() {
		foreach ( ChatWidget::getTemplateVars( false ) as $name => $value ) {
			$this->setVal( $name, $value );
		}

		// SUS-749: Add required MW messages to output
		$this->wg->Out->addModuleMessages( 'ext.Chat2.ChatWidget' );

		// As most the markup for this is the same as for the chat parser tag, we're reusing the tag template
		$this->response->getView()->setTemplatePath( __DIR__ . '/templates/widget.mustache' );
		$this->response->setTemplateEngine( WikiaResponse::TEMPLATE_ENGINE_MUSTACHE );
	}

	public function executeAnonLoginSuccess() {
		wfProfileIn( __METHOD__ );

		$totalChatters = count( Chat::getChatters() );
		if ( $totalChatters > 0 ) {
			$this->buttonText = wfMessage( 'chat-join-the-chat' )->text();
		} else {
			$this->buttonText = wfMessage( 'chat-start-a-chat' )->text();
		}
		$this->linkToSpecialChat = SpecialPage::getTitleFor( "Chat" )->escapeLocalUrl();

		wfProfileOut( __METHOD__ );
	}

	public function executeGetUsers() {
		global $wgUser;

		wfProfileIn( __METHOD__ );
		$usersInfo = $wgUser->isLoggedIn() ? ChatWidget::getUsersInfo() : [];
		$viewedUsersInfo = ChatWidget::getViewedUsersInfo( $usersInfo );
		$usersCount = count( $usersInfo );

		$this->setVal( 'users', $viewedUsersInfo );
		$this->setVal( 'hasUsers', $usersCount > 0 );

		$this->response->setCacheValidity( ChatWidget::CHAT_USER_LIST_CACHE_TTL );
		wfProfileOut( __METHOD__ );
	}

}
