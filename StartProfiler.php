<?php

$rand = mt_rand(0, 0x7fffffff);

if( !empty( $_GET['forceprofile'] ) ) {
	require_once( dirname(__FILE__).'/includes/ProfilerSimpleText.php' );
	$wgProfiler = new ProfilerSimpleText;
	$wgProfiler->setProfileID( 'forced' );
} elseif( !empty( $_GET['forcetrace'] ) ) {
	require_once( dirname(__FILE__).'/includes/ProfilerSimpleTrace.php' );
	$wgProfiler = new ProfilerSimpleTrace;
} elseif( !( $rand % 10 ) ) {
	// every 10th request gets reported via stomp
	require_once( dirname(__FILE__).'/includes/ProfilerSimpleStomp.php' );
	$wgProfiler = new ProfilerSimpleStomp;
} else {
	require_once( dirname(__FILE__).'/includes/ProfilerStub.php' );
}
