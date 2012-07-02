<?php
/**
 * Poll class
 */
class Poll {

	/**
	 * Adds a poll question to the database.
	 *
	 * @param $question String: poll question
	 * @param $image String: name of the poll image, if any
	 * @param $pageID Integer: page ID, as returned by Article::getID()
	 * @return Integer: inserted value of an auto-increment row
	 */
	public function addPollQuestion( $question, $image, $pageID ) {
		global $wgUser;
		$dbw = wfGetDB( DB_MASTER );
		$dbw->insert(
			'poll_question',
			array(
				'poll_page_id' => $pageID,
				'poll_user_id' => $wgUser->getID(),
				'poll_user_name' => $wgUser->getName(),
				'poll_text' => strip_tags( $question ),
				'poll_image' => $image,
				'poll_date' => date( 'Y-m-d H:i:s' ),
				'poll_random' => wfRandom()
			),
			__METHOD__
		);
		return $dbw->insertId();
	}

	/**
	 * Adds an individual poll answer choice to the database.
	 *
	 * @param $pollID Integer: poll ID number
	 * @param $choiceText String: user-supplied answer choice text
	 * @param $choiceOrder Integer: a value between 1 and 10
	 */
	public function addPollChoice( $pollID, $choiceText, $choiceOrder ) {
		$dbw = wfGetDB( DB_MASTER );
		$dbw->insert(
			'poll_choice',
			array(
				'pc_poll_id' => $pollID,
				'pc_text' => strip_tags( $choiceText ),
				'pc_order' => $choiceOrder
			),
			__METHOD__
		);
		$dbw->commit();
	}

	/**
	 * Adds a record to the poll_user_vote tabel to signify that the user has
	 * already voted.
	 *
	 * @param $pollID Integer: ID number of the poll
	 * @param $choiceID Integer: number of the choice
	 */
	public function addPollVote( $pollID, $choiceID ) {
		global $wgUser;
		$dbw = wfGetDB( DB_MASTER );
		$dbw->insert(
			'poll_user_vote',
			array(
				'pv_poll_id' => $pollID,
				'pv_pc_id' => $choiceID,
				'pv_user_id' => $wgUser->getID(),
				'pv_user_name' => $wgUser->getName(),
				'pv_date' => date( 'Y-m-d H:i:s' )
			),
			__METHOD__
		);
		$dbw->commit();
		if( $choiceID > 0 ) {
			$this->incPollVoteCount( $pollID );
			$this->incChoiceVoteCount( $choiceID );
			$stats = new UserStatsTrack( $wgUser->getID(), $wgUser->getName() );
			$stats->incStatField( 'poll_vote' );
		}
	}

	/**
	 * Increases the total amount of votes an answer choice has by one and
	 * commits to DB.
	 *
	 * @param $choiceID Integer: answer choice ID number between 1 and 10
	 */
	public function incChoiceVoteCount( $choiceID ) {
		$dbw = wfGetDB( DB_MASTER );
		$dbw->update(
			'poll_choice',
			array( 'pc_vote_count=pc_vote_count+1' ),
			array( 'pc_id' => $choiceID ),
			__METHOD__
		);
		$dbw->commit();
	}

	/**
	 * Increases the total amount of votes a poll has by one and commits to DB.
	 *
	 * @param $pollID Integer: poll ID number
	 */
	public function incPollVoteCount( $pollID ) {
		$dbw = wfGetDB( DB_MASTER );
		$dbw->update(
			'poll_question',
			array( 'poll_vote_count=poll_vote_count+1' ),
			array( 'poll_id' => $pollID ),
			__METHOD__
		);
		$dbw->commit();
	}

	/**
	 * Gets information about a poll.
	 *
	 * @param $pageID Integer: page ID number
	 * @return Array: poll information, such as question, choices, status, etc.
	 */
	public function getPoll( $pageID ) {
		$dbr = wfGetDB( DB_SLAVE );
		$res = $dbr->select(
			'poll_question',
			array(
				'poll_text', 'poll_vote_count', 'poll_id', 'poll_status',
				'poll_user_id', 'poll_user_name', 'poll_image',
				'UNIX_TIMESTAMP(poll_date) AS timestamp'
			),
			array( "poll_page_id = {$pageID}" ),
			__METHOD__,
			array( 'OFFSET' => 0, 'LIMIT' => 1 )
		);
		$row = $dbr->fetchObject( $res );
		$poll = array();
		if( $row ) {
			$poll['question'] = $row->poll_text;
			$poll['image'] = $row->poll_image;
			$poll['user_name'] = $row->poll_user_name;
			$poll['user_id'] = $row->poll_user_id;
			$poll['votes'] = $row->poll_vote_count;
			$poll['id'] = $row->poll_id;
			$poll['status'] = $row->poll_status;
			$poll['timestamp'] = $row->timestamp;
			$poll['choices'] = $this->getPollChoices( $row->poll_id, $row->poll_vote_count );
		}
		return $poll;
	}

	/**
	 * Gets the answer choices for the poll with ID = $poll_id.
	 *
	 * @param $poll_id Integer: poll ID number
	 * @param $poll_vote_count Integer: 0 by default
	 * @return Array: poll answer choice info (answer ID, text,
	 * 					amount of votes and percent of total votes)
	 */
	public function getPollChoices( $poll_id, $poll_vote_count = 0 ) {
		$dbr = wfGetDB( DB_SLAVE );

		$res = $dbr->select(
			'poll_choice',
			array( 'pc_id', 'pc_text', 'pc_vote_count' ),
			array( "pc_poll_id = {$poll_id}" ),
			__METHOD__,
			array( 'ORDER BY' => 'pc_order' )
		);

		$choices = array();
		foreach( $res as $row ) {
			if( $poll_vote_count ) {
				$percent = str_replace( '.0', '', number_format( $row->pc_vote_count / $poll_vote_count * 100, 1 ) );
			} else {
				$percent = 0;
			}
			//$percent = round( $row->pc_vote_count / $poll_vote_count * 100 );

			$choices[] = array(
				'id' => $row->pc_id,
				'choice' => $row->pc_text,
				'votes' => $row->pc_vote_count,
				'percent' => $percent
			);
		}

		return $choices;
	}

	/**
	 * Checks if the user has voted already to the poll with ID = $poll_id.
	 * @param $user_name Mixed: current user's username
	 * @param $poll_id Integer: poll ID number
	 * @return Boolean: true if user has voted, otherwise false
	 */
	public function userVoted( $user_name, $poll_id ) {
		$dbr = wfGetDB( DB_SLAVE );
		$s = $dbr->selectRow(
			'poll_user_vote',
			array( 'pv_id' ),
			array( 'pv_poll_id' => $poll_id, 'pv_user_name' => $user_name ),
			__METHOD__
		);
		if ( $s !== false ) {
			return true;
		}
		return false;
	}

	/**
	 * Checks if the specified user "owns" the specified poll.
	 *
	 * @param $userId Integer: user ID of the user
	 * @param $pollId Integer: poll ID number
	 * @return Boolean: true if the user owns the poll, else false
	 */
	public function doesUserOwnPoll( $userId, $pollId ) {
		$dbr = wfGetDB( DB_SLAVE );
		$s = $dbr->selectRow(
			'poll_question',
			array( 'poll_id' ),
			array(
				'poll_id' => intval( $pollId ),
				'poll_user_id' => intval( $userId )
			),
			__METHOD__
		);
		if ( $s !== false ) {
			return true;
		}
		return false;
	}

	/**
	 * Gets the URL of a randomly chosen poll (well, actually just the
	 * namespace and page title).
	 *
	 * @param $userName String: current user's username
	 * @return String: poll namespace name and poll page name or 'error'
	 */
	public function getRandomPollURL( $userName ) {
		$pollID = $this->getRandomPollID( $userName );
		if( $pollID ) {
			$pollPage = Title::newFromID( $pollID );
			global $wgContLang;
		  	return $wgContLang->getNsText( NS_POLL ) . ':'. $pollPage->getDBkey();
		} else {
			return 'error';
		}
	}

	/**
	 * Gets a random poll to which the current user hasn't answered yet.
	 *
	 * @param $userName String: current user's username
	 * @return Array
	 */
	public function getRandomPoll( $userName ) {
		$pollId = $this->getRandomPollID( $userName );
		$poll = array();
		if( $pollId ) {
			$poll = $this->getPoll( $pollId );
		}
		return $poll;
	}

	/**
	 * Gets a random poll ID from the database.
	 * The poll ID will be the ID of a poll to which the user hasn't answered
	 * yet.
	 *
	 * @param $user_name Mixed: current user's username
	 * @return Integer: random poll ID number
	 */
	public function getRandomPollID( $user_name ) {
		$dbr = wfGetDB( DB_MASTER );
		$poll_page_id = 0;
		$use_index = $dbr->useIndexClause( 'poll_random' );
		$randstr = wfRandom();
		$sql = "SELECT poll_page_id FROM {$dbr->tableName( 'poll_question' )} {$use_index}
			INNER JOIN {$dbr->tableName( 'page' )} ON page_id=poll_page_id WHERE poll_id NOT IN
				(SELECT pv_poll_id FROM {$dbr->tableName( 'poll_user_vote' )} WHERE pv_user_name = '" . $dbr->strencode( $user_name ) . "')
				AND poll_status=1 AND poll_random>$randstr ORDER BY poll_random LIMIT 0,1";
		$res = $dbr->query( $sql, __METHOD__ );
		$row = $dbr->fetchObject( $res );
		// random fallback
		if( !$row ) {
			$sql = "SELECT poll_page_id FROM {$dbr->tableName( 'poll_question' )} {$use_index}
				INNER JOIN {$dbr->tableName( 'page' )} ON page_id=poll_page_id WHERE poll_id NOT IN
					(SELECT pv_poll_id FROM {$dbr->tableName( 'poll_user_vote' )} WHERE pv_user_name = '" . $dbr->strencode( $user_name ) . "')
					AND poll_status=1 AND poll_random<$randstr ORDER BY poll_random LIMIT 0,1";
			wfDebugLog( 'PollNY', $sql );
			$res = $dbr->query( $sql, __METHOD__ );
			$row = $dbr->fetchObject( $res );
		}
		if( $row ) {
			$poll_page_id = $row->poll_page_id;
		}

		return $poll_page_id;
	}

	/**
	 * Updates the status of the poll with the ID $poll_id to $status and
	 * commits the changes.
	 *
	 * @param $pollId Integer: poll ID number
	 * @param $status Integer: 0 (close), 1 (open) or 2 (flag)
	 */
	public function updatePollStatus( $pollId, $status ) {
		$dbw = wfGetDB( DB_MASTER );
		$dbw->update(
			'poll_question',
			array( 'poll_status' => $status ),
			array( 'poll_id' => (int)$pollId ),
			__METHOD__
		);
		$dbw->commit();
	}

	/**
	 * Gets a list of polls, either from memcached or database, up to $count
	 * polls, ordered by $order and stores the list in cache
	 * (if fetched from DB).
	 *
	 * @param $count Integer: how many polls to fetch? Default is 3.
	 * @param $order String: ORDER BY for SQL query, default being 'poll_id'.
	 */
	public function getPollList( $count = 3, $order = 'poll_id' ) {
		global $wgMemc;

		$polls = array();
		// Try cache
		$key = wfMemcKey( 'polls', 'order', $order, 'count', $count );
		$data = $wgMemc->get( $key );
		if( !empty( $data ) && is_array( $data ) ) {
			wfDebug( "Got polls list ($count) ordered by {$order} from cache\n" );
			$polls = $data;
		} else {
			wfDebug( "Got polls list ($count) ordered by {$order} from db\n" );
			$dbr = wfGetDB( DB_SLAVE );
			$params['LIMIT'] = $count;
			$params['ORDER BY'] = "{$order} DESC";
			$res = $dbr->select(
				array( 'poll_question', 'page' ),
				array(
					'page_title', 'poll_id', 'poll_vote_count', 'poll_image',
					'UNIX_TIMESTAMP(poll_date) AS poll_date'
				),
				/* WHERE */array( 'poll_status' => 1 ),
				__METHOD__,
				$params,
				array( 'page' => array( 'INNER JOIN', 'page_id = poll_page_id' ) )
			);
			foreach( $res as $row ) {
				$polls[] = array(
					'title' => $row->page_title,
					'timestamp' => $row->poll_date,
					'image' => $row->poll_image,
					'choices' => self::getPollChoices( $row->poll_id, $row->poll_vote_count )
				);
			}
			if( !empty( $polls ) ) {
				$wgMemc->set( $key, $polls, 60 * 10 );
			}
		}

		return $polls;
	}

	/**
	 * The following three functions are borrowed
	 * from includes/wikia/GlobalFunctionsNY.php
	 */
	public static function dateDiff( $date1, $date2 ) {
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

	public static function getTimeOffset( $time, $timeabrv, $timename ) {
		$timeStr = '';
		if( $time[$timeabrv] > 0 ) {
			$timeStr = wfMsgExt( "poll-time-{$timename}", 'parsemag', $time[$timeabrv] );
		}
		if( $timeStr ) {
			$timeStr .= ' ';
		}
		return $timeStr;
	}

	public static function getTimeAgo( $time ) {
		$timeArray = self::dateDiff( time(), $time );
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
			$timeStr = wfMsgExt( 'poll-time-seconds', 'parsemag', 1 );
		}
		return $timeStr;
	}

}