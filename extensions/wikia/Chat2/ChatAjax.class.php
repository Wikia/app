<?php

class ChatAjax {
	const INTERNAL_POLLING_DELAY_MICROSECONDS = 500000;
	const CHAT_AVATAR_DIMENSION = 28;

	/**
	 * This is the ajax-endpoint that the node server will connect to in order to get the currently logged-in user's info.
	 * The node server will pass the same cookies that the client has set, and this will allow this ajax request to be
	 * part of the same sesssion that the user already has going.  By doing this, the user's existing wikia login session
	 * can be used, so they don't need to re-login for us to know that they are legitimately authorized to use the chat or not.
	 *
	 * The returned info is just a custom subset of what the node server needs and does not contain an exhaustive list of rights.
	 *
	 * The 'isLoggedIn' field and 'canChat' field of the result should be checked by the calling code before allowing
	 * the user to chat.  This is the last line of security against any users attemptin to circumvent our protections.  Otherwise,
	 * a banned user could copy the entire client code (HTML/JS/etc.) from an unblocked user, then run that code while logged in as
	 * under a banned account, and they would still be given access.
	 *
	 * The returned 'isChatMod' field is boolean based on whether the user is a chat moderator on the current wiki.
	 *
	 * If the user is not allowed to chat, an error message is returned (which can be shown to the user).
	 */
	static public function getUserInfo(){
		ChatHelper::info( __METHOD__ . ': Method called' );
		global $wgMemc, $wgServer, $wgArticlePath, $wgRequest, $wgCityId, $wgContLang;
		wfProfileIn( __METHOD__ );

		$data = $wgMemc->get( $wgRequest->getVal('key'), false );
		if( empty($data) ) {
			wfProfileOut( __METHOD__ );
			return array( 'errorMsg' => "Key not found");
		}

		$user = User::newFromId( $data['user_id'] );

		if( empty($user) || !$user->isLoggedIn() || $user->getName() != urldecode($wgRequest->getVal('name', '')) ) {
			wfProfileOut( __METHOD__ );
			return array( 'errorMsg' => "User not found");
		}

		$isCanGiveChatMod = false;
		$userChangeableGroups = $user->changeableGroups();
		if (in_array('chatmoderator', $userChangeableGroups['add'])) {
			$isCanGiveChatMod = true;
		}

		// First, check if they can chat on this wiki.
		$retVal = array(
			'canChat' => Chat::canChat($user),
			'isLoggedIn' => $user->isLoggedIn(),
			'isChatMod' => $user->isAllowed( 'chatmoderator' ),
			'isCanGiveChatMod' => $isCanGiveChatMod,
			'isStaff' => $user->isAllowed( 'chatstaff' ),
			'username' => $user->getName(),
			'username_encoded' => rawurlencode($user->getName()),
			'avatarSrc' => AvatarService::getAvatarUrl($user->getName(), self::CHAT_AVATAR_DIMENSION),
			'editCount' => "",
			'since' => '',

			// Extra wg variables that we need.
			'activeBasket' => ChatHelper::getServerBasket(),
			'wgCityId' => $wgCityId,
			'wgServer' => $wgServer,
			'wgArticlePath' => $wgArticlePath
		);

		// Figure out the error message to return (i18n is done on this side).
		if($retVal['isLoggedIn'] === false){
			$retVal['errorMsg'] = wfMsg('chat-no-login');
		} else if($retVal['canChat'] === false){
			$retVal['errorMsg'] = wfMsg('chat-you-are-banned-text');
		}

		// If the user is approved to chat, make sure the roomId provided is for this wiki.
		// Users may be banned on the wiki of the room, but not on this wiki for example, so this prevents cross-wiki chat hacks.
		if($retVal['canChat']){
			$roomId = $wgRequest->getVal('roomId');
			$cityIdOfRoom = NodeApiClient::getCityIdForRoom($roomId);
			if($wgCityId !== $cityIdOfRoom){
				$retVal['canChat'] = false; // don't let the user chat in the room they requested.
				$retVal['errorMsg'] = wfMsg('chat-room-is-not-on-this-wiki');
			}
		}

		// If the user can chat, dig up some other stats which are a little more expensive to compute.
		if($retVal['canChat']){
			// new user joins the chat, purge the cache
			ChatEntryPoint::purgeChatUsersCache();

			$userStatsService = new UserStatsService($user->getId());
			$stats = $userStatsService->getStats();

			// NOTE: This is attached to the user so it will be in the wiki's content language instead of wgLang (which it normally will).
			$stats['edits'] = $wgContLang->formatNum($stats['edits']);
			if(empty($stats['date'])){
				// If the user has not edited on this wiki, don't show anything
				$retVal['since'] = "";
			} else {
				// this results goes to chat server, which obiously has no user lang
				// so we just return a short month name key - it has to be translated on client side
				$date = getdate( wfTimestamp( TS_UNIX, $stats['date'] ) );
				$retVal['since'] =  $date;
			}

			$retVal['editCount'] = $stats['edits'];
		}

		wfProfileOut( __METHOD__ );
		return $retVal;
	} // end getUserInfo()

	/**
	 *  injecting data from chat to memcache
	 *  and purging cache for ChatEntryPoint used by Anons
	 */

	static public function setUsersList() {
		ChatHelper::info( __METHOD__ . ': Method called' );
		global $wgRequest;
		wfProfileIn( __METHOD__ );

		if(ChatHelper::getChatCommunicationToken() != $wgRequest->getVal('token')) {
			wfProfileOut( __METHOD__ );
			return array('status' => false);
		}

		NodeApiClient::setChatters($wgRequest->getArray('users'));

		wfProfileOut( __METHOD__ );
		return array('status' => $wgRequest->getArray('users') );
	}

	/**
	 * Ajax endpoint for createing / accessing  private rooms
	 */

	static public function getPrivateRoomID() {
		ChatHelper::info( __METHOD__ . ': Method called' );
		global $wgRequest;
		wfProfileIn( __METHOD__ );

		$users = json_decode($wgRequest->getVal('users'));
		$roomId = NodeApiClient::getDefaultRoomId( 'private', $users );

		wfProfileOut( __METHOD__ );
		return array("id" => $roomId);
	}

	static $chatUserIP = null;  // this is set by ChatAjax function

	/**
	 * webrequest->GetIP hook listener. in case of ajax requests made by nodejs server, we should use real user ip address
	 * instead of the chat server ip
	 */
	static public function onGetIP(&$ip) {
		if ( self::$chatUserIP ) $ip = self::$chatUserIP;
		return true;
	}

	/**
 	 * Ajax endpoint for blocking privata chat with user.
	 */

	static public function blockOrBanChat(){
		ChatHelper::info( __METHOD__ . ': Method called' );
		global $wgRequest, $wgUser;
		wfProfileIn( __METHOD__ );

		$kickingUser = $wgUser;

		$retVal = array();
		$userToBan = $wgRequest->getVal('userToBan');
		$userToBanId = $wgRequest->getVal('userToBanId', 0);

		if(!empty($userToBanId)) {
			$userToBan = User::newFromId($userToBanId);
			if(!empty($userToBanId)) {
				$userToBan = $userToBan->getName();
			}
		}

		$mode = $wgRequest->getVal('mode', 'private');

		if(empty($userToBan)){
			$retVal["error"] = wfMsg('chat-missing-required-parameter', 'usertoBan');
		} else {
			$dir = $wgRequest->getVal('dir', 'add');
			if($mode == 'private') {
				$result = Chat::blockPrivate($userToBan, $dir, $kickingUser);
			} else if($mode == 'global') {
				$time = (int)  $wgRequest->getVal('time', 0);
				$result = Chat::banUser($userToBan, $kickingUser, $time, $wgRequest->getVal('reason') );
			}
			if($result === true){
				$retVal["success"] = true;
			} else {
				$retVal["error"] = $result;
			}
		}

		wfProfileOut( __METHOD__ );
		return $retVal;
	} // end kickBan()


	static public function getListOfBlockedPrivate() {
		return Chat::getListOfBlockedPrivate();
	}

	/**
	 * Ajax endpoint to set a user as a chat moderator (ie: add them to the 'chatmoderator' group).
	 *
	 * Returns an associative array.  On success, returns "success" => true, on failure,
	 * returns "error" => [error message].
	 */
	static public function giveChatMod() {
		ChatHelper::info( __METHOD__ . ': Method called' );
		global $wgRequest, $wgUser;
		wfProfileIn( __METHOD__ );

		$promottingUser = $wgUser;

		$retVal = array();
		$PARAM_NAME = "userToPromote";
		$userToPromote = $wgRequest->getVal( $PARAM_NAME );
		if( empty( $userToPromote) ) {
			$retVal["error"] = wfMsg('chat-missing-required-parameter', $PARAM_NAME);
		} else {
			$result = Chat::promoteChatModerator( $userToPromote, $promottingUser );
			if( $result === true ) {
				$retVal["success"] = true;
			} else {
				$retVal["error"] = $result;
			}
		}

		wfProfileOut( __METHOD__ );
		return $retVal;
	} // end addChatMod()


	function BanModal( ) {
		ChatHelper::info( __METHOD__ . ': Method called' );
		global $wgRequest, $wgCityId, $wgLang;
		wfProfileIn( __METHOD__ );
		$tmpl = new EasyTemplate(dirname(__FILE__).'/templates/');

		$userId = $wgRequest->getVal('userId', 0);

		$isChangeBan = false;
		$isoTime = "";
		$fmtTime = "";

		if(!empty($userId) && $user = User::newFromID($userId)) {
			 $ban = Chat::getBanInformation($wgCityId, $user);
			 if($ban !== false)  {
			 	$isChangeBan = true;
			 	$isoTime = wfTimestamp( TS_ISO_8601, $ban->end_date );
				$fmtTime = $wgLang->timeanddate( wfTimestamp( TS_MW, $ban->end_date ), true );
			 }
		}

		$tmpl->set_vars(array(
				'options' => Chat::GetBanOptions(),
				'isChangeBan' => $isChangeBan,
				'isoTime' => $isoTime,
				'fmtTime' => $fmtTime
			)
		);
		$retVal = array();
		$retVal['template'] = $tmpl->render("banModal");
		$retVal['isChangeBan'] = $isChangeBan;
		wfProfileOut( __METHOD__ );
		return $retVal;
	}
} // end class ChatAjax
