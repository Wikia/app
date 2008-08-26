<?php
/*
 * Ajax Functions used by Wikia extensions
 */
 


$wgAjaxExportList [] = 'wfDeleteUserBulletin';
function wfDeleteUserBulletin($ub_id){  
	$b = new UserBulletin();
	$b->deleteBulletin($ub_id);
	
	return "ok";

}

$wgAjaxExportList [] = 'wfGetUserBulletinsJSON';
function wfGetUserBulletinsJSON($user_name, $count=25){  
	global $IP;
	
	require_once( "$IP/extensions/wikia/JSONProfile/JSON.php" );
	$json = new Services_JSON();
	
	$b = new UserBulletinList( $user_name );
	$bulletins = $b->getList("",$count);
				
	$profile_JSON_array["activity"] = array(
			"time" => time(),
			"title"=>"Recent Activity",
			"activity"=>$bulletins,
	);	
	
	return "var json_bulletins=" . $json->encode($profile_JSON_array) . ";\n\nwrite_activity(json_bulletins);";

}
?>