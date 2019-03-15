<?php

$wgExtensionCredits['other'][] = [
	'name' => 'Qualtrics Site Intercept',
	'description' => 'As part of the Foundational Strength pillar, our research and insights team along with the Sales team are launching a private panel. 
	In order to execute this, they have identified Qualtrics as the vendor of choice. 
	Please note we are ALSO maintaining Qualaroo for more general survey purposes that do not require the granularity Qualtrics provides.',
];

/**
 * Resources Loader modules
 */

// a base "QualtricsSiteIntercept" AMD module with a generic code
$wgResourceModules['ext.wikia.QualtricsSiteIntercept'] = [
	'scripts' => [
		'scripts/index.js',
	],
	'localBasePath' => __DIR__,
	'remoteExtPath' => 'wikia/QualtricsSiteIntercept',
];

$wgAutoloadClasses['QualtricsSiteInterceptHooks'] = __DIR__.'/QualtricsSiteInterceptHooks.class.php';

$wgHooks['BeforePageDisplay'][] = 'QualtricsSiteInterceptHooks::onBeforePageDisplay';
