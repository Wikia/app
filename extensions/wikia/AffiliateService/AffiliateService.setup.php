<?php
$wgExtensionCredits['other'][] = [
	'name' => 'Affiliate Service',
	'description' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/AffiliateService',
];

/**
 * Resources Loader modules
 */
$wgResourceModules['ext.wikia.AffiliateService'] = [
	'remoteExtPath' => 'wikia/AffiliateService',
	'localBasePath' => __DIR__,
	'scripts' => [
		'js/ext.AffiliateService.js',
		'js/units.js',
		'js/tracker.js',
	],
];

// hooks
$wgAutoloadClasses['AffiliateServiceHooks'] = __DIR__ . '/AffiliateServiceHooks.class.php';
$wgHooks['BeforePageDisplay'][] = 'AffiliateServiceHooks::onBeforePageDisplay';
