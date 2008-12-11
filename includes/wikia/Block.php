<?php
/*
 * a hook to prevent autoblocks from RT #747 to be made
 */

$wgHooks['AbortAutoblock'][] = 'wfWikiaAbortAutoblock';

function wfWikiaAbortAutoblock( $autoblockip, $block ) {
	if ( 0 === strpos( $autoblockip, '10.' ) ) {
		wfDebug( "IP $autoblockip was prevented from being autoblocked by 10.* autoblock" );
		return false;                 
	}
}

