<?php

/**
 * Configuration for reporting ondemand profiler data to XHGui
 */

// Disable profiling if no URL was given
if ( !$wgXhguiProfilerUrl ) {
	return;
}

function wfStartXhProf(): void {
	// Keep it in scope until the end of the request
	static $profiler;

	global $wgXhguiProfilerUrl, $wgWikiaEnvironment, $wgXhguiUploadTokenDev, $wgXhguiUploadTokenProd;

	$config = [
		'profiler' => \Xhgui\Profiler\Profiler::PROFILER_TIDEWAYS_XHPROF,

		'profiler.flags' => [
			\Xhgui\Profiler\ProfilingFlags::CPU,
			\Xhgui\Profiler\ProfilingFlags::MEMORY,
			\Xhgui\Profiler\ProfilingFlags::NO_BUILTINS,
			\Xhgui\Profiler\ProfilingFlags::NO_SPANS,
		],

		'save.handler' => \Xhgui\Profiler\Profiler::SAVER_UPLOAD,

		'save.handler.upload' => [
			'uri' => $wgXhguiProfilerUrl,
			// The timeout option is in seconds and defaults to 3 if unspecified.
			'timeout' => 15,
			// the token must match 'upload.token' config in XHGui
			'token' => $wgWikiaEnvironment === WIKIA_ENV_DEV ? $wgXhguiUploadTokenDev : $wgXhguiUploadTokenProd,
		],

		/**
		 * Determine whether profiler should run.
		 * @return bool
		 */
		'profiler.enable' => function (): bool {
			return isset( $_GET['forceprofile'] );
		},

		/**
		 * Creates a simplified URL given a standard URL.
		 * Does the following transformations:
		 *
		 * - Remove numeric values after =.
		 *
		 * @param string $url
		 * @return string
		 */
		'profile.simple_url' => function ( $url ) {
			return preg_replace( '/=\d+/', '', $url );
		},
	];

	$profiler = new \Xhgui\Profiler\Profiler( $config );
	$profiler->start();
}

wfStartXhProf();
