<?php

class ChatRailController extends WikiaController {
	const MAX_CHATTERS = 6;
	const AVATAR_SIZE = 50;
	const CHAT_WINDOW_FEATURES = 'width=600,height=600,menubar=no,status=no,location=no,toolbar=no,scrollbars=no,resizable=yes';
	const CACHE_DURATION = 60; // ttl time for the list of chat users, this is only used for anonymous requests

	/**
	 * Render chat rail module placeholder. Content will be ajax-loaded for freshness.
	 */
	public function placeholder() {
		foreach( ChatEntryPoint::getEntryPointTemplateVars( false ) as $name => $value) {
			$this->setVal( $name, $value );
		}

		$this->response->addAsset( 'extensions/wikia/Chat2/js/ChatEntryPoint.js' );

		// As most the markup for this is the same as for the chat parser tag, we're reusing the tag template
		$this->response->getView()->setTemplatePath( dirname( __FILE__ ) .'/templates/entryPointTag.tmpl.php' );
	}

	public function executeAnonLoginSuccess() {
		wfProfileIn( __METHOD__ );

		if ( !empty($this->totalInRoom) ) {
			$this->buttonText = wfMsg('chat-join-the-chat');
		} else {
			$this->buttonText = wfMsg('chat-start-a-chat');
		}
		$this->linkToSpecialChat = SpecialPage::getTitleFor("Chat")->escapeLocalUrl();

		wfProfileOut( __METHOD__ );
	}

	/**
	 * Chat entry point - rendered via Ajax or pre-rendered in JS variable
	 * @todo: backward compatibility method, remove it till Oct 2013
	 */
	public function executeContents() {
		global $wgUser, $wgReadOnly, $wgEnableWallExt;
		wfProfileIn( __METHOD__ );

		if(empty($wgReadOnly)) {
			// Main variables
			$this->profileType = !empty($wgEnableWallExt) ? 'message-wall' : 'talk-page';
			$this->linkToSpecialChat = SpecialPage::getTitleFor("Chat")->escapeLocalUrl();
			$this->isLoggedIn = $wgUser->isLoggedIn();
			$this->profileAvatarUrl = $this->isLoggedIn ? AvatarService::getAvatarUrl($wgUser->getName(), ChatRailController::AVATAR_SIZE) : '';

			// List of other people in chat
			$this->totalInRoom = 0;

			// Gets array of users currently in chat to populate rail module and user stats menus
			$this->chatters = ChatEntryPoint::getChatUsersInfo();
			$this->totalInRoom = count($this->chatters);
			for($i = 0 ; $i < $this->totalInRoom ; $i++) {
				global $wgLang;
				if ($this->chatters[$i]['showSince']) {
					$this->chatters[$i]['since'] =  $wgLang->getMonthAbbreviation($this->chatters[$i]['since_month']) .
						' ' . $this->chatters[$i]['since_year'];
				}
			}
		}

		// Cache the entire call in varnish (and browser).
		$this->response->setCacheValidity(self::CACHE_DURATION, self::CACHE_DURATION, array(WikiaResponse::CACHE_TARGET_BROWSER, WikiaResponse::CACHE_TARGET_VARNISH));

		wfProfileOut( __METHOD__ );
	}

	public function executeGetUsers() {
		wfProfileIn( __METHOD__ );
		$this->users = ChatEntryPoint::getChatUsersInfo();
		// Cache the entire call in varnish (and browser).
		$this->response->setCacheValidity(self::CACHE_DURATION, self::CACHE_DURATION, array(WikiaResponse::CACHE_TARGET_BROWSER, WikiaResponse::CACHE_TARGET_VARNISH));
		wfProfileOut( __METHOD__ );
	}

}
