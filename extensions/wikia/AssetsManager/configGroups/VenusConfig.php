<?php

$VenusConfig = [];

$VenusConfig[ 'venus_body_js' ] = [
	'type' => AssetsManager::TYPE_JS,
	'skin' => [ 'venus' ],
	'assets' => [
		//libraries/frameworks
// TODO: This should be loaded here, but for some reason, it's already included
//		'//resources/wikia/libraries/modil/modil.js',
		'//resources/wikia/libraries/Ponto/ponto.js',
		'//resources/wikia/libraries/my.class/my.class.js',

		// jQuery 2.x migration layer
		'//resources/jquery/jquery-migrate-browser.js', // provide $.browser

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
		'//resources/wikia/modules/nodeFinder.js',

		//It's needs to be included like this.
		//If we include the group from config file AssetManager is loading nirvana twice
		'//resources/wikia/modules/uifactory.js',
		'//resources/wikia/modules/uicomponent.js',

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
		'//resources/wikia/libraries/jquery/jquery-migrate/jquery-migrate-1.2.1.min.js',

		// Wikia plugins
		'//resources/wikia/jquery.wikia.js',
		'//resources/wikia/libraries/jquery/carousel/jquery.wikia.carousel.js',
		'//resources/wikia/libraries/jquery/modal/jquery.wikia.modal.js',
		'//resources/wikia/libraries/jquery/expirystorage/jquery.expirystorage.js',
		'//resources/wikia/libraries/jquery/focusNoScroll/jquery.focusNoScroll.js',

		// libraries loaders
		'//resources/wikia/libraries/jquery/getResources/jquery.wikia.getResources.js',
		'//resources/wikia/libraries/jquery/loadLibrary/jquery.wikia.loadLibrary.js',
		'//resources/wikia/libraries/jquery/loadLibrary/jquery.wikia.loadExternalLibrary.js',

		//platform components
		'//extensions/wikia/JSMessages/js/JSMessages.js',
		'//extensions/wikia/JSSnippets/js/JSSnippets.js',
		'//extensions/wikia/AssetsManager/js/AssetsManager.js',

		'//extensions/wikia/WikiaStyleGuide/js/Form.js',
		'//extensions/wikia/UserLogin/js/UserLogin.js',
		'//extensions/wikia/UserLogin/js/UserLoginModal.js',

		'//extensions/wikia/Venus/scripts/isTouchScreen.js',
		'//extensions/wikia/Venus/scripts/tracking.js',
		'//extensions/wikia/Venus/scripts/layout.js',
		'//resources/wikia/modules/dom.js',
		'//resources/wikia/modules/arrayHelper.js',

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
		'//resources/wikia/ui_components/dropdown_navigation/js/dropdownNavigation.utils.js',
		'//resources/wikia/ui_components/dropdown_navigation/js/dropdownNavigation.js',
		'//extensions/wikia/Venus/scripts/venusToc.js',

		// different article modules
		'//skins/shared/scripts/scrollableTables.js',

		//following script initialize different modules in Venus
		'//extensions/wikia/Venus/scripts/articleModulesLoader.js',

		// MiniEditor
		'//extensions/wikia/MiniEditor/js/MiniEditor.js',

		// loaders for various extensions
		'//extensions/wikia/VideoEmbedTool/js/VET_Loader.js',

		// ArticleComment
		'#group_articlecomments_js',
	]
];

$VenusConfig[ 'venus_head_js' ] = [
	'type' => AssetsManager::TYPE_JS,
	'skin' => [ 'venus' ],
	'assets' => [
		'//resources/wikia/modules/lazyqueue.js',
	]
];

$VenusConfig[ 'venus_css' ] = [
	'type' => AssetsManager::TYPE_SCSS,
	'skin' => [ 'venus' ],
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

$VenusConfig[ 'local_navigation_js' ] = [
	'type' => AssetsManager::TYPE_JS,
	'skin' => [ 'venus', 'oasis' ],
	'assets' => [
		'//extensions/wikia/LocalNavigation/scripts/LocalNavigationMenu.js',
		'//extensions/wikia/LocalNavigation/scripts/LocalNavigationTracking.js',
		// TODO: should be lazy loaded CON-2169
		'//extensions/wikia/CreatePage/js/CreatePage.js',
	]
];

/** GlobalFooter extension */
$VenusConfig[ 'venus_global_footer_scss' ] = [
	'type' => AssetsManager::TYPE_SCSS,
	'skin' => [ 'venus' ],
	'assets' => [
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
		'//extensions/wikia/GlobalNavigation/styles/GlobalNavigationUserLoginDropdown.scss',
		'//extensions/wikia/GlobalNavigation/styles/GlobalNavigationNotifications.scss',
		'//extensions/wikia/GlobalNavigation/styles/GlobalNavigationInverse.scss',
		'//skins/shared/styles/transparent-out.scss'
	]
];

$VenusConfig[ 'global_navigation_js' ] = [
	'type' => AssetsManager::TYPE_JS,
	'skin' => [ 'venus', 'oasis' ],
	'assets' => [
		'#group_menu_aim_js',
		'#group_delayed_hover_js',
		'//resources/wikia/modules/scrollToLink.js',
		'//skins/shared/scripts/transparent-out.js',
		'//extensions/wikia/Venus/scripts/layout.js',
		'//extensions/wikia/GlobalNavigation/scripts/GlobalNavigationDropdownsHandler.js',
		'//extensions/wikia/GlobalNavigation/scripts/GlobalNavigationiOSScrollFix.js',
		'//extensions/wikia/GlobalNavigation/scripts/GlobalNavigationScrollToLink.js',
		'//extensions/wikia/GlobalNavigation/scripts/GlobalNavigationTracking.js',
		'//extensions/wikia/GlobalNavigation/scripts/GlobalNavigationLazyLoad.js',
		'//extensions/wikia/GlobalNavigation/scripts/GlobalNavigationHubsMenu.js',
		'//extensions/wikia/GlobalNavigation/scripts/GlobalNavigationSearch.js',
		'//extensions/wikia/GlobalNavigation/scripts/SearchSuggestions.js',
		'//extensions/wikia/GlobalNavigation/scripts/GlobalNavigationInverseTransition.js',
		'//extensions/wikia/GlobalNavigation/scripts/GlobalNavigationAccountNavigation.js',
		'//extensions/wikia/UserLogin/js/UserBaseAjaxForm.js',
		'//extensions/wikia/UserLogin/js/UserLoginAjaxForm.js',
		'//resources/wikia/libraries/bootstrap/tooltip.js'
	]
];

$VenusConfig['wall_notifications_global_navigation_js'] = [
	'type' => AssetsManager::TYPE_JS,
	'skin' => ['oasis', 'venus'],
	'assets' => [
		'//extensions/wikia/GlobalNavigation/scripts/GlobalNavigationNotifications.js',
	]
];


$VenusConfig[ 'global_navigation_facebook_login_js' ] = [
	'type' => AssetsManager::TYPE_JS,
	'skin' => [ 'venus' ],
	'assets' => [
		'//extensions/wikia/UserLogin/js/UserBaseAjaxForm.js',
		'//extensions/wikia/UserLogin/js/FacebookLogin.js',
		'//extensions/wikia/UserLogin/js/mixins/UserSignup.mixin.js',
		'//extensions/wikia/UserLogin/js/FacebookFormConnectUser.js',
		'//extensions/wikia/UserLogin/js/FacebookFormCreateUser.js',
	]
];

$VenusConfig[ 'article_navigation_js' ] = [
	'type' => AssetsManager::TYPE_JS,
	'skin' => [ 'venus' ],
	'assets' => [
		'#group_banner_notifications_js',
		'//extensions/wikia/UserTools/scripts/UserTools.js',
		'//extensions/wikia/ArticleNavigation/scripts/articleNavUserTools.js',
		'//extensions/wikia/ArticleNavigation/scripts/edit.js',
		'//extensions/wikia/ArticleNavigation/scripts/sticky.js',
		'//extensions/wikia/ArticleNavigation/scripts/share.js',
		'//extensions/wikia/ArticleNavigation/scripts/init.js',
	]
];

$VenusConfig[ 'article_js' ] = [
	'type' => AssetsManager::TYPE_JS,
	'skin' => [ 'venus' ],
	'assets' => [
		'//extensions/wikia/UserLogin/js/UserLoginModal.js'
	]
];

$VenusConfig[ 'article_navigation_scss' ] = [
	'type' => AssetsManager::TYPE_SCSS,
	'skin' => [ 'venus' ],
	'assets' => [
		'//extensions/wikia/ArticleNavigation/styles/articleNavigation.scss',
		'//extensions/wikia/UserTools/styles/UserTools.scss'
	]
];

/** Videos module */
$VenusConfig[ 'videos_module_venus_scss' ] = [
	'type' => AssetsManager::TYPE_SCSS,
	'skin' => [ 'venus' ],
	'assets' => [
		'//extensions/wikia/VideosModule/styles/VideosModuleVenus.scss'
	]
];

$VenusConfig[ 'recommendations_view_js' ] = [
	'type' => AssetsManager::TYPE_JS,
	'skin' => [ 'venus' ],
	'assets' => [
		'//extensions/wikia/Recommendations/scripts/view.js',
		'//extensions/wikia/Recommendations/scripts/tracking.js',
		'//resources/wikia/modules/imageServing.js',
		'//resources/wikia/libraries/vignette/vignette.js'
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

$VenusConfig[ 'recent_wiki_activity_scss' ] = [
	'type' => AssetsManager::TYPE_SCSS,
	'skin' => [ 'venus' ],
	'assets' => [
		'//extensions/wikia/RecentWikiActivity/styles/RecentWikiActivity.scss',
	]
];

$VenusConfig[ 'recent_wiki_activity_js' ] = [
	'type' => AssetsManager::TYPE_JS,
	'skin' => [ 'venus' ],
	'assets' => [
		'//extensions/wikia/RecentWikiActivity/scripts/RecentWikiActivityTracking.js',
	]
];

$VenusConfig['imglzy_js'] = [
	'type' => AssetsManager::TYPE_JS,
	'assets' => [
		'//extensions/wikia/ImageLazyLoad/js/ImgLzy.module.js',
		'//extensions/wikia/ImageLazyLoad/js/ImageLazyLoad.js'
	]
];

/** CategorySelect extension */
$VenusConfig[ 'category_select_js' ] = [
	'type' => AssetsManager::TYPE_JS,
	'skin' => [ 'venus' ],
	'assets' => [
		'//extensions/wikia/CategorySelect/js/CategorySelect.view.js',
		'//resources/wikia/libraries/bootstrap/tooltip.js',
		'//resources/wikia/libraries/bootstrap/popover.js',
	]
];

$VenusConfig[ 'category_select_css' ] = [
	'type' => AssetsManager::TYPE_SCSS,
	'skin' => [ 'venus' ],
	'assets' => [
		'//extensions/wikia/CategorySelect/css/CategorySelectVenus.scss',
	]
];

$VenusConfig['zenbox_js'] = [
	'type' => AssetsManager::TYPE_JS,
	'assets' => [
		'//extensions/wikia/Zenbox/scripts/zenbox.js',
	]
];


$VenusConfig['venus_preview_js'] = [
	'type' => AssetsManager::TYPE_JS,
	'assets' => [
		'//resources/wikia/libraries/modil/modil.js',
		'//resources/wikia/modules/window.js',
		'//resources/wikia/modules/location.js',
		'//resources/jquery/jquery-2.1.1.js',
		'//resources/wikia/libraries/jquery/throttle-debounce/jquery.throttle-debounce.js',
		'//resources/wikia/modules/querystring.js',
		'//resources/wikia/modules/browserDetect.js',
		'//resources/wikia/modules/log.js',
		'//extensions/wikia/ImageLazyLoad/js/ImgLzy.module.js',
		'//extensions/wikia/ImageLazyLoad/js/ImageLazyLoad.js',
	]
];

$VenusConfig[ 'related_forum_discussion_css' ] = [
	'type' => AssetsManager::TYPE_SCSS,
	'skin' => [ 'venus' ],
	'assets' => [
		'//extensions/wikia/Forum/css/venus/RelatedForumDiscussion.scss',
	]
];
