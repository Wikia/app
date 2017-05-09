<?php
// Wikia change - begin - @author Mix
$wgProfilingDataLogged = false;

register_shutdown_function( function() {
	global $wgProfilingDataLogged;
	if ( ! $wgProfilingDataLogged && function_exists( 'wfLogProfilingData' ) ) {
		wfLogProfilingData();
		$wgProfilingDataLogged = true;
	}
} );
// Wikia change - end

# defined here since this is loaded before settings -gp
$wgProfilerSamplePercent = 1;
$wgXhprofSamplePercent = 1;
$wgProfilerRequestSample = mt_rand(1, 100);
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
} elseif ($wgProfilerRequestSample <= $wgProfilerSamplePercent  ) {
	require_once( dirname(__FILE__).'/includes/profiler/ProfilerSimpleDataCollector.php' );
	$wgProfiler = new ProfilerSimpleDataCollector(array());
} elseif ($wgProfilerRequestSample <= $wgProfilerSamplePercent + $wgXhprofSamplePercent ) {
	if ( function_exists('tideways_enable') ) {
		require_once( dirname(__FILE__).'/includes/profiler/ProfilerTideways.php' );
		$wgProfiler = new ProfilerTideways(array());
	}
} else {
	require_once( dirname(__FILE__).'/includes/profiler/ProfilerStub.php' );
}
