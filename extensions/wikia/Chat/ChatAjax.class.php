<?php

class ChatAjax {
	const INTERNAL_POLLING_DELAY_MICROSECONDS = 500000;
	const CHAT_AVATAR_DIMENSION = 50;

	/**
	 * This function is meant to just echo the COOKIES which are available to the apache server.
	 *
	 * This helps to work around a limitation in the fact that javascript can't access the second-level-domain's
	 * cookies even if they're authorized to be accessed by subdomains (eg: ".wikia.com" cookies are viewable by apache
	 * on lyrics.wikia.com, but interestingly, isn't in document.cookie in the javascript on lyrics.wikia.com).
	 */
	static public function echoCookies(){
		return $_COOKIE;
	} // end echoCookies()

	/**
	 * This is the ajax-endpoint that the node server will connect to in order to get the currently logged-in user's info.
	 * The node server will pass the same cookies that the client has set, and this will allow this ajax request to be
	 * part of the same sesssion that the user already has going.  By doing this, the user's existing wikia login session
	 * can be used, so they don't need to re-login for us to know that they are legitimately authorized to use the chat or not.
	 *
	 * The returned info is just a custom subset of what the node server needs and does not contain an exhaustive list of rights.
	 *
	 * The 'isLoggedIn' field and 'canChat' field of the result should be checked by the calling code before allowing
	 * the user to chat.  This is the last line of security against any users attemptin to circumvent our protections.  Otherwise,
	 * a banned user could copy the entire client code (HTML/JS/etc.) from an unblocked user, then run that code while logged in as
	 * under a banned account, and they would still be given access.
	 *
	 * The returned 'isChatMod' field is boolean based on whether the user is a chat moderator on the current wiki.
	 *
	 * If the user is not allowed to chat, an error message is returned (which can be shown to the user).
	 */
	static public function getUserInfo(){
		global $wgUser, $wgServer, $wgArticlePath, $wgRequest, $wgCityId;
		wfProfileIn( __METHOD__ );

		// First, check if they can chat on this wiki.
		$retVal = array(
			'canChat' => Chat::canChat($wgUser),
			'isLoggedIn' => $wgUser->isLoggedIn(),
			'isChatMod' => $wgUser->isAllowed( 'chatmoderator' ),
			'username' => $wgUser->getName(),
			'avatarSrc' => AvatarService::getAvatarUrl($wgUser->getName(), self::CHAT_AVATAR_DIMENSION),

			// Extra wg variables that we need.
			'wgServer' => $wgServer,
			'wgArticlePath' => $wgArticlePath
		);

		// Figure out the error message to return (i18n is done on this side).
		if($retVal['isLoggedIn'] === false){
			$retVal['errorMsg'] = wfMsg('chat-no-login');
		} else if($retVal['canChat'] === false){
			$retVal['errorMsg'] = wfMsg('chat-you-are-banned-text');
		}
		
		// If the user is approved to chat, make sure the roomId provided is for this wiki.
		// Users may be banned on the wiki of the room, but not on this wiki for example, so this prevents cross-wiki chat hacks.
		if($retVal['canChat']){
			$roomId = $wgRequest->getVal('roomId');
			$cityIdOfRoom = NodeApiClient::getCityIdForRoom($roomId);
			if($wgCityId !== $cityIdOfRoom){
				$retVal['canChat'] = false; // don't let the user chat in the room they requested.
				$retVal['errorMsg'] = wfMsg('chat-room-is-not-on-this-wiki');
			}
		}

		wfProfileOut( __METHOD__ );
		return $retVal;
	} // end getUserInfo()

	/**
	 * Ajax endpoint for kickbanning a user. This will change their permissions so that
	 * they are not allowed to chat on the current wiki.
	 *
	 * Returns an associative array.  On success, returns "success" => "", on failure,
	 * returns "error" => [error message].
	 */
	static public function kickBan(){
		global $wgRequest;
		wfProfileIn( __METHOD__ );

		$userToBan = $wgRequest->getVal('userToBan');
		if(empty($userToBan)){
			$retVal["error"] = wfMsg('chat-ban-requires-usertoban-parameter', 'usertoBan');
		} else {
			$result = Chat::banUser($userToBan);
			if($result === true){
				$retVal["success"] = true;
			} else {
				$retVal["error"] = $result;
			}
		}

		wfProfileOut( __METHOD__ );
		return $retVal;
	}

	/** THE METHODS BELOW ARE EXCLUSIVELY FOR THE ORIGINAL AJAX IMPLEMENTATION AND WON'T BE NEEDED IN THE NODE IMPLEMENTATION **/


	/**
	 * Gets a message from the user to record in the chat.
	 * Returns an associative array.  On success, returns "success" => true, on failure,
	 * returns "error" => [error message].
	 */
// TODO: REMOVE
/*
	static public function postMessage(){
		global $wgRequest, $wgUser;
		wfProfileIn( __METHOD__ );

		$retVal = array();

		// JUST FOR TESTING THE ERROR-HANDLING.
		//if(rand(0, 10) == 0){
		//	$retVal["error"] =  "Random failure for testing errors.";
		//}

		// Make sure that the sender isn't banned from chat.
		if( !Chat::canChat($wgUser) ){
			$retVal["error"] = "You cannot post a message, you are currently banned from chat.";
		} else {
			$chatId = $wgRequest->getVal('chatId');
			$message = $wgRequest->getVal('message');
			
			// Prevent simple HTML/JS vulnerabilities.
			$message = str_replace("<", "&lt;", $message);
			$message = str_replace(">", "&gt;", $message);
			
			if(empty($chatId)){
				$retVal["error"] = "'chatId' is required but was not found in the request.";
			} else {
				// Store the message.
				$dbw =& wfGetDB( DB_MASTER );
				$dbw->begin();
				$dbw->insert('chat_message', array(
					"chat_id" => $chatId,
					"chat_user_name" => $wgUser->getName(),
					"chat_message_body" => $message
				));
				$dbw->commit();

				if(empty($retVal)){
					$retVal["success"] = true;
				}
			}
		}

		wfProfileOut( __METHOD__ );
		return $retVal;
	}
*/

	/**
	 * A 'long poll' request (a Comet technique) which will keep a connection open for a while
	 * if there is nothing to return yet.  It will return as soon as it knows of something worth
	 * returning, or if it reaches the limit of its timeout.
	 */
// TODO: REMOVE
/*
	static public function longPoll(){
		global $wgRequest, $wgUser;
		$LONG_POLL_DURATION_IN_SECONDS = 25;
		wfProfileIn( __METHOD__ );
		
		$chatId = $wgRequest->getVal('chatId');

		$hasPurged = false;
		$expirationTime = strtotime("+ $LONG_POLL_DURATION_IN_SECONDS second");
		$retVal = ChatAjax::poll();
		while(empty($retVal["messages"])
		   && empty($retVal["users"]["join"])
		   && empty($retVal["users"]["part"])
		   && empty($retVal["users"]["kick"])
		   && empty($retVal["rejoinNeeded"])
		   && (time() < $expirationTime)){
			// Take this opportunity to purge old messages if it hasn't been done.
			if( !$hasPurged){
				// This is creating crazy locks.  Either do this WAYYYYY less often (doesn't have to be done very often) or not at all.
				//$dbw =& wfGetDB( DB_MASTER );
				//$dbw->query("DELETE FROM chat_message WHERE chat_message_timestamp < NOW() - INTERVAL ".Chat::MINUTES_TO_KEEP_MESSAGES_FOR." MINUTE");
			}

			// Wait before checking again for more messages
			usleep( ChatAjax::INTERNAL_POLLING_DELAY_MICROSECONDS );
			$retVal = ChatAjax::poll( false ); // the false prevents unneeded updates of chat_user.chat_user_lastUpdate.
		}

		// The user has been updated (even if that update is to say that nothing new has arrived). Record the time of this.
		$dbw =& wfGetDB( DB_MASTER );
		$dbw->update(
			'chat_user',
			array("chat_user_lastUpdate" => $retVal["updateTime"]),
			array(
				"chat_id" => $chatId,
				"chat_user_name" => $wgUser->getName()
			),
			__METHOD__
		);
		$dbw->commit();

		wfProfileOut( __METHOD__ );
		return $retVal;
	}
*/
	/**
	 * Returns any updates (messaages or users joinging/parting) since the time specified.
	 *
	 * @param changeLastUpdateTimestamp (optional, defaults to true), if set to true (or not present), will send a query
	 * to update chat_user.chat_user_lastUpdate to the current timestamp.  The option to set it to false is to save unneccessary
	 * updates during the multiple calls to poll() that are done by a longPoll() (which only needs to update the timestmap once).
	 * @return is an array whose keys are "messages" and "users" and whose values are an array
	 * of a specific format for each of those keys.  The "users" array's value is an array whose keys
	 * are "join", "part", and "kick". The joins array contains arrays of user data which themselves are associative arrays with the keys "user"
	 * (which contains the username) and "chatmod" if the user is a moderator or not.
	 * The part array is an array of usernames who left.
	 * The kick array is an array of usernames who were kicked.
	 * the room since the last time the current user (doing the poll) received an update.
	 * The "messages" key's value is an array of arrays which contain pairs associative arrays whose keys are
	 * "user" and "message" and whose keys are the username who sent a message and the message that that user
	 * sent.
	 *
	 * The "rejoinNeeded" key is normally false (requiring no action). If "rejoinNeeded" is true, then the client should send a
	 * "rejoin" request to make sure that they are joined.  The reason for this is that a "part" will already have a polling request
	 * open.  If we rejoin them automatically, they never successfully part.  By sending "rejoin", then legitimate polling threads
	 * that got disconnected can then rejoin whereas parting browsers will have left before getting to process the "rejoin" request.
	 *
	 * The returned updateTime is a timestamp of the end point of the update queries.  To prevent replay or missing of data, the
	 * updatse are only polling between the lastUpdate for the user and the time at the BEGINNING of the poll request (which is
	 * stored in updateTime).
	 *
	 * Since that's kind of a complicated description, please refer to this example-data:
	 *	$retVal = array(
	 *		"messages" => array(
	 *			array("user" => "sean", "message" => "Hello, Shahid."),
	 *			array("user" => "shahid", "message" => "Good day, sir!"),
	 *			array("user" => "sean", "message" => "Good day to you as well. Art though rocking out sufficiently?"),
	 *			array("user" => "shahid", "message" => "Verily!")
	 *		),
	 *		"users" => array(
	 *			"join" => array(
	 *				array("user" => "VickyBC", "chatmod" => true),
	 *				array("user" => "Hyun", "chatmod" => false)
	 *			),
	 *			"part" => array("Danny"),
	 *			"kick" => array("GracenoteBot")
	 *		),
	 *		"rejoinNeeded" => false,
	 *		"updateTime" => ""
	 *	);
	 *
	 */
// TODO: REMOVE
/*
	static public function poll($changeLastUpdateTimestamp = true){
		global $wgRequest, $wgUser;
		wfProfileIn( __METHOD__ );

		$chatId = $wgRequest->getVal('chatId');
		
		$dbr =& wfGetDB( DB_MASTER ); // DB_SLAVE: slave-lag makes this bad.  Don't use it for our test

		// Turn off read-transactions... that would make our longPolling always use the state at the beginning of the polling.
		$dbr->clearFlag( DBO_TRX );

		$res = $dbr->query("SELECT NOW() - INTERVAL 1 SECOND AS updateTime"); // the interval prevents us from missing things that happen in the same second as our queries, but a fraction of a second after them.
		$row = $dbr->fetchObject( $res );
		$updateTime = $row->updateTime;

		$retVal = array(
			"messages" => array(),
			"users" => array(
				"join" => array(),
				"part" => array(),
				"kick" => array()
			),
			"rejoinNeeded" => false,
			"updateTime" => $updateTime
		);
		
		// TODO: If this works well, the value could be used on the above query (for getting messages) too instead
		// of making it join to the chat_user table.
		$lastUpdated = $dbr->selectField(
			'chat_user',
			'chat_user_lastUpdate',
			array(
				"chat_id" => $chatId,
				"chat_user_name" => $wgUser->getName()
			),
			__METHOD__
		);
		if( empty($lastUpdated) ){
			// For some reason, the user is polling but isn't in the chat.  This could be caused by several things {connection interrupted, force-refresh of chat window, user has just been kicked}.
			// If the user was not kickbanned, they should try to reconnect.
			if( Chat::canChat($wgUser) ){
				$retVal["rejoinNeeded"] = true;
			} else {
				// This user doesn't have permission to be chatting. Kick them!
				$retVal["users"]["kick"][] = $wgUser->getName();
			}
		} else {
			// Occasionally check for timed-out users who need to be parted.
			// There is approx one poll() per second per user, so this doesn't need to be done all that often.
			if(rand(0, 100) == 0){
				$chat = new Chat($chatId);
				$chat->lookForTimedOutUsers();
			}

			// Find message updates
			$res = $dbr->select(
				array("chat_message"),
				array("chat_user_name", "chat_message_body"),
				array(
					"chat_id" => $chatId,
					"chat_user_name != '".$wgUser->getName()."'",
					"chat_message_timestamp > '$lastUpdated'",
					"chat_message_timestamp < '$updateTime'"
				),
				__METHOD__,
				array("ORDER BY" => "chat_message_timestamp")
			);
			$dbr->commit();
			
			if($res !== false){
				while ($row = $dbr->fetchObject( $res )){
					// Escape angle-brackets to prevent simple HTML/JS/XSS vulnerabilities.
					$message = $row->chat_message_body;
					$message = str_replace("<", "&lt;", $message);
					$message = str_replace(">", "&gt;", $message);

					$retVal["messages"][] = array(
						"user" => $row->chat_user_name,
						"message" => $message
					);
				} 
			}

			// Find user join updates.
			$res = $dbr->select(
				"chat_user",
				array("chat_user_name"),
				array(
					"chat_id" => $chatId,
					"chat_user_joinedOn > '$lastUpdated'",
					"chat_user_joinedOn < '$updateTime'"
				),
				__METHOD__,
				array("ORDER BY" => "chat_user_joinedOn")
			);
			if($res !== false){
				while ($row = $dbr->fetchObject( $res )){
					$userName = $row->chat_user_name;
					$retVal["users"]["join"][] = array(
						"user" => $userName,
						"chatmod" => Chat::isChatMod($userName)
					);
				}
			}

			// Find user part updates.
			$res = $dbr->select(
				"chat_recent_parts",
				array("chat_user_name, chat_recent_parts_wasKicked"),
				array(
					"chat_id" => $chatId,
					"chat_recent_parts_timestamp > '$lastUpdated'",
					"chat_recent_parts_timestamp < '$updateTime'"
				),
				__METHOD__,
				array("ORDER BY" => "chat_recent_parts_timestamp")
			);
			if($res !== false){
				while ($row = $dbr->fetchObject( $res )){
					if($row->chat_recent_parts_wasKicked == "0"){
						$retVal["users"]["part"][] = $row->chat_user_name;
					} else {
						$retVal["users"]["kick"][] = $row->chat_user_name;
					}
				}
			}
			
			// Update the lastUpdate so that the data retrieved by this call is known to have been retrieved.
			if($changeLastUpdateTimestamp){
				$dbw =& wfGetDB( DB_MASTER );
				$dbw->update(
					'chat_user',
					array("chat_user_lastUpdate" => $updateTime),
					array(
						"chat_id" => $chatId,
						"chat_user_name" => $wgUser->getName()
					),
					__METHOD__
				);
			}
		}

		wfProfileOut( __METHOD__ );
		return $retVal;
	}
*/
	
	/**
	 * When a user force-refreshes their window or has a connection problem, they will send a rejoin to indicate that
	 * they're chatting again and should def. be in the joins table.
	 */
// TODO: REMOVE
/*
	static public function rejoin(){
		global $wgRequest, $wgUser;
		wfProfileIn( __METHOD__ );

		if( Chat::canChat($wgUser) ){
			$chatId = $wgRequest->getVal('chatId');
			$chat = new Chat($chatId);
			$chat->join($wgUser->getName());
		}

		wfProfileOut( __METHOD__ );
	} // end rejoin()
*/

	/**
	 * Triggered by a user when they unload the chat window (part the chat).
	 */
// TODO: REMOVE
/*
	static public function part(){
		global $wgRequest, $wgUser;
		wfProfileIn( __METHOD__ );

		$chatId = $wgRequest->getVal('chatId');
		$chat = new Chat($chatId);
		$chat->part($wgUser->getName());
		
		wfProfileOut( __METHOD__ );
	}
*/

} // end class ChatAjax
