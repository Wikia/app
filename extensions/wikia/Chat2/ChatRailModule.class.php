<?php

class ChatRailModule extends Module {
	const MAX_CHATTERS = 6;
	const AVATAR_SIZE = 50;
	const CHAT_WINDOW_FEATURES = 'width=600,height=600,menubar=no,status=no,location=no,toolbar=no,scrollbars=no,resizable=yes';
	var $linkToSpecialChat;
	var $windowFeatures;
	var $chatHeadline;
	var $profileAvatar;
	var $totalInRoom;
	var $chatters;
	var $buttonIconUrl;
	var $buttonText;
	var $isLoggedIn;
	var $chatClickAction;	

	/**
	 * Render placeholder. Content will be ajax-loaded for freshness
	 */
	public function executePlaceholder() {
		//global $wgOut, $wgExtensionsPath;
		//$wgOut->addStyle(AssetsManager::getInstance()->getSassCommonURL('extensions/wikia/Chat/css/ChatRailModule.scss'));
		//$this->jsInitializer = F::build('JSSnippets')->addToStack( array( "/extensions/wikia/Chat/js/ChatEntryPoint.js" ), array(), 'ChatEntryPoint.init' );
	}

	public function executeAnonLoginSuccess() {
		global $wgExtensionsPath; 
		wfProfileIn( __METHOD__ );
		
		$this->linkToSpecialChat = SpecialPage::getTitleFor("Chat")->escapeLocalUrl();
		$this->buttonIconUrl = $wgExtensionsPath .'/wikia/Chat/images/chat_icon.png';
		if ( !empty($this->totalInRoom) ) {
			$this->buttonText = wfMsg('chat-join-the-chat');
		} else {
			$this->buttonText = wfMsg('chat-start-a-chat');		
		}
		$this->chatClickAction = "window.open('{$this->linkToSpecialChat}', 'wikiachat', '".self::CHAT_WINDOW_FEATURES."'); $('.modalWrapper').closeModal();";
		wfProfileOut( __METHOD__ );
	}

	/**
	 * Chat entry point - rendered via Ajax or pre-rendered in JS variable
	 */
	public function executeContents() {
		global $wgUser, $wgSitename, $wgOut, $wgExtensionsPath, $wgContLang, $wgReadOnly, $wgEnableWallExt;
		wfProfileIn( __METHOD__ );

		// Since there is no chat in the backup datacenter yet, if we're in read-only, disable the entry-point.
		// Depending on the actual failure, chat may or may not work, but the user would have to get there via URL which
		// is essentially saying that they accept some risk since they're going somewhere our interface doesn't direct them to.
		// If it's just, eg: a database problem, then they may get lucky and be able to use most of the chat features (kickbanning wouldn't work, etc.).
		if(empty($wgReadOnly)){
			// Main variables
			$this->profileType = isset($wgEnableWallExt) ? 'message-wall' : 'talk-page';
			$this->linkToSpecialChat = SpecialPage::getTitleFor("Chat")->escapeLocalUrl();
			$this->isLoggedIn = $wgUser->isLoggedIn();
			if($wgUser->isLoggedIn()){
				$this->profileAvatar = AvatarService::renderAvatar($wgUser->getName(), ChatRailModule::AVATAR_SIZE);
			} else {
				$this->profileAvatar = "";
			}

			// List of other people in chat
			$this->totalInRoom = 0;

			// Gets array of users currently in chat to populate rail module and user stats menus
			$chattersIn = NodeApiClient::getChatters($this->totalInRoom);
			$this->totalInRoom = count($chattersIn);
			$chatters = array();
			foreach($chattersIn as $i => $val) {
				$chatters[$i] = array();
				$chatters[$i]['username'] = $val;
				$chatters[$i]['avatarUrl'] = AvatarService::getAvatarUrl($chatters[$i]['username'], ChatRailModule::AVATAR_SIZE);

				// get stats for edit count and member since
				$user = User::newFromName($val);
				if(is_object($user)){
					$userStatsService = new UserStatsService($user->getId());
					$stats = $userStatsService->getStats();

					// edit count
					$chatters[$i]['editCount'] = $wgContLang->formatNum((int) $stats['edits']);

					// member since
					$chatters[$i]['showSince'] = $chatters[$i]['editCount'] != 0;
					$date = getdate( strtotime($stats['date']) );
					global $wgLang;
					$chatters[$i]['since'] =  $wgLang->getMonthAbbreviation($date['mon']) . ' ' . $date['year'];

					// profile page
					if($this->profileType == 'message-wall') {
						$chatters[$i]['profileUrl'] = Title::makeTitle( NS_USER_WALL, $chatters[$i]['username'] )->getFullURL();						
					} else {
						$chatters[$i]['profileUrl'] = Title::makeTitle( NS_USER, $chatters[$i]['username'] )->getFullURL();
					}

					// contribs page
					$chatters[$i]['contribsUrl'] = SpecialPage::getTitleFor( 'Contributions', $chatters[$i]['username'] )->getFullURL();
				}
			}

			$this->chatters = $chatters;

			// Button setup
			$this->buttonIconUrl = $wgExtensionsPath .'/wikia/Chat/images/chat_icon.png';
			if ( !empty($this->totalInRoom) ) {
				$this->buttonText = wfMsg('chat-join-the-chat');
			} else {
				$this->buttonText = wfMsg('chat-start-a-chat');
			}
		}

		wfProfileOut( __METHOD__ );
	}	
}