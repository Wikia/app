<?php
/*
 * a hook to prevent autoblocks from RT #747 to be made
 */

$wgHooks['AbortAutoblock'][] = 'wfWikiaAbortAutoblock';

function wfWikiaAbortAutoblock( $autoblockip, $block ) {
	if ( !IP::isPublic( $autoblockip ) ) {
		wfDebug( "IP $autoblockip was prevented from being autoblocked by internal IP autoblock" );
		return false;                 
	}
}

