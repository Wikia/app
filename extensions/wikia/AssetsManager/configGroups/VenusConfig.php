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
		'//resources/wikia/modules/history.js',
		'//resources/wikia/modules/throbber.js',
		'//resources/wikia/modules/thumbnailer.js',
		'//resources/wikia/modules/window.js',
		'//resources/wikia/modules/abTest.js',
		'//resources/wikia/modules/underscore.js',
		'//resources/wikia/modules/stickyElement.js',

		//tracker
		'#group_tracker_js',

		//bucky
		'#group_bucky_js',

		// jquery libs
		'//resources/wikia/libraries/mustache/mustache.js',
		'//resources/wikia/libraries/mustache/jquery.mustache.js',
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
		'//extensions/wikia/Venus/scripts/variables.js',
		'//resources/wikia/modules/dom.js',

		// BackgroundChanger
		'//extensions/wikia/Venus/scripts/BackgroundChanger.js',

		//TODO adEngine is throwing errors in console, should be fixed as part of CON-1531
//		'#group_adengine2_js',

		'//resources/wikia/modules/browserDetect.js',
		'#group_imglzy_js',

		// support for video lightbox
		'//extensions/wikia/VideoHandlers/js/VideoBootstrap.js',

		// Lightbox
		'//extensions/wikia/Lightbox/scripts/LightboxLoader.js',
		'//extensions/wikia/Lightbox/scripts/venusLightboxLoader.js',

		//TOC
		'//extensions/wikia/TOC/js/modules/toc.js',
		'//resources/wikia/ui_components/dropdown_navigation/js/dropdownNavigation.templates.mustache.js',
		'//resources/wikia/ui_components/dropdown_navigation/js/dropdownNavigation.js',
		'//extensions/wikia/Venus/scripts/venusToc.js',

		// different article modules
		'//skins/shared/scripts/scrollableTables.js',

		//following script initialize different modules in Venus
		'//extensions/wikia/Venus/scripts/articleModulesLoader.js',
	]
];

$VenusConfig[ 'venus_head_js' ] = [
	'type' => AssetsManager::TYPE_JS,
	'skin' => ['venus'],
	'assets' => [
		'#group_abtesting',
		'//resources/wikia/modules/lazyqueue.js',
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
		'//extensions/wikia/LocalNavigation/scripts/LocalNavigationMenu.js',
		'//extensions/wikia/LocalNavigation/scripts/LocalNavigationTracking.js'
	]
];

/** GlobalFooter extension */
$VenusConfig[ 'global_footer_scss' ] = [
	'type' => AssetsManager::TYPE_SCSS,
	'skin' => [ 'venus' ],
	'assets' => [
		'//extensions/wikia/GlobalFooter/styles/GlobalFooter.scss',
		'//extensions/wikia/GlobalFooter/styles/GlobalFooterVenus.scss'
	]
];

/** GlobalNavigation extension */
$VenusConfig[ 'global_navigation_scss' ] = [
	'type' => AssetsManager::TYPE_SCSS,
	'skin' => [ 'venus', 'oasis' ],
	'assets' => [
		'//extensions/wikia/GlobalNavigation/styles/GlobalNavigation.scss',
		'//extensions/wikia/GlobalNavigation/styles/GlobalNavigationSearch.scss',
		'//extensions/wikia/GlobalNavigation/styles/GlobalNavigationAccountNavigation.scss',
		'//extensions/wikia/GlobalNavigation/styles/GlobalNavigationHubsMenu.scss',
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
		'//resources/wikia/modules/scrollToLink.js',
		'//skins/shared/scripts/transparent-out.js',
		'//extensions/wikia/Venus/scripts/variables.js',
		'//extensions/wikia/GlobalNavigation/scripts/GlobalNavigationiOSScrollFix.js',
		'//extensions/wikia/GlobalNavigation/scripts/GlobalNavigationScrollToLink.js',
		'//extensions/wikia/GlobalNavigation/scripts/GlobalNavigationTracking.js',
		'//extensions/wikia/GlobalNavigation/scripts/GlobalNavigationLazyLoad.js',
		'//extensions/wikia/GlobalNavigation/scripts/GlobalNavigationHubsMenu.js',
		'//extensions/wikia/GlobalNavigation/scripts/GlobalNavigationSearch.js',
		'//extensions/wikia/GlobalNavigation/scripts/SearchSuggestions.js',
		'//extensions/wikia/UserLogin/js/UserLoginDropdown.globalNavigation.js',
		'//extensions/wikia/UserLogin/js/UserLoginAjaxForm.js',
		'//extensions/wikia/WikiaStyleGuide/js/Form.js',
		'//resources/wikia/libraries/bootstrap/tooltip.js'
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

$VenusConfig[ 'article_navigation_js' ] = [
	'type' => AssetsManager::TYPE_JS,
	'skin' => [ 'venus' ],
	'assets' => [
		'//extensions/wikia/ArticleNavigation/scripts/articleNavigation.js',
		'//extensions/wikia/ArticleNavigation/scripts/articleNavigationHelper.js'
	]
];

$VenusConfig[ 'article_navigation_scss' ] = [
	'type' => AssetsManager::TYPE_SCSS,
	'skin' => [ 'venus' ],
	'assets' => [
		'//extensions/wikia/ArticleNavigation/styles/articleNavigation.scss'
	]
];

/** Article page */
$VenusConfig[ 'article_scss' ] = [
	'type' => AssetsManager::TYPE_SCSS,
	'skin' => [ 'venus' ],
	'assets' => [
		'//extensions/wikia/Venus/styles/article/article.scss',
		'//resources/wikia/ui_components/dropdown_navigation/css/dropdownNavigation.scss'
	]
];

$VenusConfig['imglzy_js'] = [
	'type' => AssetsManager::TYPE_JS,
	'assets' => [
		'//extensions/wikia/ImageLazyLoad/js/ImgLzy.module.js',
		'//extensions/wikia/ImageLazyLoad/js/ImageLazyLoad.js',
	]
];

