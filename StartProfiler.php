<?php

if( !empty( $_GET['forceprofile'] ) ) {
	require_once( dirname(__FILE__).'/includes/ProfilerSimpleText.php' );
	$wgProfiler = new ProfilerSimpleText;
	$wgProfiler->setProfileID( 'forced' );
} elseif( !empty( $_GET['forcetrace'] ) ) {
	require_once( dirname(__FILE__).'/includes/ProfilerSimpleTrace.php' );
	$wgProfiler = new ProfilerSimpleTrace;
} else {
	//require_once( dirname(__FILE__).'/includes/ProfilerStub.php' );
	require_once( dirname(__FILE__).'/includes/ProfilerSimpleStomp.php' );
	$wgProfiler = new ProfilerSimpleStomp;
}

