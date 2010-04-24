<?php

$wgHooks["fillInAdPlaceholder"][] = "wfAnswersSudoAd2";

function wfAnswersSudoAd2($placeholdertype, $slotname, $AdEngine, $html) {
	if (("HOME_TOP_LEADERBOARD" != $slotname) && ("TOP_LEADERBOARD" != $slotname)) return true;

	$var = "wgAdslot_{$slotname}";
	if (!empty($GLOBALS[$var]) && "null" == strtolower($GLOBALS[$var])) return true;

	global $wgUser;
	if (empty($_GET["showads"]) && is_object($wgUser) && $wgUser->isLoggedIn() && !$wgUser->getOption("showAds")) return true;
					 
	$html = '<div id="' . htmlspecialchars($slotname) . '" class="noprint">
		<script type="text/javascript"><!--
			google_ad_client = "pub-1541662546603203";
			/* Wikia 728x90 */
			google_ad_slot = "1429918703";
			google_ad_width = 728;
	 		google_ad_height = 90;
			google_ad_region = "region";
			//-->
		</script>
		<script type="text/javascript" src="http://pagead2.googlesyndication.com/pagead/show_ads.js"></script>
	</div>';

	return true;
}
