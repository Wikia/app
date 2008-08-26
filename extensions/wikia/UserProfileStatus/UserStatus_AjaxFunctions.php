<?php
/*
 * Ajax Functions used by Wikia extensions
 */
 
$wgAjaxExportList [] = 'wfGetUserStatus';
function wfGetUserStatus($user_id,$rand=0){ 
	global $wgUserProfileDisplay;
	
	$user = User::newFromId($user_id);
	$user->loadFromId();
	$user_name = $user->getName();
	
	$p = new ProfilePrivacy();
	$p->loadPrivacyForUser( $user->getName() );
	
 	if( $wgUserProfileDisplay['status'] == true && $p->getPrivacyCheckForUser("VIEW_STATUS_HISTORY") ){
		$stats = new UserStats($user_id, $user_name);
		$stats_data = $stats->getUserStats();
		 
		$s = new UserStatus();
		$status = $s->getStatusMessages($user_id,10,0);
		
		$profile_JSON_array = array(
			"updates" => $status,
			"total" => $stats_data["user_status_count"]
		);
	}
	$json = new Services_JSON();
	return "var json_status_updates=" . $json->encode($profile_JSON_array) . ";\n\nwrite_profile_status(json_status_updates);";
}

$wgAjaxExportList [] = 'wfAddUserStatusProfileJSON';
function wfAddUserStatusProfileJSON($text){ 

	$text = urldecode($text);
	$b = new UserStatus();
	$m = $b->addStatus($text);

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
?>