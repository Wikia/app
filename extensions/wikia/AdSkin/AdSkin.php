<?php
/*
 * Author: Christian Williams 
 */

$wgHooks['GetHTMLAfterBody'][] = 'RenderAdSkin';
$wgHooks['SpecialFooterAfterWikia'][] = 'RenderAdSkinJS';
$wgHooks['MonacoAdLink'][] = 'RenderAdLink';

function RenderAdSkin() {
	global $wgAdSkin, $wgExtensionsPath, $wgUser, $wgStyleVersion, $wgWikiaLogo;

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
		case "dnd":
			echo '<link rel="stylesheet" type="text/css" href="'. $wgExtensionsPath .'/wikia/AdSkin/css/dnd.css?'. $wgStyleVersion .'" />';
			break;
		case "underworld":
			echo '<link rel="stylesheet" type="text/css" href="'. $wgExtensionsPath .'/wikia/AdSkin/css/underworld.css?'. $wgStyleVersion .'" />';
			echo '<style type="text/css">';
			echo 'body.mainpage #wikia_header {
				background: url('. $wgWikiaLogo .') 10px 2px no-repeat;
			}';
			echo '</style>';
			break;
		case "warhammer":
			echo '<link rel="stylesheet" type="text/css" href="'. $wgExtensionsPath .'/wikia/AdSkin/css/warhammer.css?'. $wgStyleVersion .'" />';
			echo '<style type="text/css">';
			echo 'body.mainpage #wikia_header {
				background: #252525 url('. $wgWikiaLogo .') 10px 2px no-repeat;
			}';
			echo '</style>';
			
			break;
		}	
	}

	return true;
}

function RenderAdSkinJS() {
	global $wgUser, $wgExtensionsPath, $wgStyleVersion, $wgAdSkin;
	
	if (is_object($wgUser) && $wgUser->isLoggedIn() ){
		return true;
	}

	if (isset($wgAdSkin)) {
		switch ($wgAdSkin) {
		case "warhammer":
			echo '<script type="text/javascript" src="'. $wgExtensionsPath .'/wikia/AdSkin/js/warhammer.js?'. $wgStyleVersion .'"></script>';
			echo '<A HREF="http://ad.doubleclick.net/jump/N2790.Wikia/B3436947.10;sz=1x1;ord='. time() .'?"><IMG SRC="http://ad.doubleclick.net/ad/N2790.Wikia/B3436947.10;sz=1x1;ord='. time() .'?" BORDER=0 WIDTH=1 HEIGHT=1 ALT="Click Here"></A>'; 
			break;
		}
	}
	
	return true;
}

function RenderAdLink() {
	global $wgAdSkin, $wgStyleVersion, $wgExtensionsPath;

	if (isset($wgAdSkin)) {
		switch ($wgAdSkin) {
		case "warhammer_link":
			echo '<link rel="stylesheet" type="text/css" href="'. $wgExtensionsPath .'/wikia/AdSkin/css/warhammer_link.css?'. $wgStyleVersion .'" />';
			echo '<a href="http://www.warhammeronline.com/trial?WHK33J-U7C8Q-HWPEJ-9QAIJ-4Y8JK" id="warhammer_link">Download the Free 10-Day Trial</a>';
			break;
		}
	}
	return true;
}
