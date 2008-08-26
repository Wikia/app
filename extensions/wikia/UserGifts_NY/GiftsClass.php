<?php
/**
 *
 */
class Gifts {

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
	
	static function addGift($gift_name,$gift_description,$gift_access=0){
		global $wgUser;
		
		$user_id_to = User::idFromName($user_to);
		$dbr =& wfGetDB( DB_MASTER );
		$fname = 'gift::addToDatabase';
		$dbr->insert( '`gift`',
		array(
			'gift_name' => $gift_name,
			'gift_description' => $gift_description,
			'gift_createdate' => date("Y-m-d H:i:s"),
			'gift_creator_user_id' => $wgUser->getID(), 
			'gift_creator_user_name' => $wgUser->getName(),
			'gift_access' => $gift_access,
			), $fname
		);	
		return $dbr->insertId();
	}
	
	public function updateGift($id,$gift_name,$gift_description,$access=0){
		$dbw =& wfGetDB( DB_MASTER );
		$dbw->update( '`gift`',
			array( /* SET */
			'gift_name' => $gift_name,
			'gift_description' => $gift_description,
			'gift_access' => $access
			), array( /* WHERE */
			'gift_id' => $id
			), ""
		);
	}
	

	static function getGift($id){
		if( !is_numeric($id) ) return "";
		$dbr =& wfGetDB( DB_SLAVE );
		$sql = "SELECT gift_id, gift_name, gift_description,
			gift_creator_user_id, gift_creator_user_name, gift_access
			FROM gift WHERE gift_id = {$id} LIMIT 0,1";
		$res = $dbr->query($sql);
		$row = $dbr->fetchObject( $res );
		if($row){
			$gift["gift_id"]= $row->gift_id;	
			$gift["gift_name"]= $row->gift_name;	
			$gift["gift_description"]= $row->gift_description;	
			$gift["creator_user_id"]= $row->gift_creator_user_id;
			$gift["creator_user_name"]= $row->gift_creator_user_name;
			$gift["access"]= $row->gift_access;
		}
		return $gift;
	}
	
	static function getGiftImage($id,$size){
		global $wgUploadDirectory;
		$files = glob($wgUploadDirectory . "/awards/" . $id .  "_" . $size . "*");
		
		if( !empty( $files[0] ) ) {
			$img = basename($files[0]) ;
		} else {
			$img = "default" . "_" . $size . ".gif";
		}
		return $img . "?r=" . rand();		
	}
	
	static function getGiftList($limit=0,$page=0, $order="gift_createdate DESC"){
		global $wgUser;
		
		$dbr =& wfGetDB( DB_MASTER );
		
		if($limit>0){
			$limitvalue = 0;
			if($page)$limitvalue = $page * $limit - ($limit); 
			$limit_sql = " LIMIT {$limitvalue},{$limit} ";
		}
		
		$sql = "SELECT gift_id,gift_name,gift_description,gift_given_count
			FROM gift
			where gift_access=0 OR gift_creator_user_id = {$wgUser->getID()}
			ORDER BY {$order}
			{$limit_sql}";
		
		$res = $dbr->query($sql);
		while ($row = $dbr->fetchObject( $res ) ) {
			 $gifts[] = array(
				 "id"=>$row->gift_id,"timestamp"=>($row->gift_timestamp ) ,
				 "gift_name"=>$row->gift_name,"gift_description"=>$row->gift_description,
				 "gift_given_count"=>$row->gift_given_count
				 );
		}
		return $gifts;
	}

	static function getManagedGiftList($limit=0,$page=0){
		global $wgUser;
		$dbr =& wfGetDB( DB_SLAVE );
		
	
		$params['ORDER BY'] = 'gift_createdate';
		if($limit)$params['LIMIT'] = $limit;
		
		if(! in_array('giftadmin',($wgUser->getGroups())) && ! $wgUser->isAllowed("delete") ){
			$where = array( "gift_creator_user_id" => $wgUser->getID() );
		}
			
		$dbr =& wfGetDB( DB_MASTER );
		$res = $dbr->select( '`gift`', 
				array('gift_id','gift_name','gift_description','gift_given_count','gift_access', 'gift_creator_user_id', 'gift_creator_user_name'),
			$where, __METHOD__, 
			$params
		);
		
		$gifts = array();
		while ($row = $dbr->fetchObject( $res ) ) {
			 $gifts[] = array(
				 "id"=>$row->gift_id,"timestamp"=>($row->gift_timestamp ) ,
				 "gift_name"=>$row->gift_name,"gift_description"=>$row->gift_description,
				 "gift_given_count"=>$row->gift_given_count
				 );
		}
		return $gifts;
	}

	static function getCustomCreatedGiftCount($user_id){
		$dbr =& wfGetDB( DB_SLAVE );
		$gift_count = 0;
		$s = $dbr->selectRow( '`gift`', array("count(*) as count"), array( 'gift_creator_user_id' => $user_id ), $fname );
		if ( $s !== false )$gift_count = $s->count;	
		return $gift_count;
	}
	
	static function getGiftCount(){
		$dbr =& wfGetDB( DB_SLAVE );
		$gift_count = 0;
		$s = $dbr->selectRow( '`gift`', array( 'count(*) as count' ), $fname );
		if ( $s !== false )$gift_count = $s->count;	
		return $gift_count;
	}
	
	
	
}
	
?>
