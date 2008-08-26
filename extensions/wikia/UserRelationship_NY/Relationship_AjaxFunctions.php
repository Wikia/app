<?php
/*
 * Ajax Functions used by Wikia extensions
 */
 
$wgAjaxExportList [] = 'wfRelationshipRequestResponse';
function wfRelationshipRequestResponse($response, $request_id){
	global $wgUser, $wgOut, $IP, $wgMessageCache, $wgUserRelationshipDirectory; 
	$out = "";

	
	$rel = new UserRelationship($wgUser->getName() );
	if($rel->verifyRelationshipRequest($request_id) == true ){
		$request = $rel->getRequest($request_id);
		$user_name_from = $request[0]["user_name_from"];
		$user_id_from = User::idFromName($user_name_from);
		$rel_type = strtolower($request[0]["type"]);
		
		global $wgMemc;
		$key = wfMemcKey( 'user_relationship', 'awaitingrequests', $user_id_from );
		$wgMemc->delete( $key );
		
		$rel->updateRelationshipRequestStatus($request_id,$_POST["response"]);
	
		$avatar = new wAvatar($user_id_from,"l");
		$avatar_img = $avatar->getAvatarURL();
	
		if($response==1){
			$rel->addRelationship($request_id);
			$out.= "<div class=\"relationship-action red-text\">
				{$avatar_img}
				".wfMsg("ur-requests-added-message", $user_name_from, $rel_type)."
				<div class=\"cleared\"></div>
			</div>";
		}else {
			$out.="<div class=\"relationship-action red-text\">
				{$avatar_img}
				".wfMsg("ur-requests-reject-message", $user_name_from, $rel_type)."
				<div class=\"cleared\"></div>
			</div>";
		}
		$rel->deleteRequest($request_id);
	} 
	return $out;
}



?>