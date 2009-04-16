<?php

/**
 *
 */
class UserFanBoxes {

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

	
	//used on SpecialViewFanBoxes page to get all the user's fanboxes
	public function getUserFanboxes($type,$limit=0,$page=0){
		$dbr =& wfGetDB( DB_MASTER );
		
		$limit_sql = "";
		if($limit>0){
			$limitvalue = 0;
			if($page)$limitvalue = $page * $limit - ($limit); 
			$limit_sql = " LIMIT {$limitvalue},{$limit} ";
		}
		
		$sql = "SELECT fantag_id, fantag_title, fantag_left_text, fantag_left_textcolor, fantag_left_bgcolor, fantag_right_text, fantag_right_textcolor, fantag_right_bgcolor, userft_date, fantag_image_name, fantag_left_textsize, fantag_right_textsize FROM fantag INNER JOIN user_fantag ON userft_fantag_id=fantag_id WHERE userft_user_id = {$this->user_id} ORDER BY userft_date DESC
			{$limit_sql}";
		
		$res = $dbr->query($sql);
		$userfanboxes = array();
		while ($row = $dbr->fetchObject( $res ) ) {
			 $userfanboxes[] = array(
				 "fantag_id" => $row->fantag_id, 
				 "fantag_title" => $row->fantag_title, 
				 "fantag_left_text" => $row->fantag_left_text, 
				 "fantag_left_textcolor" => $row->fantag_left_textcolor, 
				 "fantag_left_bgcolor" => $row->fantag_left_bgcolor, 
				 "fantag_right_text" => $row->fantag_right_text, 
				 "fantag_right_textcolor" => $row->fantag_right_textcolor, 
				 "fantag_right_bgcolor" => $row->fantag_right_bgcolor,
				 "fantag_image_name" => $row->fantag_image_name,
				 "fantag_left_textsize" => $row->fantag_left_textsize,
				 "fantag_right_textsize" => $row->fantag_right_textsize
				 );
		}
		
		return $userfanboxes;
	}
	
	//used on SpecialViewFanBoxes page to get hte count of a user's fanboxes so can build the prev/next bar
	static function getFanBoxCountByUsername($user_name){
		$dbr =& wfGetDB( DB_SLAVE );
		$s = $dbr->selectRow( '`user_fantag`', 
			array( 'count(*) as count' ), 
			array( 'userft_user_name'=>$user_name ), __METHOD__ );
		
		return $s->count;		
	}

	//used on SpecialViewFanBoxes to know whether popupbox should be Add or Remove fanbox
	public function checkIfUserHasFanbox($userft_fantag_id){
		global $wgUser;
		$dbr =& wfGetDB( DB_SLAVE );
		$s = $dbr->selectRow( '`user_fantag`', 
			array( 'count(*) as count' ), 
			array( 'userft_user_id'=>$wgUser->getID(), "userft_fantag_id" => $userft_fantag_id), __METHOD__ );
		return $s->count;		
	}
}
	
?>
