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

	// Cache ban info for 5m
	const BAN_INFO_TTL = 300;

	var $chatId;

	public function __construct( $chatId ) {
		$this->chatId = $chatId;
	}

	/**
	 * The return value of this method gets passed to Javascript as the global wgChatKey.  It then becomes the 'key'
	 * parameter sent with every chat request to the Node.js server.
	 *
	 * The key is then used by ChatAjax::getUserInfo() to load the info back from memcached.
	 *
	 * Here is the original description of this method, which is likely old and incorrect:
	 * ---
	 *
	 * This function is meant to just echo the COOKIES which are available to the apache server.
	 *
	 * This helps to work around a limitation in the fact that javascript can't access the second-level-domain's
	 * cookies even if they're authorized to be accessed by subdomains (eg: ".wikia.com" cookies are viewable by apache
	 * on lyrics.wikia.com, but interestingly, isn't in document.cookie in the javascript on lyrics.wikia.com).
	 */
	static public function echoCookies() {
		ChatHelper::info( __METHOD__ . ': Method called' );

		global $wgUser, $wgMemc;
		if ( !$wgUser->isLoggedIn() ) {
			return [ "key" => false ];
		}
		$key = "Chat::cookies::" . sha1( $wgUser->getId() . "_" . microtime() . '_' .  mt_rand() );
		$wgMemc->set( $key, [ "user_id" => $wgUser->getId(), "cookie" => $_COOKIE ] , 60 * 60 * 48 );
		return $key;
	}


	/**
	 * Given a username, if the current user has permission to do so, ban the user
	 * from chat on the current wiki. This can be reversed by removing them from
	 * the 'bannedfromchat' group.
	 *
	 * Will set doKickAnyway to true if the user should be kicked despite any error
	 * messages (this is used primarily when the user is already banned from the wiki.
	 * in that case, there is an error, but if the user is present they should be kicked).
	 *
	 * @param string $userNameToKickBan
	 * @param User $kickingUser
	 * @param int $time
	 * @param string $reason
	 *
	 * @return bool|string Returns true on success, returns an error message as a string on failure.
	 */
	static public function banUser( $userNameToKickBan, $kickingUser, $time, $reason ) {
		ChatHelper::info( __METHOD__ . ': Method called', [
			'userNameToKickBan' => $userNameToKickBan,
			'kickingUser' => $kickingUser,
			'time' => $time,
			'reason' => $reason,
		] );

		$kickBanPermission = 'chatmoderator';
		$userToKickBan = User::newFromName( $userNameToKickBan );

		// Make sure user doing the kick/ban has permission to do so
		if ( !( $userToKickBan instanceof User ) ||
			 !$kickingUser->isAllowed( $kickBanPermission ) ) {

			return wfMessage( 'chat-ban-you-need-permission', $kickBanPermission )
				->inContentLanguage()->text() . "\n";
		}

		// Make sure we aren't trying to kick/ban someone who shouldn't be kick/banned
		if ( $userToKickBan->isAllowed( $kickBanPermission ) && !$kickingUser->isAllowed( 'chatstaff' ) && !$kickingUser->isAllowed( 'chatadmin' ) ) {
			return wfMessage( 'chat-ban-cant-ban-moderator' )
				->inContentLanguage()->text() . "\n";
		}

		self::banUserDB(
			F::app()->wg->CityId,
			$userToKickBan,
			$kickingUser,
			$time,
			$reason,
			$time == 0 ? 'remove': 'add'
		);

		return true;
	}

	/**
	 * @param string $username
	 * @param string $dir
	 * @param User $kickingUser
	 *
	 * @return bool
	 * @throws DBUnexpectedError
	 */
	public static function blockPrivate( $username, $dir = 'add', $kickingUser ) {
		ChatHelper::info( __METHOD__ . ': Method called', [
			'username' => $username,
			'dir' => $dir,
			'kickingUser' => $kickingUser,
		] );
		global $wgExternalDatawareDB;
		wfProfileIn( __METHOD__ );

		$kickingUserId = intval( $kickingUser->getId() );
		$userToBlock = User::newFromName( $username );
		$dbw = wfGetDB( DB_MASTER, [], $wgExternalDatawareDB );

		if ( !empty( $userToBlock ) && $kickingUserId > 0 ) {
			if ( !wfReadOnly() ) { // Change to wgReadOnlyDbMode if we implement thatwgReadOnly
				if ( $dir == 'remove' ) {
					$dbw->delete(
						"chat_blocked_users",
						[
							'cbu_user_id' => $kickingUserId,
							'cbu_blocked_user_id' => $userToBlock->getId()
						],
						__METHOD__
					);
				} else {
					$dbw->insert(
						"chat_blocked_users",
						[
							'cbu_user_id' => $kickingUserId,
							'cbu_blocked_user_id' => $userToBlock->getId()
						],
						__METHOD__,
						[ 'IGNORE' ]
					);
				}
				$dbw->commit();
			}
		}
		wfProfileOut( __METHOD__ );
		return true;
	}

	/**
	 * @param int $cityId
	 * @param User $banUser
	 * @param User $adminUser
	 * @param int $time
	 * @param string $reason
	 * @param string $dir
	 *
	 * @throws DBUnexpectedError
	 * @throws MWException
	 */
	public static function banUserDB( $cityId, $banUser, $adminUser, $time, $reason, $dir = 'add' ) {
		if ( empty( $banUser ) || empty( $adminUser ) ) {
			return;
		}

		if ( wfReadOnly() ) {
			return;
		}

		$adminID = $adminUser->getId();
		$userID = $banUser->getId();

		if ( $dir == 'remove' ) {
			$timeLabel = $endOn = null;

			self::deleteUserBanFromDB( $cityId, $userID );
		} else {
			if ( Chat::getBanInformation( $cityId, $banUser ) !== false ) {
				$dir = "change";
			}

			$timeLabel = self::getTimeLabel( $time );
			$endOn = time() + $time;

			self::addUserBanToDB( $cityId, $userID, $adminID, $endOn, $reason );
		}

		ChatHelper::info( __METHOD__ . ': Method called', [
			'cityId' => $cityId,
			'banUser' => $userID,
			'adminUser' => $adminID,
			'time' => $time,
			'reason' => $reason,
			'dir' => $dir,
		] );

		Chat::addLogEntry(
			$banUser,
			$adminUser,
			[ $adminID, $userID, $timeLabel, $endOn ],
			'ban' . $dir,
			$reason
		);
	}

	protected static function deleteUserBanFromDB( $wikiID, $userID ) {
		$dbw = wfGetDB( DB_MASTER, [], F::app()->wg->ExternalDatawareDB );
		( new WikiaSQL() )
			->DELETE( 'chat_ban_users' )
			->WHERE( 'cbu_wiki_id' )->EQUAL_TO( $wikiID )
			->AND_( 'cbu_user_id' )->EQUAL_TO( $userID )
			->run( $dbw );

		self::clearBanInfoCache( $wikiID, $userID );
	}

	protected static function addUserBanToDB( $wikiID, $userID, $adminID, $endOn, $reason ) {
		$dbw = wfGetDB( DB_MASTER, [], F::app()->wg->ExternalDatawareDB );

		$dbw->replace(
			'chat_ban_users',
			null,
			[
				'cbu_wiki_id' => $wikiID,
				'cbu_user_id' => $userID,
				'cbu_admin_user_id' => $adminID,
				'start_date' => wfTimestamp( TS_MW ),
				'end_date' => wfTimestamp( TS_MW, $endOn ),
				'reason' =>  $reason
			],
			__METHOD__
		);

		self::clearBanInfoCache( $wikiID, $userID );
	}

	protected static function getTimeLabel( $time ) {
		$timeLabel = null;

		$options = self::getBanOptions();
		foreach ( $options as $key => $val ) {
			if ( $val == $time ) {
				$timeLabel = $key;
			}
		}

		return $timeLabel;
	}

	/**
	 * Return ban information, if user is not banned, return false
	 *
	 * @param int $cityID
	 * @param User $banUser
	 *
	 * @return bool|object
	 *
	 * @throws MWException
	 */
	public static function getBanInformation( $cityID, User $banUser ) {
		ChatHelper::info( __METHOD__ . ': Method called', [
			'cityId' => $cityID,
			'banUser' => $banUser,
		] );

		$userID = $banUser->getId();
		$key = self::getBanInfoCacheKey( $cityID, $userID );

		$banInfo = WikiaDataAccess::cache( $key, self::BAN_INFO_TTL, function () use ( $cityID, $userID ) {
			ChatHelper::info( __METHOD__ . ': Cache miss - querying DB', [
				'cityId' => $cityID,
				'userID' => $userID,
			] );

			return self::getBanInfoFromDB( $cityID, $userID );
		} );

		return empty( $banInfo ) ? false : $banInfo;
	}

	private static function getBanInfoFromDB( $cityID, $userID ) {

		$db = wfGetDB( DB_SLAVE, [], F::app()->wg->ExternalDatawareDB );

		$info = ( new WikiaSQL() )
			->SELECT( 'cbu_wiki_id' )
			->FIELD( 'cbu_user_id' )
			->FIELD( 'cbu_admin_user_id' )
			->FIELD( 'end_date' )
			->FIELD( 'reason' )
			->FROM( 'chat_ban_users' )
			->WHERE( 'cbu_wiki_id' )->EQUAL_TO( $cityID )
			->AND_( 'cbu_user_id' )->EQUAL_TO( $userID )
			->run( $db, function ( ResultWrapper $res ) {
				$row = $res->fetchObject();
				if ( empty( $row ) ) {
					return false;
				}

				$row->end_date = wfTimestamp( TS_UNIX, $row->end_date );
				if ( $row->end_date < time() ) {
					return false;
				}

				return $row;
			} );

		return $info;
	}

	public static function clearBanInfoCache( $wikiID, $userID ) {
		$key = self::getBanInfoCacheKey( $wikiID, $userID );
		WikiaDataAccess::cachePurge( $key );
	}

	private static function getBanInfoCacheKey( $wikiID, $userID ) {
		return wfMemcKey( 'chat-baninfo', $wikiID, $userID );
	}

	private static function userIds2UserNames( $in ) {
		wfProfileIn( __METHOD__ );
		if ( !is_array( $in ) ) {
			$in = [];
		}

		$out = [];
		foreach ( $in as $value ) {
			$user = User::newFromID( $value );
			$out[] = $user->getName();
		}
		wfProfileOut( __METHOD__ );
		return $out;
	}

	/**
	 * @return array
	 */
	public static function getListOfBlockedPrivate() {
		ChatHelper::info( __METHOD__ . ': Method called' );
		global $wgUser, $wgExternalDatawareDB;
		wfProfileIn( __METHOD__ );
		$dbw = wfGetDB( DB_MASTER, [], $wgExternalDatawareDB );

		$res = $dbw->select (
			"chat_blocked_users",
			[ 'cbu_user_id', 'cbu_blocked_user_id' ],
			[ 'cbu_user_id' => $wgUser->getId() ],
			__METHOD__
		);

		$blockedChatUsers = [];
		while ( $row = $res->fetchObject() ) {
			$blockedChatUsers[] = $row->cbu_blocked_user_id;
		}

		$res = $dbw->select (
			"chat_blocked_users",
			[ 'cbu_user_id', 'cbu_blocked_user_id' ],
			[ 'cbu_blocked_user_id' => $wgUser->getId() ],
			__METHOD__
		);

		$blockedByChatUsers = [];
		while ( $row = $res->fetchObject() ) {
			$blockedByChatUsers[] = $row->cbu_user_id;
		}

		$result = [
			'blockedChatUsers' => self::userIds2UserNames( $blockedChatUsers ),
			'blockedByChatUsers' => self::userIds2UserNames( $blockedByChatUsers )
		];
		wfProfileOut( __METHOD__ );
		return $result;
	}

	/**
	 * Attempts to add the 'chatmoderator' group to the user whose name is provided
	 * in 'userNameToPromote'.
	 *
	 * @param string $userNameToPromote
	 * @param User $promotingUser
	 *
	 * @return bool true on success, returns an error message as a string on failure.
	 */
	static public function promoteChatModerator( $userNameToPromote, $promotingUser ) {
		ChatHelper::info( __METHOD__ . ': Method called', [
			'userNameToPromote' => $userNameToPromote,
			'promotingUser' => $promotingUser
		] );
		wfProfileIn( __METHOD__ );
		$CHAT_MOD_GROUP = 'chatmoderator';

		$userToPromote = User::newFromName( $userNameToPromote );

		if ( !( $userToPromote instanceof User ) ) {
			$errorMsg = wfMessage( 'chat-err-invalid-username-chatmod', $userNameToPromote )->text();

			wfProfileOut( __METHOD__ );
			return $errorMsg;
		}

		// Check if the userToPromote is already in the chatmoderator group.
		$errorMsg = '';
		if ( in_array( $CHAT_MOD_GROUP, $userToPromote->getEffectiveGroups() ) ) {
			$errorMsg = wfMessage( "chat-err-already-chatmod", $userNameToPromote, $CHAT_MOD_GROUP )->text();
		} else {
			$changeableGroups = $promotingUser->changeableGroups();
			$promotingUserName = $promotingUser->getName();
			$isSelf = ( $userToPromote->getName() == $promotingUserName );
			$addableGroups = array_merge( $changeableGroups['add'], $isSelf ? $changeableGroups['add-self'] : [] );

			if ( in_array( $CHAT_MOD_GROUP, $addableGroups ) ) {
				// Adding the group is allowed. Add the group, clear the cache, run necessary hooks, and log the change.
				$oldGroups = $userToPromote->getGroups();

				$userToPromote->addGroup( $CHAT_MOD_GROUP );
				$userToPromote->invalidateCache();

				if ( $userToPromote instanceof User ) {
					$removegroups = [];
					$addgroups = [ $CHAT_MOD_GROUP ];
					wfRunHooks( 'UserRights', [ &$userToPromote, $addgroups, $removegroups ] );
				}

				// Update user-rights log.
				$newGroups = array_merge( $oldGroups, [ $CHAT_MOD_GROUP ] );

				// Log the rights-change.
				Chat::addLogEntry( $userToPromote, $promotingUser, [
					Chat::makeGroupNameListForLog( $oldGroups ),
					Chat::makeGroupNameListForLog( $newGroups )
				], 'chatmoderator' );
			} else {
				$errorMsg = wfMessage( "chat-err-no-permission-to-add-chatmod", $CHAT_MOD_GROUP )->text();
			}
		}

		wfProfileOut( __METHOD__ );
		return ( $errorMsg == "" ? true : $errorMsg );
	}


	static public function makeGroupNameListForLog( $ids ) {
		if ( empty( $ids ) ) {
			return '';
		} else {
			return Chat::makeGroupNameList( $ids );
		}
	}
	static public function makeGroupNameList( $ids ) {
		if ( empty( $ids ) ) {
			return wfMessage( 'rightsnone' )->inContentLanguage()->text();
		} else {
			return implode( ', ', $ids );
		}
	}

	/**
	 * Returns true if the user with the provided username has the 'chatmoderator' right
	 * on the current wiki.
	 *
	 * @param string $userName
	 *
	 * @return bool
	 */
	static public function isChatMod( $userName ) {
		wfProfileIn( __METHOD__ );

		$isChatMod = false;
		$user = User::newFromName( $userName );
		if ( !empty( $user ) ) {
			$isChatMod = $user->isAllowed( 'chatmoderator' );
		}

		wfProfileOut( __METHOD__ );
		return $isChatMod;
	}

	/**
	 * Add a rights log entry for an action.
	 * Partially copied from SpecialUserrights.php
	 *
	 * @param User $user
	 * @param User $doer
	 * @param Array $attr An array with parameters passed to LogPage::addEntry() according
	 *                    to description there these are parameters passed later to wfMsg.* functions
	 * @param String $type
	 * @param String|null $reason comment added to log
	 */
	public static function addLogEntry( $user, $doer, $attr, $type = 'banadd', $reason = null ) {
		$doerName = $doer->getName();

		$subtype = '';
		if ( $type === 'chatmoderator' ) {
			if ( empty( $reason ) ) {
				$reason = wfMessage(
					'chat-userrightslog-a-made-b-chatmod',
					$doerName,
					$user->getName()
				)->inContentLanguage()->text();
			}
			$type = 'rights';
			$subtype = $type;
		} else if ( strpos( $type, 'ban' ) === 0 ) {
			if ( empty( $reason ) ) {
				// Possible keys: chat-log-reason-banadd, chat-log-reason-bandelete, chat-log-reason-banreplace
				$reason = wfMessage( 'chat-log-reason-' . $type, $doerName )->inContentLanguage()->text();
			}
			$subtype = 'chat' . $type;
			$type =  'chatban';
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
	 * Logs to chatlog table that a user opened chat room
	 *
	 * Using chatlog table is temporary. It'll be last till event_type_description table will be done.
	 * Now we have:
	 * mysql> select * from event_type_details ;
	 * +------------------------+------------+
	 * | event_type_detail_text | event_type |
	 * +------------------------+------------+
	 * | EDIT_CATEGORY          |          1 |
	 * | CREATEPAGE_CATEGORY    |          2 |
	 * | DELETE_CATEGORY        |          3 |
	 * | UNDELETE_CATEGORY      |          4 |
	 * | UPLOAD_CATEGORY        |          5 |
	 * +------------------------+------------+
	 *
	 * That's why I put as default 6 as a event_type value.
	 *
	 * @author Andrzej 'nAndy' Łukaszewski
	 */
	public static function logChatWindowOpenedEvent() {
		global $wgCityId, $wgUser, $wgDevelEnvironment, $wgStatsDB;

		wfProfileIn( __METHOD__ );

		self::addConnectionLogEntry();

		if ( $wgDevelEnvironment ) {
		// devbox
			wfProfileOut( __METHOD__ );
			return;
		}

		// production
		$dbw = wfGetDB( DB_MASTER, [], $wgStatsDB );

		$wikiId = intval( $wgCityId );
		$userId = intval( $wgUser->GetId() );
		if ( $wikiId > 0 && $userId > 0 ) {
			$eventRow = [
				'wiki_id' => $wgCityId,
				'user_id' => $wgUser->GetId(),
				'event_type' => 6
			];

			if ( !wfReadOnly() ) { // Change to wgReadOnlyDbMode if we implement thatwgReadOnly
				$dbw->insert( 'chatlog', $eventRow, __METHOD__ );
				$dbw->commit();
			}
		} else {
			wfDebugLog( 'chat', 'User did open a chat room but it was not logged in chatlog' );
		}

		wfProfileOut( __METHOD__ );
	}

	/**
	 * @desc Add Chat log entry to "Special:Log" and Special:CheckUser;
	 * otherwise to giving a chat moderator or banning this method isn't called via AJAX,
	 * therefore we have to insert all information manually into DB table
	 */
	public static function addConnectionLogEntry() {
		global $wgMemc, $wgUser, $wgRequest;
		wfProfileIn( __METHOD__ );

		// record the IP of the connecting user.
		// use memcache so we order only one (user, ip) pair 3 min to avoid flooding the log
		$ip = $wgRequest->getIP();
		$memcKey = self::getUserIPMemcKey( $wgUser->getID(), $ip );
		$entry = $wgMemc->get( $memcKey, false );

		if ( empty( $entry ) ) {
			$wgMemc->set( $memcKey, true, 60 * 3 /*3 min*/ );

			$log = new LogPage( 'chatconnect', false, false );
			$log->addEntry( 'chatconnect', SpecialPage::getTitleFor( 'Chat' ), '', [ $ip ], $wgUser );

			$xff = $wgRequest->getHeader( self::HTTP_HEADER_XFF );
			list( $xff_ip, $isSquidOnly ) = IP::getClientIPfromXFF( $xff );

			$userAgent = $wgRequest->getHeader( self::HTTP_HEADER_USER_AGENT );
			$dbw = wfGetDB( DB_MASTER );
			$cuc_id = $dbw->nextSequenceValue( 'cu_changes_cu_id_seq' );
			$rcRow = [
					'cuc_id'         => $cuc_id,
					'cuc_namespace'  => NS_SPECIAL,
					'cuc_title'      => 'Chat',
					'cuc_minor'      => 0,
					'cuc_user'       => $wgUser->getID(),
					'cuc_user_text'  => $wgUser->getName(),
					'cuc_actiontext' => wfMessage( 'chat-checkuser-join-action' )->inContentLanguage()->text(),
					'cuc_comment'    => '',
					'cuc_this_oldid' => 0,
					'cuc_last_oldid' => 0,
					'cuc_type'       => CUC_TYPE_CHAT,
					'cuc_timestamp'  => $dbw->timestamp(),
					'cuc_ip'         => IP::sanitizeIP( $ip ),
					'cuc_ip_hex'     => $ip ? IP::toHex( $ip ) : null,
					'cuc_xff'        => !$isSquidOnly ? $xff : '',
					'cuc_xff_hex'    => ( $xff_ip && !$isSquidOnly ) ? IP::toHex( $xff_ip ) : null,
					'cuc_agent'      => ( $userAgent === false ) ? null : $userAgent,
			];

			$dbw->insert( 'cu_changes', $rcRow, __METHOD__ );
			$dbw->commit();
		}

		wfProfileOut( __METHOD__ );
	}


	static protected function getUserIPMemcKey( $userId, $address ) {
		return $userId . '_' .  $address . '_v1';
	}

	/**
	 * Since the permission essentially has to be implemented as an anti-permission, this function removes the
	 * need for confusing double-negatives in the code.
	 *
	 * @param User $userObject - an object of class User (such as wgUser).
	 *
	 * @return bool
	 */
	public static function canChat( $userObject ) {
		global $wgCityId;

		if ( $userObject->isBlocked() ) {
			return false;
		}

		if ( Chat::getBanInformation( $wgCityId, $userObject ) !== false ) {
			return false;
		}

		return ( $userObject->isLoggedin() && $userObject->isAllowed( 'chat' ) );
	}

	static public function getBanTimeFactors() {
		return [
			'minutes' => 60,
			'hours' => 60 * 60,
			'days' => 60 * 60 * 24,
			'weeks' => 60 * 60 * 24 * 7,
			'months' => 60 * 60 * 24 * 30,
			'years' => 60 * 60 * 24 * 365
		];
	}

	static public function getBanOptions() {
		wfProfileIn( __METHOD__ );
		$in = wfMessage( 'chat-ban-option-list' )->inContentLanguage()->text();
		$in = preg_replace( '!\s+!', ' ', $in );
		$list = explode( ',', $in );
		$out = [];

		$factors = self::getBanTimeFactors();

		foreach ( $list as $val ) {
			$explode1 = explode( ':', $val );
			if ( count( $explode1 ) != 2 ) {
				continue;
			}
			$label = $explode1[0];

			if ( trim( $explode1[1] ) == 'infinite' ) {
				$out[$label] =  $factors['years'] * 1000;
				continue;
			}

			$explode2 = explode( ' ', $explode1[1] );

			if ( count( $explode2 ) != 2 ) {
				continue;
			}

			$factor = trim( $explode2[1] );
			$factor = (int) ( empty( $factors[$factor] ) ? ( empty( $factors[$factor . 's'] ) ? 0: $factors[$factor . 's'] ): $factors[$factor] );

			if ( $factor < 1 ) {
				continue;
			}

			$base = (int) trim( $explode2[0] );

			if ( $base < 1 ) {
				continue;
			}

			$out[$label] = $base * $factor;
		}

		wfProfileOut( __METHOD__ );
		return $out;
	}
}
