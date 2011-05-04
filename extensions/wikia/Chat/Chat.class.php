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
	 * Given a username, if the current user has permission to do so, ban the user
	 * from chat on the current wiki. This can be reversed by removing them from
	 * the 'bannedfromchat' group.
	 *
	 * Returns true on success, returns an error message as a string on failure.
	 */
	static public function banUser($userNameToKickBan){
		global $wgUser;
		wfProfileIn( __METHOD__ );

		$errorMsg = "";
		$PERMISSION_TO_KICKBAN = "chatmoderator";
		if( $wgUser->isAllowed( $PERMISSION_TO_KICKBAN ) ){
			$userToKickBan = User::newFromName($userNameToKickBan);
			if( $userToKickBan->isAllowed( $PERMISSION_TO_KICKBAN ) ){
				$errorMsg .= wfMsg('chat-ban-cant-ban-moderator')."\n";
			} else {
				if( !Chat::canChat($userToKickBan) ){
					$errorMsg .= wfMsg('chat-ban-already-banned'). "\n";
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
			}
		} else {
			$errorMsg .= wfMsg('chat-ban-you-need-permission', $PERMISSION_TO_KICKBAN)."\n";
		}

		wfProfileOut( __METHOD__ );
		return ( $errorMsg=="" ? true : $errorMsg);
	} // end banUser()

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
		return ( $userObject->isLoggedin() && $userObject->isAllowed( 'chat' ) && (!$userObject->isBlocked()) );
	} // end canChat()

} // end class Chat
