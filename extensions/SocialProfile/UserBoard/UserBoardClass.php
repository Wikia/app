<?php
/**
 * Functions for managing user board data
 */
class UserBoard {
	/**#@+
	 * @private
	 */
	var $user_id;
	var $user_name;

	/**
	 * Constructor
	 * @private
	 */
	/* private */ function __construct() {
	}

	/**
	 * Sends a user board message to another user
	 *
	 * @param $user_id_from Integer: user ID of the sender
	 * @param $user_name_from Mixed: user name of the sender
	 * @param $user_id_to Integer: user ID of the reciever
	 * @param $user_name_to Mixed: user name of the reciever
	 * @param $message Mixed: message text
	 * @param $message_type Integer: 0 for public message
	 * @return Integer: the inserted value of ub_id row
	 */
	public function sendBoardMessage( $user_id_from, $user_name_from, $user_id_to, $user_name_to, $message, $message_type = 0 ) {
		$dbw = wfGetDB( DB_MASTER );

		$user_name_from = stripslashes( $user_name_from );
		$user_name_to = stripslashes( $user_name_to );

		$dbw->insert(
			'user_board',
			array(
				'ub_user_id_from' => $user_id_from,
				'ub_user_name_from' => $user_name_from,
				'ub_user_id' => $user_id_to,
				'ub_user_name' => $user_name_to,
				'ub_message' => $message,
				'ub_type' => $message_type,
				'ub_date' => date( 'Y-m-d H:i:s' ),
			),
			__METHOD__
		);

		// Send Email (if user is not writing on own board)
		if ( $user_id_from != $user_id_to ) {
			$this->sendBoardNotificationEmail( $user_id_to, $user_name_from );
			$this->incNewMessageCount( $user_id_to );
		}

		$stats = new UserStatsTrack( $user_id_to, $user_name_to );
		if ( $message_type == 0 ) {
			// public message count
			$stats->incStatField( 'user_board_count' );
		} else {
			// private message count
			$stats->incStatField( 'user_board_count_priv' );
		}

		$stats = new UserStatsTrack( $user_id_from, $user_name_from );
		$stats->incStatField( 'user_board_sent' );

		return $dbw->insertId();
	}

	/**
	 * Sends an email to a user if someone wrote on their board
	 *
	 * @param $user_id_to Integer: user ID of the reciever
	 * @param $user_from Mixed: the user name of the person who wrote the board message
	 */
	public function sendBoardNotificationEmail( $user_id_to, $user_from ) {
		$user = User::newFromId( $user_id_to );
		$user->loadFromId();

		// Send email if user's email is confirmed and s/he's opted in to recieving social notifications
		if ( $user->isEmailConfirmed() && $user->getIntOption( 'notifymessage', 1 ) ) {
			$board_link = SpecialPage::getTitleFor( 'UserBoard' );
			$update_profile_link = SpecialPage::getTitleFor( 'UpdateProfile' );
			wfLoadExtensionMessages( 'SocialProfileUserBoard' );
			$subject = wfMsgExt( 'message_received_subject', 'parsemag',
				$user_from
			);
			$body = wfMsgExt( 'message_received_body', 'parsemag',
				$user->getName(),
				$user_from,
				$board_link->escapeFullURL(),
				$update_profile_link->escapeFullURL()
			);
			$user->sendMail( $subject, $body, null, null, 'BoardNotificationEmail' );
		}
	}

	public function incNewMessageCount( $user_id ) {
		global $wgMemc;
		$key = wfMemcKey( 'user', 'newboardmessage', $user_id );
		$wgMemc->incr( $key );
	}

	static function clearNewMessageCount( $user_id ) {
		global $wgMemc;
		$key = wfMemcKey( 'user', 'newboardmessage', $user_id );
		$wgMemc->set( $key, 0 );
	}

	static function getNewMessageCountCache( $user_id ) {
		global $wgMemc;
		$key = wfMemcKey( 'user', 'newboardmessage', $user_id );
		$data = $wgMemc->get( $key );
		if ( $data != '' ) {
			wfDebug( "Got new message count of $data for id $user_id from cache\n" );
			return $data;
		}
	}

	static function getNewMessageCountDB( $user_id ) {
		wfDebug( "Got new message count for id $user_id from DB\n" );

		global $wgMemc;
		$key = wfMemcKey( 'user', 'newboardmessage', $user_id );
		// $dbw = wfGetDB( DB_MASTER );
		$new_count = 0;
		// $s = $dbw->selectRow( 'user_board', array( 'COUNT(*) AS count' ), array( 'ug_user_id_to' => $user_id, 'ug_status' => 1 ), __METHOD__ );
		// if ( $s !== false ) $new_count = $s->count;

		$wgMemc->set( $key, $new_count );

		return $new_count;
	}

	static function getNewMessageCount( $user_id ) {
		global $wgMemc;
		$data = self::getNewMessageCountCache( $user_id );

		if ( $data != '' ) {
			$count = $data;
		} else {
			$count = self::getNewMessageCountDB( $user_id );
		}
		return $count;
	}

	/**
	 * Checks if the user with ID number $user_id owns the board message with the ID number $ub_id
	 * @param $user_id Integer: user ID number
	 * @param $ub_id Integer: user board message ID number
	 * @return Boolean: true if user owns the message, otherwise false
	 */
	public function doesUserOwnMessage( $user_id, $ub_id ) {
		$dbw = wfGetDB( DB_MASTER );
		$s = $dbw->selectRow(
			'user_board',
			array( 'ub_user_id' ),
			array( 'ub_id' => $ub_id ),
			__METHOD__
		);
		if ( $s !== false ) {
			if ( $user_id == $s->ub_user_id ) {
				return true;
			}
		}
		return false;
	}

	/**
	 * Deletes a user board message from the database
	 * @param $ub_id Integer: ID number of the board message that we want to delete
	 */
	public function deleteMessage( $ub_id ) {
		if ( $ub_id ) {
			$dbw = wfGetDB( DB_MASTER );
			$s = $dbw->selectRow(
				'user_board',
				array( 'ub_user_id', 'ub_user_name', 'ub_type' ),
				array( 'ub_id' => $ub_id ),
				__METHOD__
			);
			if ( $s !== false ) {
				$dbw->delete(
					'user_board',
					array( 'ub_id' => $ub_id ),
					__METHOD__
				);

				$stats = new UserStatsTrack( $s->ub_user_id, $s->ub_user_name );
				if ( $s->ub_type == 0 ) {
					$stats->decStatField( 'user_board_count' );
				} else {
					$stats->decStatField( 'user_board_count_priv' );
				}
			}
		}
	}

	public function getUserBoardMessages( $user_id, $user_id_2 = 0, $limit = 0, $page = 0 ) {
		global $wgUser, $wgOut, $wgTitle;
		$dbr = wfGetDB( DB_SLAVE );

		if ( $limit > 0 ) {
			$limitvalue = 0;
			if ( $page ) {
				$limitvalue = $page * $limit - ( $limit );
			}
			$limit_sql = " LIMIT {$limitvalue},{$limit} ";
		}

		if ( $user_id_2 ) {
			$user_sql = "( (ub_user_id={$user_id} AND ub_user_id_from={$user_id_2}) OR
					(ub_user_id={$user_id_2} AND ub_user_id_from={$user_id}) )";
			if ( !( $user_id == $wgUser->getID() || $user_id_2 == $wgUser->getID() ) ) {
				$user_sql .= " AND ub_type = 0 ";
			}
		} else {
			$user_sql = "ub_user_id = {$user_id}";
			if ( $user_id != $wgUser->getID() ) {
				$user_sql .= " AND ub_type = 0 ";
			}
			if ( $wgUser->isLoggedIn() ) {
				$user_sql .= " OR (ub_user_id={$user_id} AND ub_user_id_from={$wgUser->getID() }) ";
			}
		}

		$sql = "SELECT ub_id, ub_user_id_from, ub_user_name_from, ub_user_id, ub_user_name,
			ub_message,UNIX_TIMESTAMP(ub_date) AS unix_time,ub_type
			FROM {$dbr->tableName( 'user_board' )}
			WHERE {$user_sql}
			ORDER BY ub_id DESC
			{$limit_sql}";

		$res = $dbr->query( $sql, __METHOD__ );
		$messages = array();
		while ( $row = $dbr->fetchObject( $res ) ) {
			$parser = new Parser();
			$message_text = $parser->parse( $row->ub_message, $wgTitle, $wgOut->parserOptions(), true );
			$message_text = $message_text->getText();

			$messages[] = array(
				'id' => $row->ub_id,
				'timestamp' => ( $row->unix_time ),
				'user_id_from' => $row->ub_user_id_from,
				'user_name_from' => $row->ub_user_name_from,
				'user_id' => $row->ub_user_id,
				'user_name' => $row->ub_user_name,
				'message_text' => $message_text,
				'type' => $row->ub_type
			);
		}
		return $messages;
	}

	public function getUserBoardToBoardCount( $user_id, $user_id_2 ) {
		global $wgUser;
		$dbr = wfGetDB( DB_SLAVE );

		$user_sql = " ( (ub_user_id={$user_id} AND ub_user_id_from={$user_id_2}) OR
					(ub_user_id={$user_id_2} AND ub_user_id_from={$user_id}) )";

		if ( !( $user_id == $wgUser->getID() || $user_id_2 == $wgUser->getID() ) ) {
			$user_sql .= " AND ub_type = 0 ";
		}
		$sql = "SELECT count(*) AS the_count
			FROM {$dbr->tableName( 'user_board' )}
			WHERE {$user_sql}";

		$res = $dbr->query( $sql, __METHOD__ );
		$row = $dbr->fetchObject( $res );
		if ( $row ) {
			$count = $row->the_count;
		}
		return $count;
	}

	public function displayMessages( $user_id, $user_id_2 = 0, $count = 10, $page = 0 ) {
		global $wgUser, $wgTitle;

		$output = ''; // Prevent E_NOTICE
		$messages = $this->getUserBoardMessages( $user_id, $user_id_2, $count, $page );
		wfLoadExtensionMessages( 'SocialProfileUserBoard' );
		if ( $messages ) {

			foreach ( $messages as $message ) {
				$user = Title::makeTitle( NS_USER, $message['user_name_from'] );
				$avatar = new wAvatar( $message['user_id_from'], 'm' );

				$board_to_board = '';
				$board_link = '';
				$message_type_label = '';
				$delete_link = '';

				if ( $wgUser->getName() != $message['user_name_from'] ) {
					$board_to_board = '<a href="' . UserBoard::getUserBoardToBoardURL( $message['user_name'], $message['user_name_from'] ) . '">' . wfMsgHtml( 'userboard_board-to-board' ) . '</a>';
					$board_link = '<a href="' . UserBoard::getUserBoardURL( $message['user_name_from'] ) . '">' . wfMsgHtml( 'userboard_sendmessage', $message['user_name_from'] ) . '</a>';
				}
				if ( $wgUser->getName() == $message['user_name'] || $wgUser->isAllowed( 'userboard-delete' ) ) {
					$delete_link = "<span class=\"user-board-red\">
							<a href=\"javascript:void(0);\" onclick=\"javascript:delete_message({$message["id"]})\">" . wfMsgHtml( 'userboard_delete' ) . "</a>
						</span>";
				}
				if ( $message['type'] == 1 ) {
					$message_type_label = '(' . wfMsgHtml( 'userboard_private' ) . ')';
				}

				# $max_link_text_length = 50;
				$message_text = $message['message_text'];
				# $message_text = preg_replace_callback( "/(<a[^>]*>)(.*?)(<\/a>)/i", 'cut_link_text', $message['message_text'] );

				$output .= "<div class=\"user-board-message\" >
					<div class=\"user-board-message-from\">
					<a href=\"{$user->escapeFullURL()}\" title=\"{$message["user_name_from"]}\">{$message["user_name_from"]}</a> {$message_type_label}
					</div>
					<div class=\"user-board-message-time\">
						" . wfMsgHtml( 'userboard_posted_ago', $this->getTimeAgo( $message['timestamp'] ) ) . "
					</div>
					<div class=\"user-board-message-content\">
						<div class=\"user-board-message-image\">
							<a href=\"{$user->escapeFullURL()}\" title=\"{$message["user_name_from"]}\">{$avatar->getAvatarURL()}</a>
						</div>
						<div class=\"user-board-message-body\" >
							{$message_text}
						</div>
						<div class=\"cleared\"></div>
					</div>
					<div class=\"user-board-message-links\">
						{$board_link}
						{$board_to_board}
						{$delete_link}
					</div>
				</div>";
			}
		} elseif ( $wgUser->getName() == $wgTitle->getText() ) {
			$output .= '<div class="no-info-container">'
				. wfMsgHtml( 'userboard_nomessages' ) .
			'</div>';

		}
		return $output;
	}

	static function getBoardBlastURL() {
		$title = SpecialPage::getTitleFor( 'SendBoardBlast' );
		return $title->escapeFullURL();
	}

	static function getUserBoardURL( $user_name ) {
		$title = SpecialPage::getTitleFor( 'UserBoard' );
		$user_name = str_replace( '&', '%26', $user_name );
		return $title->escapeFullURL( 'user=' . $user_name );
	}

	static function getUserBoardToBoardURL( $user_name_1, $user_name_2 ) {
		$title = SpecialPage::getTitleFor( 'UserBoard' );
		$user_name_1 = str_replace( '&', '%26', $user_name_1 );
		$user_name_2 = str_replace( '&', '%26', $user_name_2 );
		return $title->escapeFullURL( 'user=' . $user_name_1 . '&conv=' . $user_name_2 );
	}

	/**
	 * Gets the difference between two given dates
	 *
	 * @param $dt1 Mixed: current time, as returned by PHP's time() function
	 * @param $dt2 Mixed: date
	 * @return Difference between dates
	 */
	public function dateDiff( $date1, $date2 ) {
		$dtDiff = $date1 - $date2;

		$totalDays = intval( $dtDiff / ( 24 * 60 * 60 ) );
		$totalSecs = $dtDiff - ( $totalDays * 24 * 60 * 60 );
		$dif['w'] = intval( $totalDays / 7 );
		$dif['d'] = $totalDays;
		$dif['h'] = $h = intval( $totalSecs / ( 60 * 60 ) );
		$dif['m'] = $m = intval( ( $totalSecs - ( $h * 60 * 60 ) ) / 60 );
		$dif['s'] = $totalSecs - ( $h * 60 * 60 ) - ( $m * 60 );

		return $dif;
	}

	public function getTimeOffset( $time, $timeabrv, $timename ) {
		wfLoadExtensionMessages( 'SocialProfileUserBoard' );
		$timeStr = '';
		if ( $time[$timeabrv] > 0 ) {
			$timeStr = wfMsgExt( "userboard-time-{$timename}", 'parsemag', $time[$timeabrv] );
		}
		if ( $timeStr ) {
			$timeStr .= ' ';
		}
		return $timeStr;
	}

	/**
	 * Gets the time how long ago the given board message was posted
	 * @param $time
	 * @return $timeStr Mixed: time, such as "20 days" or "11 hours"
	 */
	public function getTimeAgo( $time ) {
		$timeArray = $this->dateDiff( time(), $time );
		$timeStr = '';
		$timeStrD = $this->getTimeOffset( $timeArray, 'd', 'days' );
		$timeStrH = $this->getTimeOffset( $timeArray, 'h', 'hours' );
		$timeStrM = $this->getTimeOffset( $timeArray, 'm', 'minutes' );
		$timeStrS = $this->getTimeOffset( $timeArray, 's', 'seconds' );
		$timeStr = $timeStrD;
		if ( $timeStr < 2 ) {
			$timeStr .= $timeStrH;
			$timeStr .= $timeStrM;
			if ( !$timeStr ) {
				$timeStr .= $timeStrS;
			}
		}
		if ( !$timeStr ) {
			$timeStr = wfMsgExt( 'userboard-time-seconds', 'parsemag', 1 );
		}
		return $timeStr;
	}
}
