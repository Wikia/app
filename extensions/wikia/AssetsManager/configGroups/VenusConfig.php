<?php

$VenusConfig = [];

$VenusConfig['venus_body_js'] = [
	'type' => AssetsManager::TYPE_JS,
	'skin' => ['venus'],
	'assets' => [
		'//resources/jquery/jquery-2.1.1.min.js',

		//libraries/frameworks
// TODO: This should be loaded here, but for some reason, it's already included
//		'//resources/wikia/libraries/modil/modil.js',
		'//resources/wikia/libraries/Ponto/ponto.js',
		'//resources/wikia/libraries/my.class/my.class.js',

		//core modules
		'//resources/wikia/modules/instantGlobals.js',
		'//resources/wikia/modules/cache.js',
		'//resources/wikia/modules/cookies.js',
		'//resources/wikia/modules/document.js',
		'//resources/wikia/modules/geo.js',
		'//resources/wikia/modules/loader.js',
		'//resources/wikia/modules/localStorage.js',
		'//resources/wikia/modules/location.js',
		'//resources/wikia/modules/log.js',
		'//resources/wikia/modules/mw.js',
		'//resources/wikia/modules/nirvana.js',
		'//resources/wikia/modules/querystring.js',
		'//resources/wikia/modules/throbber.js',
		'//resources/wikia/modules/thumbnailer.js',
		'//resources/wikia/modules/tracker.js',
		'//resources/wikia/modules/window.js',
		'//resources/wikia/modules/abTest.js',

		'//resources/wikia/modules/lazyqueue.js',

		//tracker
		'#group_tracker_js',

		// jquery libs
		'//resources/wikia/libraries/mustache/mustache.js',
		'//resources/wikia/libraries/jquery/throttle-debounce/jquery.throttle-debounce.js',
		'//resources/wikia/libraries/sloth/sloth.js',
		'//resources/wikia/jquery.wikia.js',

		//platform components
		'//extensions/wikia/JSMessages/js/JSMessages.js',
		'//extensions/wikia/JSSnippets/js/JSSnippets.js',
		'//extensions/wikia/AssetsManager/js/AssetsManager.js',

		'//extensions/wikia/Venus/scripts/isTouchScreen.js',
		'//extensions/wikia/Venus/scripts/Venus.js',

		'#group_adengine2_js',
	]
];

$VenusConfig['venus_head_js'] = [
	'type' => AssetsManager::TYPE_JS,
	'skin' => ['venus'],
	'assets' => [
		'#group_abtesting',
	]
];

$VenusConfig['venus_css'] = [
	'type' => AssetsManager::TYPE_SCSS,
	'skin' => ['venus'],
	'assets' => [
		'//extensions/wikia/Venus/styles/Venus.scss'
	]
];

/** GlobalNavigation extension */
$VenusConfig['global_navigation_scss'] = array(
	'type' => AssetsManager::TYPE_SCSS,
	'skin' => ['venus', 'oasis'],
	'assets' => array(
		'//extensions/wikia/GlobalNavigation/css/GlobalNavigation.scss',
		'//extensions/wikia/GlobalNavigation/css/GlobalNavigationHubsMenu.scss',
		'//extensions/wikia/GlobalNavigation/css/GlobalNavigationSearch.scss'
	)
);

$VenusConfig['global_navigation_js'] = [
	'type' => AssetsManager::TYPE_JS,
	'skin' => ['venus', 'oasis'],
	'assets' => [
		'//resources/wikia/libraries/menu-aim/menu-aim.js',
		'//resources/wikia/libraries/delayed-hover/js-delayed-hover.js',
		'//extensions/wikia/GlobalNavigation/js/GlobalNavigationLazyLoad.js',
		'//extensions/wikia/GlobalNavigation/js/GlobalNavigationHubsMenu.js',
		'//extensions/wikia/GlobalNavigation/js/GlobalNavigation.js',
		'//extensions/wikia/GlobalNavigation/js/GlobalNavigationSearch.js',
		'//extensions/wikia/GlobalNavigation/js/SearchSuggestions.js',
		// TODO don't load autocomplete on every pv
		'//resources/wikia/libraries/jquery/autocomplete/jquery.autocomplete.js',
		'//skins/shared/js/Search.js',
	]
];

/** GlobalFooter extension */
$VenusConfig['global_footer_scss'] = array(
	'type' => AssetsManager::TYPE_SCSS,
	'skin' => ['venus'],
	'assets' => array(
		'//extensions/wikia/GlobalFooter/styles/GlobalFooter.scss'
	)
);
