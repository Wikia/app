<?php

$rand_mod_10 = mt_rand(0, 0x7fffffff) % 10;

if( !empty( $_GET['forceprofile'] ) ) {
	require_once( dirname(__FILE__).'/includes/ProfilerSimpleText.php' );
	$wgProfiler = new ProfilerSimpleText;
	$wgProfiler->setProfileID( 'forced' );
} elseif( !empty( $_GET['forcetrace'] ) ) {
	require_once( dirname(__FILE__).'/includes/ProfilerSimpleTrace.php' );
	$wgProfiler = new ProfilerSimpleTrace;
} elseif( $rand_mod_10 == 1 ) {
	require_once( dirname(__FILE__).'/includes/ProfilerSimpleStomp.php' );
	$wgProfiler = new ProfilerSimpleStomp;
} elseif( $rand_mod_10 == 2 ) {
	require_once( dirname(__FILE__).'/includes/ProfilerSimpleUDP.php' );
	$wgProfiler = new ProfilerSimpleUDP;
	$wgProfiler->setProfileId( 'wikia' );
} else {
	require_once( dirname(__FILE__).'/includes/ProfilerStub.php' );
}
