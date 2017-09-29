<?php

/**
 * Class for managing a Chat (aka: chat-room)
 * This is for a demo & if the prototype works out, this will probably need to be thrown away and
 * replaced with Jabberd or something similar which could scale to our level of potential usage.
 *
 * @author Sean Colombo
 */
class Chat {
	const HTTP_HEADER_XFF = 'X-FORWARDED-FOR';
	const HTTP_HEADER_USER_AGENT = 'USER-AGENT';

	const CHATTERS_CACHE_KEY = 'Chat::chatters';
	const CHATTERS_CACHE_TTL = 86400; //60 * 60 * 24 -  1 day
	const CHAT_SESSION_TTL = 172800; //60 * 60 * 48 - 2 days

	const BAN_ADD = 'add';
	const BAN_CHANGE = 'change';
	const BAN_REMOVE = 'remove';

	const PRIVATE_BLOCK_ADD = 'add';
	const PRIVATE_BLOCK_REMOVE = 'remove';

	/**
	 * Stands for both: group name and permission name
	 */
	const CHAT_MODERATOR = 'chatmoderator';

	/**
	 * Permission name to be a chat staff
	 */
	const CHAT_STAFF = 'chatstaff';
	const CHAT_ADMIN = 'chatadmin';

	/**
	 * The return value of this method gets passed to Javascript as the global wgChatKey.  It then becomes the 'key'
	 * parameter sent with every chat request to the Node.js server.
	 *
	 * The key is then used by ChatAjax::getUserInfo() to load the info back from memcached.
	 *
	 * @return null|string
	 */
	public static function getSessionKey() {
		$wg = F::app()->wg;

		if ( !$wg->User->isLoggedIn() ) {
			return null;
		}
		$key = 'Chat::cookies::' . sha1( $wg->User->getId() . "_" . microtime() . '_' . mt_rand() );
		$wg->Memc->set( $key, [
			'user_id' => $wg->User->getId(),
			'cookie' => $_COOKIE,
		], self::CHAT_SESSION_TTL );

		return $key;
	}

	/**
	 * Given a username, if the current user has permission to do so, ban the user
	 * from chat on the current wiki.
	 *
	 * @param string $subjectUserName
	 * @param User $adminUser
	 * @param int $time Ban time (0 = remove ban)
	 * @param string $reason
	 *
	 * @return true|string Returns true on success, returns an error message as a string on failure.
	 */
	public static function banUser( $subjectUserName, User $adminUser, $time, $reason ) {
		if ( $adminUser->isBlocked() ) {
			return wfMessage( 'actionthrottled' )->text();
		}

		$subjectUser = User::newFromName( $subjectUserName );

		// Make sure user doing the kick/ban has permission to do so
		if ( !( $subjectUser instanceof User ) || !$adminUser->isAllowed( self::CHAT_MODERATOR ) ) {
			return wfMessage( 'chat-ban-you-need-permission', self::CHAT_MODERATOR )
				->inContentLanguage()->text() . "\n";
		}

		// Make sure we aren't trying to kick/ban someone who shouldn't be kick/banned
		// Chat moderators can be kicked/banned only by staff members and admins
		if ( !self::canBan( $subjectUser, $adminUser ) ) {
			return wfMessage( 'chat-ban-cant-ban-moderator' )->inContentLanguage()->text() . "\n";
		}
		
		$action = $time != 0 ? self::BAN_ADD : self::BAN_REMOVE;

		$subjectChatUser = new ChatUser( $subjectUser );
		if ( $action == self::BAN_ADD ) {
			if ( $subjectChatUser->isBanned() ) {
				$action = self::BAN_CHANGE;
			}

			$options = array_flip( ChatBanTimeOptions::newDefault()->get() );
			$timeLabel = $options[ $time ];
			$endOn = time() + $time;

			$subjectChatUser->ban( $adminUser->getId(), $endOn, $reason );
		} else {
			$timeLabel = $endOn = null;
			$subjectChatUser->unban();
		}

		Chat::addLogEntry(
			$subjectUser,
			$adminUser,
			[ $adminUser->getId(), $subjectUser->getId(), $timeLabel, $endOn, $time ],
			'ban' . $action,
			$reason
		);

		Wikia::purgeSurrogateKey( ChatBanListSpecialController::getAxShowUsersSurrogateKey() );

		return true;
	}

	/**
	 * @param string $subjectUserName
	 * @param string $dir
	 * @param User $requestingUser
	 *
	 * @return bool
	 * @throws DBUnexpectedError
	 */
	public static function blockPrivate( $subjectUserName, $requestingUser, $dir = self::PRIVATE_BLOCK_ADD ) {
		$subjectUser = User::newFromName( $subjectUserName );

		if ( !empty( $subjectUser ) && !$subjectUser->isAnon() && !$requestingUser->isAnon() ) {
			$requestingChatUser = new ChatUser( $requestingUser );
			if ( $dir === self::PRIVATE_BLOCK_ADD ) {
				$requestingChatUser->blockUser( $subjectUser );
			} elseif ( $dir === self::PRIVATE_BLOCK_REMOVE ) {
				$requestingChatUser->unblockUser( $subjectUser );
			}
		}

		return true;
	}

	/**
	 * Takes a time in seconds and returns a human readable string (e.g. "2 hours").
	 *
	 * @param $time
	 * @return string|null
	 */
	protected static function getTimeLabel( $time ) {
		global $wgContLang;

		return $wgContLang->formatTimePeriod( $time , [ 'noabbrevs' => true ] );
	}

	private static function getUserNamesFromIds( $userIds ) {
		if ( !is_array( $userIds ) ) {
			return [ ];
		}

		return array_map( function ( $userId ) {
			return User::newFromId( $userId )->getName();
		}, $userIds );
	}

	/**
	 * @return array
	 */
	public static function getPrivateBlocks() {
		$chatUser = ChatUser::newCurrent();

		$blockedChatUsers = $chatUser->getBlockedUsers();
		$blockedByChatUsers = $chatUser->getBlockedByUsers();

		$result = [
			'blockedChatUsers' => self::getUserNamesFromIds( $blockedChatUsers ),
			'blockedByChatUsers' => self::getUserNamesFromIds( $blockedByChatUsers )
		];

		return $result;
	}

	/**
	 * Add a rights log entry for an action.
	 *
	 * @param User $user
	 * @param User $doer
	 * @param array $attr An array with parameters passed to LogPage::addEntry() according
	 *                    to description there these are parameters passed later to wfMsg.* functions
	 * @param String $type
	 * @param String|null $reason comment added to log
	 */
	public static function addLogEntry( $user, $doer, $attr, $type = 'banadd', $reason = null ) {
		$doerName = $doer->getName();

		$subtype = '';
		if ( strpos( $type, 'ban' ) === 0 ) {
			if ( empty( $reason ) ) {
				// Possible keys: chat-log-reason-banadd, chat-log-reason-banchane, chat-log-reason-banremove
				$reason = wfMessage( 'chat-log-reason-' . $type, $doerName )->inContentLanguage()->text();
			}
			$subtype = 'chat' . $type;
			$type = 'chatban';
		}

		$log = new LogPage( $type );
		$log->addEntry( $subtype,
			$user->getUserPage(),
			$reason,
			$attr,
			$doer
		);
	}

	/**
	 * Add Chat log entry to "Special:Log" and Special:CheckUser;
	 * otherwise to giving a chat moderator or banning this method isn't called via AJAX,
	 * therefore we have to insert all information manually into DB table
	 */
	public static function addConnectionLogEntry() {
		$wg = F::app()->wg;

		// record the IP of the connecting user.
		// throttle adding a log entry using memcached (max. once per 3 minutes)
		$ip = $wg->Request->getIP();
		$memcKey = self::getConnectionLogThrottleCacheKey( $wg->User->getID(), $ip );
		$throttleData = $wg->Memc->get( $memcKey );

		if ( empty( $throttleData ) ) {
			$wg->Memc->set( $memcKey, true, 60 * 3 /*3 min*/ );

			$log = new LogPage( 'chatconnect', false, false );
			$log->addEntry( 'chatconnect', SpecialPage::getTitleFor( 'Chat' ), '', [ $ip ], $wg->User );

			$xff = $wg->Request->getHeader( self::HTTP_HEADER_XFF );
			list( $xff_ip, $isSquidOnly ) = IP::getClientIPfromXFF( $xff );

			$userAgent = $wg->Request->getHeader( self::HTTP_HEADER_USER_AGENT );
			$dbw = wfGetDB( DB_MASTER );
			$cuc_id = $dbw->nextSequenceValue( 'cu_changes_cu_id_seq' );
			$rcRow = [
				'cuc_id' => $cuc_id,
				'cuc_namespace' => NS_SPECIAL,
				'cuc_title' => 'Chat',
				'cuc_minor' => 0,
				'cuc_user' => $wg->User->getID(),
				'cuc_user_text' => $wg->User->getName(),
				'cuc_actiontext' => wfMessage( 'chat-checkuser-join-action' )->inContentLanguage()->text(),
				'cuc_comment' => '',
				'cuc_this_oldid' => 0,
				'cuc_last_oldid' => 0,
				'cuc_type' => CUC_TYPE_CHAT,
				'cuc_timestamp' => $dbw->timestamp(),
				'cuc_ip' => IP::sanitizeIP( $ip ),
				'cuc_ip_hex' => $ip ? IP::toHex( $ip ) : null,
				'cuc_xff' => !$isSquidOnly ? $xff : '',
				'cuc_xff_hex' => ( $xff_ip && !$isSquidOnly ) ? IP::toHex( $xff_ip ) : null,
				'cuc_agent' => ( $userAgent === false ) ? null : $userAgent,
			];

			$dbw->insert( 'cu_changes', $rcRow, __METHOD__ );
		}

	}

	protected static function getConnectionLogThrottleCacheKey( $userId, $ip ) {
		return wfSharedMemcKey( 'Chat', 'userIP', $userId, $ip, 'v1' );
	}

	/**
	 * Since the permission essentially has to be implemented as an anti-permission, this function removes the
	 * need for confusing double-negatives in the code.
	 *
	 * Note: Request should carry the user's IP address for Tor check to work correctly.
	 *
	 * @param User $subjectUser
	 *
	 * @return bool
	 */
	public static function canChat( User $subjectUser ) {
		$chatUser = new ChatUser( $subjectUser );

		if ( $chatUser->isBanned() ||
			 $subjectUser->isBlocked() ||
			 $subjectUser->isAnon()
		) {
			return false;
		}

		// If the TorBlock extension exists, user is an exitNode, and user does not have the torunblocked right
		if ( class_exists( 'TorBlock' ) && TorBlock::isExitNode() && !$subjectUser->isAllowed( 'torunblocked' ) ) {
			return false;
		}

		return $subjectUser->isAllowed( 'chat' );
	}

	/**
	 * Can given admin user ban subject user from chat?
	 *
	 * @param User $subjectUser
	 * @param User $adminUser
	 * @return bool
	 */
	public static function canBan( User $subjectUser, User $adminUser ) {
		return (
			// must be a chat moderator
			$adminUser->isAllowed( self::CHAT_MODERATOR )
			&& (
				!$subjectUser->isAllowed( self::CHAT_MODERATOR )
				// moderators can be kicked only by chat staff/admins
				|| $adminUser->isAllowedAny( self::CHAT_STAFF, self::CHAT_ADMIN )
			) );
	}

	/**
	 * Get a list of ban time length options
	 *
	 * Label are keys, and number of seconds are values
	 *
	 * @return array
	 */
	public static function getBanOptions() {
		return ChatBanTimeOptions::newDefault()->get();
	}

	public static function getChatters() {
		global $wgMemc;

		wfProfileIn( __METHOD__ );
		$memcKey = wfMemcKey( self::CHATTERS_CACHE_KEY );
		$chatters = $wgMemc->get( $memcKey );
		wfProfileOut( __METHOD__ );

		return $chatters ?: [];
	}

	public static function setChatters( $chatters ) {
		global $wgMemc;

		wfProfileIn( __METHOD__ );

		$memcKey = wfMemcKey( self::CHATTERS_CACHE_KEY );
		$wgMemc->set( $memcKey, $chatters, self::CHATTERS_CACHE_TTL );
		ChatWidget::purgeChatUsersCache();
		Chat::purgeChattersCache();

		wfProfileOut( __METHOD__ );
	}

	public static function purgeChattersCache() {
		// CONN-436: Invalidate Varnish cache for ChatRail:GetUsers
		ChatRailController::purgeMethod( 'GetUsers', [ 'format' => 'json' ] );
	}
}
