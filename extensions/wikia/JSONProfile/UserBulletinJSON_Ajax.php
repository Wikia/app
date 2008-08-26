<?php
/*
 * Ajax Functions used by Wikia extensions
 */


$wgAjaxExportList [] = 'wfGetUserBulletinsJSON';

function wfGetUserBulletinsJSON($user_name, $count=18, $type = -1){  
	global $IP, $wgUser;
	$user_name = urldecode( $user_name );
	$id = User::idFromName( $user_name );

	$rp = new ProfilePhoto( $id);
	
	$p = new ProfilePrivacy();
	$p->loadPrivacyForUser( $user_name );
		
	if( $user_name == $wgUser->getName() || ( $p->getPrivacyCheckForUser("VIEW_FULL") && $p->getPrivacyCheckForUser("VIEW_BULLETINS") ) ){	
		$b = new UserBulletinList( $user_name );
		$bulletins = $b->getList($type,$count);
	}else{
		$bulletins = array();	
	}
	
	$profile_JSON_array["activity"] = array(
			"time" => time(),
			"user_name_display"=>user_name_display($id, $user_name),
			"r_avatar"=>$rp->getProfileImageURL("l"),
			"title"=>"Recent Activity",
			"activity"=>$bulletins,
	);

	$types = UserBulletin::$bulletin_types;
	foreach( $types as $id => $type ){
		$type_array[] = array( "id" => $id, "type" => $type );
	}
	$profile_JSON_array["types"] = $type_array;
	
	return "var json_bulletins=" . jsonify($profile_JSON_array) . ";\n\nwrite_activity(json_bulletins);";

}
?>