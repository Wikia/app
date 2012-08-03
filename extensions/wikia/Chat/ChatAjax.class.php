<?php

class ChatAjax {
	const INTERNAL_POLLING_DELAY_MICROSECONDS = 500000;
	const CHAT_AVATAR_DIMENSION = 28;

	/**
	 * This function is meant to just echo the COOKIES which are available to the apache server.
	 *
	 * This helps to work around a limitation in the fact that javascript can't access the second-level-domain's
	 * cookies even if they're authorized to be accessed by subdomains (eg: ".wikia.com" cookies are viewable by apache
	 * on lyrics.wikia.com, but interestingly, isn't in document.cookie in the javascript on lyrics.wikia.com).
	 */
	static public function echoCookies(){
		global $wgUser, $wgMemc;
		if( !$wgUser->isLoggedIn() ) {
			return array("key" => false ) ;
		}
		$key = md5( $wgUser->getId() . "_" . time() . '_' .  mt_rand(0, 65535) );
		$wgMemc->set($key, array( "user_id" => $wgUser->getId(), "cookie" => $_COOKIE) , 60*60*24);
		return array("key" => $key ) ;
	} // end echoCookies()

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
		global $wgMemc, $wgServer, $wgArticlePath, $wgRequest, $wgCityId, $wgContLang;
		wfProfileIn( __METHOD__ );

		$data = $wgMemc->get( $wgRequest->getVal('key'), false );
		if( empty($data) ) {
			wfProfileOut( __METHOD__ );
			return array( 'errorMsg' => wfMsg('chat-room-is-not-on-this-wiki'));
		}

		$user = User::newFromId( $data['user_id'] );

		if( empty($user) || !$user->isLoggedIn() || $user->getName() != $wgRequest->getVal('name', '') ) {
			wfProfileOut( __METHOD__ );
			return array( 'errorMsg' => wfMsg('chat-room-is-not-on-this-wiki'));
		}

		$isCanGiveChatMode = false;
		$userChangeableGroups = $user->changeableGroups();
		if (in_array('chatmoderator', $userChangeableGroups['add'])) {
			$isCanGiveChatMode = true;
		}

		// First, check if they can chat on this wiki.
		$retVal = array(
			'canChat' => Chat::canChat($user),
			'isLoggedIn' => $user->isLoggedIn(),
			'isChatMod' => $user->isAllowed( 'chatmoderator' ),
			'isCanGiveChatMode' => $isCanGiveChatMode,
			'isStaff' => $user->isAllowed( 'chatstaff' ),
			'username' => $user->getName(),
			'avatarSrc' => AvatarService::getAvatarUrl($user->getName(), self::CHAT_AVATAR_DIMENSION),
			'editCount' => "",
			'since' => '',

			// Extra wg variables that we need.
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
			$userStatsService = new UserStatsService($user->getId());
			$stats = $userStatsService->getStats();

			// NOTE: This is attached to the user so it will be in the wiki's content language instead of wgLang (which it normally will).
			$stats['edits'] = $wgContLang->formatNum($stats['edits']);
			if(empty($stats['date'])){
				// If the user has not edited on this wiki, don't show anything
				$retVal['since'] = "";
			} else {
				//$stats['date'] = $wgContLang->date(wfTimestamp(TS_MW, $stats['date']));
				$stats['date'] = date("M Y", strtotime($stats['date']));
				$retVal['since'] = wfMsg('chat-member-since', $stats['date']);
			}

			$retVal['editCount'] = $stats['edits'];
		}

		wfProfileOut( __METHOD__ );
		return $retVal;
	} // end getUserInfo()

	/**
	 * Ajax endpoint for createing / accessing  private rooms
	 */

	static public function getPrivateRoomID() {
		global $wgRequest;

		// TODO: change this
		$roomName = 'private room name';
		$roomTopic = 'private room topic';

		$users = explode( ',', $wgRequest->getVal('users'));
		$roomId = NodeApiClient::getDefaultRoomId($roomName, $roomTopic, 'private', $users );

		return array("id" => $roomId);
	}


	/**
	 * Ajax endpoint for kickbanning a user. This will change their permissions so that
	 * they are not allowed to chat on the current wiki.
	 *
	 * Returns an associative array.  On success, returns "success" => true, on failure,
	 * returns "error" => [error message].
	 * Regardless of outcome, returns another field whose key is "doKickAnyway" and where 0
	 * indicates the caller should take no action, but 1 indicates that the caller should
	 * kick the user even if this function returned an error (this is useful in the case that
	 * the caller is trying to kickBan a user who is already banned.  They might have been
	 * banned on the wiki & now are still logged in... if this is the case, they should be kicked!
	 */
	static public function kickBan($private = false){
		global $wgRequest, $wgUser, $wgMemc;
		wfProfileIn( __METHOD__ );

		$data = $wgMemc->get( $wgRequest->getVal('key'), false );
		if( !empty($data) ) {
			$kickingUser = User::newFromId( $data['user_id'] );
		} else {
			$kickingUser = $wgUser;
		}

		$retVal = array();
		$userToBan = $wgRequest->getVal('userToBan');

		if(empty($userToBan)){
			$retVal["error"] = wfMsg('chat-missing-required-parameter', 'usertoBan');
		} else {
			if($private) {
				$dir = $wgRequest->getVal('dir', 'add');
				$result = Chat::blockPrivate($userToBan, $dir, $kickingUser);
			} else {
				$doKickAnyway = false; // might get changed by reference
				$result = Chat::banUser($userToBan, $doKickAnyway, $kickingUser);
				$retVal["doKickAnyway"] = ($doKickAnyway? 1:0);
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


	/**
	 * Ajax endpoint for blocking private chat with user
	 **/

	static public function blockPrivate(){
		return self::kickBan(true);
	}

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
		global $wgRequest, $wgUser, $wgMemc;
		wfProfileIn( __METHOD__ );

		$data = $wgMemc->get( $wgRequest->getVal('key'), false );
		if( !empty($data) ) {
			$promottingUser = User::newFromId( $data['user_id'] );
		} else {
			$promottingUser = $wgUser;
		}

		$retVal = array();
		$PARAM_NAME = "userToPromote";
		$userToPromote = $wgRequest->getVal( $PARAM_NAME );
		if(empty($userToPromote)){
			$retVal["error"] = wfMsg('chat-missing-required-parameter', $PARAM_NAME);
		} else {
			$result = Chat::promoteChatModerator($userToPromote, $promottingUser);
			if($result === true){
				$retVal["success"] = true;
			} else {
				$retVal["error"] = $result;
			}
		}

		wfProfileOut( __METHOD__ );
		return $retVal;
	} // end addChatMod()

} // end class ChatAjax
