<?php

/**
 *
 */
class UserGifts {

	/**
	 * All member variables should be considered private
	 * Please use the accessor functions
	 */

	 /**#@+
	 * @private
	 */
	var $user_id;           	# Text form (spaces not underscores) of the main part
	var $user_name;			# Text form (spaces not underscores) of the main part
	
	/**
	 * Constructor
	 * @private
	 */
	/* private */ function __construct($username) {
		$title1 = Title::newFromDBkey($username  );
		$this->user_name = $title1->getText();
		$this->user_id = User::idFromName($this->user_name);
		
	}
	
	public function sendGift($user_to,$gift_id,$type, $message){		
		$user_id_to = User::idFromName($user_to);
		$dbr =& wfGetDB( DB_MASTER );
		$fname = 'user_gift::addToDatabase';
		$dbr->insert( '`user_gift`',
		array(
			'ug_gift_id' => $gift_id,
			'ug_user_id_from' => $this->user_id,
			'ug_user_name_from' => $this->user_name,
			'ug_user_id_to' => $user_id_to,
			'ug_user_name_to' => $user_to,
			'ug_type' => $type,
			'ug_status' => 1,
			'ug_message' => $message,
			'ug_date' => date("Y-m-d H:i:s"),
			), $fname
		);
		$ug_gift_id = $dbr->insertId();
		$this->incGiftGivenCount($gift_id);
		$this->sendGiftNotificationEmail($user_id_to,$this->user_name,$gift_id,$type);
		
		//add to new gift count cache for receiving user
		$this->incNewGiftCount($user_id_to);
		
		$stats = new UserStatsTrack($user_id_to, $user_to);
		$stats->incStatField("gift_rec");

		$stats = new UserStatsTrack($this->user_id, $this->user_name);
		$stats->incStatField("gift_sent");
		return $ug_gift_id;
	}
	
	public function sendGiftNotificationEmail($user_id_to,$user_from,$gift_id,$type){
		
		//language messages
		require_once ( "UserGifts.i18n.php" );
		global $wgMessageCache;
		foreach( efWikiaUserGifts() as $lang => $messages ){
			$wgMessageCache->addMessages( $messages, $lang );
		}
	
		$gift = Gifts::getGift($gift_id);
		$user = User::newFromId($user_id_to);
		$user->loadFromDatabase();
		if($user->isEmailConfirmed() && $user->getIntOption("notifygift",1) ){
			$gifts_link = Title::makeTitle( NS_SPECIAL , "ViewGifts"  );
			$update_profile_link = Title::makeTitle( NS_SPECIAL , "UpdateProfile"  );
			$subject = wfMsgExt( 'gift_received_subject', "parsemag",
				$user_from,
				$gift["gift_name"]
				 );
			$body = wfMsgExt( 'gift_received_body', "parsemag",
				(( trim($user->getRealName()) )?$user->getRealName():$user->getName()),
				$user_from,
				$gift["gift_name"],
				$gifts_link->getFullURL(),
				$update_profile_link->getFullURL()
			);
				
				
			$user->sendMail($subject, $body, null, null, 'GiftNotificationEmail');
		}
	}
	
	public function clearAllUserGiftStatus(){
		$dbw =& wfGetDB( DB_MASTER );
		$dbw->update( '`user_gift`',
			array( /* SET */
			'ug_status' => 0
			), array( /* WHERE */
			'ug_user_id_to' => $this->user_id
			), ""
		);
		$this->clearNewGiftCountCache($this->user_id);
	}

	static function clearUserGiftStatus($id){
		$dbw =& wfGetDB( DB_MASTER );
		$dbw->update( '`user_gift`',
			array( /* SET */
			'ug_status' => 0
			), array( /* WHERE */
			'ug_id' => $id
			), ""
		);
		
	}	

	public function doesUserOwnGift($user_id, $ug_id){
		$dbr =& wfGetDB( DB_SLAVE );
		$s = $dbr->selectRow( '`user_gift`', array( 'ug_user_id_to' ), array( 'ug_id' => $ug_id ), __METHOD__ );
		if ( $s !== false ) {
			if($user_id == $s->ug_user_id_to){
				return true;
			}
		}
		return false;
	}

	static function deleteGift($ug_id){
		$dbr =& wfGetDB( DB_MASTER );
		$sql = "DELETE FROM user_gift WHERE ug_id={$ug_id}";
		$res = $dbr->query($sql);
	}	

	static function getUserGift($id){
		if( !is_numeric($id) ) return "";
		
		$dbr =& wfGetDB( DB_MASTER );
		$sql = "SELECT ug_id, ug_user_id_from, ug_user_name_from, ug_user_id_to,ug_user_name_to,ug_message,gift_id, ug_date,
			ug_status,gift_name, gift_description, gift_given_count
			FROM user_gift INNER JOIN gift ON ug_gift_id=gift_id  
			WHERE ug_id = {$id} LIMIT 0,1";
		$res = $dbr->query($sql);
		$row = $dbr->fetchObject( $res );
		if($row){
			$gift["id"]= $row->ug_id;
			$gift["user_id_from"]= $row->ug_user_id_from;
			$gift["user_name_from"]= $row->ug_user_name_from;
			$gift["user_id_to"]= $row->ug_user_id_to;
			$gift["user_name_to"]= $row->ug_user_name_to;
			$gift["message"]= $row->ug_message;
			$gift["gift_count"]= $row->gift_given_count;
			$gift["timestamp"]= $row->ug_date;
			$gift["gift_id"]= $row->gift_id;	
			$gift["name"]= $row->gift_name;	
			$gift["description"]= $row->gift_description;	
			$gift["status"]= $row->ug_status;	
		}

		return $gift;
	}

	public function incNewGiftCount($user_id){
		global $wgMemc;
		$key = wfMemcKey( 'user_gifts', 'new_count', $user_id );
		$wgMemc->incr( $key );
		
	}
	
	public function decNewGiftCount($user_id){
		global $wgMemc;
		$key = wfMemcKey( 'user_gifts', 'new_count', $user_id );
		$wgMemc->decr( $key );
	}
	
	public function clearNewGiftCountCache(){
		global $wgMemc;
		$key = wfMemcKey( 'user_gifts', 'new_count', $this->user_id );
		$wgMemc->set( $key, 0 );
		//$wgMemc->delete($key);
	}
	
	static function getNewGiftCountCache($user_id){
		global $wgMemc;
		$key = wfMemcKey( 'user_gifts', 'new_count', $user_id );
		$data = $wgMemc->get( $key );
		if($data != ""){
			wfDebug( "Got new gift count of $data for id $user_id from cache\n" );
			return $data;
		}
	}		
	
	static function getNewGiftCount($user_id){
		global $wgMemc;
		$data = self::getNewGiftCountCache($user_id);
		
		if( $data != "" ){
			$count = $data;
		}else{
			$count = self::getNewGiftCountDB($user_id);
		}	
		return $count;
	}
	
	static function getNewGiftCountDB($user_id){
		wfDebug( "Got new gift count for id $user_id from db\n" );
		
		global $wgMemc;
		$key = wfMemcKey( 'user_gifts', 'new_count', $user_id );
		$dbr =& wfGetDB( DB_MASTER );
		$new_gift_count = 0;
		$s = $dbr->selectRow( '`user_gift`', array( 'count(*) as count' ), array( 'ug_user_id_to' => $user_id, 'ug_status' => 1 ), __METHOD__ );
		if ( $s !== false )$new_gift_count = $s->count;	
		
		$wgMemc->set($key,$new_gift_count);
		
		return $new_gift_count;
	}
	
	public function getUserGiftList($type,$limit=0,$page=0){
		$dbr =& wfGetDB( DB_SLAVE );
		
		if($limit>0){
			$limitvalue = 0;
			if($page)$limitvalue = $page * $limit - ($limit); 
			$limit_sql = " LIMIT {$limitvalue},{$limit} ";
		}
		
		$sql = "SELECT ug_id, ug_user_id_from, ug_user_name_from, ug_gift_id, ug_date, ug_status,
			gift_name, gift_description, gift_given_count, UNIX_TIMESTAMP(ug_date) as unix_time
			FROM user_gift INNER JOIN gift ON ug_gift_id=gift_id 
			WHERE ug_user_id_to = {$this->user_id}
			ORDER BY ug_id DESC
			{$limit_sql}";
		
		$res = $dbr->query($sql);
		$requests = array();
		while ($row = $dbr->fetchObject( $res ) ) {
			 $requests[] = array(
				 "id"=>$row->ug_id,
				 "gift_id"=>$row->ug_gift_id,
				 "timestamp"=>($row->ug_date ), 
				 "status"=>$row->ug_status,
				 "user_id_from"=>$row->ug_user_id_from,
				 "user_name_from"=>$row->ug_user_name_from,
				 "gift_name"=>$row->gift_name, 
				 "gift_description"=>$row->gift_description, 
				 "gift_given_count" => $row->gift_given_count,
				 "unix_timestamp" => $row->unix_time
				 );
		}
		return $requests;
	}

	public function getAllGiftList($limit=10,$page=0){
		$dbr =& wfGetDB( DB_SLAVE );
		
		if($limit>0){
			$limitvalue = 0;
			if($page)$limitvalue = $page * $limit - ($limit); 
			$limit_sql = " LIMIT {$limitvalue},{$limit} ";
		}
		
		$sql = "SELECT ug_id, ug_user_id_from, ug_user_name_from, ug_gift_id, ug_date, ug_status,
			gift_name, gift_description, gift_given_count, UNIX_TIMESTAMP(ug_date) as unix_time
			FROM user_gift INNER JOIN gift ON ug_gift_id=gift_id 
			ORDER BY ug_id DESC
			{$limit_sql}";
		
		$res = $dbr->query($sql);
		$requests = array();
		while ($row = $dbr->fetchObject( $res ) ) {
			 $requests[] = array(
				 "id"=>$row->ug_id,"gift_id"=>$row->ug_gift_id,"timestamp"=>($row->ug_date ) , "status"=>$row->ug_status,
				 "user_id_from"=>$row->ug_user_id_from,"user_name_from"=>$row->ug_user_name_from,
				 "gift_name"=>$row->gift_name, "gift_description"=>$row->gift_description, "gift_given_count" => $row->gift_given_count,
				 "unix_timestamp" => $row->unix_time
				 );
		}
		return $requests;
	}
	
	private function incGiftGivenCount($gift_id){
		$dbw = wfGetDB( DB_MASTER );
		$dbw->update( 'gift',
			array( 'gift_given_count=gift_given_count+1' ),
			array( 'gift_id' => $gift_id ),
			__METHOD__ );
	}
	
	static function getGiftCountByUsername($user_name){
		$dbr =& wfGetDB( DB_SLAVE );
		$user_id = User::idFromName($user_name);
		$sql = "SELECT count(*) as count
			FROM user_gift
			WHERE ug_user_id_to = {$user_id}
			LIMIT 0,1";
		$res = $dbr->query($sql);
		$row = $dbr->fetchObject( $res );
		$gift_count = 0;
		if($row){
			$gift_count=$row->count;
		}
		return $gift_count;		
	}
	
	
	
}
	
?>
