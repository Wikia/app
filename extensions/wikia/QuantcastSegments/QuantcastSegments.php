<?php
$wgExtensionCredits['other'][] = array(
	'name' => 'QuantcastSegments',
	'author' => 'William Lee'
);

$wgHooks['MakeGlobalVariablesScript'][] = 'QuantcastSegments::onMakeGlobalVariablesScript';
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

	/**
	 * Adds global JS variables. Switches for collecting Quantcast audience segments
	 * and integrating them in DART URLs.
	 */
	public static function onMakeGlobalVariablesScript( &$vars ) {
		global $wgCollectQuantcastSegments, $wgIntegrateQuantcastSegments;
		wfProfileIn( __METHOD__ );

		global $wgRequest, $wgNoExternals;
		$wgNoExternals = $wgRequest->getBool('noexternals', $wgNoExternals);

		$vars['wgCollectQuantcastSegments'] = $wgCollectQuantcastSegments && !$wgNoExternals;
		$vars['wgIntegrateQuantcastSegments'] = $wgIntegrateQuantcastSegments;

		wfProfileOut( __METHOD__ );
		return true;
	} // end onMakeGlobalVariablesScript()
}
