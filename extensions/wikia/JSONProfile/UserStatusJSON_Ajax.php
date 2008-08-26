<?php
/*
 * Ajax Functions used by Wikia extensions
 */
 
$wgAjaxExportList [] = 'wfGetUserStatus';
function wfGetUserStatus($user_id,$rand=0){ 
	global $wgUserProfileDisplay, $wgMemc;
	
	$user = User::newFromId($user_id);
	$user->loadFromId();
	$user_name = $user->getName();
	
	$p = new ProfilePrivacy();
	$p->loadPrivacyForUser( $user->getName() );
	
 	if( $wgUserProfileDisplay['status'] == true && $p->getPrivacyCheckForUser("VIEW_STATUS_HISTORY") ){
		$stats = new UserStats($user_id, $user_name);
		$stats_data = $stats->getUserStats();
		 
		$key = wfMemcKey( 'user', 'status', 'list', $user_id, 10 );
		$data = $wgMemc->get( $key );
		
		if( !is_array( $data ) ){
			$s = new UserStatus();
			$status = $s->getStatusMessages($user_id,10,0);
			$wgMemc->set( $key, $status );
			$from_cache = 0;
		}else{
			$status = $data;
			$from_cache = 1;
		}
		
		$profile_JSON_array = array(
			"updates" => $status,
			"total" => $stats_data["user_status_count"],
			"cache" => $from_cache
		);
		
		return "var json_status_updates=" . jsonify($profile_JSON_array) . ";\n\nwrite_profile_status(json_status_updates);";
	}
	return "void(0);";
	
}

$wgAjaxExportList [] = 'wfAddUserStatusProfileJSON';
function wfAddUserStatusProfileJSON($text){ 
	global $wgMemc, $wgUser;
	
	$text = urldecode($text);
	$b = new UserStatus();
	$m = $b->addStatus($text);

	$key = wfMemcKey( 'user', 'status', 'list', $wgUser->getID(), 10 );
	$wgMemc->delete( $key );
		
	return "get_all_status();";
}

$wgAjaxExportList [] = 'wfAddUserStatusProfile';
function wfAddUserStatusProfile($text){ 

	$text = urldecode($text);
	$b = new UserStatus();
	$m = $b->addStatus($text);

	return "ok";
}

$wgAjaxExportList [] = 'wfDeleteUserStatus';
function wfDeleteUserStatus($us_id){ 
	global $IP, $wgUser;
	 
	$b = new UserStatus();
	if( $b->doesUserOwnStatusMessage($wgUser->getID(),$us_id) ){
		$b->deleteStatus($us_id);
	}
	return "ok";

}

$wgAjaxExportList [] = 'wfClearUserStatus';
function wfClearUserStatus($us_id){ 
	global $IP, $wgUser, $wgMemc;
	 
	$key = wfMemcKey( 'user', 'status', 'list', $wgUser->getID(), 10 );
	$wgMemc->delete( $key );
	
	$b = new UserStatus();
	if( $b->doesUserOwnStatusMessage($wgUser->getID(),$us_id) ){
		$b->clearStatus($us_id);
	}
	return "edit_status('yes');";

}
?>