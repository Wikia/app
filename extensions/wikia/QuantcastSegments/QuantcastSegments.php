<?php
$wgExtensionCredits['other'][] = array(
	'name' => 'QuantcastSegments',
	'author' => 'William Lee'
);

//$wgHooks['BeforePageDisplay'][] = 'quantcastSegmentsAdditionalScripts';

/**
 * Before the page is rendered this gives us a chance to cram some Javascript in.
 */
function quantcastSegmentsAdditionalScripts( &$out, &$sk ){
	global $wgExtensionsPath,$wgStyleVersion;

	//$out->addScript("<script type='text/javascript' src='$wgExtensionsPath/wikia/QuantcastSegments/qcs.js?$wgStyleVersion'></script>\n");		// WL: moved to StaticChute
	return true;
}

class QuantcastSegments {
	const SEGMENTS_COOKIE_NAME = 'qcseg';
	const UPDATE_COOKIE_NAME = 'qcsegupdate';

}
