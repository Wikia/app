<?php
/**
 * Functions for managing relationship data
 */
class UserRelationship {
	public $user_id;
	public $user_name;

	/**
	 * Constructor
	 */
	public function __construct( $username ) {
		$title1 = Title::newFromDBkey( $username );
		$this->user_name = $title1->getText();
		$this->user_id = User::idFromName( $this->user_name );
	}

	/**
	 * Add a relationship request to the database.
	 *
	 * @param $user_to String: user name of the recipient of the relationship
	 *                         request
	 * @param $type Integer: 1 for friend request, 2 (or anything else than 1)
	 *                       for foe request
	 * @param $message String: user-supplied message to to the recipient; may
	 *                         be empty
	 * @param $email Boolean: send out email to the recipient of the request?
	 * @return Integer: ID of the new relationship request
	 */
	public function addRelationshipRequest( $userTo, $type, $message, $email = true ) {
		$userIdTo = User::idFromName( $userTo );
		$dbw = wfGetDB( DB_MASTER );

		$dbw->insert(
			'user_relationship_request',
			array(
				'ur_user_id_from' => $this->user_id,
				'ur_user_name_from' => $this->user_name,
				'ur_user_id_to' => $userIdTo,
				'ur_user_name_to' => $userTo,
				'ur_type' => $type,
				'ur_message' => $message,
				'ur_date' => date( 'Y-m-d H:i:s' )
			), __METHOD__
		);
		$requestId = $dbw->insertId();

		$this->incNewRequestCount( $userIdTo, $type );

		if ( $email ) {
			$this->sendRelationshipRequestEmail( $userIdTo, $this->user_name, $type );
		}

		return $requestId;
	}

	/**
	 * Send e-mail about a new relationship request to the user whose user ID
	 * is $userIdTo if they have opted in for these notification e-mails.
	 *
	 * @param $userIdTo Integer: user ID of the recipient
	 * @param $userFrom String: name of the user who requested the relationship
	 * @param $type Integer: 1 for friend request, 2 (or anything else than 1)
	 *                       for foe request
	 */
	public function sendRelationshipRequestEmail( $userIdTo, $userFrom, $type ) {
		$user = User::newFromId( $userIdTo );
		$user->loadFromDatabase();
		if ( $user->getEmail() && $user->getIntOption( 'notifyfriendrequest', 1 ) ) {
			$requestLink = SpecialPage::getTitleFor( 'ViewRelationshipRequests' );
			$updateProfileLink = SpecialPage::getTitleFor( 'UpdateProfile' );
			if ( trim( $user->getRealName() ) ) {
				$name = $user->getRealName();
			} else {
				$name = $user->getName();
			}
			if ( $type == 1 ) {
				$subject = wfMsgExt( 'friend_request_subject', 'parsemag',
					$userFrom
				);
				$body = wfMsgExt( 'friend_request_body', 'parsemag',
					$name,
					$userFrom,
					$requestLink->getFullURL(),
					$updateProfileLink->getFullURL()
				);
			} else {
				$subject = wfMsgExt( 'foe_request_subject', 'parsemag',
					$userFrom
				);
				$body = wfMsgExt( 'foe_request_body', 'parsemag',
					$name,
					$userFrom,
					$requestLink->getFullURL(),
					$updateProfileLink->getFullURL()
				);
			}
			$user->sendMail( $subject, $body );
		}
	}

	/**
	 * Send an e-mail to the user whose user ID is $userIdTo about a new user
	 * relationship.
	 *
	 * @param $userIdTo Integer: user ID of the recipient of the e-mail
	 * @param $userFrom String: name of the user who removed the relationship
	 * @param $type Integer: 1 for friend, 2 (or anything else but 1) for foe
	 */
	public function sendRelationshipAcceptEmail( $userIdTo, $userFrom, $type ) {
		$user = User::newFromId( $userIdTo );
		$user->loadFromDatabase();
		if ( $user->getEmail() && $user->getIntOption( 'notifyfriendrequest', 1 ) ) {
			$userLink = Title::makeTitle( NS_USER, $userFrom );
			$updateProfileLink = SpecialPage::getTitleFor( 'UpdateProfile' );
			if ( trim( $user->getRealName() ) ) {
				$name = $user->getRealName();
			} else {
				$name = $user->getName();
			}
			if ( $type == 1 ) {
				$subject = wfMsgExt( 'friend_accept_subject', 'parsemag',
					$userFrom
				);
				$body = wfMsgExt( 'friend_accept_body', 'parsemag',
					$name,
					$userFrom,
					$userLink->getFullURL(),
					$updateProfileLink->getFullURL()
				);
			} else {
				$subject = wfMsgExt( 'foe_accept_subject', 'parsemag',
					$userFrom
				);
				$body = wfMsgExt( 'foe_accept_body', 'parsemag',
					$name,
					$userFrom,
					$userLink->getFullURL(),
					$updateProfileLink->getFullURL()
				);
			}
			$user->sendMail( $subject, $body );
		}
	}

	/**
	 * Send an e-mail to the user whose user ID is $userIdTo about a removed
	 * relationship.
	 *
	 * @param $userIdTo Integer: user ID of the recipient of the e-mail
	 * @param $userFrom String: name of the user who removed the relationship
	 * @param $type Integer: 1 for friend, 2 (or anything else but 1) for foe
	 */
	public function sendRelationshipRemoveEmail( $userIdTo, $userFrom, $type ) {
		$user = User::newFromId( $userIdTo );
		$user->loadFromDatabase();
		if ( $user->isEmailConfirmed() && $user->getIntOption( 'notifyfriendrequest', 1 ) ) {
			$userLink = Title::makeTitle( NS_USER, $userFrom );
			$updateProfileLink = SpecialPage::getTitleFor( 'UpdateProfile' );
			if ( trim( $user->getRealName() ) ) {
				$name = $user->getRealName();
			} else {
				$name = $user->getName();
			}
			if ( $type == 1 ) {
				$subject = wfMsgExt( 'friend_removed_subject', 'parsemag',
					$userFrom
				);
				$body = wfMsgExt( 'friend_removed_body', 'parsemag',
					$name,
					$userFrom,
					$userLink->getFullURL(),
					$updateProfileLink->getFullURL()
				);
			} else {
				$subject = wfMsgExt( 'foe_removed_subject', 'parsemag',
					$userFrom
				);
				$body = wfMsgExt( 'foe_removed_body', 'parsemag',
					$name,
					$userFrom,
					$userLink->getFullURL(),
					$updateProfileLink->getFullURL()
				);
			}
			$user->sendMail( $subject, $body );
		}
	}

	/**
	 * Add a new relationship to the database.
	 *
	 * @param $relationshipRequestId Integer: relationship request ID number
	 * @param $email Boolean: send out email to the recipient of the request?
	 * @return Boolean: true if successful, otherwise false
	 */
	public function addRelationship( $relationshipRequestId, $email = true ) {
		global $wgMemc;

		$dbw = wfGetDB( DB_MASTER );
		$s = $dbw->selectRow(
			'user_relationship_request',
			array( 'ur_user_id_from', 'ur_user_name_from', 'ur_type' ),
			array( 'ur_id' => $relationshipRequestId ),
			__METHOD__
		);

		if ( $s == true ) {
			$ur_user_id_from = $s->ur_user_id_from;
			$ur_user_name_from = $s->ur_user_name_from;
			$ur_type = $s->ur_type;

			if ( self::getUserRelationshipByID( $this->user_id, $ur_user_id_from ) > 0 ) {
				return '';
			}

			$dbw->insert(
				'user_relationship',
				array(
					'r_user_id' => $this->user_id,
					'r_user_name' => $this->user_name,
					'r_user_id_relation' => $ur_user_id_from,
					'r_user_name_relation' => $ur_user_name_from,
					'r_type' => $ur_type,
					'r_date' => date( 'Y-m-d H:i:s' )
				),
				__METHOD__
			);

			$dbw->insert(
				'user_relationship',
				array(
					'r_user_id' => $ur_user_id_from,
					'r_user_name' => $ur_user_name_from,
					'r_user_id_relation' => $this->user_id,
					'r_user_name_relation' => $this->user_name,
					'r_type' => $ur_type,
					'r_date' => date( 'Y-m-d H:i:s' )
				),
				__METHOD__
			);

			$stats = new UserStatsTrack( $this->user_id, $this->user_name );
			if ( $ur_type == 1 ) {
				$stats->incStatField( 'friend' );
			} else {
				$stats->incStatField( 'foe' );
			}

			$stats = new UserStatsTrack( $ur_user_id_from, $ur_user_name_from );
			if ( $ur_type == 1 ) {
				$stats->incStatField( 'friend' );
			} else {
				$stats->incStatField( 'foe' );
			}

			if ( $email ) {
				$this->sendRelationshipAcceptEmail( $ur_user_id_from, $this->user_name, $ur_type );
			}

			// Purge caches
			$wgMemc->delete( wfMemcKey( 'relationship', 'profile', "{$this->user_id}-{$ur_type}" ) );
			$wgMemc->delete( wfMemcKey( 'relationship', 'profile', "{$ur_user_id_from}-{$ur_type}" ) );

			// Hooks (for Semantic SocialProfile mostly)
			if ( $ur_type == 1 ) {
				wfRunHooks( 'NewFriendAccepted', array( $ur_user_name_from, $this->user_name ) );
			} else {
				wfRunHooks( 'NewFoeAccepted', array( $ur_user_name_from, $this->user_name ) );
			}

			return true;
		} else {
			return false;
		}
	}

	/**
	 * Remove a relationship between two users and clear caches afterwards.
	 *
	 * @param $user1 Integer: user ID of the first user
	 * @param $user2 Integer: user ID of the second user
	 */
	public function removeRelationshipByUserID( $user1, $user2 ) {
		global $wgUser, $wgMemc;

		if ( $user1 != $wgUser->getID() && $user2 != $wgUser->getID() ) {
			return false; // only logged in user should be able to delete
		}

		// must delete record for each user involved in relationship
		$dbw = wfGetDB( DB_MASTER );
		$dbw->delete(
			'user_relationship',
			array( 'r_user_id' => $user1, 'r_user_id_relation' => $user2 ),
			__METHOD__
		);
		$dbw->delete(
			'user_relationship',
			array( 'r_user_id' => $user2, 'r_user_id_relation' => $user1 ),
			__METHOD__
		);

		$wgMemc->delete( wfMemcKey( 'relationship', 'profile', "{$user1}-1" ) );
		$wgMemc->delete( wfMemcKey( 'relationship', 'profile', "{$user2}-1" ) );

		$wgMemc->delete( wfMemcKey( 'relationship', 'profile', "{$user1}-2" ) );
		$wgMemc->delete( wfMemcKey( 'relationship', 'profile', "{$user2}-2" ) );

		// RelationshipRemovedByUserID hook
		wfRunHooks( 'RelationshipRemovedByUserID', array( $user1, $user2 ) );

		// Update social statistics for both users
		$stats = new UserStatsTrack( $user1, '' );
		$stats->updateRelationshipCount( 1 );
		$stats->updateRelationshipCount( 2 );
		$stats->clearCache();

		$stats = new UserStatsTrack( $user2, '' );
		$stats->updateRelationshipCount( 1 );
		$stats->updateRelationshipCount( 2 );
		$stats->clearCache();
	}

	/**
	 * Delete a user relationship request from the database.
	 *
	 * @param $id Integer: relationship request ID number
	 */
	public function deleteRequest( $id ) {
		$request = $this->getRequest( $id );
		$this->decNewRequestCount( $this->user_id, $request[0]['rel_type'] );

		$dbw = wfGetDB( DB_MASTER );
		$dbw->delete(
			'user_relationship_request',
			array( 'ur_id' => $id ),
			__METHOD__
		);
	}

	/**
	 * @param $relationshipRequestId Integer: relationship request ID number
	 * @param $status
	 */
	public function updateRelationshipRequestStatus( $relationshipRequestId, $status ) {
		$dbw = wfGetDB( DB_MASTER );
		$dbw->update(
			'user_relationship_request',
			/* SET */array( 'ur_status' => $status ),
			/* WHERE */array( 'ur_id' => $relationshipRequestId ),
			__METHOD__
		);
	}

	/**
	 * Make sure that there is a pending user relationship request with the
	 * given ID.
	 *
	 * @param $relationshipRequestId Integer: relationship request ID number
	 * @return bool
	 */
	public function verifyRelationshipRequest( $relationshipRequestId ) {
		$dbr = wfGetDB( DB_SLAVE );
		$s = $dbr->selectRow(
			'user_relationship_request',
			array( 'ur_user_id_to' ),
			array( 'ur_id' => $relationshipRequestId ),
			__METHOD__
		);
		if ( $s !== false ) {
			if ( $this->user_id == $s->ur_user_id_to ) {
				return true;
			}
		}
		return false;
	}

	/**
	 * @param $user1 Integer:
	 * @param $user2 Integer:
	 * @return Mixed: integer or boolean false
	 */
	static function getUserRelationshipByID( $user1, $user2 ) {
		$dbr = wfGetDB( DB_SLAVE );
		$s = $dbr->selectRow(
			'user_relationship',
			array( 'r_type' ),
			array( 'r_user_id' => $user1, 'r_user_id_relation' => $user2 ),
			__METHOD__
		);
		if ( $s !== false ) {
			return $s->r_type;
		} else {
			return false;
		}
	}

	/**
	 * @param $user1 Integer: user ID of the recipient of the request
	 * @param $user2 Integer: user ID of the sender of the request
	 * @return bool
	 */
	static function userHasRequestByID( $user1, $user2 ) {
		$dbr = wfGetDB( DB_SLAVE );
		$s = $dbr->selectRow(
			'user_relationship_request',
			array( 'ur_type' ),
			array(
				'ur_user_id_to' => $user1,
				'ur_user_id_from' => $user2,
				'ur_status' => 0
			),
			__METHOD__
		);
		if ( $s === false ) {
			return false;
		} else {
			return true;
		}
	}

	/**
	 * Get an individual user relationship request via its ID.
	 *
	 * @param $id Integer: relationship request ID
	 * @return Array: array containing relationship request info, such as its
	 *                ID, type, requester, etc.
	 */
	public function getRequest( $id ) {
		$dbr = wfGetDB( DB_SLAVE );
		$res = $dbr->select(
			'user_relationship_request',
			array(
				'ur_id', 'ur_user_id_from', 'ur_user_name_from', 'ur_type',
				'ur_message', 'ur_date'
			),
			array( "ur_id = {$id}" ),
			__METHOD__
		);

		foreach ( $res as $row ) {
			if ( $row->ur_type == 1 ) {
				$typeName = 'Friend';
			} else {
				$typeName = 'Foe';
			}
			$request[] = array(
				'id' => $row->ur_id,
				'rel_type' => $row->ur_type,
				'type' => $typeName,
				'timestamp' => ( $row->ur_date ),
				'user_id_from' => $row->ur_user_id_from,
				'user_name_from' => $row->ur_user_name_from
			);
		}

		return $request;
	}

	/**
	 * Get the list of open relationship requests.
	 *
	 * @param $status Integer:
	 * @param $limit Integer: used as the LIMIT in the SQL query
	 * @return Array: array of open relationship requests
	 */
	public function getRequestList( $status, $limit = 0 ) {
		$dbr = wfGetDB( DB_SLAVE );

		$options = array();

		if ( $limit > 0 ) {
			$options['OFFSET'] = 0;
			$options['LIMIT'] = $limit;
		}

		$options['ORDER BY'] = 'ur_id DESC';
		$res = $dbr->select(
			'user_relationship_request',
			array(
				'ur_id', 'ur_user_id_from', 'ur_user_name_from', 'ur_type',
				'ur_message', 'ur_date'
			),
			array(
				"ur_user_id_to = {$this->user_id}",
				"ur_status = {$status}"
			),
			__METHOD__,
			$options
		);

		$requests = array();
		foreach ( $res as $row ) {
			if ( $row->ur_type == 1 ) {
				$type_name = 'Friend';
			} else {
				$type_name = 'Foe';
			}
			$requests[] = array(
				'id' => $row->ur_id,
				'type' => $type_name,
				'message' => $row->ur_message,
				'timestamp' => ( $row->ur_date ),
				'user_id_from' => $row->ur_user_id_from,
				'user_name_from' => $row->ur_user_name_from
			);
		}

		return $requests;
	}

	/**
	 * Increase the amount of open relationship requests for a user.
	 *
	 * @param $userId Integer: user ID for whom to get the requests
	 * @param $relType Integer: 1 for friends, 2 (or anything else but 1) for foes
	 */
	private function incNewRequestCount( $userId, $relType ) {
		global $wgMemc;
		$key = wfMemcKey( 'user_relationship', 'open_request', $relType, $userId );
		$wgMemc->incr( $key );
	}

	/**
	 * Decrease the amount of open relationship requests for a user.
	 *
	 * @param $userId Integer: user ID for whom to get the requests
	 * @param $relType Integer: 1 for friends, 2 (or anything else but 1) for foes
	 */
	private function decNewRequestCount( $userId, $relType ) {
		global $wgMemc;
		$key = wfMemcKey( 'user_relationship', 'open_request', $relType, $userId );
		$wgMemc->decr( $key );
	}

	/**
	 * Get the amount of open user relationship requests for a user from the
	 * database and cache it.
	 *
	 * @param $userId Integer: user ID for whom to get the requests
	 * @param $relType Integer: 1 for friends, 2 (or anything else but 1) for foes
	 * @return Integer
	 */
	static function getOpenRequestCountDB( $userId, $relType ) {
		global $wgMemc;

		wfDebug( "Got open request count (type={$relType}) for id $userId from DB\n" );

		$key = wfMemcKey( 'user_relationship', 'open_request', $relType, $userId );
		$dbr = wfGetDB( DB_SLAVE );
		$requestCount = 0;

		$s = $dbr->selectRow(
			'user_relationship_request',
			array( 'COUNT(*) AS count' ),
			array(
				'ur_user_id_to' => $userId,
				'ur_status' => 0,
				'ur_type' => $relType
			),
			__METHOD__
		);

		if ( $s !== false ) {
			$requestCount = $s->count;
		}

		$wgMemc->set( $key, $requestCount );

		return $requestCount;
	}

	/**
	 * Get the amount of open user relationship requests from cache.
	 *
	 * @param $userId Integer: user ID for whom to get the requests
	 * @param $relType Integer: 1 for friends, 2 (or anything else but 1) for foes
	 * @return Integer
	 */
	static function getOpenRequestCountCache( $userId, $relType ) {
		global $wgMemc;
		$key = wfMemcKey( 'user_relationship', 'open_request', $relType, $userId );
		$data = $wgMemc->get( $key );
		if ( $data != '' ) {
			wfDebug( "Got open request count of $data (type={$relType}) for id $userId from cache\n" );
			return $data;
		}
	}

	/**
	 * Get the amount of open user relationship requests; first tries cache,
	 * and if that fails, fetches the count from the database.
	 *
	 * @param $userId Integer: user ID for whom to get the requests
	 * @param $relType Integer: 1 for friends, 2 (or anything else but 1) for foes
	 * @return Integer
	 */
	static function getOpenRequestCount( $userId, $relType ) {
		$data = self::getOpenRequestCountCache( $userId, $relType );

		if ( $data != '' ) {
			if ( $data == -1 ) {
				$data = 0;
			}
			$count = $data;
		} else {
			$count = self::getOpenRequestCountDB( $userId, $relType );
		}

		return $count;
	}

	/**
	 * Get the relationship list for the current user.
	 *
	 * @param $type Integer: 1 for friends, 2 (or anything else but 1) for foes
	 * @param $limit Integer: used as the LIMIT in the SQL query
	 * @param $page Integer: if greater than 0, will be used to calculate the
	 *                       OFFSET for the SQL query
	 * @return Array: array of relationship information
	 */
	public function getRelationshipList( $type = 0, $limit = 0, $page = 0 ) {
		$dbr = wfGetDB( DB_SLAVE );

		$where = array();
		$options = array();
		$where['r_user_id'] = $this->user_id;
		if ( $type ) {
			$where['r_type'] = $type;
		}
		if ( $limit > 0 ) {
			$limitvalue = 0;
			if ( $page ) {
				$limitvalue = $page * $limit - ( $limit );
			}
			$options['LIMIT'] = $limit;
			$options['OFFSET'] = $limitvalue;
		}
		$res = $dbr->select(
			'user_relationship',
			array(
				'r_id', 'r_user_id_relation', 'r_user_name_relation', 'r_date',
				'r_type'
			),
			$where,
			__METHOD__,
			$options
		);

		$requests = array();
		foreach ( $res as $row ) {
			$requests[] = array(
				'id' => $row->r_id,
				'timestamp' => ( $row->r_date ),
				'user_id' => $row->r_user_id_relation,
				'user_name' => $row->r_user_name_relation,
				'type' => $row->r_type
			);
		}

		return $requests;
	}

	/**
	 * Get the relationship IDs for the current user.
	 *
	 * @param $type Integer: 1 for friends, 2 (or anything else but 1) for foes
	 * @return Array: array of relationship ID numbers
	 */
	public function getRelationshipIDs( $type ) {
		$dbr = wfGetDB( DB_SLAVE );

		$res = $dbr->select(
			'user_relationship',
			array(
				'r_id', 'r_user_id_relation',
				'r_user_name_relation', 'r_date'
			),
			array( "r_user_id = {$this->user_id}", "r_type = {$type}" ),
			__METHOD__,
			array( 'ORDER BY' => 'r_user_name_relation' )
		);

		$rel = array();
		foreach ( $res as $row ) {
			$rel[] = $row->r_user_id_relation;
		}

		return $rel;
	}

	/**
	 * Get the amount of friends and foes a user has from the
	 * user_relationship_stats database table.
	 *
	 * @param $userName String: name of the user whose stats we're looking up
	 * @return Array: array containing the amount of friends and foes
	 */
	static function getRelationshipCountByUsername( $userName ) {
		$dbr = wfGetDB( DB_SLAVE );
		$userId = User::idFromName( $userName );
		$res = $dbr->select(
			'user_relationship_stats',
			array( 'rs_friend_count', 'rs_foe_count' ),
			array( "rs_user_id = {$userId}" ),
			__METHOD__,
			array( 'LIMIT' => 1, 'OFFSET' => 0 )
		);
		$row = $dbr->fetchObject( $res );
		$friendCount = 0;
		$foeCount = 0;
		if ( $row ) {
			$friendCount = $row->rs_friend_count;
			$foeCount = $row->rs_foe_count;
		}
		$stats['friend_count'] = $friendCount;
		$stats['foe_count'] = $foeCount;
		return $stats;
	}
}
