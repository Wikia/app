<?php
/**
 * Class to manipulate user-specific status messages.
 *
 * @file
 */
class UserStatusClass {

	/* private */ function __construct() {
		global $wgOut, $wgScriptPath;
		$wgOut->addExtensionStyle( $wgScriptPath . '/extensions/SocialProfile/UserStatus/UserStatus.css' );
		$wgOut->addScriptFile( $wgScriptPath . '/extensions/SocialProfile/UserStatus/UserStatus.js' );
	}

	public function getStatus( $u_id ) {
		$dbr = wfGetDB( DB_SLAVE );
		$res = $dbr->select(
			'user_status',
			'*',
			array( 'us_user_id' => $u_id ),
			__METHOD__
		);

		$message = array();

		if ( empty( $res ) ) {
			$message = '';
		} else {
			foreach ( $res as $row ) {
				$message = array(
					'us_id' => $row->us_id,
					'us_user_id' => $row->us_user_id,
					'us_status' => $row->us_status,
				);
			}
		}

		return $message;
	}

	public function removeStatus( $status_id ) {
		$dbw = wfGetDB( DB_MASTER );
		$dbw->delete(
			'user_status',
			array( 'us_id' => $status_id ),
			__METHOD__
		);
		return;
	}

	/**
	 * Add a status message to the database.
	 *
	 * @param $u_id Integer: user ID number
	 * @param $message String: user-supplied status message
	 */
	public function setStatus( $u_id, $message ) {
		$message = trim( $message );
		if ( ( mb_strlen( $message ) > 90 ) || ( mb_strlen( $message ) < 1 ) ) {
			// INFO. Letter limit is 70, but here is 90, for special characters.
			// ERROR. Message length is too long
			return;
		}

		$dbw = wfGetDB( DB_MASTER );
		$res = $dbw->select(
			'user_status',
			'*',
			array( 'us_user_id' => $u_id ),
			__METHOD__
		);

		$i = 0;

		foreach ( $res as $row ) {
			$i++;
		}

		if ( $i == 0 ) {
			$dbw->insert(
				'user_status',
				/* SET */ array(
					'us_user_id' => $u_id,
					'us_status' => $message,
				),
				__METHOD__
			);
		} else {
			$dbw->update(
				'user_status',
				/* SET */ array( 'us_status' => $message ),
				/* WHERE */ array( 'us_user_id' => $u_id ),
				__METHOD__
			);
		}

		$this->useStatusHistory( 'insert', $u_id );
		return;
	}

	/**
	 * Method that manipulates the user_status_history table.
	 *
	 * @param $mode String: variable for realization of two methods.
	 *                      Variants: 'insert' and 'select'
	 * @param $u_id Integer: user ID number
	 * @return Array: array when $mode == 'select', else void
	 */
	public function useStatusHistory( $mode, $u_id ) {
		$dbw = wfGetDB( DB_MASTER );
		$userHistory = $dbw->select(
			'user_status_history',
			'*',
			array( 'ush_user_id' => $u_id ),
			__METHOD__,
			array( 'ORDER BY' => 'ush_timestamp' )
		);

		$i = 0;
		$history = array();

		foreach ( $userHistory as $row ) {
			$i++;
			$history[] = array(
				'ush_id' => $row->ush_id,
				'ush_user_id' => $row->ush_user_id,
				'ush_timestamp' => $row->ush_timestamp,
				'ush_status' => $row->ush_status,
				'ush_likes' => ( isset( $row->ush_likes ) ? $row->ush_likes : 0 ),
			);
		}

		if ( $mode == 'select' ) {
			return $history;
		}

		if ( $mode == 'insert' ) {
			$currentStatus = $this->getStatus( $u_id );

			if ( $i < 4 ) {
				$dbw->insert(
					'user_status_history',
					/* SET */ array(
						'ush_user_id' => $u_id,
						'ush_status' => $currentStatus['us_status']
					),
					__METHOD__
				);
			} else {
				$dbw->update(
					'user_status_history',
					/* SET */ array(
						'ush_status' => $currentStatus['us_status']
					),
					/*WHERE*/ array(
						'ush_user_id' => $u_id,
						'ush_timestamp' => $history[0]['ush_timestamp']
					),
					__METHOD__
				);
				$dbw->delete(
					'user_status_likes',
					array( 'usl_status_id' => $history[0]['ush_id'] ),
					__METHOD__
				);
			}
			return;
		}
	}

	public function removeHistoryStatus( $status_id ) {
		$dbw = wfGetDB( DB_MASTER );
		$dbw->delete(
			'user_status_history',
			array( 'ush_id' => $status_id ),
			__METHOD__
		);
		$dbw->delete(
			'user_status_likes',
			array( 'usl_status_id' => $status_id ),
			__METHOD__
		);
		return;
	}
	
	/**
	 * Method that get the number of people that liked $status_id status.
	 *
	 * @param $status_id Integer: ID number of status
	 * @return Integer: count of "likes" that status have.
	 */
	public function getLikeCount( $status_id ) {
		$dbr = wfGetDB( DB_SLAVE );
		$count = (int)$dbr->selectField( 
			'user_status_likes', 
			'COUNT(*) AS count', 
			array( 'usl_status_id' => $status_id ), 
			__METHOD__ 
		); 
		return $count;
	}
	
	/**
	 * Method that controlls and adds "like"s <3
	 *
	 * @param $liker_id Integer: ID number of user who liked the status
	 * @param $status_id Integer: ID number of status that was liked
	 * 
	 * @return Integer: count of "likes" that current status have
	 */
	public function likeStatus( $liker_id, $status_id ) {
		$dbw = wfGetDB( DB_MASTER );
		$statusLikes = $dbw->select(
			'user_status_likes',
			'*',
			array(
				'usl_status_id' => $status_id, 
				'usl_user_id' => $liker_id,
			),
			__METHOD__
		);
		
		$i = $dbw->numRows( $statusLikes );
		
		if ( $i==0 ) {
			$dbw->insert(
				'user_status_likes',
				array(
					'usl_status_id' => $status_id,
					'usl_user_id' => $liker_id,
				),
				__METHOD__
			);
		} else {
			$dbw->delete(
				'user_status_likes',
				array(
					'usl_status_id' => $status_id,
					'usl_user_id' => $liker_id,
				),
				__METHOD__
			);
		}
		return (string)$this->getLikeCount($status_id).' &#9829;';
	}
}