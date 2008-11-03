<?php
/*
 * Author: Christian Williams 
 */

$wgHooks['GetHTMLAfterBody'][] = 'RenderAdSkin';
		
function RenderAdSkin() {
	global $wgAdSkin, $wgExtensionsPath, $wgUser, $wgStyleVersion;

	// Disable for logged in users
	if (is_object($wgUser) && $wgUser->isLoggedIn() ){
		return true;
	}

	if (isset($wgAdSkin)) {
		switch ($wgAdSkin) {
		case "wow_lich_king":
			echo '<link rel="stylesheet" type="text/css" href="'. $wgExtensionsPath .'/wikia/AdSkin/css/wow_lich_king.css?'. $wgStyleVersion .'" />';
			break;
		case "wow_lich_king_warhammer":
			echo '<link rel="stylesheet" type="text/css" href="'. $wgExtensionsPath .'/wikia/AdSkin/css/wow_lich_king_warhammer.css?'. $wgStyleVersion .'" />';
			break;
		case "dragonball_origins":
			echo '<link rel="stylesheet" type="text/css" href="'. $wgExtensionsPath .'/wikia/AdSkin/css/dragonball_origins.css?'. $wgStyleVersion .'" />';
			break;
		}	
	}

	return true;
}
