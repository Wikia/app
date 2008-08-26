<?php
/**
 * Functions for managing relationship data
 */
class UserRelationship {
	 /**#@+
	 * @private
	 */
	var $user_id;
	var $user_name;

	/**
	 * Constructor
	 * @private
	 */
	/* private */ function __construct($username) {
		wfLoadExtensionMessages( 'SocialProfileUserRelationship' );
		$title1 = Title::newFromDBkey($username );
		$this->user_name = $title1->getText();
		$this->user_id = User::idFromName($this->user_name);
	}

	public function addRelationshipRequest($user_to, $type, $message, $email=true){
		global $wgDBprefix;
		$user_id_to = User::idFromName($user_to);
		$dbr = wfGetDB( DB_MASTER );
		$fname = $wgDBprefix.'user_relationship_request::addToDatabase';
		$dbr->insert( '`'.$wgDBprefix.'user_relationship_request`',
		array(
			'ur_user_id_from' => $this->user_id,
			'ur_user_name_from' => $this->user_name,
			'ur_user_id_to' => $user_id_to,
			'ur_user_name_to' => $user_to,
			'ur_type' => $type,
			'ur_message' => $message,
			'ur_date' => date("Y-m-d H:i:s")
			), $fname
		);
		$request_id = $dbr->insertId();

		$this->incNewRequestCount($user_id_to, $type);

		if($email)$this->sendRelationshipRequestEmail($user_id_to, $this->user_name, $type);
		return $request_id;
	}

	public function sendRelationshipRequestEmail($user_id_to,$user_from,$type){
		$user = User::newFromId($user_id_to);
		$user->loadFromDatabase();
		if( $user->getEmail() && $user->getIntOption("notifyfriendrequest",1) ){ //if($user->isEmailConfirmed() && $user->getIntOption("notifyfriendrequest",1)){
			$request_link = Title::makeTitle( NS_SPECIAL , "ViewRelationshipRequests" );
			$update_profile_link = Title::makeTitle( NS_SPECIAL , "UpdateProfile" );
			if($type==1){
				$subject = wfMsgExt( 'friend_request_subject', "parsemag",
					$user_from
				);
				$body = wfMsgExt( 'friend_request_body', "parsemag",
					(( trim($user->getRealName()) )?$user->getRealName():$user->getName()),
					$user_from,
					$request_link->getFullURL(),
					$update_profile_link->getFullURL()
				);
			} else {
				$subject = wfMsgExt( 'foe_request_subject', "parsemag",
					$user_from
				);
				$body = wfMsgExt( 'foe_request_body', "parsemag",
					(( trim($user->getRealName()) )?$user->getRealName():$user->getName()),
					$user_from,
					$request_link->getFullURL(),
					$update_profile_link->getFullURL()
				);
			}
			$user->sendMail($subject, $body );
		}
	}

	public function sendRelationshipAcceptEmail($user_id_to, $user_from, $type){
		$user = User::newFromId($user_id_to);
		$user->loadFromDatabase();
		if( $user->getEmail() && $user->getIntOption("notifyfriendrequest",1) ){ //if($user->isEmailConfirmed() && $user->getIntOption("notifyfriendrequest",1)){
			$user_link = Title::makeTitle( NS_USER , $user_from );
			$update_profile_link = Title::makeTitle( NS_SPECIAL , "UpdateProfile" );
			if($type==1){
				$subject = wfMsgExt( 'friend_accept_subject', "parsemag",
					$user_from
				);
				$body = wfMsgExt( 'friend_accept_body', "parsemag",
					(( trim($user->getRealName()) )?$user->getRealName():$user->getName()),
					$user_from,
					$user_link->getFullURL(),
					$update_profile_link->getFullURL()
				);
			} else {
				$subject = wfMsgExt( 'foe_accept_subject', "parsemag",
					$user_from
				);
				$body = wfMsgExt( 'foe_accept_body', "parsemag",
					(( trim($user->getRealName()) )?$user->getRealName():$user->getName()),
					$user_from,
					$user_link->getFullURL(),
					$update_profile_link->getFullURL()
				);
			}
			$user->sendMail($subject, $body );
		}
	}

	public function sendRelationshipRemoveEmail($user_id_to, $user_from, $type){
		$user = User::newFromId($user_id_to);
		$user->loadFromDatabase();
		if($user->isEmailConfirmed() && $user->getIntOption("notifyfriendrequest",1)){
			$user_link = Title::makeTitle( NS_USER , $user_from );
			$update_profile_link = Title::makeTitle( NS_SPECIAL , "UpdateProfile" );
			if($type==1){
				$subject = wfMsgExt( 'friend_removed_subject',"parsemag",
					$user_from
				);
				$body = wfMsgExt( 'friend_removed_body',"parsemag",
					(( trim($user->getRealName()) )?$user->getRealName():$user->getName()),
					$user_from,
					$user_link->getFullURL(),
					$update_profile_link->getFullURL()
				);
			} else {
				$subject = wfMsgExt( 'foe_removed_subject',"parsemag",
					$user_from
				);
				$body = wfMsgExt( 'foe_removed_body',"parsemag",
					(( trim($user->getRealName()) )?$user->getRealName():$user->getName()),
					$user_from,
					$user_link->getFullURL(),
					$update_profile_link->getFullURL()
				);
			}
			$user->sendMail($subject, $body );
		}
	}

	public function addRelationship($relationship_request_id, $email=true){
		global $wgMemc, $wgDBprefix;

		$dbr = wfGetDB( DB_MASTER );
		$s = $dbr->selectRow( '`'.$wgDBprefix.'user_relationship_request`',
				array( 'ur_user_id_from','ur_user_name_from','ur_type'),
				array( 'ur_id' => $relationship_request_id ), $fname
		);

		if ( $s == true ) {
			$ur_user_id_from = $s->ur_user_id_from;
			$ur_user_name_from = $s->ur_user_name_from;
			$ur_type = $s->ur_type;

			if( self::getUserRelationshipByID($this->user_id,$ur_user_id_from) > 0 ){
				return "";
			}

			$fname = $wgDBprefix.'user_relationship::addToDatabase';
			$dbr->insert( '`'.$wgDBprefix.'user_relationship`',
			array(
				'r_user_id' => $this->user_id,
				'r_user_name' => $this->user_name,
				'r_user_id_relation' => $ur_user_id_from,
				'r_user_name_relation' => $ur_user_name_from,
				'r_type' => $ur_type,
				'r_date' => date("Y-m-d H:i:s")
				), $fname
			);

			$fname = $wgDBprefix.'user_relationship::addToDatabase';
			$dbr->insert( '`'.$wgDBprefix.'user_relationship`',
			array(
				'r_user_id' => $ur_user_id_from,
				'r_user_name' => $ur_user_name_from,
				'r_user_id_relation' => $this->user_id,
				'r_user_name_relation' => $this->user_name,
				'r_type' => $ur_type,
				'r_date' => date("Y-m-d H:i:s")
				), $fname
			);

			$stats = new UserStatsTrack($this->user_id, $this->user_name);
			if($ur_type==1){
				$stats->incStatField("friend");
			} else {
				$stats->incStatField("foe");
			}

			$stats = new UserStatsTrack($ur_user_id_from, $ur_user_name_from);
			if($ur_type==1){
				$stats->incStatField("friend");
			} else {
				$stats->incStatField("foe");
			}

			if($email)$this->sendRelationshipAcceptEmail($ur_user_id_from, $this->user_name, $ur_type);

			$wgMemc->delete( wfMemcKey( 'relationship', 'profile', "{$this->user_id}-{$ur_type}") );
			$wgMemc->delete( wfMemcKey( 'relationship', 'profile', "{$ur_user_id_from}-{$ur_type}") );

			return true;
		} else {
			return false;
		}
	}

	public function removeRelationshipByUserID($user1,$user2){
		global $wgUser, $wgMemc, $wgDBprefix;

		if($user1!=$wgUser->getID() && $user2!=$wgUser->getID()){
			return false; //only logged in user should be able to delete
		}
		//must delete record for each user involved in relationship
		$dbr = wfGetDB( DB_MASTER );
		$sql = "DELETE FROM ".$wgDBprefix."user_relationship WHERE r_user_id={$user1} AND r_user_id_relation={$user2}";
		$res = $dbr->query($sql);
		$sql = "DELETE FROM ".$wgDBprefix."user_relationship WHERE r_user_id={$user2} AND r_user_id_relation={$user1}";
		$res = $dbr->query($sql);

		$wgMemc->delete( wfMemcKey( 'relationship', 'profile', "{$user1}-1") );
		$wgMemc->delete( wfMemcKey( 'relationship', 'profile', "{$user2}-1" ) );

		$wgMemc->delete( wfMemcKey( 'relationship', 'profile', "{$user1}-2" ) );
		$wgMemc->delete( wfMemcKey( 'relationship', 'profile', "{$user2}-2" ) );

		$stats = new UserStatsTrack($user1, "");
		$stats->updateRelationshipCount(1);
		$stats->updateRelationshipCount(2);
		$stats->clearCache();

		$stats = new UserStatsTrack($user2, "");
		$stats->updateRelationshipCount(1);
		$stats->updateRelationshipCount(2);
		$stats->clearCache();
	}

	public function deleteRequest($id){
	global $wgDBprefix;
		$request = $this->getRequest($id);
		$this->decNewRequestCount($this->user_id, $request[0]["rel_type"]);

		$dbr = wfGetDB( DB_MASTER );
		$sql = "DELETE FROM ".$wgDBprefix."user_relationship_request WHERE ur_id={$id}";
		$res = $dbr->query($sql);;
	}

	public function updateRelationshipRequestStatus($relationship_request_id, $status){
		global $wgDBprefix;
		$dbw = wfGetDB( DB_MASTER );
		$dbw->update( '`'.$wgDBprefix.'user_relationship_request`',
			array( /* SET */
			'ur_status' => $status
			), array( /* WHERE */
			'ur_id' => $relationship_request_id
			), ""
		);
	}

	public function verifyRelationshipRequest($relationship_request_id){
	global $wgDBprefix;
		$dbr = wfGetDB( DB_MASTER );
		$s = $dbr->selectRow( '`'.$wgDBprefix.'user_relationship_request`', array( 'ur_user_id_to' ), array( 'ur_id' => $relationship_request_id ), $fname );
		if ( $s !== false ) {
			if($this->user_id == $s->ur_user_id_to){
				return true;
			}
		}
		return false;
	}

	static function getUserRelationshipByID($user1,$user2){
	global $wgDBprefix;
		$dbr = wfGetDB( DB_MASTER );
		//For some reason in this function, if you add $wgDBprefix before user_relationship it adds it twice. Also removed was ''
		$s = $dbr->selectRow( 'user_relationship', array( 'r_type' ), array( 'r_user_id' => $user1, 'r_user_id_relation' => $user2 ), __METHOD__ );
		if ( $s !== false ) {
			return $s->r_type;
		} else {
			return false;
		}
	}

	static function userHasRequestByID($user1, $user2){
	global $wgDBprefix;
		$dbr = wfGetDB( DB_MASTER );
		$s = $dbr->selectRow( '`'.$wgDBprefix.'user_relationship_request`', array( 'ur_type' ), array( 'ur_user_id_to' => $user1, 'ur_user_id_from' => $user2, 'ur_status' => 0 ), __METHOD__ );
		if ( $s === false ) {
			return false;
		} else {
			return true;
		}
	}

	public function getRequest($id){
	global $wgDBprefix;
		$dbr = wfGetDB( DB_MASTER );
		$sql = "SELECT ur_id, ur_user_id_from, ur_user_name_from, ur_type, ur_message, ur_date
			FROM ".$wgDBprefix."user_relationship_request
			WHERE ur_id = {$id}";
		$res = $dbr->query($sql);
		while ($row = $dbr->fetchObject( $res ) ) {
			if($row->ur_type==1){
				$type_name = "Friend";
			} else {
				$type_name = "Foe";
			}
			 $request[] = array(
				 "id"=>$row->ur_id,"rel_type"=>$row->ur_type,"type"=>$type_name,"timestamp"=>($row->ur_date ) ,
				 "user_id_from"=>$row->ur_user_id_from,"user_name_from"=>$row->ur_user_name_from
				 );
		}
		return $request;
	}

	public function getRequestList($status,$limit=0){
	global $wgDBprefix;
		$dbr = wfGetDB( DB_MASTER );

		$limit_sql = $limit > 0 ? " LIMIT 0,{$limit} " : '';

		$sql = "SELECT ur_id, ur_user_id_from, ur_user_name_from, ur_type, ur_message, ur_date
			FROM ".$wgDBprefix."user_relationship_request
			WHERE ur_user_id_to = {$this->user_id} AND ur_status = {$status}
			{$limit_sql}
			ORDER BY ur_id DESC";
		$res = $dbr->query($sql);

		$requests = array();
		while ($row = $dbr->fetchObject( $res ) ) {
			if( $row->ur_type==1){
				$type_name = "Friend";
			} else {
				$type_name = "Foe";
			}
			 $requests[] = array(
				 "id"=>$row->ur_id,"type"=>$type_name,"message"=>$row->ur_message,"timestamp"=>($row->ur_date ) ,
				 "user_id_from"=>$row->ur_user_id_from,"user_name_from"=>$row->ur_user_name_from
				 );
		}
		return $requests;
	}

	private function incNewRequestCount($user_id, $rel_type){
		global $wgMemc;
		$key = wfMemcKey( 'user_relationship', 'open_request', $rel_type, $user_id );;
		$wgMemc->incr( $key );
	}

	private function decNewRequestCount($user_id, $rel_type){
		global $wgMemc;
		$key = wfMemcKey( 'user_relationship', 'open_request', $rel_type, $user_id );
		$wgMemc->decr( $key );
	}

	static function getOpenRequestCountDB($user_id, $rel_type){
		wfDebug( "Got open request count (type={$rel_type}) for id $user_id from db\n" );

		global $wgMemc, $wgDBprefix;
		$key = wfMemcKey( 'user_relationship', 'open_request', $rel_type, $user_id );
		$dbr = wfGetDB( DB_SLAVE );
		$request_count = 0;
		$s = $dbr->selectRow( '`'.$wgDBprefix.'user_relationship_request`', array( 'count(*) as count' ), array( 'ur_user_id_to' => $user_id, 'ur_status' => 0, 'ur_type' => $rel_type ), __METHOD__ );
		if ( $s !== false )$request_count = $s->count;

		$wgMemc->set($key, $request_count);

		return $request_count;
	}

	static function getOpenRequestCountCache($user_id, $rel_type){
		global $wgMemc;
		$key = wfMemcKey( 'user_relationship', 'open_request', $rel_type, $user_id );
		$data = $wgMemc->get( $key );
		//$wgMemc->delete( $key );
		if( $data != "" ){
			wfDebug( "Got open request count of $data (type={$rel_type}) for id $user_id from cache\n" );
			return $data;
		}
	}

	static function getOpenRequestCount($user_id, $rel_type){
		$data = self::getOpenRequestCountCache($user_id, $rel_type);

		if( $data != "" ){
			if($data==-1)$data = 0;
			$count = $data;
		} else {
			$count = self::getOpenRequestCountDB($user_id, $rel_type);
		}
		return $count;
	}

	public function getRelationshipList($type=0,$limit=0,$page=0){
		global $wgDBprefix;
		$dbr = wfGetDB( DB_SLAVE );

		if($limit>0){
			$limitvalue = 0;
			if($page)$limitvalue = $page * $limit - ($limit);
			$limit_sql = " LIMIT {$limitvalue},{$limit} ";
		} else {
			$limit_sql = '';
		}

		if($type){
			$type_sql = " AND r_type = {$type} ";
		} else {
			$type_sql = '';
		}

		$sql = "SELECT r_id, r_user_id_relation, r_user_name_relation, r_date, r_type
			FROM ".$wgDBprefix."user_relationship
			WHERE r_user_id = {$this->user_id} $type_sql
			ORDER BY r_user_name_relation
			{$limit_sql}";

		$res = $dbr->query($sql);
		$requests = array();
		while ($row = $dbr->fetchObject( $res ) ) {
			 $requests[] = array(
				 "id"=>$row->r_id,"timestamp"=>($row->r_date ) ,
				 "user_id"=>$row->r_user_id_relation,"user_name"=>$row->r_user_name_relation,
				 "type" => $row->r_type
				 );
		}

		return $requests;
	}

	public function getRelationshipIDs($type){
		global $wgDBprefix;
		$dbr = wfGetDB( DB_SLAVE );

		$sql = "SELECT r_id, r_user_id_relation, r_user_name_relation, r_date
			FROM ".$wgDBprefix."user_relationship
			WHERE r_user_id = {$this->user_id} AND r_type = {$type}
			ORDER BY r_user_name_relation
			{$limit_sql}";

		$rel = array();
		$res = $dbr->query($sql);
		while ($row = $dbr->fetchObject( $res ) ) {
			 $rel[] = $row->r_user_id_relation;
		}
		return $rel;
	}

	static function getRelationshipCountByUsername($user_name){
		global $wgDBprefix;
		$dbr = wfGetDB( DB_SLAVE );
		$user_id = User::idFromName($user_name);
		$sql = "SELECT rs_friend_count, rs_foe_count
			FROM ".$wgDBprefix."user_relationship_stats
			WHERE rs_user_id = {$user_id}
			LIMIT 0,1";
		$res = $dbr->query($sql);
		$row = $dbr->fetchObject( $res );
		$friend_count = 0;
		$foe_count = 0;
		if($row){
			 $friend_count=$row->rs_friend_count;
			 $foe_count=$row->rs_foe_count;
		}
		$stats["friend_count"]= $friend_count;
		$stats["foe_count"]= $foe_count;
		return $stats;
	}
}
