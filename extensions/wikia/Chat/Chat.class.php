<?php

/**
 * Class for managing a Chat (aka: chat-room)
 * This is for a demo & if the prototype works out, this will probably need to be thrown away and
 * replaced with Jabberd or something similar which could scale to our level of potential usage.
 *
 * @author Sean Colombo
 */
class Chat {
	const MINUTES_TO_KEEP_MESSAGES_FOR = 10;
	const MINUTES_TO_USER_TIMEOUT = 2; // if user has not updated at all during this time, remove them from the room.

	var $chatId;

	public function __construct($chatId){
		$this->chatId = $chatId;
	}

	/**
	 * Returns the id of the default chat for the current wiki.
	 *
	 * If the chat doesn't exist, creates it.
	 *
	 * @param chatName - will be filled with the name of the chat (a string stored in VARCHAR(255), so it's reasonable length)
	 * @param chatTopic - will be filled with the topic of the chat (a string stored in a blob, so it might be fairly large).
	 */
	static public function getDefaultChatId(&$chatName='', &$chatTopic=''){
		global $wgCityId;
		wfProfileIn(__METHOD__);

		// Get or create the chat.
		$dbr =& wfGetDB( DB_SLAVE );
		$row = $dbr->selectRow(
			"chat",
			array("chat_id", "chat_name", "chat_topic"),
			array("city_id" => $wgCityId),
			__METHOD__,
			array("ORDER BY" => "chat_id") // get the oldest chat for now... that will be the canonical chat for the wiki to start
		);
		if( empty($row) || empty($row->chat_id) ){
			global $wgSitename;
			$chatName = $wgSitename;
			$chatTopic = wfMsg('chat-default-topic', $wgSitename);
			$chatId = Chat::create($chatName, $chatTopic);
		} else {
			$chatId = $row->chat_id;
			$chatName = $row->chat_name;
			$chatTopic = $row->chat_topic;
		}
		
		wfProfileOut(__METHOD__);
		return $chatId;
	}

	/**
	 * Create a chat room.
	 */
	static public function create($chatName, $chatTopic){
		global $wgCityId;
		wfProfileIn(__METHOD__);
	
		$dbw =& wfGetDB( DB_MASTER );
		$dbw->insert('chat', array(
			'city_id'	=> $wgCityId,
			'chat_name' => $chatName,
			'chat_topic' => $chatTopic
		));
		$dbw->commit();

		// TODO: If we roll this system out with multiple chats per wiki, we'll need some error-checking in case this is trying to create a chat with a name that's already taken (that will get a duplicate key error).
		
		$chatId = $dbw->selectField(
			'chat', 'chat_id',
			array(
				"city_id" => $wgCityId,
				"chat_name" => $chatName,
			),
			__METHOD__
		);

		wfProfileOut(__METHOD__);
		return $chatId;
	}
	
	/**
	 * Set a user (by user.user_name) as being present in a specific chat.
	 */
	public function join($userName){
		wfProfileIn( __METHOD__ );

		$dbw =& wfGetDB( DB_MASTER );

		// If the user parted recently, that is no longer relevant.
		$dbw->delete('chat_recent_parts', array(
			'chat_id' => $this->chatId,
			'chat_user_name' => $userName
		));

		// Add the user into the current user-list for the chat.
		$dbw->query("INSERT INTO chat_user (chat_id, chat_user_name, chat_user_joinedOn) VALUES ('{$this->chatId}', '".addslashes($userName)."', NOW()) ON DUPLICATE KEY UPDATE chat_user_lastUpdate = NOW()");

		wfProfileOut( __METHOD__ );
	}
	
	/**
	 * "Parts" the user from the chat.  This adds them to the log of recent parts
	 * so that other clients can see that the user left, and it also removes them
	 * from the list of active users.
	 */
	public function part($userName, $wasKicked=false){
		wfProfileIn( __METHOD__ );

		$dbw =& wfGetDB( DB_MASTER );

		// Prune expired parts.
		$result = $dbw->delete('chat_recent_parts', array(
			'chat_id' => $this->chatId,
			'chat_recent_parts_timestamp < NOW() - INTERVAL '.Chat::MINUTES_TO_KEEP_MESSAGES_FOR.' MINUTE'
		));
		//if(!$result){print "DB ERROR: ".$dbw->lastError();}

		// Remember that this user parted (so that other users can be updated about it).
		$wasKicked = ($wasKicked?"1":"0");
		$queryString = "INSERT INTO ".$dbw->tableName('chat_recent_parts')." (chat_id, chat_user_name, chat_recent_parts_wasKicked) VALUES ('{$this->chatId}', '".addslashes($userName)."', $wasKicked) ON DUPLICATE KEY UPDATE chat_recent_parts_timestamp = NOW()";
		$result = $dbw->query($queryString);
		//if(!$result){print "DB ERROR: ".$dbw->lastError();}

		// Remove the user from being present.
		$result = $dbw->delete('chat_user', array(
			'chat_id' => $this->chatId,
			'chat_user_name' => $userName
		));
		//if(!$result){print "DB ERROR: ".$dbw->lastError();}
		
		$dbw->commit();

		wfProfileOut( __METHOD__ );
	}

	/**
	 * Given a username, if the current user has permission to do so, kick the user
	 * out of the chat and ban them.
	 *
	 * Returns true on success, returns an error message as a string on failure.
	 */
	public function kickBan($userNameToKickBan){
		global $wgUser;
		wfProfileIn( __METHOD__ );

		$errorMsg = "";
		$PERMISSION_TO_KICKBAN = "chatmoderator";
		if( $wgUser->isAllowed( $PERMISSION_TO_KICKBAN ) ){
			$userToKickBan = User::newFromName($userNameToKickBan);
			if( $userToKickBan->isAllowed( $PERMISSION_TO_KICKBAN ) ){
				$errorMsg .= "You cannot kick/ban another Chat Moderator.\n";
			} else {
				if( !Chat::canChat($userToKickBan) ){
					$errorMsg .= "$userNameToKickBan is already banned from chat on this wiki.\n";
				} else {
					// Add the user to the banned group for this wiki.
					$BANNED_GROUP = "bannedfromchat";
					$oldGroups = $userToKickBan->getGroups();
					$userToKickBan->addGroup( $BANNED_GROUP );
					$newGroups = $userToKickBan->getGroups();

					// Log the rights-change.
					Chat::addLogEntry($userToKickBan, $oldGroups, $newGroups, $wgUser->getName());

					// Make sure the new group is set in the database.
					$userToKickBan->saveSettings();
				}

				// Force-part the user (and mark it as a kick).  Do this even if they already had "bannedfromchat" in their groups just to make sure they get kicked.
				$WAS_KICKED = true;
				$this->part($userToKickBan->getName(), $WAS_KICKED);
			}
		} else {
			$errorMsg .= "You do not have the '$PERMISSION_TO_KICKBAN' permission which is required to kick/ban a user.\n";
		}

		wfProfileOut( __METHOD__ );
		return ( $errorMsg=="" ? true : $errorMsg);
	} // end kickBan()

	/**
	 * Should be called fairly regularly (about once every couple of minutes)
	 * to find users who have timed out and record 'part's for them).
	 */
	public function lookForTimedOutUsers(){
		wfProfileIn( __METHOD__ );

		// If anyone has timed out, record them as a recent parting and remove them from the room.
		$dbr =& wfGetDB( DB_SLAVE );
		$res = $dbr->select(
			"chat_user",
			array("chat_user_name"),
			array(
				"chat_id" => $this->chatId,
				"chat_user_lastUpdate < NOW() - INTERVAL ".Chat::MINUTES_TO_USER_TIMEOUT." MINUTE",
			),
			__METHOD__
		);
		if(!empty($res)){
			while ($row = $dbr->fetchObject( $res )){
				$partingUser = $row->chat_user_name;
				$this->part($partingUser);
			}
		}
		
		wfProfileOut( __METHOD__ );
	}

	/**
	 * Return the full list of users currently present in the chat.
	 * Will be returned as an array of associative arrays which will contain
	 * two keys: "user" (whose value will be strings where the strings are usernames from
	 * user.user_name (same as chat_user.chat_user_name)) and "chatmod" whose value will
	 * be true or false.
	 */
	public function getUserList(){
		wfProfileIn( __METHOD__ );

		// Force-part any timed-out users.
		$this->lookForTimedOutUsers();

		// Now, get the list of users who are still here.
		$dbr =& wfGetDB( DB_SLAVE );
		$userList = array();
		$res = $dbr->select(
			"chat_user",
			array("chat_user_name"),
			array("chat_id" => $this->chatId),
			__METHOD__
		);
		if($res !== false){
			while ($row = $dbr->fetchObject( $res )){
				$userName = $row->chat_user_name;
				$userData = array(
					"user" => $userName,
					"chatmod" => self::isChatMod($userName)
				);
				$userList[] = $userData;
			}
		}

		wfProfileOut( __METHOD__ );
		return $userList;
	}

	/**
	 * Return the full list of messages that's currently kept for the chat.
	 * This won't be extremely long since the back-buffer only lasts for
	 * MINUTES_TO_KEEP_MESSAGES_FOR minutes.
	 *
	 * The results are returned as an array where each VALUE is itself
	 * an associative array whose key is a username and whose value is the
	 * text of a message.  This wrapper array is used instead of a single
	 * associative array because it is very common that the same user will
	 * have more than one message in this array, so their name is not a unique
	 * key.
	 */
	public function getMessages(){
		wfProfileIn( __METHOD__ );
		
		// NOTE: We don't need to purge expired messages here (that is done during long-polling).

		$messages = array();
		$dbr =& wfGetDB( DB_SLAVE );
		$res = $dbr->select(
			'chat_message',
			array('chat_user_name', 'chat_message_body'),
			array("chat_message_timestamp > NOW() - INTERVAL ".Chat::MINUTES_TO_KEEP_MESSAGES_FOR." MINUTE"),
			__METHOD__,
			array("ORDER BY" => "chat_message_timestamp")
		);
		if($res !== false){
			while ($row = $dbr->fetchObject( $res )){
				$messages[] = array($row->chat_user_name => $row->chat_message_body);
			}
		}

		wfProfileOut( __METHOD__ );
		return $messages;
	} // end getMessages()

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
	 * @param string kicker - the chatmoderator that banned the user (this is subed into an i18n message).
	 */
	private static function addLogEntry($user, $oldGroups, $newGroups, $kicker) {
		global $wgRequest;

		wfProfileIn(__METHOD__);
		$log = new LogPage('rights');

		$log->addEntry('rights',
			$user->getUserPage(),
			wfMsg('chat-kick-log-reason', "<em>$kicker</em>"),
			array(
				implode(', ', $oldGroups),
				implode(', ', $newGroups)
			)
		);
		wfProfileOut(__METHOD__);
	}

	/**
	 * Since the permission essentially has to be implemented as an anti-permission, this function removes the
	 * need for confusing double-negatives in the code.
	 *
	 * @param userObject - an object of class User (such as wgUser).
	 */
	public static function canChat($userObject){
		return ( !$userObject->isAllowed( 'bannedfromchat' ) );
	} // end canChat()

} // end class Chat
