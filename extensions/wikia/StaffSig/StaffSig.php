<?php

//Avoid unstubbing $wgParser on setHook() too early on modern (1.12+) MW versions, as per r35980
if ( defined( 'MW_SUPPORTS_PARSERFIRSTCALLINIT' ) ) {
	$wgHooks['ParserFirstCallInit'][] = 'wfSigSetup';
} else {
	$wgExtensionFunctions[] = 'wfSigSetup';
}

function wfSigSetup() {
	global $wgParser;
	$wgParser->setHook( 'staff', 'wfMakeSignature' );
	return true;
}

function wfMakeSignature( $contents, $attributes, $parser ) {
	global $wgStylePath;
	return '<a href="http://www.wikia.com/wiki/Wikia:Staff" title="This user is a member of Wikia staff" class="staffSigLink"><img src="'.$wgStylePath.'/common/dot.gif" style="background-image: url(\'http://images.wikia.com/wikia/images/e/e9/WikiaStaff.png\')" alt="@Wikia" class="staffSig" width="53" height="12" /></a>';
}

?>
