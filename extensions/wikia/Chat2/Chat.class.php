<?php

use Wikia\DependencyInjection\Injector;
use Wikia\Service\User\Permissions\PermissionsService;

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
	 * @var PermissionsService
	 */
	private static $permissionsService;

	/**
	 * @return PermissionsService
	 */
	private static function permissionsService() {
		if ( is_null( self::$permissionsService ) ) {
			self::$permissionsService = Injector::getInjector()->get( PermissionsService::class );
		}

		return self::$permissionsService;
	}

	/**
	 * The return value of this method gets passed to Javascript as the global wgChatKey.  It then becomes the 'key'
	 * parameter sent with every chat request to the Node.js server.
	 *
	 * The key is then used by ChatAjax::getUserInfo() to load the info back from memcached.
	 *
	 * @return string
	 */
	public static function getSessionKey() {
		self::info( __METHOD__ . ': Method called' );
		$wg = F::app()->wg;

		if ( !$wg->User->isLoggedIn() ) {
			return '';
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
		self::info( __METHOD__ . ': Method called', [
			'subjectUserName' => $subjectUserName,
			'adminUser' => $adminUser,
			'time' => $time,
			'reason' => $reason,
		] );

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

		$cityId = F::app()->wg->CityId;
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

		self::info( __METHOD__ . ': Method called', [
			'cityId' => $cityId,
			'subjectUser' => $subjectUser->getId(),
			'adminUser' => $adminUser->getId(),
			'time' => $time,
			'reason' => $reason,
			'action' => $action,
		] );

		Chat::addLogEntry(
			$subjectUser,
			$adminUser,
			[ $adminUser->getId(), $subjectUser->getId(), $timeLabel, $endOn, $time ],
			'ban' . $action,
			$reason
		);

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
	public static function blockPrivate( $subjectUserName, $dir = self::PRIVATE_BLOCK_ADD, $requestingUser ) {
		self::info( __METHOD__ . ': Method called', [
			'subjectUserName' => $subjectUserName,
			'dir' => $dir,
			'requestingUser' => $requestingUser,
		] );

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
		self::info( __METHOD__ . ': Method called' );

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
	 * Attempts to add the 'chatmoderator' group to the subject user
	 *
	 * @param string $subjectUserName
	 * @param User $adminUser
	 *
	 * @return bool true on success, returns an error message as a string on failure.
	 */
	public static function promoteModerator( $subjectUserName, $adminUser ) {
		self::info( __METHOD__ . ': Method called', [
			'subjectUserName' => $subjectUserName,
			'adminUser' => $adminUser
		] );

		$subjectUser = User::newFromName( $subjectUserName );

		if ( !( $subjectUser instanceof User ) ) {
			$errorMsg = wfMessage( 'chat-err-invalid-username-chatmod', $subjectUserName )->text();

			return $errorMsg;
		}

		// Check if the userToPromote is already in the chatmoderator group.
		$errorMsg = '';
		if ( in_array( self::CHAT_MODERATOR, $subjectUser->getEffectiveGroups() ) ) {
			$errorMsg = wfMessage( "chat-err-already-chatmod", $subjectUserName, self::CHAT_MODERATOR )->text();
		} else if ( self::canPromoteModerator( $subjectUser, $adminUser ) ) {
			self::doPromoteModerator( $adminUser, $subjectUser );
		} else {
			$errorMsg = wfMessage( "chat-err-no-permission-to-add-chatmod", self::CHAT_MODERATOR )->text();
		}

		return ( $errorMsg == "" ? true : $errorMsg );
	}

	/**
	 * Promote given user to moderator and log that action. No permission checks are done here.
	 *
	 * @param User $adminUser
	 * @param User $subjectUser
	 */
	private static function doPromoteModerator( User $adminUser, User $subjectUser ) {
		// Add group
		$oldGroups = $subjectUser->getGroups();
		self::permissionsService()->addToGroup( $adminUser, $subjectUser, self::CHAT_MODERATOR );

		// Run UserRights hook
		$removegroups = [ ];
		$addgroups = [ self::CHAT_MODERATOR ];
		wfRunHooks( 'UserRights', [ &$subjectUser, $addgroups, $removegroups ] );

		// Update user-rights log.
		$newGroups = array_merge( $oldGroups, [ self::CHAT_MODERATOR ] );

		// Log the rights-change.
		Chat::addLogEntry( $subjectUser, $adminUser, [
			Chat::makeGroupNameListForLog( $oldGroups ),
			Chat::makeGroupNameListForLog( $newGroups )
		], self::CHAT_MODERATOR );
	}

	/**
	 * @param array $ids
	 *
	 * @return string
	 */
	public static function makeGroupNameListForLog( $ids ) {
		if ( empty( $ids ) ) {
			return '';
		} else {
			return Chat::makeGroupNameList( $ids );
		}
	}

	/**
	 * @param array $ids
	 *
	 * @return string
	 */
	public static function makeGroupNameList( $ids ) {
		if ( empty( $ids ) ) {
			return wfMessage( 'rightsnone' )->inContentLanguage()->text();
		} else {
			return implode( ', ', $ids );
		}
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
		$wg = F::app()->wg;

		self::addConnectionLogEntry();

		if ( $wg->DevelEnvironment ) {
			return;
		}

		$dbw = wfGetDB( DB_MASTER, [ ], $wg->StatsDB );

		$wikiId = intval( $wg->CityId );
		$userId = intval( $wg->User->GetId() );
		if ( $wikiId > 0 && $userId > 0 ) {
			$eventRow = [
				'wiki_id' => $wg->CityId,
				'user_id' => $wg->User->GetId(),
				'event_type' => 6
			];

			if ( !wfReadOnly() ) { // Change to wgReadOnlyDbMode if we implement that
				$dbw->insert( 'chatlog', $eventRow, __METHOD__ );
			}
		} else {
			wfDebugLog( 'chat', 'User did open a chat room but it was not logged in chatlog' );
		}

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
		if ( $type === self::CHAT_MODERATOR ) {
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
		global $wgUser;

		if ( !$subjectUser->equals($wgUser) ) {
			self::info( __METHOD__ . ': Method called for arbitrary user', [
				'wgUserName' => $wgUser->getName(),
				'subjectUserName' => $subjectUser->getName(),
			] );
		}

		if ( $subjectUser->isAnon() ) {
			return false;
		}

		if ( $subjectUser->isBlocked() ) {
			return false;
		}

		$chatUser = new ChatUser( $subjectUser );
		if ( $chatUser->isBanned() ) {
			return false;
		}

		// If the TorBlock extension exists, user is an exitNode, and user does not have the torunblocked right
		if ( class_exists( 'TorBlock' ) && TorBlock::isExitNode() && !$subjectUser->isAllowed( 'torunblocked' ) ) {
			return false;
		}

		return $subjectUser->isAllowed( 'chat' );
	}

	/**
	 * Can given admin user kick subject user from chat?
	 *
	 * @param User $subjectUser
	 * @param User $adminUser
	 * @return bool
	 */
	public static function canKick( User $subjectUser, User $adminUser ) {
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
	 * Can given admin user ban subject user from chat?
	 *
	 * @param User $subjectUser
	 * @param User $adminUser
	 * @return bool
	 */
	public static function canBan( User $subjectUser, User $adminUser ) {
		return self::canKick( $subjectUser, $adminUser );
	}

	/**
	 * Can given admin user promote subject user to become moderator?
	 *
	 * @param User $subjectUser
	 * @param User $adminUser
	 * @return bool
	 */
	public static function canPromoteModerator( User $subjectUser, User $adminUser ) {
		$changeableGroups = $adminUser->changeableGroups();
		$isSelf = ( $subjectUser->getName() == $adminUser->getName() );
		$addableGroups = array_merge( $changeableGroups['add'], $isSelf ? $changeableGroups['add-self'] : [ ] );

		return in_array( self::CHAT_MODERATOR, $addableGroups );
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

	public static function info( $message, Array $params = [ ] ) {
		\Wikia\Logger\WikiaLogger::instance()->info( 'CHAT: ' . $message, $params );
	}

	public static function debug( $message, Array $params = [ ] ) {
		\Wikia\Logger\WikiaLogger::instance()->debug( 'CHAT: ' . $message, $params );
	}

}
