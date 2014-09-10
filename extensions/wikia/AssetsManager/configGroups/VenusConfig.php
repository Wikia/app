<?php

$VenusConfig = [];

$VenusConfig[ 'venus_body_js' ] = [
	'type' => AssetsManager::TYPE_JS,
	'skin' => 'venus',
	'assets' => [
		'//extensions/wikia/Venus/scripts/Venus.js',
	]
];

$VenusConfig[ 'venus_head_js' ] = [
	'type' => AssetsManager::TYPE_JS,
	'skin' => 'venus',
	'assets' => [
		'#function_AssetsConfig::getJQueryUrl',
		'//resources/wikia/libraries/mustache/mustache.js',
		'//extensions/wikia/JSMessages/js/JSMessages.js',
		'//resources/wikia/modules/nirvana.js',
	]
];

$VenusConfig[ 'venus_css' ] = [
	'type' => AssetsManager::TYPE_SCSS,
	'skin' => 'venus',
	'assets' => [
		'//extensions/wikia/Venus/styles/Venus.scss'
	]
];

/** GlobalFooter extension */
$VenusConfig[ 'global_footer_css' ] = [
	'type' => AssetsManager::TYPE_SCSS,
	'skin' => [ 'venus' ],
	'assets' => [
		'//extensions/wikia/GlobalFooter/styles/GlobalFooter.scss'
	]
];

/** GlobalNavigation extension */
$VenusConfig[ 'global_navigation_scss' ] = [
	'type' => AssetsManager::TYPE_SCSS,
	'skin' => [ 'venus', 'oasis' ],
	'assets' => [
		'//extensions/wikia/GlobalNavigation/css/GlobalNavigation.scss',
		'//extensions/wikia/GlobalNavigation/css/GlobalNavigationSearch.scss',
		'//extensions/wikia/GlobalNavigation/css/GlobalNavigationAccountNavigation.scss',
		'//extensions/wikia/GlobalNavigation/css/GlobalNavigationHubsMenu.scss',
		'//extensions/wikia/UserLogin/css/UserLoginDropdown.globalNavigation.scss',
		'//extensions/wikia/WallNotifications/styles/WallNotifications.venus.scss',
	]
];

$VenusConfig[ 'global_navigation_js' ] = [
	'type' => AssetsManager::TYPE_JS,
	'skin' => [ 'venus', 'oasis' ],
	'assets' => [
		'//resources/wikia/libraries/menu-aim/menu-aim.js',
		'//resources/wikia/libraries/delayed-hover/js-delayed-hover.js',
		'//extensions/wikia/GlobalNavigation/js/GlobalNavigationLazyLoad.js',
		'//extensions/wikia/GlobalNavigation/js/GlobalNavigationHubsMenu.js',
		'//extensions/wikia/GlobalNavigation/js/GlobalNavigation.js',
		'//extensions/wikia/GlobalNavigation/js/GlobalNavigationSearch.js',
		'//extensions/wikia/UserLogin/js/UserLoginDropdown.globalNavigation.js',
		'//extensions/wikia/WallNotifications/scripts/WallNotifications.venus.js',
	]
];

$VenusConfig[ 'global_navigation_facebook_login_js' ] = [
	'type' => AssetsManager::TYPE_JS,
	'skin' => [ 'venus '],
	'assets' => [
		'//extensions/wikia/UserLogin/js/UserLoginFacebook.js',
		'//extensions/wikia/UserLogin/js/UserLoginFacebookForm.js',
	]
];

/** GlobalFooter extension */
$VenusConfig[ 'global_footer_scss' ] = [
	'type' => AssetsManager::TYPE_SCSS,
	'skin' => [ 'venus' ],
	'assets' => [
		'//extensions/wikia/GlobalFooter/styles/GlobalFooter.scss'
	]
];
