<?php

class ChatAjax {
	const INTERNAL_POLLING_DELAY_MICROSECONDS = 500000;

	/**
	 * Gets a message from the user to record in the chat.
	 * Returns an associative array.  On success, returns "success" => true, on failure,
	 * returns "error" => [error message].
	 */
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

	/**
	 * A 'long poll' request (a Comet technique) which will keep a connection open for a while
	 * if there is nothing to return yet.  It will return as soon as it knows of something worth
	 * returning, or if it reaches the limit of its timeout.
	 */
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
					array("user" => "VickyBC", "chatmod" => true),
					array("user" => "Hyun", "chatmod" => false)
				),
	 *			"part" => array("Danny"),
	 *			"kick" => array("GracenoteBot")
	 *		),
	 *		"rejoinNeeded" => false,
	 *		"updateTime" => ""
	 *	);
	 *
	 */
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
	
	/**
	 * When a user force-refreshes their window or has a connection problem, they will send a rejoin to indicate that
	 * they're chatting again and should def. be in the joins table.
	 */
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

	/**
	 * Triggered by a user when they unload the chat window (part the chat).
	 */
	static public function part(){
		global $wgRequest, $wgUser;
		wfProfileIn( __METHOD__ );

		$chatId = $wgRequest->getVal('chatId');
		$chat = new Chat($chatId);
		$chat->part($wgUser->getName());
		
		wfProfileOut( __METHOD__ );
	}

	/**
	 * Ajax endpoint for kickbanning a user. This will eject them from the chat
	 * and not let them rejoin.
	 *
	 * Returns an associative array.  On success, returns "success" => "", on failure,
	 * returns "error" => [error message].
	 */
	static public function kickBan(){
		global $wgRequest;
		wfProfileIn( __METHOD__ );

		$chatId = $wgRequest->getVal('chatId');
		$userToBan = $wgRequest->getVal('userToBan');
		if(empty($chatId)){
			$retVal["error"] = "'chatId' is required but was not found in the request.";
		} elseif(empty($userToBan)){
			$retVal["error"] = "'usertoBan' is required but was not found in the request.";
		} else {
			$chat = new Chat($chatId);
			$result = $chat->kickBan($userToBan);
			if($result === true){
				$retVal["success"] = true;
			} else {
				$retVal["error"] = $result;
			}
		}

		wfProfileOut( __METHOD__ );
		return $retVal;
	}

} // end class ChatAjax
