<?php
/**
 *
 */
class SystemGifts {

	/**
	 * All member variables should be considered private
	 * Please use the accessor functions
	 */
	var $categories = array(
				"edit"=>1,
				"vote"=>2,
				"comment"=>3,
				"comment_plus"=>4,
				"opinions_created"=>5,
				"opinions_pub"=>6,
				"referral_complete"=>7,
				"friend"=>8,
				"foe"=>9,
				"challenges_won"=>10,
				"gift_rec"=>11,
				"points_winner_weekly"=>12,
				"points_winner_monthly"=>13,
				"quiz_points"=>14
				);
				
	/**
	 * Constructor
	 * @private
	 */
	/* private */ function __construct() {

		
	}
	
	public function update_system_gifts(  ){
		global $IP, $wgOut, $wgMemc;
		
		$dbr =& wfGetDB( DB_MASTER );
		$stats = new UserStatsTrack(1,"");
		$this->categories = array_flip($this->categories); 
		
		$sql = "SELECT gift_id,gift_category,gift_threshold, gift_name
			FROM system_gift
			ORDER BY gift_category,gift_threshold ASC";
		
		$res = $dbr->query($sql);
		$x = 1;
		while ($row = $dbr->fetchObject( $res ) ) {
			
			if($row->gift_category){
				$sql2 = "SELECT stats_user_id, stats_user_name
					FROM user_stats
					WHERE " . $stats->stats_fields[ $this->categories[$row->gift_category]] . " >= {$row->gift_threshold}
					and stats_user_id<>0";
				
				$res2 = $dbr->query($sql2);
				
				while ($row2 = $dbr->fetchObject( $res2 ) ) {
					if($this->doesUserHaveGift($row2->stats_user_id,$row->gift_id)==false){
						
						$dbr->insert( '`user_system_gift`',
						array(
							'sg_gift_id' => $row->gift_id,
							'sg_user_id' => $row2->stats_user_id,
							'sg_user_name' => $row2->stats_user_name,
							'sg_status' => 0,
							'sg_date' => date("Y-m-d H:i:s", time() - (60 * 60 * 24 * 3) ),
							), $fname
						);
						
						$sg_key = wfMemcKey( 'user', 'profile', 'system_gifts', "{$row2->stats_user_id}" );
						$wgMemc->delete($sg_key);
						
						$wgOut->addHTML( $row2->stats_user_name. " got ". $row->gift_name . "<BR>");
						$x++;
					}
				}
			}
		}
		$wgOut->addHTML("{$x} awards were given out");
	}
	
	public function doesUserHaveGift($user_id,$gift_id){
		$dbr = wfGetDB( DB_SLAVE );
		$s = $dbr->selectRow( '`user_system_gift`', array( 'sg_gift_id' ), array( 'sg_gift_id' => $gift_id , 'sg_user_id' => $user_id ), __METHOD__ );
		if ( $s === false ) {
			return false;
		}else{
			return $s->sg_gift_id;
		}		
	}
	
	public function addGift($gift_name,$gift_description, $gift_category,$gift_threshold){
		$user_id_to = User::idFromName($user_to);
		$dbr =& wfGetDB( DB_MASTER );
		$fname = 'system_gift::addToDatabase';
		$dbr->insert( '`system_gift`',
		array(
			'gift_name' => $gift_name,
			'gift_description' => $gift_description,
			'gift_category' => $gift_category,
			'gift_threshold' => $gift_threshold,
			'gift_createdate' => date("Y-m-d H:i:s"),
			), $fname
		);	
		return $dbr->insertId();
	}
	
	public function updateGift($id,$gift_name,$gift_description,$gift_category,$gift_threshold){
		$dbw =& wfGetDB( DB_MASTER );
		$dbw->update( '`system_gift`',
			array( /* SET */
			'gift_name' => $gift_name,
			'gift_description' => $gift_description,
			'gift_category' => $gift_category,
			'gift_threshold' => $gift_threshold,
			), array( /* WHERE */
			'gift_id' => $id
			), ""
		);
	}
	
	public function doesGiftExistForThreshold($category,$threshold){
		$dbr = wfGetDB( DB_SLAVE );
		$s = $dbr->selectRow( '`system_gift`', array( 'gift_id' ), array( 'gift_category' => $this->categories[$category] , 'gift_threshold' => $threshold  ), __METHOD__ );
		if ( $s === false ) {
			return false;
		}else{
			return $s->gift_id;
		}
	}
	
	
	static function getGift($id){
		$dbr =& wfGetDB( DB_SLAVE );
		$sql = "SELECT gift_id, gift_name, gift_description, gift_category, gift_threshold, gift_given_count
			FROM system_gift WHERE gift_id = {$id} LIMIT 0,1";
		$res = $dbr->query($sql);
		$row = $dbr->fetchObject( $res );
		if($row){
			$gift["gift_id"]= $row->gift_id;	
			$gift["gift_name"]= $row->gift_name;	
			$gift["gift_description"]= $row->gift_description;
			$gift["gift_category"]= $row->gift_category;
			$gift["gift_threshold"]= $row->gift_threshold;
			$gift["gift_given_count"] = $row->gift_given_count;
		}
		return $gift;
	}
	
	static function getGiftImage($id,$size){
		global $wgUploadDirectory;
		$files = glob($wgUploadDirectory . "/awards/sg_" . $id .  "_" . $size . "*");
		
		if( !empty( $files[0] ) ) {
			$img = basename($files[0]) ;
		} else {
			$img = "default" . "_" . $size . ".gif";
		}
		return $img . "?r=" . rand();		
	}
	
	static function getGiftList($limit=0,$page=0){
		$dbr =& wfGetDB( DB_SLAVE );
		
		if($limit>0){
			$limitvalue = 0;
			if($page)$limitvalue = $page * $limit - ($limit); 
			$limit_sql = " LIMIT {$limitvalue},{$limit} ";
		}
		
		$sql = "SELECT gift_id,gift_name,gift_description,gift_category, gift_threshold, gift_given_count
			FROM system_gift
			ORDER BY gift_createdate DESC
			{$limit_sql}";
		
		$res = $dbr->query($sql);
		while ($row = $dbr->fetchObject( $res ) ) {
			 $gifts[] = array(
				 "id"=>$row->gift_id,"timestamp"=>($row->gift_timestamp ) ,
				 "gift_name"=>$row->gift_name,"gift_description"=>$row->gift_description,
				  "gift_category"=>$row->gift_category,"gift_threshold"=>$row->gift_threshold,
				 "gift_given_count"=>$row->gift_given_count
				 );
		}
		return $gifts;
	}

	static function getGiftCount(){
		$dbr =& wfGetDB( DB_SLAVE );
		$gift_count = 0;
		$s = $dbr->selectRow( '`system_gift`', array( 'count(*) as count' ), $fname );
		if ( $s !== false )$gift_count = $s->count;	
		return $gift_count;
	}
	
	
	
}
	
?>
