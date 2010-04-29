<?php
/**
 *
 */
class UserRelationship {

	/**
	 * All member variables should be considered private
	 * Please use the accessor functions
	 */

	 /**#@+
	 * @private
	 */
	var $user_id;           	# Text form (spaces not underscores) of the main part
	var $user_name;			# Text form (spaces not underscores) of the main part
	var $friend_count;           	# Text form (spaces not underscores) of the main part
	var $foe_count;           	# Text form (spaces not underscores) of the main part
	
	static $trust_types = array(
		0 => "None",
		1 => "Little",
		2 => "Below Average",
		3 => "Ordinary",
		4 => "High",
		5 => "Complete"
	);
	
	/**
	 * Constructor
	 * @private
	 */
	/* private */ function __construct($username) {
		$title1 = Title::newFromDBkey($username  );
		$this->user_name = $title1->getText();
		$this->user_id = User::idFromName($this->user_name);
		
	}
	
	public function addRelationshipRequest($user_to,$type,$message, $email=true, $trust=0){
		$user_id_to = User::idFromName($user_to);
		if( !$user_id_to ){ //in case auto friending is on, slave might not have id yet in idFromName immediately after registering
			$dbr = wfGetDB( DB_MASTER );
			$s = $dbr->selectRow( 'user', array( 'user_id' ), array( 'user_name' => $user_to ), __METHOD__ );
			$user_id_to = $s->user_id;
		}
		if( !$user_id_to )return false;
		
		$dbr =& wfGetDB( DB_MASTER );
		
		$s = $dbr->selectRow( '`user_relationship_request`', array( 'ur_user_id_to' ), array( 'ur_user_id_to' => $user_id_to, 'ur_user_id_from' =>  $this->user_id), __METHOD__ );
		if ( isset($s) && isset($s->ur_user_id_to) && ($s->ur_user_id_to > 0) ) {
			return "";	
		}
		
		
		$fname = 'user_relationship_request::addToDatabase';
		$dbr->insert( '`user_relationship_request`',
		array(
			'ur_user_id_from' => $this->user_id,
			'ur_user_name_from' => $this->user_name,
			'ur_user_id_to' => $user_id_to,
			'ur_user_name_to' => $user_to,
			'ur_type' => $type,
			'ur_message' => $message,
			'ur_trust_type' => $trust,
			'ur_date' => date("Y-m-d H:i:s")
			), $fname
		);
		
		$request_id = $dbr->insertId();
		$dbr->commit();
		
		global $wgMemc;
		$key = wfMemcKey( 'user_relationship', 'awaitingrequests', $this->user_id );
		$wgMemc->delete( $key );
		
		$this->incNewRequestCount($user_id_to, $type);
		
		if($email)$this->sendRelationshipRequestEmail($user_id_to,$this->user_name,$type);
		return $request_id;
		
	}

	public function getUserLocalizedMsg($user, $sMsgKey, $args) {
		global $wgContLanguageCode, $wgUser, $wgContLang;
		$sBody = null;

		$sLangCode = $user->getOption('language');

		if( $wgContLang->hasVariants() && in_array($sLangCode, $wgContLang->getVariants()) ){
			$variant = $wgContLang->getPreferredVariant();
			if( $variant != $wgContLanguageCode )
				$sLangCode = $variant;
		}

		if( empty( $sLangCode ) || !preg_match( '/^[a-z-]+$/', $sLangCode ) ) {
			wfDebug( "Invalid user language code\n" );
			$sLangCode = $wgContLanguageCode;
		}
		
		$sBody = wfMsgExt($sMsgKey, array( 'parsemag', 'language' => $sLangCode )  );
		
		$sBody = wfMsgReplaceArgs($sBody, $args);
		return $sBody;
	}
	
	public function sendRelationshipRequestEmail($user_id_to,$user_from,$type){
		$user = User::newFromId($user_id_to);
		$user->loadFromId();
		
		$user_from_obj = User::newFromName($user_from);
		if( is_object( $user_from_obj ) ){
			$user_from_obj->load();
			$user_from_display =  trim($user_from_obj->getRealName());
		}
		if( !$user_from_display ){
			$user_from_display = $user_from;
		}
		
		if(  $user->getEmail() && $user->getIntOption("notifyfriendrequest",1) ){ //if($user->isEmailConfirmed()  && $user->getIntOption("notifyfriendrequest",1)){
			$request_link = Title::makeTitle( NS_SPECIAL , "ViewRelationshipRequests"  );
			$update_profile_link = Title::makeTitle( NS_SPECIAL , "UpdateProfile"  );
			if($type==1){
				$subject = $this->getUserLocalizedMsg( $user, "friend_request_subject", array( 0 => $user_from , 1 => $user_from_display ) );
				$body = $this->getUserLocalizedMsg( $user, "friend_request_body", 
					array(
					0 => (( trim($user->getRealName()) )?$user->getRealName():$user->getName()),
					1 => $user_from,
					2 => $request_link->getFullURL(),
					3 => $update_profile_link->getFullURL(),
					4 => $user_from_display)
				);
			}else{
				$subject = wfMsgExt( 'foe_request_subject', 'parsemag',
					$user_from
				 );
				$body = wfMsgExt( 'foe_request_body', 'parsemag',
					(( trim($user->getRealName()) )?$user->getRealName():$user->getName()),
					$user_from,
					$request_link->getFullURL(),
					$update_profile_link->getFullURL()
				);				
			}
			$user->sendMail($subject, $body, null, null, 'RelationshipRequestEmail');
		}
	}
	
	public function sendRelationshipAcceptEmail($user_id_to, $user_from, $type){
		$user = User::newFromId($user_id_to);
		$user->loadFromId();
		
		$user_from_obj = User::newFromName($user_from);
		if( is_object( $user_from_obj ) ){
			$user_from_obj->load();
			$user_from_display =  trim($user_from_obj->getRealName());
		}
		if( !$user_from_display ){
			$user_from_display = $user_from;
		}
		
		if(  $user->getEmail() && $user->getIntOption("notifyfriendrequest",1) ){ //if($user->isEmailConfirmed()  && $user->getIntOption("notifyfriendrequest",1)){
			$user_link = Title::makeTitle( NS_USER ,  $user_from  );
			$update_profile_link = Title::makeTitle( NS_SPECIAL , "UpdateProfile"  );
			if($type==1){
				$subject = $this->getUserLocalizedMsg( $user, "friend_accept_subject", array( 0 => $user_from , 1 => $user_from_display ) );
				$body = $this->getUserLocalizedMsg( $user, "friend_accept_body", 
					array(
					0 => (( trim($user->getRealName()) )?$user->getRealName():$user->getName()),
					1 => $user_from,
					2 => $user_link->getFullURL(),
					3 => $update_profile_link->getFullURL())
				);
			}else{
				$subject = wfMsgExt( 'foe_accept_subject', 'parsemag',
					$user_from
				 );
				$body = wfMsgExt( 'foe_accept_body', 'parsemag',
					(( trim($user->getRealName()) )?$user->getRealName():$user->getName()),
					$user_from,
					$user_link->getFullURL(),
					$update_profile_link->getFullURL()
				);				
			}
			$user->sendMail($subject, $body, null, null, 'RelationshipAcceptEmail');
		}		
	}

	public function sendRelationshipRemoveEmail($user_id_to, $user_from, $type){
		return; // rt#47426

		$user = User::newFromId($user_id_to);
		$user->loadFromId();
		
		$user_from_obj = User::newFromName($user_from);
		if( is_object( $user_from_obj ) ){
			$user_from_obj->load();
			$user_from_display =  trim($user_from_obj->getRealName());
		}
		if( !$user_from_display ){
			$user_from_display = $user_from;
		}
		
		if($user->isEmailConfirmed() && $user->getIntOption("notifyfriendrequest",1)){
			$user_link = Title::makeTitle( NS_USER ,  $user_from  );
			$update_profile_link = Title::makeTitle( NS_SPECIAL , "UpdateProfile"  );
			if($type==1){
				$subject = $this->getUserLocalizedMsg( $user, "friend_removed_subject", array( 0 => $user_from , 1 => $user_from_display ) );
				$body = $this->getUserLocalizedMsg( $user, "friend_removed_body", 
					array(
					0 => (( trim($user->getRealName()) )?$user->getRealName():$user->getName()),
					1 => $user_from,
					2 => $user_link->getFullURL(),
					3 => $update_profile_link->getFullURL(),
					4 => $user_from_display)
				);
			}else{
				$subject = wfMsgExt( 'foe_removed_subject','parsemag',
					$user_from
				 );
				$body = wfMsgExt( 'foe_removed_body','parsemag',
					(( trim($user->getRealName()) )?$user->getRealName():$user->getName()),
					$user_from,
					$user_link->getFullURL(),
					$update_profile_link->getFullURL()
				);				
			}
			$user->sendMail($subject, $body, null, null, 'RelationshipRemoveEmail');
		}		
	}
	
	public function addRelationship($relationship_request_id, $email=true, $trust_type = 0){
		global $wgMemc, $wgUserBulletins;
		
		
		$dbr =& wfGetDB( DB_MASTER );
		$s = $dbr->selectRow( '`user_relationship_request`', 
				array( 'ur_user_id_from','ur_user_name_from','ur_type','ur_trust_type'),
				array( 'ur_id' => $relationship_request_id ), __METHOD__ 
		);
		if ( $s == true ) {
			$ur_user_id_from = $s->ur_user_id_from;
			$ur_user_name_from = $s->ur_user_name_from;
			$ur_type = $s->ur_type;
			$trust_type_from  = $s->ur_trust_type;
			
			if( self::getUserRelationshipByID($this->user_id,$ur_user_id_from) > 0 ){
				return "";
			}
			
			$fname = 'user_relationship::addToDatabase';
			$dbr->insert( '`user_relationship`',
			array(
				'r_user_id' => $this->user_id,
				'r_user_name' => $this->user_name,
				'r_user_id_relation' => $ur_user_id_from,
				'r_user_name_relation' => $ur_user_name_from,
				'r_type' => $ur_type,
				'r_trust_type' => $trust_type,
				'r_date' => date("Y-m-d H:i:s")
				), $fname
			);
			$dbr->commit();
			
			if( $wgUserBulletins["rel"] == true ){
				$b = new UserBulletin();
				$b->addBulletin($this->user_name,"friend",$ur_user_name_from);
			}
			
			$fname = 'user_relationship::addToDatabase';
			$dbr->insert( '`user_relationship`',
			array(
				'r_user_id' => $ur_user_id_from,
				'r_user_name' => $ur_user_name_from,
				'r_user_id_relation' => $this->user_id,
				'r_user_name_relation' => $this->user_name,
				'r_type' => $ur_type,
				'r_trust_type' => $trust_type_from,
				'r_date' => date("Y-m-d H:i:s")
				), $fname
			);
			$dbr->commit();
			
			if( $wgUserBulletins["rel"] == true ){
				$b = new UserBulletin();
				$b->addBulletin($ur_user_name_from,"friend",$this->user_name);
			}
			
			$stats = new UserStatsTrack($this->user_id, $this->user_name);
			if($ur_type==1){
				$stats->incStatField("friend");
			}else{
				$stats->incStatField("foe");
			}
			
			$stats = new UserStatsTrack($ur_user_id_from,$ur_user_name_from);
			if($ur_type==1){
				$stats->incStatField("friend");
			}else{
				$stats->incStatField("foe");
			}
			
			if($email)$this->sendRelationshipAcceptEmail($ur_user_id_from,$this->user_name,$ur_type);
			
			$wgMemc->delete( wfMemcKey( 'relationship', 'profile', "{$this->user_id}-{$ur_type}") );
			$wgMemc->delete( wfMemcKey( 'relationship', 'profile', "{$ur_user_id_from}-{$ur_type}") );
			
			$wgMemc->delete( wfMemcKey( 'relationship', 'list', $ur_user_id_from) );
			$wgMemc->delete( wfMemcKey( 'relationship', 'list', $this->user_id) );
			
			return true;
		}else{
			return false;
		}
		
		
	}
	
	public function removeRelationshipByUserID($user1,$user2){
		global $wgUser, $wgMemc;
		
		if($user1!=$wgUser->getID() && $user2!=$wgUser->getID()){
			return false; //only logged in user should be able to delete
		}
		//must delete record for each user involved in relationship
		$dbr =& wfGetDB( DB_MASTER );
		$sql = "DELETE FROM user_relationship WHERE r_user_id={$user1} AND r_user_id_relation={$user2}";
		$res = $dbr->query($sql);
		$dbr->commit();
		$sql = "DELETE FROM user_relationship WHERE r_user_id={$user2} AND r_user_id_relation={$user1}";
		$res = $dbr->query($sql);
		$dbr->commit();
		
		$wgMemc->delete( wfMemcKey( 'relationship', 'profile', "{$user1}-1") );
		$wgMemc->delete( wfMemcKey( 'relationship', 'profile', "{$user2}-1" ) );
			
		$wgMemc->delete( wfMemcKey( 'relationship', 'profile', "{$user1}-2" ) );
		$wgMemc->delete( wfMemcKey( 'relationship', 'profile', "{$user2}-2" ) );
		
		$wgMemc->delete( wfMemcKey( 'relationship', 'list', "{$user1}" ) );
		$wgMemc->delete( wfMemcKey( 'relationship', 'list', "{$user2}" ) );
		
		$stats = new UserStatsTrack($user1,"");
		$stats->updateRelationshipCount(1);
		$stats->updateRelationshipCount(2);
		
		$stats = new UserStatsTrack($user2,"");
		$stats->updateRelationshipCount(1);
		$stats->updateRelationshipCount(2);
	}
	
	public function deleteRequest($id){
		$request = $this->getRequest($id);
		$this->decNewRequestCount($this->user_id,$request[0]["rel_type"]);
		
		$dbr =& wfGetDB( DB_MASTER );
		$sql = "DELETE FROM user_relationship_request WHERE ur_id={$id}";
		$res = $dbr->query($sql);
		$dbr->commit();
	}	
	
	public function updateRelationshipRequestStatus($relationship_request_id, $status){
		$dbw =& wfGetDB( DB_MASTER );
		$dbw->update( '`user_relationship_request`',
			array( /* SET */
			'ur_status' => $status
			), array( /* WHERE */
			'ur_id' => $relationship_request_id
			), ""
		);
		$dbw->commit();
	}
	
	public function verifyRelationshipRequest($relationship_request_id){
		$dbr =& wfGetDB( DB_MASTER );
		$s = $dbr->selectRow( '`user_relationship_request`', array( 'ur_user_id_to' ), array( 'ur_id' => $relationship_request_id ), __METHOD__ );
		if ( $s !== false ) {
			if($this->user_id == $s->ur_user_id_to){
				return true;
			}
		}
		return false;
	}
	
	static function getUserRelationshipByID($user1,$user2){
		$dbr =& wfGetDB( DB_MASTER );
		$s = $dbr->selectRow( '`user_relationship`', array( 'r_type' ), array( 'r_user_id' => $user1, 'r_user_id_relation' => $user2 ), __METHOD__ );
		if ( $s !== false ) {
			return $s->r_type;
		}else{
			return false;
		}
	}
	
	static function userHasRequestByID($user1,$user2){
		$dbr =& wfGetDB( DB_MASTER );
		$s = $dbr->selectRow( '`user_relationship_request`', array( 'ur_type' ), array( 'ur_user_id_to' => $user1, 'ur_user_id_from' => $user2, 'ur_status' => 0 ), __METHOD__ );
		if ( $s === false ) {
			return false;
		}else{
			return true;
		}
	}
	
	public function getRequest($id){
		$dbr =& wfGetDB( DB_MASTER );
		$sql = "SELECT ur_id, ur_user_id_from, ur_user_name_from, ur_type, ur_message, ur_date
			FROM user_relationship_request 
			WHERE ur_id = {$id}";
		$res = $dbr->query($sql);
		while ($row = $dbr->fetchObject( $res ) ) {
			if($row->ur_type==1){
				$type_name = "Friend";
			}else{
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
		$dbr =& wfGetDB( DB_MASTER );
		
		if ($limit>0) {
			$limit_sql = " LIMIT 0,{$limit} ";
		}
		else {
			$limit_sql = '';
		}
		
		$sql = "SELECT ur_id, ur_user_id_from, ur_user_name_from, ur_type, ur_message, ur_date
			FROM user_relationship_request 
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
			if( !in_array( $row->ur_user_id_from, $requests ) ){
			 $requests[$row->ur_user_id_from] = array(
				 "id"=>$row->ur_id,"type"=>$type_name,"message"=>$row->ur_message,"timestamp"=>($row->ur_date ) ,
				 "user_id_from"=>$row->ur_user_id_from,"user_name_from"=>$row->ur_user_name_from
				 );
			}
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
		
		global $wgMemc;
		$key = wfMemcKey( 'user_relationship', 'open_request', $rel_type, $user_id );
		$dbr =& wfGetDB( DB_MASTER );
		$request_count = 0;
		$s = $dbr->selectRow( '`user_relationship_request`', array( 'count(*) as count' ), array( 'ur_user_id_to' => $user_id, 'ur_status' => 0, 'ur_type' => $rel_type ), __METHOD__ );
		if ( $s !== false )$request_count = $s->count;	
	
		$wgMemc->set($key,$request_count);
		
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
		}else{
			$count = self::getOpenRequestCountDB($user_id, $rel_type);
		}	
		return $count;
	}
	
	public function getRelationshipList($type=0,$limit=0,$page=0,$trust_type = -1){
		global $wgUser;
		
		$dbr =& wfGetDB( DB_MASTER );
		
		$limit_sql = "";
		if($limit>0){
			$limitvalue = 0;
			if($page)$limitvalue = $page * $limit - ($limit); 
			$limit_sql = " LIMIT {$limitvalue},{$limit} ";
		}
		
		$type_sql = $trust_type_sql = "";
		if($type){
			$type_sql = " AND r_type = {$type} ";
		}
		if($trust_type > 0){
			$trust_type_sql = " AND r_trust_type = {$trust_type} ";
		}
			
		$sql = "SELECT r_id, r_user_id_relation, r_user_name_relation, r_date, r_type, r_trust_type
			FROM user_relationship 
			WHERE r_user_id = {$this->user_id} $type_sql $trust_type_sql
			ORDER BY r_user_name_relation
			{$limit_sql}";
		
		$res = $dbr->query($sql);
		$requests = array();
		while ($row = $dbr->fetchObject( $res ) ) {
			$trust_type = -1;
			if( $this->user_id == $wgUser->getID() ){
				$trust_type = $row->r_trust_type;
			}
			 $requests[$row->r_user_id_relation] = array(
				 "id"=>$row->r_id,"timestamp"=>($row->r_date ) ,
				 "user_id"=>$row->r_user_id_relation,"user_name"=>$row->r_user_name_relation,
				 "type" => $row->r_type, "trust_type" => $trust_type
				 );
		}
		
		return $requests;
	}

	public function getRelationshipCount($type=0,$trust_type = -1){
		
		$dbr =& wfGetDB( DB_SLAVE );
		
		$where = array();
		
		$where["r_user_id"] = $this->user_id;
		if($type){
			$where["r_type"] = $type;
		}
		if($trust_type > 0){
			$where["r_trust_type"] = $trust_type;
		}
		$s = $dbr->selectRow( '`user_relationship`', array( 'count(*) as the_count' ), $where, __METHOD__ );
	
		return $s->the_count;

	}
	
	public function getAllRelationships(){
		global $wgMemc;
		
		$key = wfMemcKey( 'user_relationship', 'list', $this->user_id );
		$wgMemc->delete( $key );
		$data = $wgMemc->get( $key );
		
		$rel = array();
		if( ! is_array( $data ) ){
			$rel = $this->getRelationshipList();
			if( count( $rel ) > 0 ){
				$wgMemc->set( $key, $rel );
			}
		}else{
			$rel = $data;	
		}
		
		return $rel;
	}
	
	public function getRandomRelationships( $count = 10 ){
		$rel_randomized = array();
		$rel = $this->getAllRelationships();
		
		if( $count > count( $rel ) ){
			$count = count( $rel );
		}
		
		$rel_randomized_keys = array_rand( $rel, $count );
		if( $count == 1 ){ //if one array_rand just returns index
			$rel_randomized[] = $rel[$rel_randomized_keys];
		}else{
			foreach( $rel_randomized_keys as $random ){
				$rel_randomized[] = $rel[ $random ];
			}
		}
		return $rel_randomized;
	}

	public function getAwaitingRequests(){
		global $wgMemc;
		$key = wfMemcKey( 'user_relationship', 'awaitingrequests', $this->user_id );
		$data = $wgMemc->get( $key );
		if( !is_array( $data ) ){
			$dbr =& wfGetDB( DB_SLAVE );
			$res = $dbr->select( '`user_relationship_request`', 
					array('ur_user_id_to'),
					array("ur_user_id_from" => $this->user_id ), __METHOD__, 
					""
			);
			$awaiting_requests = array();
			while ($row = $dbr->fetchObject( $res ) ) {
				$awaiting_requests[] = $row->ur_user_id_to;
			}
			$wgMemc->set( $key, $awaiting_requests );
		}else{
			$awaiting_requests = $data;
		}
	
		return $awaiting_requests;	
				
	}
	
	public function getRelationshipIDs($type){
		
		$dbr =& wfGetDB( DB_MASTER );
	
		$sql = "SELECT r_id, r_user_id_relation, r_user_name_relation, r_date
			FROM user_relationship 
			WHERE r_user_id = {$this->user_id} AND r_type = {$type}
			ORDER BY r_user_name_relation
			{$limit_sql}";
		
		$rel = array();
		$res = $dbr->query($sql);
		while ($row = $dbr->fetchObject( $res ) ) {
			 $rel[] =  $row->r_user_id_relation;
		}
		return $rel;
	}

}
	
?>
