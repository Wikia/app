<?php

/**
 * Class for managing a Chat (aka: chat-room)
 * This is for a demo & if the prototype works out, this will probably need to be thrown away and
 * replaced with Jabberd or something similar which could scale to our level of potential usage.
 *
 * @author Sean Colombo
 */
class Chat {
	var $chatId;

	public function __construct($chatId){
		$this->chatId = $chatId;
	}

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
		$wgMemc->set($key, array( "user_id" => $wgUser->getId(), "cookie" => $_COOKIE) , 60*60*48);
		return $key;
	} // end echoCookies()


	/**
	 * Given a username, if the current user has permission to do so, ban the user
	 * from chat on the current wiki. This can be reversed by removing them from
	 * the 'bannedfromchat' group.
	 *
	 * Will set doKickAnyway to true if the user should be kicked despite any error
	 * messages (this is used primarily when the user is already banned from the wiki.
	 * in that case, there is an error, but if the user is present they should be kicked).
	 *
	 * Returns true on success, returns an error message as a string on failure.
	 */
	static public function banUser($userNameToKickBan, $kickingUser, $time, $reason){
		global $wgCityId;
		wfProfileIn( __METHOD__ );
		$errorMsg = "";
		$PERMISSION_TO_KICKBAN = "chatmoderator";
		$userToKickBan = User::newFromName($userNameToKickBan);

		if( ($userToKickBan instanceof User) && $kickingUser->isAllowed( $PERMISSION_TO_KICKBAN ) ){

			if( $userToKickBan->isAllowed( $PERMISSION_TO_KICKBAN ) && !$kickingUser->isAllowed('chatstaff') && !$kickingUser->isAllowed('chatadmin') ){
				$errorMsg .= wfMsg('chat-ban-cant-ban-moderator')."\n";
			} else {
				self::banUserDB($wgCityId, $userToKickBan, $kickingUser, $time, $reason, $time == 0 ?  'remove':'add' );
			}
		} else {
			$errorMsg .= wfMsg('chat-ban-you-need-permission', $PERMISSION_TO_KICKBAN)."\n";
		}

		wfProfileOut( __METHOD__ );
		return ( $errorMsg=="" ? true : $errorMsg);
	} // end banUser()

	public static function blockPrivate($username, $dir = 'add', $kickingUser) {
		global $wgExternalDatawareDB;
		wfProfileIn( __METHOD__ );

		$kickingUserId = intval($kickingUser->getId());
		$userToBlock = User::newFromName($username);
		$dbw = wfGetDB( DB_MASTER, array(), $wgExternalDatawareDB );

		if( !empty($userToBlock) && $kickingUserId > 0) {
			if( !wfReadOnly() ){ // Change to wgReadOnlyDbMode if we implement thatwgReadOnly
				if($dir == 'remove') {
					$dbw->delete(
						"chat_blocked_users",
						array(
							'cbu_user_id' => $kickingUserId,
							'cbu_blocked_user_id' => $userToBlock->getId()
						),
						__METHOD__
					);
				} else {
					$dbw->insert(
						"chat_blocked_users",
						array(
							'cbu_user_id' => $kickingUserId,
							'cbu_blocked_user_id' => $userToBlock->getId()
						),
						__METHOD__,
						array( 'IGNORE' )
					);
				}
				$dbw->commit();
			}
		}
		wfProfileOut( __METHOD__ );
		return true;
	}

	//TODO: move it to some data base table
	public static function banUserDB($cityId, $banUser, $adminUser, $time, $reason, $dir = 'add') {
		global $wgExternalDatawareDB;
		wfProfileIn( __METHOD__ );

		$dbw = wfGetDB( DB_MASTER, array(), $wgExternalDatawareDB );

		if( !empty($banUser) && !empty($adminUser) ) {
			if( !wfReadOnly() ){ // Change to wgReadOnlyDbMode if we implement thatwgReadOnly
				if($dir == 'remove') {
					if(Chat::getBanInformation($cityId, $banUser) === false) {
						wfProfileOut( __METHOD__ );
						return true;
					}
					$dbw->delete(
						"chat_ban_users",
						array(
							'cbu_wiki_id' => $cityId,
							'cbu_user_id' => $banUser->getId(),
						),
						__METHOD__
					);
				} else {
					if(Chat::getBanInformation($cityId, $banUser) !== false) {
						$dir = "change";
					}

					$endon = time() + $time;
					$dbw->replace(
						"chat_ban_users",
						null,
						array(
							'cbu_wiki_id' => $cityId,
							'cbu_user_id' => $banUser->getId(),
							'cbu_admin_user_id' => $adminUser->getId(),
							'start_date' => wfTimestamp( TS_MW ),
							'end_date' => wfTimestamp( TS_MW, $endon ),
							'reason' =>  $reason
						),
						__METHOD__
					);

					$options = self::getBanOptions();
					foreach($options as $key => $val) {
						if($val == $time) {
							$timeLabel = $key;
						}
					}
				}

				Chat::addLogEntry($banUser, $adminUser, array(
					$adminUser->getId(),
					$banUser->getId(),
					empty($timeLabel) ? null:$timeLabel,
					empty($endon) ? null:$endon,
				), 'ban'.$dir, $reason);

				$dbw->commit();
			}
		}
		wfProfileOut( __METHOD__ );
		return true;
	}

	/**
	 * Return ban information if user is not ban return false;
	 */
	public static function getBanInformation($cityId, $banUser) {
		global $wgExternalDatawareDB;
		wfProfileIn( __METHOD__ );

		$dbw = wfGetDB( DB_MASTER, array(), $wgExternalDatawareDB );

		$row = $dbw->selectRow(
			"chat_ban_users",
			array(
				'cbu_wiki_id',
				'cbu_user_id',
				'cbu_admin_user_id',
				'end_date',
				'reason'
			),
			array(
				'cbu_wiki_id' => $cityId,
				'cbu_user_id' => $banUser->getId(),
			),
			__METHOD__
		);

		if(empty($row)) {
			wfProfileOut( __METHOD__ );
			return false;
		}

		$row->end_date = wfTimestamp( TS_UNIX, $row->end_date );

		if($row->end_date < (time() ) ) {
			wfProfileOut( __METHOD__ );
			return false;
		}

		wfProfileOut( __METHOD__ );
		return $row;
	}

	private static function userIds2UserNames($in) {
		wfProfileIn( __METHOD__ );
		if(!is_array($in)) {
			$in = array();
		}

		$out = array();
		foreach($in as $value) {
			$user = User::newFromID($value);
			$out[] = $user->getName();
		}
		wfProfileOut( __METHOD__ );
		return $out;
	}

	public static function getListOfBlockedPrivate() {
		global $wgUser, $wgExternalDatawareDB;
		wfProfileIn( __METHOD__ );
		$dbw = wfGetDB( DB_MASTER, array(), $wgExternalDatawareDB );

		$res = $dbw->select (
			"chat_blocked_users",
			array('cbu_user_id', 'cbu_blocked_user_id'),
			array(
				'cbu_user_id' => $wgUser->getId()
			),
			__METHOD__
		);

		$blockedChatUsers = array();
		while ( $row = $res->fetchObject() ) {
			$blockedChatUsers[] = $row->cbu_blocked_user_id;
		}

		$res = $dbw->select (
			"chat_blocked_users",
			array('cbu_user_id', 'cbu_blocked_user_id'),
			array(
				'cbu_blocked_user_id' => $wgUser->getId()
			),
			__METHOD__
		);

		$blockedByChatUsers = array();
		while ( $row = $res->fetchObject() ) {
			$blockedByChatUsers[] = $row->cbu_user_id;
		}

		$result = array(
			'blockedChatUsers' => self::userIds2UserNames($blockedChatUsers),
			'blockedByChatUsers' => self::userIds2UserNames($blockedByChatUsers)
		);
		wfProfileOut( __METHOD__ );
		return $result;
	}

	/**
	 * Attempts to add the 'chatmoderator' group to the user whose name is provided
	 * in 'userNameToPromote'.
	 *
	 * Returns true on success, returns an error message as a string on failure.
	 */
	static public function promoteChatModerator($userNameToPromote, $promottingUser) {
		wfProfileIn( __METHOD__ );
		$CHAT_MOD_GROUP = 'chatmoderator';

		$userToPromote = User::newFromName($userNameToPromote);

		if( !($userToPromote instanceof User) ) {
			$errorMsg = wfMsg('chat-err-invalid-username-chatmod', $userNameToPromote);

			wfProfileOut( __METHOD__ );
			return $errorMsg;
		}

		// Check if the userToPromote is already in the chatmoderator group.
		$errorMsg = '';
		if( in_array($CHAT_MOD_GROUP, $userToPromote->getEffectiveGroups()) ) {
			$errorMsg = wfMsg("chat-err-already-chatmod", $userNameToPromote, $CHAT_MOD_GROUP);
		} else {
			$changeableGroups = $promottingUser->changeableGroups();
			$promottingUserName = $promottingUser->getName();
			$isSelf = ($userToPromote->getName() == $promottingUserName);
			$addableGroups = array_merge( $changeableGroups['add'], $isSelf ? $changeableGroups['add-self'] : array() );

			if( in_array($CHAT_MOD_GROUP, $addableGroups) ) {
				// Adding the group is allowed. Add the group, clear the cache, run necessary hooks, and log the change.
				$oldGroups = $userToPromote->getGroups();

				$userToPromote->addGroup( $CHAT_MOD_GROUP );
				$userToPromote->invalidateCache();

				if( $userToPromote instanceof User ) {
					$removegroups = array();
					$addgroups = array( $CHAT_MOD_GROUP );
					wfRunHooks( 'UserRights', array( &$userToPromote, $addgroups, $removegroups ) );
				}

				// Update user-rights log.
				$newGroups = array_merge($oldGroups, array($CHAT_MOD_GROUP));

				// Log the rights-change.
				Chat::addLogEntry($userToPromote, $promottingUser, array(
					Chat::makeGroupNameListForLog( $oldGroups ),
					Chat::makeGroupNameListForLog( $newGroups )
				),'chatmoderator');
			} else {
				$errorMsg = wfMsg("chat-err-no-permission-to-add-chatmod", $CHAT_MOD_GROUP);
			}
		}

		wfProfileOut( __METHOD__ );
		return ( $errorMsg == "" ? true : $errorMsg);
	} // end promoteChatMod()


	static public function makeGroupNameListForLog( $ids ) {
		if ( empty( $ids ) ) {
			return '';
		} else {
			return Chat::makeGroupNameList( $ids );
		}
	}
	static public function makeGroupNameList( $ids ) {
		if ( empty( $ids ) ) {
			return wfMsgForContent( 'rightsnone' );
		} else {
			return implode( ', ', $ids );
		}
	}

	/**
	 * Returns true if the user with the provided username has the 'chatmoderator' right
	 * on the current wiki.
	 */
	static public function isChatMod($userName){
		wfProfileIn( __METHOD__ );

		$isChatMod = false;
		$user = User::newFromName($userName);
		if(!empty($user)){
			$isChatMod = $user->isAllowed( 'chatmoderator' );
		}

		wfProfileOut( __METHOD__ );
		return $isChatMod;
	} // end isChatMod()

	/**
	 * Add a rights log entry for an action.
	 * Partially copied from SpecialUserrights.php
	 *
	 * @param object $user User object
	 * @param boolean $addGroups adding or removing groups?
	 * @param array $groups names of groups
	 * @param object $doer - the chatmoderator that banned the user (this is subed into an i18n message).
	 */
	public static function addLogEntry($user, $doer, $attr, $type = 'banadd', $reasone = null) {
		global $wgRequest;
		wfProfileIn(__METHOD__);

		$doerName = $doer->getName();

		if( $type === 'chatmoderator' ) {
			$reason = empty($reasone) ? wfMsgForContent('chat-userrightslog-a-made-b-chatmod', $doerName, $user->getName()):$reasone;
			$type = 'rights';
			$subtype = $type;
		} elseif(strpos($type, 'ban') === 0) {
			$reason = empty($reasone) ? wfMsgForContent('chat-log-reason-'.$type, $doerName):$reasone;
			$subtype = 'chat'.$type;
			$type =  'chatban';
		}

		$log = new LogPage($type);
		$log->addEntry($subtype,
			$user->getUserPage(),
			$reason,
			$attr,
			$doer
		);

		wfProfileOut(__METHOD__);
	}

	/**
	 * Logs to chatlog table that a user opened chat room
	 *
	 * Using chatlog table is temporaly. It'll be last till event_type_description table will be done.
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
		global $wgCityId, $wgUser, $wgCatId, $wgDevelEnvironment, $wgStatsDB;

		wfProfileIn(__METHOD__);

		self::addConnectionLogEntry();

		if( $wgDevelEnvironment ) {
		//devbox
			wfProfileOut( __METHOD__ );
			return true;
		}

		//production
		$dbw = wfGetDB( DB_MASTER, array(), $wgStatsDB );

		$wikiId = intval($wgCityId);
		$userId = intval($wgUser->GetId());
		if( $wikiId > 0 && $userId > 0 ) {
			$eventRow = array(
				'wiki_id' => $wgCityId,
				'user_id' => $wgUser->GetId(),
				'event_type' => 6
			);

			if( !wfReadOnly() ){ // Change to wgReadOnlyDbMode if we implement thatwgReadOnly
				$dbw->insert('chatlog', $eventRow, __METHOD__);
				$dbw->commit();
			}
		} else {
			wfDebugLog('chat', 'User did open a chat room but it was not logged in chatlog');
		}

		wfProfileOut(__METHOD__);
	}

	/**
	 * Add Chat log entry to "Special:log"
	 */

	public static function addConnectionLogEntry() {
		global $wgMemc, $wgUser;
		wfProfileIn(__METHOD__);

		// record the IP of the connecting user.
		// use memcache so we order only one (user, ip) pair 3 min to avoide flooding the log
		$ip = F::app()->wg->request->getIP();

		$memcKey = self::getUserIPMemcKey($wgUser->getID(), $ip );
		$entry = $wgMemc->get( $memcKey, false );

		if ( empty($entry) ) {
			$wgMemc->set($memcKey, true, 60*3 /*3 min*/);
			$log = new LogPage( 'chatconnect', false, false );
			$log->addEntry( 'chatconnect', SpecialPage::getTitleFor('Chat'), '', array($ip), $wgUser);

			$dbw = wfGetDB( DB_MASTER );
			$cuc_id = $dbw->nextSequenceValue( 'cu_changes_cu_id_seq' );
			$rcRow = array(
					'cuc_id'         => $cuc_id,
					'cuc_namespace'  => NS_SPECIAL,
					'cuc_title'      => 'Chat',
					'cuc_minor'      => 0,
					'cuc_user'       => $wgUser->getID(),
					'cuc_user_text'  => $wgUser->getName(),
					'cuc_actiontext' => wfMsgForContent( 'chat-checkuser-join-action' ),
					'cuc_comment'    => '',
					'cuc_this_oldid' => 0,
					'cuc_last_oldid' => 0,
					'cuc_type'       => CUC_TYPE_CHAT,
					'cuc_timestamp'  => $dbw->timestamp(),
					'cuc_ip'         => IP::sanitizeIP( $ip ),
					'cuc_ip_hex'     => $ip ? IP::toHex( $ip ) : null,
					'cuc_xff'        => '',
					'cuc_xff_hex'    => null,
					'cuc_agent'      => null
			);
			$dbw->insert( 'cu_changes', $rcRow, __METHOD__ );
			$dbw->commit();
		}

		wfProfileOut(__METHOD__);
	}


	static protected function getUserIPMemcKey($userId, $address) {
		return $userId . '_' .  $address . '_v1';
	}

	/**
	 * Since the permission essentially has to be implemented as an anti-permission, this function removes the
	 * need for confusing double-negatives in the code.
	 *
	 * @param userObject - an object of class User (such as wgUser).
	 */
	public static function canChat($userObject){
		global $wgCityId;

		if($userObject->isBlocked()) {
			return false;
		}

		if(Chat::getBanInformation($wgCityId, $userObject) !== false) {
			return false;
		}

		return ( $userObject->isLoggedin() && $userObject->isAllowed( 'chat' ) );
	} // end canChat()

	static public function getBanTimeFactors() {
		return array(
			'minutes' => 60,
			'hours' => 60*60,
			'days' => 60*60*24,
			'weeks' => 60*60*24*7,
			'months' => 60*60*24*30,
			'years' => 60*60*24*365
		);
	}

	static public function getBanOptions() {
		wfProfileIn(__METHOD__);
		$in = wfMsgForContent('chat-ban-option-list');
		$in = preg_replace('!\s+!', ' ', $in);
		$list = explode(',', $in);
		$out = array();

		$factors = self::getBanTimeFactors();

		foreach($list as $val) {
			$explode1 = explode(':', $val);
			if(count($explode1) != 2) {
				continue;
			}
			$label = $explode1[0];

			if(trim($explode1[1]) == 'infinite') {
				$out[$label] =  $factors['years'] * 1000;
				continue;
			}

			$explode2 = explode(' ', $explode1[1]);

			if(count($explode2) != 2) {
				continue;
			}

			$factor = trim($explode2[1]);
			$factor = (int) (empty($factors[$factor]) ? (empty($factors[$factor.'s']) ? 0:$factors[$factor.'s'] ):$factors[$factor]);

			if($factor < 1) {
				continue;
			}

			$base = (int) trim($explode2[0]);

			if($base < 1) {
				continue;
			}

			$out[$label] = $base*$factor;
		}

		wfProfileOut(__METHOD__);
		return $out;
	}


} // end class Chat
