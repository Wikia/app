<?php

$wgHooks['UserProfileBeginLeft'][] = 'wfUserProfileXboxGamerCard';

function wfUserProfileXboxGamerCard( $user_profile ){
	global $wgUser, $wgOut, $wgTitle, $IP;
	
	$output = "";

	$xbox_id = strip_tags($user_profile->profile_data["custom_1"]);
	
	if( $xbox_id ){
		
		$output .= "<div class=\"user-section-heading\">
			<div class=\"user-section-title\">Xbox Gamecard</div>
			<div class=\"user-section-actions\">
				<div class=\"action-right\"></div>
				<div class=\"action-left\"></div>
			</div>
			<div class=\"cleared\"></div>
		</div>
		<div class=\"cleared\"></div>
		<div class=\"profile-info-container\">
			<iframe src=\"http://gamercard.xbox.com/{$xbox_id}.card\" scrolling=\"no\" frameBorder=\"0\" height=\"140\" width=\"204\">{$xbox_id}</iframe>
		</div>";
		
		$wgOut->addHTML( $output );
	}
	return true;
}


?>
