<?php
# defined here since this is loaded before settings -gp
$wgProfilerSamplePercent = 10;
if( !empty( $_GET['forceprofile'] ) ) {
	require_once( dirname(__FILE__).'/includes/ProfilerSimpleText.php' );
	$wgProfiler = new ProfilerSimpleText;
	$wgProfiler->setProfileID( 'forced' );
} elseif( !empty( $_GET['forcetrace'] ) ) {
	require_once( dirname(__FILE__).'/includes/ProfilerSimpleTrace.php' );
	$wgProfiler = new ProfilerSimpleTrace;
} elseif( false ) {
	// this extension is not finished yet, do not enable
	if ( !class_exists( 'ProfilerSimple' ) ) {
		require_once( dirname(__FILE__).'/includes/ProfilerSimple.php');
	}
	require_once( dirname(__FILE__).'/extensions/wikia/WyvProfiler/WyvProfiler.class.php' );
	$wgProfiler = new WyvProfilerH;
} elseif (rand(1, 100) <= $wgProfilerSamplePercent  ) {
	require_once( dirname(__FILE__).'/includes/ProfilerSimpleUDP.php' );
 	$wgProfiler = new ProfilerSimpleUDP;
} else {
	require_once( dirname(__FILE__).'/includes/ProfilerStub.php' );
}
