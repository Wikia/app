<?php
# defined here since this is loaded before settings -gp
$wgProfilerSamplePercent = 10;
if( !empty( $_GET['forceprofile'] ) ) {
	require_once( dirname(__FILE__).'/includes/profiler/ProfilerSimpleText.php' );
	$wgProfiler = new ProfilerSimpleText(array());
	$wgProfiler->setProfileID( 'forced' );
// Wikia change - begin - @author: wladek
} elseif( !empty( $_GET['forcetrace'] ) && $_GET['forcetrace'] == 2 ) {
	require_once( dirname(__FILE__).'/includes/wikia/profiler/ProfilerWikiaTrace.php' );
	$wgProfiler = new ProfilerWikiaTrace(array());
// Wikia change - end
} elseif( !empty( $_GET['forcetrace'] ) ) {
	require_once( dirname(__FILE__).'/includes/profiler/ProfilerSimpleTrace.php' );
	$wgProfiler = new ProfilerSimpleTrace(array());
} elseif( false ) {
	// this extension is not finished yet, do not enable
	if ( !class_exists( 'ProfilerSimple' ) ) {
		require_once( dirname(__FILE__).'/includes/profiler/ProfilerSimple.php');
	}
	require_once( dirname(__FILE__).'/extensions/wikia/WyvProfiler/WyvProfiler.class.php' );
	$wgProfiler = new WyvProfiler;
} elseif (rand(1, 100) <= $wgProfilerSamplePercent  ) {
	require_once( dirname(__FILE__).'/includes/profiler/ProfilerSimpleUDP.php' );
	$wgProfiler = new ProfilerSimpleUDP(array());
} else {
	require_once( dirname(__FILE__).'/includes/profiler/ProfilerStub.php' );
}
