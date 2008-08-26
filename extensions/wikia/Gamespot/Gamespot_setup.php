<?php

// gamespot-branded wiki have different logo and navlinks

$wgHooks['AlternateNavLinks'][] = 'GamespotNavLinks';

function GamespotNavLinks()
{
	global $wgPartnerWikiData;
	if (!empty($wgPartnerWikiData['header']))
	{
		global $IP;
		$tmpl = new EasyTemplate($IP);
		$output = $tmpl->execute($wgPartnerWikiData['header']);

		echo $output;

		return false;
	} else
	{
		return true;
	}
}

// gamespot-branded wiki have additional widget with info feed from gs

global $wgShowGamespotWidget;
$wgShowGamespotWidget = true;

$widgetFiles['WidgetGamespot'] = "$IP/extensions/wikia/Gamespot/WidgetGamespot.php";

// gs-b. w. have its own skin; unchangeable

global $wgForceSkin;
$wgForceSkin = 'quartz-gamespot';

// gs-b. w. should not be indexed by google etc.

for( $i=0; $i<16; $i++ ) {
	$wgNamespaceRobotPolicies[$i] = "noindex,nofollow";
}
$wgNamespaceRobotPolicies[110] = "noindex,nofollow";
$wgNamespaceRobotPolicies[111] = "noindex,nofollow";

// old stuff

if( isset( $wgVisitorSkin) ) unset($wgVisitorSkin);

?>
