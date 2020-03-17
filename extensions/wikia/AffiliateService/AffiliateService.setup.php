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
		'js/templates.js',
		'js/tracker.js',
	],
	'styles' => [
		'styles/affiliate-unit.scss',
	],
];

// hooks
$wgAutoloadClasses['AffiliateServiceHooks'] = __DIR__ . '/AffiliateServiceHooks.class.php';
$wgHooks['BeforePageDisplay'][] = 'AffiliateServiceHooks::onBeforePageDisplay';
$wgHooks['WikiaSkinTopScripts'][] = 'AffiliateServiceHooks::onWikiaSkinTopScripts';

// i18n
$wgExtensionMessagesFiles['AffiliateService'] = __DIR__ . '/AffiliateService.i18n.php';
