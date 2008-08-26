<?php
/**
 *
 */
function wfGetGiftDBName() {
	global $wgSharedUserProfile, $wgSharedDB, $wgDBname;
	return ($wgSharedUserProfile)?$wgSharedDB:$wgDBname;
}

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
	
	var $db_name;
	
	/**
	 * Constructor
	 * @private
	 */
	/* private */ function __construct() {
	}
	
	static function addGift($gift_name,$gift_description)
	{
		#---
		$db_name = wfGetGiftDBName();
		#---
		$dbr =& wfGetDB( DB_MASTER );
		$fname = __METHOD__;
		$dbr->insert( "`{$db_name}`.`gift`", 
		array(
			'gift_name' => $gift_name,
			'gift_description' => $gift_description,
			'gift_createdate' => date("Y-m-d H:i:s"),
			), $fname
		);	
		return $dbr->insertId();
	}
	
	public function updateGift($id,$gift_name,$gift_description)
	{
		#---
		$db_name = wfGetGiftDBName();
		#---
		$dbw =& wfGetDB( DB_MASTER );
		$dbw->update( "`{$db_name}`.`gift`",
			array( /* SET */
			'gift_name' => $gift_name,
			'gift_description' => $gift_description
			), array( /* WHERE */
			'gift_id' => $id
			), ""
		);
	}

	static function getGift($id)
	{
		#---
		$db_name = wfGetGiftDBName();
		#---
		$dbr =& wfGetDB( DB_MASTER );
		$sql = "SELECT gift_id, gift_name, gift_description
			FROM `{$db_name}`.`gift` WHERE gift_id = {$id} LIMIT 0,1";
		$res = $dbr->query($sql);
		$row = $dbr->fetchObject( $res );
		$gift = array("gift_name"=>"", "gift_description"=>"", "gift_id"=>"");
		if($row){
			$gift["gift_id"]= $row->gift_id;	
			$gift["gift_name"]= $row->gift_name;	
			$gift["gift_description"]= $row->gift_description;	
		}
		return $gift;
	}
	
    static public function getGiftFile($id, $size)
    {
        $sImage = "{$id}x{$size}";
        $sHash = sha1("{$id}");
        $sDir = substr($sHash, 0, 1)."/".substr($sHash, 0, 2);
        return "{$sDir}/{$sImage}";
    }

    static public function getGiftDir($id)
    {
        $sHash = sha1("{$id}");
        $sDir = substr($sHash, 0, 1)."/".substr($sHash, 0, 2);
        return "{$sDir}";
    }
	
	static function getGiftImage($id,$size)
	{
		global $wgGiftImageUploadPath;
		
		if (empty($wgGiftImageUploadPath)) {
			wfDebug( __METHOD__.": wgGiftImageUploadPath is empty, taking default ".$wgUploadDirectory."/awards\n" );
			$wgGiftImageUploadPath = $wgUploadDirectory."/awards";
		}

		$files = glob($wgGiftImageUploadPath ."/". self::getGiftFile($id, $size) . "*");
		
		if (empty($files) || empty($files[0])) {
			$img = "default" . "_" . $size . ".gif";
		} else {
			$img = self::getGiftDir($id)."/".basename($files[0]) ;
		}
		return $img . "?r=" . rand();		
	}
	
	static function getGiftList($limit=0,$page=0,$order="gift_createdate DESC")
	{
		#---
		$db_name = wfGetGiftDBName();
		#---
		$dbr =& wfGetDB( DB_MASTER );
		
		if($limit>0){
			$limitvalue = 0;
			if($page)$limitvalue = $page * $limit - ($limit); 
			$limit_sql = " LIMIT {$limitvalue},{$limit} ";
		}
		
		$sql = "SELECT gift_id,gift_name,gift_description,gift_given_count, gift_createdate FROM `{$db_name}`.`gift` ORDER BY {$order} {$limit_sql}";
		
		$res = $dbr->query($sql);
		$gifts = array();
		while ($row = $dbr->fetchObject( $res ) ) {
			 $gifts[] = array(
				 "id"=>$row->gift_id,"timestamp"=>($row->gift_createdate ) ,
				 "gift_name"=>$row->gift_name,"gift_description"=>$row->gift_description,
				 "gift_given_count"=>$row->gift_given_count
				 );
		}
		return $gifts;
	}

	static function getGiftCount()
	{
		$fname = "Gifts:getGiftCount";
		#---
		$db_name = wfGetGiftDBName();
		#---
		$dbr =& wfGetDB( DB_MASTER );
		$gift_count = 0;
		$s = $dbr->selectRow( "`{$db_name}`.`gift`", array( 'count(*) as count' ), array(), $fname );
		if ( $s !== false )$gift_count = $s->count;	
		return $gift_count;
	}
	
}
	
?>
