<?php
/**
 * AJAX functions used by UserRelationship extension.
 */

$wgAjaxExportList[] = 'wfRelationshipRequestResponse';
function wfRelationshipRequestResponse( $response, $request_id ){
	global $wgUser, $wgOut;
	$out = '';

	wfLoadExtensionMessages( 'SocialProfileUserRelationship' );

	$rel = new UserRelationship( $wgUser->getName() );
	if( $rel->verifyRelationshipRequest($request_id) == true ){
		$request = $rel->getRequest($request_id);
		$user_name_from = $request[0]['user_name_from'];
		$user_id_from = User::idFromName($user_name_from);
		$rel_type = strtolower($request[0]['type']);

		$rel->updateRelationshipRequestStatus($request_id, $_POST['response']);

		$avatar = new wAvatar($user_id_from, 'l');
		$avatar_img = $avatar->getAvatarURL();

		if( $response == 1 ){
			$rel->addRelationship($request_id);
			$out.= "<div class=\"relationship-action red-text\">
				{$avatar_img}
				".wfMsg("ur-requests-added-message-{$rel_type}", $user_name_from)."
				<div class=\"cleared\"></div>
			</div>";
		} else {
			$out.= "<div class=\"relationship-action red-text\">
				{$avatar_img}
				".wfMsg("ur-requests-reject-message-{$rel_type}", $user_name_from)."
				<div class=\"cleared\"></div>
			</div>";
		}
		$rel->deleteRequest($request_id);
	}
	return $out;
}