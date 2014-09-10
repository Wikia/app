<?php

$VenusConfig = [];

$VenusConfig['venus_body_js'] = [
	'type' => AssetsManager::TYPE_JS,
	'skin' => 'venus',
	'assets' => [
		'//resources/jquery/jquery-2.1.1.js',
		'//extensions/wikia/Venus/scripts/Venus.js',
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
$VenusConfig['global_navigation_scss'] = array(
	'type' => AssetsManager::TYPE_SCSS,
	'skin' => ['venus', 'oasis'],
	'assets' => array(
		'//extensions/wikia/GlobalNavigation/css/GlobalNavigation.scss',
		'//extensions/wikia/GlobalNavigation/css/GlobalNavigationSearch.scss'
	)
);

$VenusConfig['global_navigation_js'] = array(
	'type' => AssetsManager::TYPE_JS,
	'skin' => ['venus', 'oasis'],
	'assets' => array(
		'//extensions/wikia/GlobalNavigation/js/GlobalNavigationSearch.js',
		'//extensions/wikia/GlobalNavigation/js/SearchSuggestions.js',
		// TODO don't load autocomplete on every pv
		'//resources/wikia/libraries/jquery/autocomplete/jquery.autocomplete.js',
		'//skins/shared/js/Search.js',
	)
);
