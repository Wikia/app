<?php
# defined here since this is loaded before settings -gp
$wgProfilerSamplePercent = 1;
$wgXhprofSamplePercent = 10;
$wgProfilerRequestSample = rand(1, 100);
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
	require_once( dirname(__FILE__).'/includes/profiler/ProfilerSimpleUDP.php' );
	$wgProfiler = new ProfilerSimpleUDP(array());
} elseif ($wgProfilerRequestSample <= $wgProfilerSamplePercent + $wgXhprofSamplePercent ) {
	if ( function_exists('xhprof_enable') ) {
		require_once( dirname(__FILE__).'/includes/profiler/ProfilerXhprof.php' );
		$wgProfiler = new ProfilerXhprof(array());
	}
} else {
	require_once( dirname(__FILE__).'/includes/profiler/ProfilerStub.php' );
}
