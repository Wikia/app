<?php

$rand = mt_rand(0, 0x7fffffff);
$host = @$_SERVER['HTTP_HOST'];

if ( @$_SERVER['REQUEST_URI'] == '/index.php?title=Anakin_Skywalker&action=submit' ) {
	require_once( dirname(__FILE__).'/includes/ProfilerSimpleUDP.php' );
	$wgProfiler = new ProfilerSimpleUDP;
	$wgProfiler->setProfileID( 'bigpage' );
} elseif (!empty($_GET['forceprofile'])) {
	require_once( dirname(__FILE__).'/includes/ProfilerSimpleText.php' );
	$wgProfiler = new ProfilerSimpleText;
	$wgProfiler->setProfileID( 'forced' );
} elseif ( !( $rand % 50 ) ) {
	require_once( dirname(__FILE__).'/includes/ProfilerSimpleUDP.php' );
	$wgProfiler = new ProfilerSimpleUDP;
	if ( $host == 'www.wowwiki.com' ) {
		$wgProfiler->setProfileID( 'wow' );
	} elseif ( $host == 'starwars.wikia.com' ) {
		$wgProfiler->setProfileID( 'starwars' );
	} elseif ( $host == 'yugioh.wikia.com' ) {
		$wgProfiler->setProfileID( 'yugioh' );
	} elseif ( $host == 'muppet.wikia.com' ) {
		$wgProfiler->setProfileID( 'muppet' );
	} else {
		$wgProfiler->setProfileID( 'wikia' );
	}
	#$wgProfiler->setProfileID( 'all' );
	#$wgProfiler->setMinimum(5 /* seconds */);
} elseif ( defined( 'MW_FORCE_PROFILE' ) ) {
	require_once( dirname(__FILE__).'/includes/Profiler.php' );
	$wgProfiler = new Profiler;
} else {
	require_once( dirname(__FILE__).'/includes/ProfilerStub.php' );
}

