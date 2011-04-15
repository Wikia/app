<?php

class ChatAjax {
	const INTERNAL_POLLING_DELAY_MICROSECONDS = 500000;
	const CHAT_AVATAR_DIMENSION = 50;

	/**
	 * This function is meant to just echo the COOKIES which are available to the apache server.
	 *
	 * This helps to work around a limitation in the fact that javascript can't access the second-level-domain's
	 * cookies even if they're authorized to be accessed by subdomains (eg: ".wikia.com" cookies are viewable by apache
	 * on lyrics.wikia.com, but interestingly, isn't in document.cookie in the javascript on lyrics.wikia.com).
	 */
	static public function echoCookies(){
		return $_COOKIE;
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
		global $wgUser, $wgServer, $wgArticlePath, $wgRequest, $wgCityId, $wgContLang;
		wfProfileIn( __METHOD__ );

		// First, check if they can chat on this wiki.
		$retVal = array(
			'canChat' => Chat::canChat($wgUser),
			'isLoggedIn' => $wgUser->isLoggedIn(),
			'isChatMod' => $wgUser->isAllowed( 'chatmoderator' ),
			'username' => $wgUser->getName(),
			'avatarSrc' => AvatarService::getAvatarUrl($wgUser->getName(), self::CHAT_AVATAR_DIMENSION),
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
			$userStatsService = new UserStatsService($wgUser->getId());
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
	 * Ajax endpoint for kickbanning a user. This will change their permissions so that
	 * they are not allowed to chat on the current wiki.
	 *
	 * Returns an associative array.  On success, returns "success" => "", on failure,
	 * returns "error" => [error message].
	 */
	static public function kickBan(){
		global $wgRequest;
		wfProfileIn( __METHOD__ );

		$userToBan = $wgRequest->getVal('userToBan');
		if(empty($userToBan)){
			$retVal["error"] = wfMsg('chat-ban-requires-usertoban-parameter', 'usertoBan');
		} else {
			$result = Chat::banUser($userToBan);
			if($result === true){
				$retVal["success"] = true;
			} else {
				$retVal["error"] = $result;
			}
		}

		wfProfileOut( __METHOD__ );
		return $retVal;
	}

} // end class ChatAjax
