<?php

$VenusConfig = [];

$VenusConfig['venus_body_js'] = [
	'type' => AssetsManager::TYPE_JS,
	'skin' => 'venus',
	'assets' => [
		'//extensions/wikia/Venus/scripts/Venus.js',
		'#function_AssetsConfig::getJQueryUrl',
	]
];

$VenusConfig['venus_head_js'] = [
	'type' => AssetsManager::TYPE_JS,
	'skin' => 'venus',
	'assets' => [
	]
];

$VenusConfig['venus_css'] = [
	'type' => AssetsManager::TYPE_SCSS,
	'skin' => 'venus',
	'assets' => [
		'//extensions/wikia/Venus/styles/Venus.scss'
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


/** GlobalNavigation extension */
$VenusConfig['global_navigation_scss'] = [
	'type' => AssetsManager::TYPE_SCSS,
	'skin' => ['venus', 'oasis'],
	'assets' => [
		'//extensions/wikia/GlobalNavigation/css/GlobalNavigation.scss',
		'//extensions/wikia/GlobalNavigation/css/AccountNavigation.scss',
		'//extensions/wikia/UserLogin/css/UserLoginDropdown.venus.scss',
		'//extensions/wikia/GlobalNavigation/css/GlobalNavigationSearch.scss'
	]
];

$VenusConfig['global_navigation_js'] = [
	'type' => AssetsManager::TYPE_JS,
	'skin' => ['venus', 'oasis'],
	'assets' => [
		'//extensions/wikia/GlobalNavigation/js/GlobalNavigationSearch.js',
	]
];
