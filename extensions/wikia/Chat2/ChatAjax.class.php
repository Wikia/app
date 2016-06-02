<?php

class ChatAjax {
	const INTERNAL_POLLING_DELAY_MICROSECONDS = 500000;
	const CHAT_AVATAR_DIMENSION = 28;

	const ERROR_NOT_AUTHENTICATED = 'Not authenticated';
	const ERROR_KEY_NOT_FOUND = 'Key not found';
	const ERROR_USER_NOT_FOUND = 'User not found';

	/**
	 * This is the ajax-endpoint that the node server will connect to in order to get the currently logged-in user's info.
	 * The node server will pass the same cookies that the client has set, and this will allow this ajax request to be
	 * part of the same sesssion that the user already has going.  By doing this, the user's existing wikia login session
	 * can be used, so they don't need to re-login for us to know that they are legitimately authorized to use the chat or not.
	 *
	 * The returned info is just a custom subset of what the node server needs and does not contain an exhaustive list of rights.
	 *
	 * The 'canChat' field of the result should be checked by the calling code before allowing
	 * the user to chat.  This is the last line of security against any users attempting to circumvent our protections.  Otherwise,
	 * a banned user could copy the entire client code (HTML/JS/etc.) from an unblocked user, then run that code while logged in as
	 * under a banned account, and they would still be given access.
	 *
	 * The returned 'isModerator' field is boolean based on whether the user is a chat moderator on the current wiki.
	 *
	 * If the user is not allowed to chat, an error message is returned (which can be shown to the user).
	 */
	static public function getUserInfo() {
		global $wgMemc, $wgServer, $wgArticlePath, $wgRequest, $wgCityId, $wgContLang;

		wfProfileIn( __METHOD__ );
		Chat::info( __METHOD__ . ': Method called' );

		if ( !self::authenticateServer() ) {
			wfProfileOut( __METHOD__ );

			return [ 'errorMsg' => self::ERROR_NOT_AUTHENTICATED ];
		}

		$data = $wgMemc->get( $wgRequest->getVal( 'key' ) );
		if ( empty( $data ) ) {
			wfProfileOut( __METHOD__ );

			return [ 'errorMsg' => self::ERROR_KEY_NOT_FOUND ];
		}

		$user = User::newFromId( $data['user_id'] );
		if ( empty( $user ) || !$user->isLoggedIn() || $user->getName() != urldecode( $wgRequest->getVal( 'name', '' ) ) ) {
			wfProfileOut( __METHOD__ );

			return [ 'errorMsg' => self::ERROR_USER_NOT_FOUND ];
		}

		$canPromoteModerator = in_array( Chat::CHAT_MODERATOR, $user->changeableGroups()['add'] );

		$res = [
			'canChat' => Chat::canChat( $user ),
			'isModerator' => $user->isAllowed( Chat::CHAT_MODERATOR ),
			'canPromoteModerator' => $canPromoteModerator,
			'isStaff' => $user->isAllowed( Chat::CHAT_STAFF ),
			'username' => $user->getName(),
			'username_encoded' => rawurlencode( $user->getName() ),
			'avatarSrc' => AvatarService::getAvatarUrl( $user->getName(), self::CHAT_AVATAR_DIMENSION ),
			'editCount' => "",
			'since' => '',

			// Extra wg variables that we need.
			'wgCityId' => $wgCityId,
			'wgServer' => $wgServer,
			'wgArticlePath' => $wgArticlePath
		];

		// Figure out the error message to return (i18n is done on this side).
		if ( !$user->isLoggedIn() ) {
			$res['errorMsg'] = wfMessage( 'chat-no-login' )->text();
		} else if ( !$res['canChat'] ) {
			$res['errorMsg'] = wfMessage( 'chat-you-are-banned-text' )->text();
		}

		// If the user is approved to chat, make sure the roomId provided is for this wiki.
		// Users may be banned on the wiki of the room, but not on this wiki for example, so this prevents cross-wiki chat hacks.
		if ( $res['canChat'] ) {
			$roomId = $wgRequest->getVal( 'roomId' );
			$cityIdFromRoom = ChatServerApiClient::getCityIdFromRoomId( $roomId );
			if ( $wgCityId !== $cityIdFromRoom ) {
				$res['canChat'] = false; // don't let the user chat in the room they requested.
				$res['errorMsg'] = wfMessage( 'chat-room-is-not-on-this-wiki' )->text();
			}
		}

		// If the user can chat, dig up some other stats which are a little more expensive to compute.
		if ( $res['canChat'] ) {
			$stats = ( new UserStatsService( $user->getId() ) )->getStats();

			// this results goes to chat server, which obiously has no user lang
			// so we just return a short month name key - it has to be translated on client side
			$res['since'] = !empty( $stats['firstRevisionDate'] )
				? getdate( wfTimestamp( TS_UNIX, $stats['firstRevisionDate'] ) )
				: '';

			// NOTE: This is attached to the user so it will be in the wiki's content language instead of wgLang (which it normally will).
			$res['editCount'] = $wgContLang->formatNum( $stats['edits'] );
		}

		wfProfileOut( __METHOD__ );

		return $res;
	}

	/**
	 *  injecting data from chat to memcache
	 *  and purging cache for ChatWidget used by Anons
	 */
	static public function setUsersList() {
		global $wgRequest;

		wfProfileIn( __METHOD__ );
		Chat::info( __METHOD__ . ': Method called' );

		if ( !self::authenticateServer() ) {
			wfProfileOut( __METHOD__ );

			return [ 'status' => false ];
		}

		$users = $wgRequest->getArray( 'users', [] );
		Chat::setChatters( $users );

		wfProfileOut( __METHOD__ );

		return [ 'status' => $users ];
	}

	/**
	 * Ajax endpoint for creating / accessing  private rooms
	 */
	static public function getPrivateRoomID() {
		global $wgRequest, $wgUser;

		wfProfileIn( __METHOD__ );
		Chat::info( __METHOD__ . ': Method called' );

		if ( !self::authenticateServerOrUser() ) {
			wfProfileOut( __METHOD__ );

			return [ 'id' => false ];
		}

		$users = json_decode( $wgRequest->getVal( 'users' ) );
		if ( !$users || !is_array( $users ) || !in_array( $wgUser->getName(), $users ) ) {
			wfProfileOut( __METHOD__ );

			return [ 'id' => false ];
		}

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

		if ( !self::authenticateServerOrUser() ) {
			wfProfileOut( __METHOD__ );

			return [ 'error' => self::ERROR_NOT_AUTHENTICATED ];
		}

		$adminUser = $wgUser;

		$res = [ ];
		$subjectUserName = $wgRequest->getVal( 'userToBan' );
		$subjectUserId = $wgRequest->getVal( 'userToBanId', 0 );

		if ( !empty( $subjectUserId ) ) {
			$subjectUserName = User::newFromId( $subjectUserId )->getName();
		}

		$mode = $wgRequest->getVal( 'mode', 'private' );

		if ( empty( $subjectUserName ) ) {
			$res["error"] = wfMessage( 'chat-missing-required-parameter', 'usertoBan' )->text;
		} else {
			$dir = $wgRequest->getVal( 'dir', 'add' );
			$result = null;
			if ( $mode == 'private' ) {
				$result = Chat::blockPrivate( $subjectUserName, $dir, $adminUser );
			} else if ( $mode == 'global' ) {
				$time = (int)$wgRequest->getVal( 'time', 0 );
				$result = Chat::banUser( $subjectUserName, $adminUser, $time, $wgRequest->getVal( 'reason' ) );
			}
			if ( $result === true ) {
				$res["success"] = true;
			} else {
				$res["error"] = $result;
			}
		}

		wfProfileOut( __METHOD__ );

		return $res;
	}


	static public function getPrivateBlocks() {
		return Chat::getPrivateBlocks();
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

		if ( !self::authenticateServer() ) {
			wfProfileOut( __METHOD__ );

			return [ 'error' => self::ERROR_NOT_AUTHENTICATED ];
		}

		$promotingUser = $wgUser;

		$res = [ ];
		$userToPromote = $wgRequest->getVal( 'userToPromote' );

		if ( empty( $userToPromote ) ) {
			$res["error"] = wfMessage( 'chat-missing-required-parameter', 'userToPromote' )->text();
		} else {
			$result = Chat::promoteModerator( $userToPromote, $promotingUser );
			if ( $result === true ) {
				$res["success"] = true;
			} else {
				$res["error"] = $result;
			}
		}

		wfProfileOut( __METHOD__ );

		return $res;
	}

	/**
	 * When token matches accept internal GET requests, i.e. do not report them as CSRF errors (PLATFORM-2207)
	 *
	 * @return bool
	 */
	private static function authenticateServer() {
		global $wgRequest;

		$tokenMatched = \Wikia\Security\Utils::matchToken( ChatConfig::getSecretToken(), $wgRequest->getVal( 'token' ) );

		if ( $tokenMatched ) {
			\Wikia\Security\CSRFDetector::markHttpMethodAccepted( __METHOD__ );
		}

		return $tokenMatched;
	}

	private static function authenticateServerOrUser() {
		global $wgRequest, $wgUser;

		return self::authenticateServer() || ( $wgRequest->wasPosted() && $wgUser->matchEditToken( $wgRequest->getVal( 'token' ) ) );
	}


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

		$tmpl = new EasyTemplate( __DIR__ . '/templates/' );
		$tmpl->set_vars( [
			'options' => Chat::getBanOptions(),
			'isChangeBan' => $isChangeBan,
			'isoTime' => $isoTime,
			'fmtTime' => $fmtTime
		] );

		$res = [
			'template' => $tmpl->render( 'banModal' ),
			'isChangeBan' => $isChangeBan,
		];

		wfProfileOut( __METHOD__ );

		return $res;
	}
}
