<?php

/**
 * Adds <staff /> and <helper/> parser hooks rendering as @wikia signatures
 *
 * @author Emil Podlaszewski, C. Uberfuzzy Stafford
 */

//Avoid unstubbing $wgParser on setHook() too early on modern (1.12+) MW versions, as per r35980
$wgHooks['ParserFirstCallInit'][] = 'wfSigSetup';

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
	global $wgStylePath;

	if( empty($iurl) ) {
		$iurl = wfReplaceImageServer('http://images.wikia.com/wikia/images/e/e9/WikiaStaff.png');
	}

	return '<a href="'. $href .'" title="'. $title . ' class="staffSigLink"><img src="'.$wgStylePath.'/common/dot.gif" style="background-image: url(\''. $iurl .'\')" alt="@Wikia" class="staffSig" width="53" height="12" /></a>';
}