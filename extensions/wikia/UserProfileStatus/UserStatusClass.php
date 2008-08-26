<?php
/**
 *
 */
class UserStatus {

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
	/* private */ function __construct() {

		
	}
	
	public function addStatus($text){	
		global $wgUser, $wgMemc, $wgUserBulletins;
		
		$dbr =& wfGetDB( DB_MASTER );
	
		if( $wgUser->isBlocked() ) return "";

		$dbr->insert( '`user_profile_status`',
		array(
	
			'us_user_id' => $wgUser->getID(),
			'us_user_name' => $wgUser->getName(),
			'us_text' => $text,
			'us_date' => date("Y-m-d H:i:s"),
			), $fname
		);
		$us_id = $dbr->insertId();
	
		$stats = new UserStatsTrack($wgUser->getID(), $wgUser->getName());
		$stats->incStatField("user_status_count");
	
		if( $wgUserBulletins["status"] == true ){
			$b = new UserBulletin();
			$b->addBulletin($wgUser->getName(),"status",$text);
		}
		
		self::clearLatestCache( $wgUser->getID() );
		
		return $us_id;
	}
	
	public function doesUserOwnStatusMessage($user_id, $us_id){
		$dbr =& wfGetDB( DB_MASTER );
		$s = $dbr->selectRow( '`user_profile_status`', array( 'us_user_id' ), array( 'us_id' => $us_id ), $fname );
		if ( $s !== false ) {
			if($user_id == $s->us_user_id){
				return true;
			}
		}
		return false;
	}

	public function clearStatus($us_id){
		global $wgUser;
		
		if($us_id){
			$dbw =& wfGetDB( DB_MASTER );
			$dbw->update( 'user_profile_status',
				array( 'us_status' => 0  ),
				array( 'us_id' => $us_id ),
			__METHOD__ );
			self::clearLatestCache( $wgUser->getID() );
		}
	}
	
	public function deleteStatus($us_id){
		if($us_id){
			$dbr =& wfGetDB( DB_MASTER );
			$s = $dbr->selectRow( '`user_profile_status`', array( 'us_user_id','us_user_name' ), array( 'us_id' => $us_id ), $fname );
			if ( $s !== false ) {
				
				$sql = "DELETE FROM user_profile_status WHERE us_id={$us_id}";
				$res = $dbr->query($sql);
			
				$stats = new UserStatsTrack($s->us_user_id, $s->us_user_name);
				$stats->decStatField("user_status_count");
				
				self::clearLatestCache( $wgUser->getID() );
				
			}
		}
	}
	
	static function formatMessage($message){
		global $wgTitle, $wgOut;
		$message_text = $wgOut->parse( trim($message), false );
		return $message_text;
	}
	
	public function getStatusMessage($us_id){
		global $wgUser, $wgOut, $wgTitle;
		$dbr =& wfGetDB( DB_MASTER );
		
		$sql = "SELECT us_id, us_user_id, us_user_name, us_text,
			UNIX_TIMESTAMP(us_date) as unix_time, us_status
			FROM user_profile_status
			WHERE us_id={$us_id} limit 1
			";
			
		$res = $dbr->query($sql);
		$messages = array();
		while ($row = $dbr->fetchObject( $res ) ) {	
			 $messages[] = array(
				 "id"=>$row->us_id,"timestamp"=>($row->unix_time ) , "ago" => get_time_ago($row->unix_time),
				 "user_id"=>$row->us_user_id,"user_name"=>$row->us_user_name,
				 "text"=>$this->formatMessage($row->us_text), "status" => $row->us_status
			
				 );
		}
		return $messages[0];
	}
	
	static public function getLatestMessage( $user_id ){
		global $wgMemc;
		$key = wfMemcKey( 'user_status', 'latest', $user_id );
		$data = $wgMemc->get( $key );
		if( is_array( $data ) ){
			//echo "cache";
			$latest =  $data;
		}else{
			//echo "dbs";
			$latest = self::getStatusMessages( $user_id, 1, 0 );
			if( count( $latest ) > 0 ){
				$wgMemc->set( $key, $latest );
			}
		}
		
		if( $latest[0]["status"] == 1 ){
			return $latest[0];
		}
		return false;
	}
	
	function clearLatestCache( $user_id ){
		global $wgMemc;
		
		//clear stats cache for current user
		$key = wfMemcKey( 'user_status', 'latest', $user_id );
		$wgMemc->delete( $key );
	}
	
	public function getStatusMessages($user_id=0,$limit=10,$page=0){
		global $wgUser, $wgOut, $wgTitle;
		$dbr =& wfGetDB( DB_MASTER );
		
		if($limit>0){
			$limitvalue = 0;
			if($page)$limitvalue = $page * $limit - ($limit); 
			$limit_sql = " LIMIT {$limitvalue},{$limit} ";
		}
		
		if($user_id>0){
			$user_sql .= "  us_user_id = {$user_id} ";
		}

		
		$sql = "SELECT us_id, us_user_id, us_user_name, us_text,
			UNIX_TIMESTAMP(us_date) as unix_time, us_status
			FROM user_profile_status
			WHERE {$user_sql}
			ORDER BY us_id DESC
			{$limit_sql}";
			
		$res = $dbr->query($sql);
		$messages = array();
		while ($row = $dbr->fetchObject( $res ) ) {	

			 $messages[] = array(
				 "id"=>$row->us_id,"timestamp"=>($row->unix_time ) , "ago" => get_time_ago($row->unix_time),
				 "user_id"=>$row->us_user_id,"user_name"=>$row->us_user_name,
				 "text"=>self::formatMessage($row->us_text), "status" => $row->us_status
			
				 );
		}
		return $messages;
	}
}
	
?>