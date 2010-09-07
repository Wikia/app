<?php
$wgExtensionCredits['other'][] = array(
	'name' => 'Geo',
	'author' => 'William Lee'
);

//$wgHooks['BeforePageDisplay'][] = 'geoAdditionalScripts';

/**
 * Before the page is rendered this gives us a chance to cram some Javascript in.
 */
function geoAdditionalScripts( &$out, &$sk ){
	global $wgExtensionsPath,$wgStyleVersion;

	//$out->addScript("<script type='text/javascript' src='$wgExtensionsPath/wikia/Geo/geo.js?$wgStyleVersion'></script>\n");	// WL: moved to StaticChute
	return true;
}

class Geo {
	//@todo accessors for Geo cookie
}
