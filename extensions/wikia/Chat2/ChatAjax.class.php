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
	 * the user to chat.  This is the last line of security against any users attempting to circumvent our protections.  Otherwise,
	 * a banned user could copy the entire client code (HTML/JS/etc.) from an unblocked user, then run that code while logged in as
	 * under a banned account, and they would still be given access.
	 *
	 * The returned 'isChatMod' field is boolean based on whether the user is a chat moderator on the current wiki.
	 *
	 * If the user is not allowed to chat, an error message is returned (which can be shown to the user).
	 */
	static public function getUserInfo() {
		global $wgMemc, $wgServer, $wgArticlePath, $wgRequest, $wgCityId, $wgContLang;

		wfProfileIn( __METHOD__ );
		Chat::info( __METHOD__ . ': Method called' );

		$data = $wgMemc->get( $wgRequest->getVal( 'key' ) );
		if ( empty( $data ) ) {
			wfProfileOut( __METHOD__ );

			return [ 'errorMsg' => "Key not found" ];
		}

		$user = User::newFromId( $data['user_id'] );

		if ( empty( $user ) || !$user->isLoggedIn() || $user->getName() != urldecode( $wgRequest->getVal( 'name', '' ) ) ) {
			wfProfileOut( __METHOD__ );

			return [ 'errorMsg' => "User not found" ];
		}

		$isCanGiveChatMod = in_array( Chat::CHAT_MODERATOR, $user->changeableGroups()['add'] );

		// First, check if they can chat on this wiki.
		$res = [
			'canChat' => Chat::canChat( $user ),
			'isLoggedIn' => $user->isLoggedIn(),
			'isChatMod' => $user->isAllowed( Chat::CHAT_MODERATOR ),
			'isCanGiveChatMod' => $isCanGiveChatMod,
			'isStaff' => $user->isAllowed( 'chatstaff' ),
			'username' => $user->getName(),
			'username_encoded' => rawurlencode( $user->getName() ),
			'avatarSrc' => AvatarService::getAvatarUrl( $user->getName(), self::CHAT_AVATAR_DIMENSION ),
			'editCount' => "",
			'since' => '',

			// Extra wg variables that we need.
			'activeBasket' => ChatConfig::getServerBasket(),
			'wgCityId' => $wgCityId,
			'wgServer' => $wgServer,
			'wgArticlePath' => $wgArticlePath
		];

		// Figure out the error message to return (i18n is done on this side).
		if ( $res['isLoggedIn'] === false ) {
			$res['errorMsg'] = wfMsg( 'chat-no-login' );
		} else if ( $res['canChat'] === false ) {
			$res['errorMsg'] = wfMsg( 'chat-you-are-banned-text' );
		}

		// If the user is approved to chat, make sure the roomId provided is for this wiki.
		// Users may be banned on the wiki of the room, but not on this wiki for example, so this prevents cross-wiki chat hacks.
		if ( $res['canChat'] ) {
			$roomId = $wgRequest->getVal( 'roomId' );
			$cityIdFromRoom = ChatServerApiClient::getCityIdFromRoomId( $roomId );
			if ( $wgCityId !== $cityIdFromRoom ) {
				$res['canChat'] = false; // don't let the user chat in the room they requested.
				$res['errorMsg'] = wfMsg( 'chat-room-is-not-on-this-wiki' );
			}
		}

		// If the user can chat, dig up some other stats which are a little more expensive to compute.
		if ( $res['canChat'] ) {
			// new user joins the chat, purge the cache
			ChatWidget::purgeChatUsersCache();

			$stats = ( new UserStatsService( $user->getId() ) )->getStats();

			// this results goes to chat server, which obiously has no user lang
			// so we just return a short month name key - it has to be translated on client side
			$res['since'] = !empty( $stats['date'] )
				? getdate( wfTimestamp( TS_UNIX, $stats['date'] ) )
				: '';

			// NOTE: This is attached to the user so it will be in the wiki's content language instead of wgLang (which it normally will).
			$res['editCount'] = $wgContLang->formatNum( $stats['edits'] );
		}

		wfProfileOut( __METHOD__ );

		return $res;
	} // end getUserInfo()

	/**
	 *  injecting data from chat to memcache
	 *  and purging cache for ChatWidget used by Anons
	 */
	static public function setUsersList() {
		global $wgRequest;

		wfProfileIn( __METHOD__ );
		Chat::info( __METHOD__ . ': Method called' );

		if ( \Wikia\Security\Utils::matchToken( ChatConfig::getSecretToken(), $wgRequest->getVal( 'token' ) ) ) {
			wfProfileOut( __METHOD__ );

			return [ 'status' => false ];
		}

		Chat::setChatters( $wgRequest->getArray( 'users' ) );

		wfProfileOut( __METHOD__ );

		return [ 'status' => $wgRequest->getArray( 'users' ) ];
	}

	/**
	 * Ajax endpoint for creating / accessing  private rooms
	 */
	static public function getPrivateRoomID() {
		global $wgRequest;

		wfProfileIn( __METHOD__ );
		Chat::info( __METHOD__ . ': Method called' );

		$users = json_decode( $wgRequest->getVal( 'users' ) );
		$roomId = ChatServerApiClient::getPrivateRoomId( $users );

		wfProfileOut( __METHOD__ );

		return [ "id" => $roomId ];
	}

	/**
	 * Ajax endpoint for blocking private chat with user.
	 *
	 * @throws BadRequestException
	 */
	static public function blockOrBanChat() {
		global $wgRequest, $wgUser;

		wfProfileIn( __METHOD__ );
		Chat::info( __METHOD__ . ': Method called' );

		// MAIN-6290  server.js needs to pass edit token for this to work
		// $wgRequest->isValidWriteRequest( $wgUser );

		$kickingUser = $wgUser;

		$res = [ ];
		$userToBan = $wgRequest->getVal( 'userToBan' );
		$userToBanId = $wgRequest->getVal( 'userToBanId', 0 );

		if ( !empty( $userToBanId ) ) {
			$userToBan = User::newFromId( $userToBanId );
			$userToBan = $userToBan->getName();
		}

		$mode = $wgRequest->getVal( 'mode', 'private' );

		if ( empty( $userToBan ) ) {
			$res["error"] = wfMsg( 'chat-missing-required-parameter', 'usertoBan' );
		} else {
			$dir = $wgRequest->getVal( 'dir', 'add' );
			$result = null;
			if ( $mode == 'private' ) {
				$result = Chat::blockPrivate( $userToBan, $dir, $kickingUser );
			} else if ( $mode == 'global' ) {
				$time = (int)$wgRequest->getVal( 'time', 0 );
				$result = Chat::banUser( $userToBan, $kickingUser, $time, $wgRequest->getVal( 'reason' ) );
			}
			if ( $result === true ) {
				$res["success"] = true;
			} else {
				$res["error"] = $result;
			}
		}

		wfProfileOut( __METHOD__ );

		return $res;
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
		global $wgRequest, $wgUser;

		wfProfileIn( __METHOD__ );
		Chat::info( __METHOD__ . ': Method called' );

		$promotingUser = $wgUser;

		$res = [ ];
		$PARAM_NAME = "userToPromote";
		$userToPromote = $wgRequest->getVal( $PARAM_NAME );

		if ( empty( $userToPromote ) ) {
			$res["error"] = wfMsg( 'chat-missing-required-parameter', $PARAM_NAME );
		} else {
			$result = Chat::promoteChatModerator( $userToPromote, $promotingUser );
			if ( $result === true ) {
				$res["success"] = true;
			} else {
				$res["error"] = $result;
			}
		}

		wfProfileOut( __METHOD__ );

		return $res;
	} // end addChatMod()


	function BanModal() {
		global $wgRequest, $wgLang;

		wfProfileIn( __METHOD__ );
		Chat::info( __METHOD__ . ': Method called' );

		$userId = $wgRequest->getVal( 'userId', 0 );

		$isChangeBan = false; // false = creating a ban, true = editing ban details
		$isoTime = "";
		$fmtTime = "";

		if ( !empty( $userId ) && $user = User::newFromID( $userId ) ) {
			$chatUser = new ChatUser( $user );
			if ( $chatUser->isBanned() ) {
				$isChangeBan = true;
				$ban = $chatUser->getBanInfo();
				$isoTime = wfTimestamp( TS_ISO_8601, $ban->end_date );
				$fmtTime = $wgLang->timeanddate( wfTimestamp( TS_MW, $ban->end_date ), true );
			}
		}

		$tmpl = new EasyTemplate( dirname( __FILE__ ) . '/templates/' );
		$tmpl->set_vars( [
			'options' => Chat::GetBanOptions(),
			'isChangeBan' => $isChangeBan,
			'isoTime' => $isoTime,
			'fmtTime' => $fmtTime
		] );

		$res = [
			'template' => $tmpl->render( "banModal" ),
			'isChangeBan' => $isChangeBan,
		];

		wfProfileOut( __METHOD__ );

		return $res;
	}
} // end class ChatAjax
