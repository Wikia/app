<?php

$VenusConfig = [];

$VenusConfig[ 'venus_body_js' ] = [
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
		'//resources/wikia/modules/window.js',
		'//resources/wikia/modules/abTest.js',

		'//resources/wikia/modules/lazyqueue.js',

		//tracker
		'#group_tracker_js',

		// jquery libs
		'//resources/wikia/libraries/mustache/mustache.js',
		'//resources/wikia/libraries/sloth/sloth.js',

		// polyfills
		'//resources/wikia/polyfills/jquery.wikia.placeholder.js',
		'//resources/wikia/polyfills/array.js',

		// 3rd party plugins
		'//resources/wikia/libraries/jquery/getcss/jquery.getcss.js',
		'//resources/wikia/libraries/jquery/cookies/jquery.cookies.2.1.0.js',
		'//resources/wikia/libraries/jquery/timeago/jquery.timeago.js',
		'//resources/wikia/libraries/jquery/store/jquery.store.js',
		'//resources/wikia/libraries/jquery/throttle-debounce/jquery.throttle-debounce.js',
		'//resources/wikia/libraries/jquery/floating-scrollbar/jquery.floating-scrollbar.js',

		// Wikia plugins
		'//resources/wikia/jquery.wikia.js',
		'//resources/wikia/libraries/jquery/carousel/jquery.wikia.carousel.js',
		'//resources/wikia/libraries/jquery/modal/jquery.wikia.modal.js',
		'//resources/wikia/libraries/jquery/expirystorage/jquery.expirystorage.js',
		'//resources/wikia/libraries/jquery/focusNoScroll/jquery.focusNoScroll.js',

		// libraries loaders
		'//resources/wikia/libraries/jquery/getResources/jquery.wikia.getResources.js',
		'//resources/wikia/libraries/jquery/loadLibrary/jquery.wikia.loadLibrary.js',

		//platform components
		'//extensions/wikia/JSMessages/js/JSMessages.js',
		'//extensions/wikia/JSSnippets/js/JSSnippets.js',
		'//extensions/wikia/AssetsManager/js/AssetsManager.js',

		'//extensions/wikia/Venus/scripts/isTouchScreen.js',
		'//extensions/wikia/Venus/scripts/Venus.js',

		// BackgroundChanger
		'//extensions/wikia/Venus/scripts/BackgroundChanger.js',

		'#group_adengine2_js',
	]
];

$VenusConfig[ 'venus_head_js' ] = [
	'type' => AssetsManager::TYPE_JS,
	'skin' => ['venus'],
	'assets' => [
		'#group_abtesting',
	]
];

$VenusConfig[ 'venus_css' ] = [
	'type' => AssetsManager::TYPE_SCSS,
	'skin' => ['venus'],
	'assets' => [
		'//extensions/wikia/Venus/styles/Venus.scss'
	]
];

/** LocalNavigation extension */
$VenusConfig[ 'local_navigation_scss' ] = [
	'type' => AssetsManager::TYPE_SCSS,
	'skin' => [ 'venus', 'oasis' ],
	'assets' => [
		'//extensions/wikia/LocalNavigation/styles/LocalNavigation.scss'
	]
];

$VenusConfig['local_navigation_js'] = [
	'type' => AssetsManager::TYPE_JS,
	'skin' => ['venus', 'oasis'],
	'assets' => [
		'//resources/wikia/modules/eventshelper.js',
		'//extensions/wikia/LocalNavigation/scripts/LocalNavigationMenu.js',
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
		'//extensions/wikia/WallNotifications/styles/WallNotifications.globalNavigation.scss',
	]
];

$VenusConfig[ 'global_navigation_js' ] = [
	'type' => AssetsManager::TYPE_JS,
	'skin' => [ 'venus', 'oasis' ],
	'assets' => [
		'//resources/wikia/libraries/menu-aim/menu-aim.js',
		'//resources/wikia/libraries/delayed-hover/js-delayed-hover.js',
		'//extensions/wikia/GlobalNavigation/js/GlobalNavigationTracking.js',
		'//extensions/wikia/GlobalNavigation/js/GlobalNavigationLazyLoad.js',
		'//extensions/wikia/GlobalNavigation/js/GlobalNavigationHubsMenu.js',
		'//extensions/wikia/GlobalNavigation/js/GlobalNavigationSearch.js',
		'//extensions/wikia/GlobalNavigation/js/SearchSuggestions.js',
		'//skins/shared/js/transparent-out.js',
		'//extensions/wikia/UserLogin/js/UserLoginDropdown.globalNavigation.js',
		'//extensions/wikia/UserLogin/js/UserLoginAjaxForm.js',
		'//extensions/wikia/WikiaStyleGuide/js/Form.js',
		'//resources/wikia/libraries/bootstrap/tooltip.js',
	]
];

$VenusConfig[ 'global_navigation_facebook_login_js' ] = [
	'type' => AssetsManager::TYPE_JS,
	'skin' => [ 'venus'],
	'assets' => [
		'//extensions/FBConnect/fbconnect.js',
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
