<?php

if( !empty( $_GET['forceprofile'] ) ) {
	require_once( dirname(__FILE__).'/includes/ProfilerSimpleText.php' );
	$wgProfiler = new ProfilerSimpleText;
	$wgProfiler->setProfileID( 'forced' );
} elseif( !empty( $_GET['forcetrace'] ) ) {
	require_once( dirname(__FILE__).'/includes/ProfilerSimpleTrace.php' );
	$wgProfiler = new ProfilerSimpleTrace;
} else if (rand(1, 100) == 42 ) {
	/* Wikia change -- turn on invisible profiling for 1% of hits */
	require_once( dirname(__FILE__).'/includes/ProfilerSimpleText.php' );
	$wgProfiler = new ProfilerSimpleText;
	$wgProfiler->invisible=true;
} else {
	require_once( dirname(__FILE__).'/includes/ProfilerStub.php' );
}
