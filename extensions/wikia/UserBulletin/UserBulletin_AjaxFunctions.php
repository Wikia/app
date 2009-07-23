<?php
/*
 * Ajax Functions used by Wikia extensions
 */

$wgAjaxExportList [] = 'wfDeleteUserBulletin';
$wgAjaxExportList [] = 'wfGetUserBulletinsJSON';

function wfDeleteUserBulletin($ub_id){
	$b = new UserBulletin();
	$b->deleteBulletin($ub_id);

	return "ok";
}

function wfGetUserBulletinsJSON($user_name, $count=25){

	wfProfileIn( __METHOD__ );
	$b = new UserBulletinList( $user_name );
	$bulletins = $b->getList("",$count);

	$profile_JSON_array["activity"] = array(
			"time" => time(),
			"title"=>"Recent Activity",
			"activity"=>$bulletins,
	);
	wfProfileOut( __METHOD__ );

	return "var json_bulletins=" . Wikia::json_encode( $profile_JSON_array ) . ";\n\nwrite_activity(json_bulletins);";
}
