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

	const CHAT_MODERATOR = 'chatmoderator';

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
	 * Here is the original description of this method, which is likely old and incorrect:
	 * ---
	 *
	 * This function is meant to just echo the COOKIES which are available to the apache server.
	 *
	 * This helps to work around a limitation in the fact that javascript can't access the second-level-domain's
	 * cookies even if they're authorized to be accessed by subdomains (eg: ".wikia.com" cookies are viewable by apache
	 * on lyrics.wikia.com, but interestingly, isn't in document.cookie in the javascript on lyrics.wikia.com).
	 */
	public static function echoCookies() {
		self::info( __METHOD__ . ': Method called' );
		$wg = F::app()->wg;

		if ( !$wg->User->isLoggedIn() ) {
			return [ "key" => false ];
		}
		$key = "Chat::cookies::" . sha1( $wg->User->getId() . "_" . microtime() . '_' . mt_rand() );
		$wg->Memc->set( $key, [ "user_id" => $wg->User->getId(), "cookie" => $_COOKIE ], 60 * 60 * 48 );

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
	public static function banUser( $userNameToKickBan, $kickingUser, $time, $reason ) {
		self::info( __METHOD__ . ': Method called', [
			'userNameToKickBan' => $userNameToKickBan,
			'kickingUser' => $kickingUser,
			'time' => $time,
			'reason' => $reason,
		] );

		$userToKickBan = User::newFromName( $userNameToKickBan );

		// Make sure user doing the kick/ban has permission to do so
		if ( !( $userToKickBan instanceof User ) ||
			!$kickingUser->isAllowed( self::CHAT_MODERATOR )
		) {

			return wfMessage( 'chat-ban-you-need-permission', self::CHAT_MODERATOR )
				->inContentLanguage()->text() . "\n";
		}

		// Make sure we aren't trying to kick/ban someone who shouldn't be kick/banned
		if ( $userToKickBan->isAllowed( self::CHAT_MODERATOR ) && !$kickingUser->isAllowed( 'chatstaff' ) && !$kickingUser->isAllowed( 'chatadmin' ) ) {
			return wfMessage( 'chat-ban-cant-ban-moderator' )
				->inContentLanguage()->text() . "\n";
		}

		self::banUserDB(
			F::app()->wg->CityId,
			$userToKickBan,
			$kickingUser,
			$time,
			$reason,
			$time == 0 ? 'remove' : 'add'
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
		self::info( __METHOD__ . ': Method called', [
			'username' => $username,
			'dir' => $dir,
			'kickingUser' => $kickingUser,
		] );

		$blockedUser = User::newFromName( $username );

		if ( !empty( $blockedUser ) && !$kickingUser->isAnon() ) {
			$chatUser = new ChatUser( $kickingUser );
			if ( $dir == 'remove' ) {
				$chatUser->unblockUser( $blockedUser );
			} else {
				$chatUser->blockUser( $blockedUser );
			}
			wfGetDB( DB_MASTER, [ ], F::app()->wg->ExternalDatawareDB );
		}

		return true;
	}

	/**
	 * Add, update or remove a user ban from chat on a specific wikia
	 *
	 * @param int $cityId The ID of the wikia where the user was banned
	 * @param User $banUser The ID of the user who was banned
	 * @param User $adminUser The ID of the user doing the banning if adding or updating
	 * @param int $time The time in seconds to ban the user if adding or updating
	 * @param string $reason Why the user ban status was changed
	 * @param string $action The operation
	 *
	 * @throws DBUnexpectedError
	 * @throws MWException
	 */
	public static function banUserDB( $cityId, $banUser, $adminUser, $time, $reason, $action = 'add' ) {
		if ( empty( $banUser ) || empty( $adminUser ) ) {
			return;
		}

		if ( wfReadOnly() ) {
			return;
		}

		$adminID = $adminUser->getId();
		$userID = $banUser->getId();

		$chatUser = ChatUser::newFromId( $userID, $cityId );

		if ( $action == 'remove' ) {
			$timeLabel = $endOn = null;
			$chatUser->unban();
		} else {
			if ( $chatUser->isBanned() ) {
				$action = 'change';
			}

			$timeLabel = self::getTimeLabel( $time );
			$endOn = time() + $time;

			$chatUser->ban( $adminID, $endOn, $reason );
		}

		self::info( __METHOD__ . ': Method called', [
			'cityId' => $cityId,
			'banUser' => $userID,
			'adminUser' => $adminID,
			'time' => $time,
			'reason' => $reason,
			'action' => $action,
		] );

		Chat::addLogEntry(
			$banUser,
			$adminUser,
			[ $adminID, $userID, $timeLabel, $endOn ],
			'ban' . $action,
			$reason
		);
	}

	/**
	 * Takes a time in seconds and returns a human readable string (e.g. "2 hours").
	 * This bizarre system only works for the time periods defined in the
	 * chat-ban-option-list i18n message.
	 *
	 * @param $time
	 *
	 * @return null|string
	 */
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

	private static function getUserNamesFromIds( $userIds ) {
		if ( !is_array( $userIds ) ) {
			$userIds = [ ];
		}

		$userNames = [ ];
		foreach ( $userIds as $value ) {
			$user = User::newFromID( $value );
			$userNames[] = $user->getName();
		}

		return $userNames;
	}

	/**
	 * @return array
	 */
	public static function getListOfBlockedPrivate() {
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
	 * Attempts to add the 'chatmoderator' group to the user whose name is provided
	 * in 'userNameToPromote'.
	 *
	 * @param string $userNameToPromote
	 * @param User $promotingUser
	 *
	 * @return bool true on success, returns an error message as a string on failure.
	 */
	public static function promoteChatModerator( $userNameToPromote, $promotingUser ) {
		self::info( __METHOD__ . ': Method called', [
			'userNameToPromote' => $userNameToPromote,
			'promotingUser' => $promotingUser
		] );

		$userToPromote = User::newFromName( $userNameToPromote );

		if ( !( $userToPromote instanceof User ) ) {
			$errorMsg = wfMessage( 'chat-err-invalid-username-chatmod', $userNameToPromote )->text();

			return $errorMsg;
		}

		// Check if the userToPromote is already in the chatmoderator group.
		$errorMsg = '';
		if ( in_array( self::CHAT_MODERATOR, $userToPromote->getEffectiveGroups() ) ) {
			$errorMsg = wfMessage( "chat-err-already-chatmod", $userNameToPromote, self::CHAT_MODERATOR )->text();
		} else {
			$changeableGroups = $promotingUser->changeableGroups();
			$promotingUserName = $promotingUser->getName();
			$isSelf = ( $userToPromote->getName() == $promotingUserName );
			$addableGroups = array_merge( $changeableGroups['add'], $isSelf ? $changeableGroups['add-self'] : [ ] );

			if ( in_array( self::CHAT_MODERATOR, $addableGroups ) ) {
				// Adding the group is allowed. Add the group, clear the cache, run necessary hooks, and log the change.
				$oldGroups = $userToPromote->getGroups();

				self::permissionsService()->addToGroup( $promotingUser, $userToPromote, self::CHAT_MODERATOR );

				if ( $userToPromote instanceof User ) {
					$removegroups = [ ];
					$addgroups = [ self::CHAT_MODERATOR ];
					wfRunHooks( 'UserRights', [ &$userToPromote, $addgroups, $removegroups ] );
				}

				// Update user-rights log.
				$newGroups = array_merge( $oldGroups, [ self::CHAT_MODERATOR ] );

				// Log the rights-change.
				Chat::addLogEntry( $userToPromote, $promotingUser, [
					Chat::makeGroupNameListForLog( $oldGroups ),
					Chat::makeGroupNameListForLog( $newGroups )
				], self::CHAT_MODERATOR );
			} else {
				$errorMsg = wfMessage( "chat-err-no-permission-to-add-chatmod", self::CHAT_MODERATOR )->text();
			}
		}

		return ( $errorMsg == "" ? true : $errorMsg );
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
	 * Returns true if the user with the provided username has the 'chatmoderator' right
	 * on the current wiki.
	 *
	 * @param string $userName
	 *
	 * @return bool
	 */
	public static function isChatMod( $userName ) {

		$isChatMod = false;
		$user = User::newFromName( $userName );
		if ( !empty( $user ) ) {
			$isChatMod = $user->isAllowed( self::CHAT_MODERATOR );
		}

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
				// Possible keys: chat-log-reason-banadd, chat-log-reason-bandelete, chat-log-reason-banreplace
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

			if ( !wfReadOnly() ) { // Change to wgReadOnlyDbMode if we implement thatwgReadOnly
				$dbw->insert( 'chatlog', $eventRow, __METHOD__ );
				$dbw->commit();
			}
		} else {
			wfDebugLog( 'chat', 'User did open a chat room but it was not logged in chatlog' );
		}

	}

	/**
	 * @desc Add Chat log entry to "Special:Log" and Special:CheckUser;
	 * otherwise to giving a chat moderator or banning this method isn't called via AJAX,
	 * therefore we have to insert all information manually into DB table
	 */
	public static function addConnectionLogEntry() {
		$wg = F::app()->wg;

		// record the IP of the connecting user.
		// use memcache so we order only one (user, ip) pair 3 min to avoid flooding the log
		$ip = $wg->Request->getIP();
		$memcKey = self::getUserIPMemcKey( $wg->User->getID(), $ip );
		$entry = $wg->Memc->get( $memcKey );

		if ( empty( $entry ) ) {
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
			$dbw->commit();
		}

	}

	protected static function getUserIPMemcKey( $userId, $address ) {
		return wfSharedMemcKey( 'Chat', 'userIP', $userId, $address, 'v1' );
	}

	/**
	 * Since the permission essentially has to be implemented as an anti-permission, this function removes the
	 * need for confusing double-negatives in the code.
	 *
	 * @param User $userObject - an object of class User (such as wgUser).
	 *
	 * @return bool
	 */
	public static function canChat( User $userObject ) {
		if ( $userObject->isAnon() ) {
			return false;
		}

		if ( $userObject->isBlocked() ) {
			return false;
		}

		$chatUser = new ChatUser( $userObject );
		if ( $chatUser->isBanned() ) {
			return false;
		}

		return $userObject->isAllowed( 'chat' );
	}

	/**
	 * Get a list of ban time length options
	 *
	 * @return array
	 */
	public static function getBanOptions() {
		$in = wfMessage( 'chat-ban-option-list' )->inContentLanguage()->text();
		$in = preg_replace( '!\s+!', ' ', $in );
		$list = explode( ',', $in );
		$out = [ ];

		$factors = self::getBanTimeFactors();

		foreach ( $list as $val ) {
			$explode1 = explode( ':', $val );
			if ( count( $explode1 ) != 2 ) {
				continue;
			}
			$label = $explode1[0];

			if ( trim( $explode1[1] ) == 'infinite' ) {
				$out[$label] = $factors['years'] * 1000;
				continue;
			}

			$explode2 = explode( ' ', $explode1[1] );

			if ( count( $explode2 ) != 2 ) {
				continue;
			}

			$factor = trim( $explode2[1] );
			$factor = (int)( empty( $factors[$factor] ) ? ( empty( $factors[$factor . 's'] ) ? 0 : $factors[$factor . 's'] ) : $factors[$factor] );

			if ( $factor < 1 ) {
				continue;
			}

			$base = (int)trim( $explode2[0] );

			if ( $base < 1 ) {
				continue;
			}

			$out[$label] = $base * $factor;
		}

		return $out;
	}

	private static function getBanTimeFactors() {
		return [
			'minutes' => 60,
			'hours' => 60 * 60,
			'days' => 60 * 60 * 24,
			'weeks' => 60 * 60 * 24 * 7,
			'months' => 60 * 60 * 24 * 30,
			'years' => 60 * 60 * 24 * 365
		];
	}

	public static function info( $message, Array $params = [ ] ) {
		\Wikia\Logger\WikiaLogger::instance()->info( 'CHAT: ' . $message, $params );
	}

	public static function debug( $message, Array $params = [ ] ) {
		\Wikia\Logger\WikiaLogger::instance()->debug( 'CHAT: ' . $message, $params );
	}

	public static function getChatters() {
		global $wgMemc;
		wfProfileIn( __METHOD__ );

		$memKey = wfMemcKey( "ChatServerApiClient::getChatters" );

		// data are store in memcache and set by node.js
		$chatters = $wgMemc->get( $memKey );
		if ( !$chatters ) {
			$chatters = array();
		}

		wfProfileOut( __METHOD__ );

		return $chatters;
	}

	public static function setChatters( $chatters ) {
		global $wgMemc;
		wfProfileIn( __METHOD__ );

		$memKey = wfMemcKey( "ChatServerApiClient::getChatters" );
		$wgMemc->set( $memKey, $chatters, 60 * 60 * 24 );

		wfProfileOut( __METHOD__ );
	}
}
