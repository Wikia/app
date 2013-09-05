<?php

class ChatRailController extends WikiaController {
	const MAX_CHATTERS = 6;
	const AVATAR_SIZE = 50;
	const CHAT_WINDOW_FEATURES = 'width=600,height=600,menubar=no,status=no,location=no,toolbar=no,scrollbars=no,resizable=yes';
	const CACHE_DURATION = 5; // in seconds

	/**
	 * Render placeholder. Content will be ajax-loaded for freshness
	 */
	public function executePlaceholder() {
		$this->response->addAsset('extensions/wikia/Chat2/js/ChatEntryPoint.js');
	}

	public function executeAnonLoginSuccess() {
		global $wgExtensionsPath;
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
			$this->profileType = !empty($wgEnableWallExt) ? 'message-wall' : 'talk-page';
			$this->linkToSpecialChat = SpecialPage::getTitleFor("Chat")->escapeLocalUrl();
			$this->isLoggedIn = $wgUser->isLoggedIn();
			$this->profileAvatarUrl = $this->isLoggedIn ? AvatarService::getAvatarUrl($wgUser->getName(), ChatRailController::AVATAR_SIZE) : '';

			// List of other people in chat
			$this->totalInRoom = 0;

			// Gets array of users currently in chat to populate rail module and user stats menus
			$chattersIn = NodeApiClient::getChatters($this->totalInRoom);
			$this->totalInRoom = count($chattersIn);
			$chatters = array();			
			foreach($chattersIn as $i => $val) {
				$chatters[$i] = array();
				$cacheChatter = $this->getCachedUser($val);
				if(!empty($cacheChatter)) {
					$chatters[$i] = $cacheChatter;
					continue;
				}

				$chatters[$i]['username'] = $val;
				$chatters[$i]['avatarUrl'] = AvatarService::getAvatarUrl($chatters[$i]['username'], ChatRailController::AVATAR_SIZE);

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
						$chatters[$i]['profileUrl'] = Title::makeTitle( NS_USER_TALK, $chatters[$i]['username'] )->getFullURL();
					}

					// contribs page
					$chatters[$i]['contribsUrl'] = SpecialPage::getTitleFor( 'Contributions', $chatters[$i]['username'] )->getFullURL();
				}

				$this->cacheUser($val, $chatters[$i] );
			}

			$this->chatters = $chatters;
		}
		
		// Cache the entire call in varnish (and browser).
		$this->response->setCacheValidity(self::CACHE_DURATION, self::CACHE_DURATION, array(WikiaResponse::CACHE_TARGET_BROWSER, WikiaResponse::CACHE_TARGET_VARNISH));
		
		wfProfileOut( __METHOD__ );
	}

	public function cacheUser($user, $data) {
		global $wgMemc;
		$key = wfMemcKey( 'chatavatars', $user );
		$wgMemc->set($key, $data , 60*60);
		return $key;
	}

	public function getCachedUser($user) {
		global $wgMemc;
		$key = wfMemcKey( 'chatavatars', $user );
		return $wgMemc->get($key, 60*60);
	}
}