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
	static public function banUser($userNameToKickBan, &$doKickAnyway=false, $kickingUser){
		wfProfileIn( __METHOD__ );
		
		$errorMsg = "";
		$PERMISSION_TO_KICKBAN = "chatmoderator";
		$userToKickBan = User::newFromName($userNameToKickBan);
		if( ($userToKickBan instanceof User) && $kickingUser->isAllowed( $PERMISSION_TO_KICKBAN ) ){
			if( $userToKickBan->isAllowed( $PERMISSION_TO_KICKBAN ) ){
				$errorMsg .= wfMsg('chat-ban-cant-ban-moderator')."\n";
			} else {
				if( !Chat::canChat($userToKickBan) ){
					$errorMsg .= wfMsg('chat-ban-already-banned', $userToKickBan->getName()). "\n";
					// If the user is already banned... make sure they get kicked if they're somehow still in the room (eg: they got banned from somewhere other than the Chat interface).
					$doKickAnyway = true;
				} else {
					// Add the user to the banned group for this wiki.
					$BANNED_GROUP = "bannedfromchat";
					$oldGroups = $userToKickBan->getGroups();
					$userToKickBan->addGroup( $BANNED_GROUP );
					$newGroups = $userToKickBan->getGroups();
					
					// Log the rights-change.
					Chat::addLogEntry($userToKickBan, $oldGroups, $newGroups, $kickingUser);
					
					// Make sure the new group is set in the database.
					$userToKickBan->saveSettings();
				}
			}
		} else {
			$errorMsg .= wfMsg('chat-ban-you-need-permission', $PERMISSION_TO_KICKBAN)."\n";
		}

		wfProfileOut( __METHOD__ );
		return ( $errorMsg=="" ? true : $errorMsg);
	} // end banUser()


	//TODO: move it to some data base table 
	public static function blockPrivate($username, $dir = 'add', $kickingUser) {
		global $wgExternalDatawareDB;
		
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
		return true;
	}


	private static function userIds2UserNames($in) {
		if(!is_array($in)) {
			$in = array();
		}
		
		$out = array();
		foreach($in as $value) {
			$user = User::newFromID($value);
			$out[] = $user->getName();
		} 
		return $out;
	}
	
	
	
	public static function getListOfBlockedPrivate() {
		global $wgUser, $wgExternalDatawareDB;
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

		return array( 
			'blockedChatUsers' => self::userIds2UserNames($blockedChatUsers),
			'blockedByChatUsers' => self::userIds2UserNames($blockedByChatUsers)
		);
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
				Chat::addLogEntry($userToPromote, $oldGroups, $newGroups, $promottingUser, 'chatmod');
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
	private static function addLogEntry($user, $oldGroups, $newGroups, $doer, $type = 'kick') {
		global $wgRequest;
		wfProfileIn(__METHOD__);
		
		$doerName = $doer->getName();
		
		if( $type === 'kick' ) {
		//kickban
			$reason = wfMsg('chat-kick-log-reason', $doerName);
		} else {
		//chatmode
			$reason = wfMsg('chat-userrightslog-a-made-b-chatmod', $doerName, $user->getName());
		}
		
		$log = new LogPage('rights');
		$log->addEntry('rights',
			$user->getUserPage(),
			$reason,
			array(
				Chat::makeGroupNameListForLog( $oldGroups ),
				Chat::makeGroupNameListForLog( $newGroups )
			),
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
		
		if( $wgDevelEnvironment ) {
		//devbox
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
	 * Backward compatibility
	 */
	
	public static function getBanInformation()  {
		return false;
	}
	
	/**
	 * Since the permission essentially has to be implemented as an anti-permission, this function removes the
	 * need for confusing double-negatives in the code.
	 *
	 * @param userObject - an object of class User (such as wgUser).
	 */
	public static function canChat($userObject){
		return ( $userObject->isLoggedin() && $userObject->isAllowed( 'chat' ) && (!$userObject->isBlocked()) );
	} // end canChat()
} // end class Chat
