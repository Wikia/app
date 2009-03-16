<?php
/*
 * Author: Christian Williams 
 */

$wgAdSkinVersion = 1;

$wgHooks['GetHTMLAfterBody'][] = 'RenderAdSkin';
$wgHooks['SpecialFooterAfterWikia'][] = 'RenderAdSkinJS';
$wgHooks['MonacoAdLink'][] = 'RenderAdLink';

function RenderAdSkin() {
	global $wgAdSkin, $wgExtensionsPath, $wgUser, $wgWikiaLogo, $wgAdSkinVersion;

	// Disable for logged in users
	if (is_object($wgUser) && $wgUser->isLoggedIn() ){
		return true;
	}

	if (isset($wgAdSkin)) {
		switch ($wgAdSkin) {
		case "wow_lich_king":
			echo '<link rel="stylesheet" type="text/css" href="'. $wgExtensionsPath .'/wikia/AdSkin/css/wow_lich_king.css?'. $wgAdSkinVersion .'" />';
			break;
		case "wow_lich_king_warhammer":
			echo '<link rel="stylesheet" type="text/css" href="'. $wgExtensionsPath .'/wikia/AdSkin/css/wow_lich_king_warhammer.css?'. $wgAdSkinVersion .'" />';
			break;
		case "dragonball_origins":
			echo '<link rel="stylesheet" type="text/css" href="'. $wgExtensionsPath .'/wikia/AdSkin/css/dragonball_origins.css?'. $wgAdSkinVersion .'" />';
			break;
		case "dnd":
			echo '<link rel="stylesheet" type="text/css" href="'. $wgExtensionsPath .'/wikia/AdSkin/css/dnd.css?'. $wgAdSkinVersion .'" />';
			break;
		case "underworld":
			echo '<link rel="stylesheet" type="text/css" href="'. $wgExtensionsPath .'/wikia/AdSkin/css/underworld.css?'. $wgAdSkinVersion .'" />';
			echo '<style type="text/css">';
			echo 'body.mainpage #wikia_header {
				background: url('. $wgWikiaLogo .') 10px 2px no-repeat;
			}';
			echo '</style>';
			break;
		case "warhammer":
			echo '<link rel="stylesheet" type="text/css" href="'. $wgExtensionsPath .'/wikia/AdSkin/css/warhammer.css?'. $wgAdSkinVersion .'" />';
			echo '<style type="text/css">';
			echo 'body.mainpage #wikia_header {
				background: #252525 url('. $wgWikiaLogo .') 10px 2px no-repeat;
			}';
			echo '</style>';
			break;
		case "superpages":
			echo '<link rel="stylesheet" type="text/css" href="'. $wgExtensionsPath .'/wikia/AdSkin/css/superpages.css?'. $wgAdSkinVersion .'" />';
			break;
		}	
	}

	return true;
}

function RenderAdSkinJS() {
	global $wgUser, $wgExtensionsPath, $wgAdSkin, $wgAdSkinVersion;
	
	if (is_object($wgUser) && $wgUser->isLoggedIn() ){
		return true;
	}

	if (isset($wgAdSkin)) {
		switch ($wgAdSkin) {
		case "warhammer":
			echo '<script type="text/javascript" src="'. $wgExtensionsPath .'/wikia/AdSkin/js/warhammer.js?'. $wgAdSkinVersion .'"></script>';
			echo '<A HREF="http://ad.doubleclick.net/jump/N2790.Wikia/B3436947.10;sz=1x1;ord='. time() .'?"><IMG SRC="http://ad.doubleclick.net/ad/N2790.Wikia/B3436947.10;sz=1x1;ord='. time() .'?" BORDER=0 WIDTH=1 HEIGHT=1 ALT="Click Here"></A>'; 
			break;
		}
	}
	
	return true;
}

function RenderAdLink() {
	global $wgAdSkin, $wgAdSkinVersion, $wgExtensionsPath;

	if (isset($wgAdSkin)) {
		switch ($wgAdSkin) {
		case "warhammer_link":
			echo '<link rel="stylesheet" type="text/css" href="'. $wgExtensionsPath .'/wikia/AdSkin/css/warhammer_link.css?'. $wgAdSkinVersion .'" />';
			echo '<a href="http://www.warhammeronline.com/trial?WHK33J-U7C8Q-HWPEJ-9QAIJ-4Y8JK" id="warhammer_link">Download the Free 10-Day Trial</a>';
			break;
		}
	}
	return true;
}
