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
function wfSigSetup( Parser $parser ): bool {
	$parser->setHook( 'staff', 'wfMakeStaffSignature' );
	$parser->setHook( 'helper', 'wfMakeHelperSignature' );
	return true;
}

function wfMakeStaffSignature( $contents, $attributes, $parser ) {
	$title = GlobalTitle::newFromText('Staff', 4 /*project*/, 177);
	return wfMakeSignatureCommon( $title->getFullURL(), "This user is a member of Fandom Staff" );
}

function wfMakeHelperSignature( $contents, $attributes, $parser ) {
	$title = GlobalTitle::newFromText('Helper_Group', 12 /*help*/, 177);
	return wfMakeSignatureCommon( $title->getFullURL(), "This user is a Fandom Helper" );
}

function wfMakeSignatureCommon($href, $title, $iurl=null) {
	global $wgBlankImgUrl;

	if( empty($iurl) ) {
		$iurl = wfGetSignatureUrl();
	}

	return '<a href="'. $href .'" title="'. $title . '" class="staffSigLink"><img src="'. $wgBlankImgUrl .'" style="background-image: url('. $iurl .'); background-size: 100% 100%;" alt="@fandom" class="staffSig" width="64" height="14" /></a>';
}

function wfGetSignatureUrl() {
	global $wgExtensionsPath;
	return $wgExtensionsPath . '/wikia/DesignSystem/bower_components/design-system/dist/svg/wds-company-logo-fandom.svg';
}
