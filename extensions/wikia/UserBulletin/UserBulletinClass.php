<?php
/**
 *
 */
class UserBulletin {

	/* private */ function __construct() {

		
	}
	
	static $bulletin_types = array(
		1 => "friend",
		2 => "status",
		3 => "wall",
		4 => "edit",
		6 => "basic profile",
		7 => "personal profile",
		8 => "work profile",
		//9 => "nudge",
		//10 => "nudgeback",
		11 => "profile photo"
	);
	
	public function getBulletinTypeID( $name ){
		
		$types = array_flip( self::$bulletin_types );
		
		return $types[ $name ];
	}
	
	static function getBulletinText( $name, $text, $gender=0, $display_name = "" ){

		if ($gender) $gender_term = "her";
		else $gender_term = "his";
		
		if( !$display_name ) $display_name = $text;
		
		$text = wfMsgExt("bulletin_$name", "parse", $text, $gender_term, $display_name );
		
		//really bad hack because we want to parse=firstline, but don't want wrapping <p> tags
		if( substr( $text, 0 , 3) == "<p>" ){
			$text = substr( $text , 3);
		}

		if( substr( $text, strlen( $text) -4 , 4) == "</p>" ){
			$text = substr( $text, 0, strlen( $text) -4 );
		}
		return $text;
		
	}
	
	public function addBulletin($user_name,$type,$message){	
		$user_id = User::idFromName($user_name);
		$dbr =& wfGetDB( DB_MASTER );
		$fname = 'user_bulletin::addToDatabase';
		$dbr->insert( '`user_bulletin`',
		array(
			'ub_user_id' => $user_id,
			'ub_user_name' => $user_name,
			'ub_type' => self::getBulletinTypeID($type),
			'ub_message' => $message,
			'ub_date' => date("Y-m-d H:i:s"),
			), $fname
		);
	}

	public function doesUserOwnBulletin($ub_id){
		global $wgUser;
		
		$dbr =& wfGetDB( DB_MASTER );
		$s = $dbr->selectRow( '`user_bulletin`', array( 'ub_user_id' ), array( 'ub_id' => $ub_id, 'ub_user_id' => $wgUser->getID() ), $fname );
		if ( $s !== false ) {
			return true;
		}
		return false;
	}

	public function deleteBulletin($id){
		
		if( !$this->doesUserOwnBulletin($id) ){
			return "";
		}
		$dbr =& wfGetDB( DB_MASTER );
		$dbr->delete( 'user_bulletin',array( 'ub_id' =>  $id ),__METHOD__ );
	}	

	

	
	
}
	
class UserBulletinList{
	
	/**
	 * Constructor
	 * @private
	 */
	/* private */ function __construct( $user_name ) {
		$this->user_name = $user_name;
		$this->user_id = User::idFromName($user_name);
	}
	
	public function getList( $type = "", $limit=0,$page=0,$order="ub_id"){
		global $wgUser;
		$dbr =& wfGetDB( DB_SLAVE );
		
		if( $this->user_id == 0 ){
			$bulletins = array();
			return $bulletins;
		}
		
		$sql = "SELECT up_gender from user_profile where up_user_id={$this->user_id}";
		$gender_res = $dbr->query($sql);
		if ($gender_row = $dbr->fetchObject($gender_res)) $gender = $gender_row->up_gender;
		
		if ($gender == "") $gender = 0;
		
		$params['ORDER BY'] = "$order desc";
		if($limit)$params['LIMIT'] = $limit;
		if($page)$params["OFFSET"] = $page * $limit - ($limit); 
		
		if( $type > 0 ){
			$where["ub_type"] = $type;
		}
		
		$where["ub_user_id"] = $this->user_id;
		
		$dbr =& wfGetDB( DB_MASTER );
		$res = $dbr->select( '`user_bulletin`', 
				array( 'ub_id', 'ub_type', 'UNIX_TIMESTAMP(ub_date) as timestamp', 'ub_message'),
			$where, __METHOD__, 
			$params
		);
		
		$bulletins = array();
		while ($row = $dbr->fetchObject( $res ) ) {
			
			$type_name = UserBulletin::$bulletin_types[ $row->ub_type ];
			 $bulletins[] = array(
				 "id"=>$row->ub_id,"timestamp"=>($row->timestamp ) , "ago" => get_time_ago( $row->timestamp ),
				 "type"=>($row->ub_type ), "type_name" => $type_name,
				 "user_name" => $this->user_name, "user_id" => $this->user_id,
				 "message" => $row->ub_message,
				 "text" => UserBulletin::getBulletinText($type_name, $row->ub_message, $gender)
			);
			
		}
		
		return $bulletins;
	}

	

}
?>