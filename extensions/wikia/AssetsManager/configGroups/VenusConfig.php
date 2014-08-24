<?php

$VenusConfig = [];

$VenusConfig['venus_body_js'] = [
	'type' => AssetsManager::TYPE_JS,
	'skin' => 'venus',
	'assets' => [
		'//extensions/wikia/Venus/scripts/Venus.js',
	]
];

$VenusConfig['venus_head_js'] = [
	'type' => AssetsManager::TYPE_JS,
	'skin' => 'venus',
	'assets' => [
		'#function_AssetsConfig::getJQueryUrl',
		'//resources/wikia/libraries/mustache/mustache.js',
		'//extensions/wikia/JSMessages/js/JSMessages.js',
		'//resources/wikia/modules/nirvana.js',
	]
];

$VenusConfig['venus_css'] = [
	'type' => AssetsManager::TYPE_SCSS,
	'skin' => 'venus',
	'assets' => [
		'//extensions/wikia/Venus/styles/Venus.scss'
	]
];

/** GlobalNavigation extension */
$VenusConfig['global_navigation_css'] = array(
	'type' => AssetsManager::TYPE_SCSS,
	'skin' => ['venus', 'oasis'],
	'assets' => array(
		'//extensions/wikia/GlobalNavigation/css/GlobalNavigation.scss',
		'//extensions/wikia/GlobalNavigation/css/GlobalNavigationHubsMenu.scss'
	)
);

$VenusConfig['global_navigation_js'] = [
	'type' => AssetsManager::TYPE_JS,
	'skin' => ['venus', 'oasis'],
	'assets' => [
		'//resources/wikia/libraries/menu-aim/menu-aim.js',
		'//extensions/wikia/GlobalNavigation/js/GlobalNavigationLazyLoad.js',
		'//extensions/wikia/GlobalNavigation/js/GlobalNavigationHubsMenu.js',
		'//extensions/wikia/GlobalNavigation/js/GlobalNavigation.js',
	]
];

/** GlobalFooter extension */
$VenusConfig['global_footer_css'] = array(
	'type' => AssetsManager::TYPE_SCSS,
	'skin' => ['venus'],
	'assets' => array(
		'//extensions/wikia/GlobalFooter/styles/GlobalFooter.scss'
	)
);
