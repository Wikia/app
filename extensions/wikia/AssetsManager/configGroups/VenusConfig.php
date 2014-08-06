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

$VenusConfig['venus_search_css'] = [
	'type' => AssetsManager::TYPE_SCSS,
	'skin' => 'venus',
	'assets' => [
		'//extensions/wikia/Search/css/WikiaSearch.venus.scss'
	]
];
