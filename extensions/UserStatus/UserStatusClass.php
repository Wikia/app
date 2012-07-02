<?php
/**
 * Class for managing status updates and status update votes ("X people agree")
 *
 * @file
 * @ingroup Extensions
 */
class UserStatus {

	/**
	 * All member variables should be considered private
	 * Please use the accessor functions
	 */

	/**#@+
	 * @private
	 */
	//var $user_id;           	# Text form (spaces not underscores) of the main part
	//var $user_name;			# Text form (spaces not underscores) of the main part

	/**
	 * Constructor
	 * @private
	 */
	/* private */ function __construct() {}

	public function addStatus( $sport_id, $team_id, $text ) {
		global $wgUser;

		$dbw = wfGetDB( DB_MASTER );

		if( $wgUser->isBlocked() ) {
			return '';
		}

		$dbw->insert(
			'user_status',
			array(
				'us_user_id' => $wgUser->getID(),
				'us_user_name' => $wgUser->getName(),
				'us_sport_id' => $sport_id,
				'us_team_id' => $team_id,
				'us_text' => $text,
				'us_date' => date( 'Y-m-d H:i:s' ),
			),
			__METHOD__
		);
		$us_id = $dbw->insertId();

		$stats = new UserStatsTrack( $wgUser->getID(), $wgUser->getName() );
		$stats->incStatField( 'user_status_count' );

		$this->updateUserCache( $text, $sport_id, $team_id );

		return $us_id;
	}

	/**
	 * Add a vote for the given status update.
	 * Only registered users who haven't voted before can vote.
	 *
	 * @param $us_id Integer: status update ID number
	 * @param $vote Integer: -1 or 1
	 * @return Integer: vote ID
	 */
	public function addStatusVote( $us_id, $vote ) {
		global $wgUser;

		// Only registered users may vote...
		if( $wgUser->isLoggedIn() ) {
			// ...and only if they haven't already voted
			if( $this->alreadyVotedStatusMessage( $wgUser->getID(), $us_id ) ) {
				return;
			}

			$dbw = wfGetDB( DB_MASTER );

			$dbw->insert(
				'user_status_vote',
				array(
					'sv_user_id' => $wgUser->getID(),
					'sv_user_name' => $wgUser->getName(),
					'sv_us_id' => $us_id,
					'sv_vote_score' => $vote,
					'sv_date' => date( 'Y-m-d H:i:s' ),
				),
				__METHOD__
			);
			$sv_id = $dbw->insertId();

			$this->incStatusVoteCount( $us_id, $vote );

			return $sv_id;
		}
	}

	public function incStatusVoteCount( $us_id, $vote ) {
		if( $vote == 1 ) {
			$field = 'us_vote_plus';
		} else {
			$field = 'us_vote_minus';
		}
		$dbw = wfGetDB( DB_MASTER );
		$dbw->update(
			'user_status',
			array( "{$field}={$field}+1" ),
			array( 'us_id' => $us_id ),
			__METHOD__
		);
	}

	public function updateUserCache( $text, $sport_id, $team_id = 0 ) {
		global $wgUser, $wgMemc;
		$key = wfMemcKey( 'user', 'status-last-update', $wgUser->getID() );

		$data['text'] = $this->formatMessage( $text );
		$data['sport_id'] = $sport_id;
		$data['team_id'] = $team_id;
		$data['timestamp'] = time();
		if( $team_id ) {
			$team = SportsTeams::getTeam( $team_id );
			$data['network'] = $team['name'];
		} else {
			$sport = SportsTeams::getSport( $sport_id );
			$data['network'] = $sport['name'];
		}
		$wgMemc->set( $key, $data );
	}

	/**
	 * Check if the given user has already voted on the given status message.
	 *
	 * @param $user_id Integer: user ID number
	 * @param $us_id Integer: status message ID number
	 * @return Boolean: true if the user has already voted, otherwise false
	 */
	public function alreadyVotedStatusMessage( $user_id, $us_id ) {
		$dbr = wfGetDB( DB_MASTER );
		$s = $dbr->selectRow(
			'user_status_vote',
			array( 'sv_user_id' ),
			array( 'sv_us_id' => $us_id, 'sv_user_id' => $user_id ),
			__METHOD__
		);
		if ( $s !== false ) {
			return true;
		}
		return false;
	}

	/**
	 * Check if the given user is the author of the given status message.
	 *
	 * @param $user_id Integer: user ID number
	 * @param $us_id Integer: status message ID number
	 * @return Boolean: true if the user owns the status message, else false
	 */
	public function doesUserOwnStatusMessage( $user_id, $us_id ) {
		$dbr = wfGetDB( DB_MASTER );
		$s = $dbr->selectRow(
			'user_status',
			array( 'us_user_id' ),
			array( 'us_id' => $us_id ),
			__METHOD__
		);
		if ( $s !== false ) {
			if( $user_id == $s->us_user_id ) {
				return true;
			}
		}
		return false;
	}

	/**
	 * Delete a status message via its ID.
	 *
	 * @param $us_id Integer: ID number of the status message to delete
	 */
	public function deleteStatus( $us_id ) {
		if( $us_id ) {
			$dbw = wfGetDB( DB_MASTER );
			$s = $dbw->selectRow(
				'user_status',
				array(
					'us_user_id', 'us_user_name', 'us_sport_id', 'us_team_id'
				),
				array( 'us_id' => $us_id ),
				__METHOD__
			);
			if ( $s !== false ) {
				$dbw->delete(
					'user_status',
					array( 'us_id' => $us_id ),
					__METHOD__
				);

				$stats = new UserStatsTrack( $s->us_user_id, $s->us_user_name );
				$stats->decStatField( 'user_status_count' );
			}
		}
	}

	/**
	 * Format a message by passing it to the Parser.
	 *
	 * @param $message String: message (wikitext) to parse
	 * @return String: parsed status message
	 */
	static function formatMessage( $message ) {
		global $wgOut;
		$messageText = $wgOut->parse( trim( $message ), false );
		return $messageText;
	}

	/**
	 * Get information about an individual status message via its ID number.
	 *
	 * @param $us_id Integer: status update ID number
	 * @return Array: array containing info, such as the text and ID, about the
	 *                status message
	 */
	public function getStatusMessage( $us_id ) {
		global $wgUser;

		$dbr = wfGetDB( DB_MASTER );

		$sql = "SELECT us_id, us_user_id, us_user_name, us_text,
			us_sport_id, us_team_id, us_vote_plus, us_vote_minus,
			UNIX_TIMESTAMP(us_date) AS unix_time,
			(SELECT COUNT(*) FROM {$dbr->tableName( 'user_status_vote' )}
				WHERE sv_us_id = us_id
				AND sv_user_id =" . $wgUser->getID() . ") AS AlreadyVoted
			FROM {$dbr->tableName( 'user_status' )}
			WHERE us_id={$us_id} LIMIT 1";

		$res = $dbr->query( $sql, __METHOD__ );

		$messages = array();

		foreach ( $res as $row ) {
			$messages[] = array(
				'id' => $row->us_id,
				'timestamp' => ($row->unix_time),
				'user_id' => $row->us_user_id,
				'user_name' => $row->us_user_name,
				'sport_id' => $row->us_sport_id,
				'team_id' => $row->us_team_id,
				'plus_count' => $row->us_vote_plus,
				'minus_count' => $row->us_vote_minus,
				'text' => $this->formatMessage( $row->us_text ),
				'voted' => $row->AlreadyVoted
			);
		}

		return $messages[0];
	}

	/**
	 * Get the given amount of the given user's status messages; used by
	 * displayStatusMessages().
	 *
	 * @param $user_id Integer: user ID whose status updates we want to display
	 * @param $sport_id Integer: sport ID for which we want to display updates
	 * @param $team_id Integer: sports team ID
	 * @param $count Integer: display this many messages
	 * @param $page Integer: page we're on; used for pagination
	 * @return Array: array containing information such as the timestamp,
	 *                status update ID number and more about each update
	 */
	public function getStatusMessages( $user_id = 0, $sport_id = 0, $team_id = 0, $limit = 10, $page = 0 ) {
		global $wgUser;

		$dbr = wfGetDB( DB_MASTER );
		$user_sql = $sport_sql = '';

		if( $limit > 0 ) {
			$limitvalue = 0;
			if( $page ) {
				$limitvalue = $page * $limit - ( $limit );
			}
			$limit_sql = " LIMIT {$limitvalue},{$limit} ";
		}

		if( $user_id > 0 ) {
			$user_sql .= " us_user_id = {$user_id} ";
		}

		if( $sport_id > 0 && $team_id == 0 ) {
			$sport_sql .= " ( ( us_sport_id = {$sport_id} AND us_team_id = 0 ) OR us_team_id IN
				(SELECT team_id FROM {$dbr->tableName( 'sport_team' )} WHERE team_sport_id = {$sport_id} ) ) ";
		}

		if( $team_id > 0 ) {
			$sport_sql .= " us_team_id = {$team_id} ";
		}

		if( $user_sql && $sport_sql ) {
			$user_sql .= ' AND ';
		}

		$sql = "SELECT us_id, us_user_id, us_user_name, us_text,
			us_sport_id, us_team_id, us_vote_plus, us_vote_minus,
			UNIX_TIMESTAMP(us_date) AS unix_time,
			(SELECT COUNT(*) FROM {$dbr->tableName( 'user_status_vote' )}
				WHERE sv_us_id = us_id
				AND sv_user_id = " . $wgUser->getID() . ") AS AlreadyVoted
			FROM {$dbr->tableName( 'user_status' )}
			WHERE {$user_sql} {$sport_sql}
			ORDER BY us_id DESC
			{$limit_sql}";

		$res = $dbr->query( $sql, __METHOD__ );

		$messages = array();

		foreach ( $res as $row ) {
			$messages[] = array(
				'id' => $row->us_id,
				'timestamp' => ( $row->unix_time ),
				'user_id' => $row->us_user_id,
				'user_name' => $row->us_user_name,
				'sport_id' => $row->us_sport_id,
				'team_id' => $row->us_team_id,
				'plus_count' => $row->us_vote_plus,
				'minus_count' => $row->us_vote_minus,
				'text' => $this->formatMessage( $row->us_text ),
				'voted' => $row->AlreadyVoted
			);
		}

		return $messages;
	}

	/**
	 * Display the given amount of the given user's status messages.
	 *
	 * @param $user_id Integer: user ID whose status updates we want to display
	 * @param $sport_id Integer: sport ID for which we want to display updates
	 * @param $team_id Integer: sports team ID
	 * @param $count Integer: display this many messages
	 * @param $page Integer: page we're on; used for pagination
	 * @return String: HTML
	 */
	public function displayStatusMessages( $user_id, $sport_id = 0, $team_id = 0, $count = 10, $page = 0 ) {
		global $wgUser;

		$output = '';

		$messages = $this->getStatusMessages(
			$user_id,
			$sport_id,
			$team_id,
			$count,
			$page
		);
		$messages_count = count( $messages );
		$x = 1;

		$thought_link = SpecialPage::getTitleFor( 'ViewThought' );

		if( $messages ) {
			foreach ( $messages as $message ) {
				$user = Title::makeTitle( NS_USER, $message['user_name'] );
				$avatar = new wAvatar( $message['user_id'], 'm' );

				$messages_link = '<a href="' .
					UserStatus::getUserUpdatesURL( $message['user_name'] ) . '">' .
					wfMsg( 'userstatus-view-all-updates', $message['user_name'] ) .
				'</a>';
				$delete_link = '';

				$vote_count = wfMsgExt( 'userstatus-num-agree', 'parsemag', $message['plus_count'] );

				if (
					$wgUser->getName() == $message['user_name'] ||
					$wgUser->isAllowed( 'delete-status-updates' )
				)
				{
					$delete_link = "<span class=\"user-board-red\">
						<a href=\"javascript:void(0);\" onclick=\"javascript:delete_message({$message['id']})\">" .
						wfMsg( 'userstatus-delete-thought-text' ) . '</a>
					</span>';
				}

				$vote_link = '';
				if( $wgUser->isLoggedIn() && $wgUser->getName() != $message['user_name'] ) {
					if ( !$message['voted'] ) {
						$vote_link = "<a href=\"javascript:void(0);\" onclick=\"vote_status({$message['id']},1)\">[" .
							wfMsg( 'userstatus-agree' ) . ']</a>';
					} else {
						$vote_link = $vote_count;
					}
				}

				$view_thought_link = '<a href="' . $thought_link->getFullURL( 'id=' . $message['id'] ) .
					'">[' . wfMsg( 'userstatus-see-who-agrees' ) . ']</a>';

				$message_text = preg_replace_callback(
					'/(<a[^>]*>)(.*?)(<\/a>)/i',
					array( 'UserStatus', 'cutLinkText' ),
					$message['text']
				);

				if ( $x == 1 ) {
					$output .= '<div class="user-status-row-top">';
				} elseif ( $x < $messages_count ) {
					$output .= '<div class="user-status-row">';
				} else {
					$output .= '<div class="user-status-row-bottom">';
				}

				$output .= "

				<div class=\"user-status-logo\">
					<a href=\"{$user->getFullURL()}\">{$avatar->getAvatarURL()}</a>
				</div>

				<div class=\"user-status-message\">

					<a href=\"{$user->getFullURL()}\"><b>{$message['user_name']}</b></a> {$message_text}

					<div class=\"user-status-date\">" .
						wfMsg( 'userstatus-ago', self::getTimeAgo( $message['timestamp'] ) ) .
						"<span class=\"user-status-vote\" id=\"user-status-vote-{$message['id']}\">
							{$vote_link}
						</span>
						{$view_thought_link}
						<span class=\"user-status-links\">
							{$delete_link}
						</span>
					</div>

				</div>

				<div class=\"cleared\"></div>

				</div>";

				$x++;

			}
		} else {
			$output .= '<p>' . wfMsg( 'userstatus-no-new-thoughts' ) . '</p>';
		}

		return $output;
	}

	/**
	 * Get the amount of plus and minus votes a status update has, if any.
	 *
	 * @param $us_id Integer: status update ID number
	 * @return Mixed: boolean false if it doesn't have any votes yet, otherwise
	 *                an array containing the plus and minus votes
	 */
	public function getStatusVotes( $us_id ) {
		$dbr = wfGetDB( DB_MASTER );
		$s = $dbr->selectRow(
			'user_status',
			array( 'us_vote_plus', 'us_vote_minus' ),
			array( 'us_id' => $us_id ),
			__METHOD__
		);
		if ( $s !== false ) {
			$votes['plus'] = $s->us_vote_plus;
			$votes['minus'] = $s->us_vote_minus;
			return $votes;
		}
		return false;
	}

	public function getStatusVoters( $us_id ) {
		$dbr = wfGetDB( DB_MASTER );

		$res = $dbr->select(
			'user_status_vote',
			array(
				'sv_user_id', 'sv_user_name',
				'UNIX_TIMESTAMP(sv_date) AS unix_time', 'sv_vote_score'
			),
			array( 'sv_us_id' => intval( $us_id ) ),
			__METHOD__,
			array( 'ORDER BY' => 'sv_id DESC' )
		);

		$voters = array();

		foreach ( $res as $row ) {
			$voters[] = array(
				'timestamp' => ( $row->unix_time ),
				'user_id' => $row->sv_user_id,
				'user_name' => $row->sv_user_name,
				'score' => $row->sv_vote_score
			);
		}

		return $voters;
	}

	static function getNetworkUpdatesCount( $sport_id, $team_id ) {
		$dbr = wfGetDB( DB_MASTER );
		if( !$team_id ) {
			$where_sql = " ( ( us_sport_id = {$sport_id} AND us_team_id = 0 ) OR us_team_id IN
				(SELECT team_id FROM {$dbr->tableName( 'sport_team' )} WHERE team_sport_id = {$sport_id} ) ) ";
		} else {
			$where_sql = " us_team_id = {$team_id} ";
		}
		$sql = "SELECT COUNT(*) AS the_count FROM {$dbr->tableName( 'user_status' )} WHERE {$where_sql} ";
		$res = $dbr->query( $sql, __METHOD__ );
		$row = $dbr->fetchObject( $res );
		return $row->the_count;
	}

	static function getUserUpdatesURL( $user_name ) {
		$title = SpecialPage::getTitleFor( 'UserStatus' );
		return $title->escapeFullURL( "user=$user_name" );
	}

	static function dateDifference( $date1, $date2 ) {
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

	static function getTimeOffset( $time, $timeabrv, $timename ) {
		$timeStr = '';
		if( $time[$timeabrv] > 0 ) {
			$timeStr = wfMsgExt( "userstatus-time-{$timename}", 'parsemag', $time[$timeabrv] );
		}
		if( $timeStr ) {
			$timeStr .= ' ';
		}
		return $timeStr;
	}

	function getTimeAgo( $time ) {
		$timeArray = self::dateDifference( time(), $time );
		$timeStr = '';
		$timeStrD = self::getTimeOffset( $timeArray, 'd', 'days' );
		$timeStrH = self::getTimeOffset( $timeArray, 'h', 'hours' );
		$timeStrM = self::getTimeOffset( $timeArray, 'm', 'minutes' );
		$timeStrS = self::getTimeOffset( $timeArray, 's', 'seconds' );
		$timeStr = $timeStrD;
		if( $timeStr < 2 ) {
			$timeStr .= $timeStrH;
			$timeStr .= $timeStrM;
			if( !$timeStr ) {
				$timeStr .= $timeStrS;
			}
		}
		if( !$timeStr ) {
			$timeStr = wfMsgExt( 'userstatus-time-seconds', 'parsemag', 1 );
		}
		return $timeStr;
	}

	/**
	 * Cuts link text if it's too long.
	 * For example, http://www.google.com/some_stuff_here could be changed into
	 * http://goo...stuff_here or so.
	 */
	public static function cutLinkText( $matches ) {
		$tagOpen = $matches[1];
		$linkText = $matches[2];
		$tagClose = $matches[3];

		$image = preg_match( '/<img src=/i', $linkText );
		$isURL = ( preg_match( '%^(?:http|https|ftp)://(?:www\.)?.*$%i', $linkText ) ? true : false );

		if( $isURL && !$image && strlen( $linkText ) > 50 ) {
			$start = substr( $linkText, 0, ( 50 / 2 ) - 3 );
			$end = substr( $linkText, strlen( $linkText ) - ( 50 / 2 ) + 3, ( 50 / 2 ) - 3 );
			$linkText = trim( $start ) . wfMsg( 'ellipsis' ) . trim( $end );
		}
		return $tagOpen . $linkText . $tagClose;
	}
}