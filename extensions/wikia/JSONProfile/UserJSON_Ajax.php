<?php

$wgAjaxExportList [] = 'wfUserSearchJSON';
function wfUserSearchJSON( $q="", $limit = 10, $start = 0, $callback = "usersRender" ){ 

	global $wgUser;
	
	$q = strtoupper($q);
	
	if($limit)$params['LIMIT'] = $limit;
	if($start)$params["OFFSET"] = $start; 

	$where["link_status"] = $status;
	
	
	$dbr =& wfGetDB( DB_SLAVE );
	$res = $dbr->select( '`wikicities`.user INNER JOIN user_profile on up_user_id = user_id', 
			array('user_id', 'user_name', 'user_real_name'),
			"UPPER(user_name) like '%" . $dbr->escapeLike( $q )  . "%' or UPPER(user_real_name) like '%" . $dbr->escapeLike( $q )  . "%'" , __METHOD__, 
		$params
	);
	  
	//load your friend stuff
	$this_rel = new UserRelationship($wgUser->getName());
	$awaiting_requests = $this_rel->getAwaitingRequests();
	$complete_friends = $this_rel->getAllRelationships();	
	
	$p = new ProfilePrivacy();
	
	$users = array();

	while ($row = $dbr->fetchObject( $res ) ) {
		$photo = new ProfilePhoto( $row->user_id  );
		
		//is this person already your friend?
		$relationship = UserRelationship::getUserRelationshipByID($row->user_id,$wgUser->getID());
		$awaiting_request = in_array( $row->user_id, $awaiting_requests );
	
		//get mutual friend count
		$mutual_friend_count = 0;
		
		//make sure you have access of friend list
		$p->loadPrivacyForUser( $row->user_name );
		if( $row->user_id != $wgUser->getID() && $p->getPrivacyCheckForUser("VIEW_FULL") && $p->getPrivacyCheckForUser("VIEW_FRIENDS") ){
			$rel = new UserRelationship($row->user_name);
			$complete_friends_current_user = $rel->getAllRelationships();
			//combined array
			$mutual_friends = array_intersect_key($complete_friends_current_user, $complete_friends);
			$mutual_friend_count = count( $mutual_friends );
		}
		
		//If you are already friends or have a pending request, don't show add link
		$show_add_link = false;
		if( $row->user_id != $wgUser->getID() && !$relationship && !$awaiting_request ){
			$show_add_link = true;
		}
		
		//Location Data
		$profile = new UserProfile($row->user_name);
		$profile_data = $profile->getProfile();
		
		$location = $profile_data["location_state"];
		if( $profile_data["location_city"] ) $location = $profile_data["location_city"] . (($location)?", ":"") . $profile_data["location_state"];
		if( $profile_data["location_country"]!="United States" ){
			$location .= " " . $profile_data["location_country"];
		}
		$location = trim($location);
		
		//Populate JSON Array
		$users["users"][] = array( 
				"user_id" => $row->user_id,
				"user_name" => $row->user_name,
				"user_real_name" => $row->user_real_name,
				"user_image" => $photo->getProfileImageURL("m"),
				"user_show_add_link" => $show_add_link,
				"user_location" => $location,
				"mutual_friend_count" => $mutual_friend_count
		);
	}
	
	//for pagination on search js
	$users["start"] = $start ;
	$users["end"] = $start  + count( $users["users"] ) ;
	
	return "{$callback}(" . jsonify( $users ) . ")";	
}
?>
