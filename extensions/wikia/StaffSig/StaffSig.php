<?php

/**
 * Adds <staff /> parser hook rendering as staff signature
 *
 * @author Emil Podlaszewski
 */

//Avoid unstubbing $wgParser on setHook() too early on modern (1.12+) MW versions, as per r35980
$wgHooks['ParserFirstCallInit'][] = 'wfSigSetup';

function wfSigSetup(&$parser) {
	$parser->setHook( 'staff', 'wfMakeSignature' );
	$parser->setHook( 'helper', 'wfMakeHSignature' );
	return true;
}

function wfMakeSignature( $contents, $attributes, $parser ) {
	global $wgStylePath;
	return '<a href="http://community.wikia.com/wiki/Project:Staff" title="This user is a member of Wikia staff" class="staffSigLink"><img src="'.$wgStylePath.'/common/dot.gif" style="background-image: url(\'http://images.wikia.com/wikia/images/e/e9/WikiaStaff.png\')" alt="@Wikia" class="staffSig" width="53" height="12" /></a>';
}

function wfMakeHSignature( $contents, $attributes, $parser ) {
	global $wgStylePath;
	return '<a href="http://community.wikia.com/wiki/Help:Helper_Group" title="This user is a Wikia Helper" class="staffSigLink"><img src="'.$wgStylePath.'/common/dot.gif" style="background-image: url(\'http://images.wikia.com/wikia/images/e/e9/WikiaStaff.png\')" alt="@Wikia" class="staffSig" width="53" height="12" /></a>';
}
