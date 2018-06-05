<?php

/**
 * Begin profiling of a function
 * @deprecated explicit profiler calls are no longer required
 * @param $functionname String: name of the function we will profile
 */
function wfProfileIn( $functionname ) {
	// no-op
}

/**
 * Stop profiling of a function
 * @deprecated explicit profiler calls are no longer required
 * @param $functionname String: name of the function we have profiled
 */
function wfProfileOut( $functionname = 'missing' ) {
	// no-op
}

// No profiler configuration has been supplied but profiling has been explicitly requested
if ( empty( $wgProfiler ) && !empty( $_GET['forceprofile'] ) ) {
	$wgProfiler = [
		'class' => ProfilerXhprof::class,
		'output' => [ 'text' ],
	];
}
