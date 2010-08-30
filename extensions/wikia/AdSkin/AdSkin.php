<?php
/*
 * Author: Christian Williams 
 */

$wgAdSkinVersion = 5;

$wgHooks['GetHTMLAfterBody'][] = 'RenderAdSkin';
$wgHooks['SpecialFooterAfterWikia'][] = 'RenderAdSkinJS';
$wgHooks['MonacoAdLink'][] = 'RenderAdLink';

function RenderAdSkin($skin, &$html) {
	global $wgAdSkin, $wgExtensionsPath, $wgUser, $wgWikiaLogo, $wgAdSkinVersion;

	// Disable for logged in users
	if (is_object($wgUser) && $wgUser->isLoggedIn() ){
		return true;
	}

	//Entire site skins here
	if (isset($wgAdSkin)) {
		switch ($wgAdSkin) {
		case "iphone_games":
			$html .= '<link rel="stylesheet" type="text/css" href="'. $wgExtensionsPath .'/wikia/AdSkin/css/iphone_games.css?'. $wgAdSkinVersion .'" />\n';
			break;
		}
	}

	// Disable if not the main page
	if (!ArticleAdLogic::isMainPage()) {
		return true;
	}

	//Homepage skins here (should be the vast majority)
	if (isset($wgAdSkin)) {
		switch ($wgAdSkin) {
		case "wow_lich_king":
			$html .= '<link rel="stylesheet" type="text/css" href="'. $wgExtensionsPath .'/wikia/AdSkin/css/wow_lich_king.css?'. $wgAdSkinVersion .'" />\n';
			break;
		case "wow_lich_king_warhammer":
			$html .= '<link rel="stylesheet" type="text/css" href="'. $wgExtensionsPath .'/wikia/AdSkin/css/wow_lich_king_warhammer.css?'. $wgAdSkinVersion .'" />\n';
			break;
		case "dragonball_origins":
			$html .= '<link rel="stylesheet" type="text/css" href="'. $wgExtensionsPath .'/wikia/AdSkin/css/dragonball_origins.css?'. $wgAdSkinVersion .'" />\n';
			break;
		case "dnd":
			$html .= '<link rel="stylesheet" type="text/css" href="'. $wgExtensionsPath .'/wikia/AdSkin/css/dnd.css?'. $wgAdSkinVersion .'" />\n';
			break;
		case "underworld":
			$html .= '<link rel="stylesheet" type="text/css" href="'. $wgExtensionsPath .'/wikia/AdSkin/css/underworld.css?'. $wgAdSkinVersion .'" />\n';
			$html .= '<style type="text/css">';
			$html .= 'body.mainpage #wikia_header {
				background: url('. $wgWikiaLogo .') 10px 2px no-repeat;
			}';
			$html .= '</style>';
			break;
		case "warhammer":
			$html .= '<link rel="stylesheet" type="text/css" href="'. $wgExtensionsPath .'/wikia/AdSkin/css/warhammer.css?'. $wgAdSkinVersion .'" />\n';
			$html .= '<style type="text/css">\n';
			$html .= 'body.mainpage #wikia_header {\n
				background: #252525 url('. $wgWikiaLogo .') 10px 2px no-repeat;\n
			}\n';
			$html .= '</style>\n';
			break;
		case "superpages":
			/*
			echo '<div style="position: absolute;">';
			echo '<script language="JavaScript" type="text/javascript">
			document.write(\'<script language="JavaScript" src="http://ad.doubleclick.net/adj/npm.wikia/superpages;tile=1;sz=1x1;click=;ord=?" type="text/javascript"></scr\' + \'ipt>\');
			</script>
			<noscript>
			<a href="http://ad.doubleclick.net/jump/npm.wikia/superpages;tile=1;sz=1x1;click=;ord=?" target="_blank"><img src="http://ad.doubleclick.net/ad/npm.wikia/superpages;tile=1;sz=1x1;ord=?" width="1" height=1" border="0" alt=""></a></noscript>';
			echo '</div>';
			*/
			$html .= '<link rel="stylesheet" type="text/css" href="'. $wgExtensionsPath .'/wikia/AdSkin/css/superpages.css?'. $wgAdSkinVersion .'" />\n';
			break;
		}	
	}

	return true;
}

function RenderAdSkinJS() {
	global $wgUser, $wgExtensionsPath, $wgAdSkin, $wgAdSkinVersion;

	//Disable for logged-in users
	if (is_object($wgUser) && $wgUser->isLoggedIn() ){
		return true;
	}
	
	//Entire site skins here
	if (isset($wgAdSkin)) {
		switch ($wgAdSkin) {
		case "iphone_games":
			echo '<script type="text/javascript" src="'. $wgExtensionsPath .'/wikia/AdSkin/js/iphone_games.js?'. $wgAdSkinVersion .'"></script>';
			break;
		}
	}

	// Disable if not the main page
	if (!ArticleAdLogic::isMainPage()) {
		return true;
	}

	//Homepage skins here (should be the vast majority)
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
		case "ffxi_link":
			echo '<link rel="stylesheet" type="text/css" href="'. $wgExtensionsPath .'/wikia/AdSkin/css/ffxi_link.css?'. $wgAdSkinVersion .'" />';
			echo '<a href="http://ad.doubleclick.net/clk;213790954;29393853;v?http://www.finalfantasyxi.com" id="ffxi_link">The story of Vana\'diel continues! New chapters in the FINAL FANTASY&reg; XI saga begin, starting with "The Crystalline Prophecy."<br />Experience the story of a lifetime!</a>';
			break;
		case "mlb_link":
			echo '<style type="text/css">
				#request_wiki {
					display: none;
				}
				#mlb_link {
					color: #FFF !important;
					font-size: 8pt;
					font-weight: bold;
					left: 221px;
					position: absolute;
					text-align: left;
					top: 3px;
					width: 320px;
				}
			</style>';

			echo "<div id=\"mlb_link\"><script type='text/javascript'><!--//<![CDATA[
 var m3_u = (location.protocol=='https:'?'https://wikia-ads.wikia.com/www/delivery/ajs.php':'http://wikia-ads.wikia.com/www/delivery/ajs.php');
 var m3_r = Math.floor(Math.random()*99999999999);
 if (!document.MAX_used) document.MAX_used = ',';
 document.write (\"<scr\"+\"ipt type='text/javascript' src='\"+m3_u);
 document.write (\"?zoneid=667\");
 document.write ('&amp;cb=' + m3_r);
 if (document.MAX_used != ',') document.write (\"&amp;exclude=\" + document.MAX_used);
 document.write (\"&amp;loc=\" + escape(window.location));
 if (document.referrer) document.write (\"&amp;referer=\" + escape(document.referrer));
 if (document.context) document.write (\"&context=\" + escape(document.context));
 if (document.mmm_fo) document.write (\"&amp;mmm_fo=1\");
 document.write (\"'><\/scr\"+\"ipt>\");
//]]>--></script></div>";
			break;
		}
	}
	return true;
}
