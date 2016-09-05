<?php

/**
 * Adds <staff /> and <helper/> parser hooks rendering as @wikia signatures
 *
 * @author Emil Podlaszewski, C. Uberfuzzy Stafford
 */

//Avoid unstubbing $wgParser on setHook() too early on modern (1.12+) MW versions, as per r35980
$wgHooks['ParserFirstCallInit'][] = 'wfSigSetup';

/**
 * @param Parser $parser
 * @return bool
 */
function wfSigSetup(&$parser) {
	$parser->setHook( 'staff', 'wfMakeStaffSignature' );
	$parser->setHook( 'helper', 'wfMakeHelperSignature' );
	return true;
}

function wfMakeStaffSignature( $contents, $attributes, $parser ) {
	$title = GlobalTitle::newFromText('Staff', 4 /*project*/, 177);
	return wfMakeSignatureCommon( $title->getFullURL(), "This user is a member of Wikia Staff" );
}

function wfMakeHelperSignature( $contents, $attributes, $parser ) {
	$title = GlobalTitle::newFromText('Helper_Group', 12 /*help*/, 177);
	return wfMakeSignatureCommon( $title->getFullURL(), "This user is a Wikia Helper" );
}

function wfMakeSignatureCommon($href, $title, $iurl=null) {
	global $wgExtensionsPath, $wgBlankImgUrl;

	if( empty($iurl) ) {
		$iurl = $wgExtensionsPath . '/wikia/StaffSig/images/StaffSignature.png';
	}

	return '<a href="'. $href .'" title="'. $title . '" class="staffSigLink"><img src="'. $wgBlankImgUrl .'" style="background-image: url('. $iurl .')" alt="@Wikia" class="staffSig" width="41" height="12" /></a>';
}
