<?php

$config = [];

/********* Shared libraries and assets ********/

$config['oasis_shared_core_js'] = [
	'type' => AssetsManager::TYPE_JS,
	'assets' => [
		'//resources/wikia/libraries/sloth/sloth.js',
		'//resources/wikia/libraries/mustache/mustache.js',
		'//resources/wikia/modules/browserDetect.js',
		'//resources/mediawiki/mediawiki.Uri.js',
		'#group_banner_notifications_js',
		'#group_ui_repo_api_js',
		// Parametrized links to category pages might be everywhere and we need to catch 'em all
		'#group_seo_tweaks_uncrawlable_urls',
	],
];

$config['oasis_extensions_js'] = [
	'type' => AssetsManager::TYPE_JS,
	'assets' => [
		'#group_oasis_noads_extensions_js',
		'#group_ui_repo_api_js',
	],
];

$config['tracker_js'] = [
	'type' => AssetsManager::TYPE_JS,
	'assets' => [
		'//resources/wikia/modules/tracker.stub.js',
		'//resources/wikia/modules/tracker.js',
	],
];

$config['recirculation_js'] = [
	'type' => AssetsManager::TYPE_JS,
	'skin' => [ 'oasis' ],
	'assets' => [
		'//resources/wikia/modules/eventLogger.js',
		'//resources/wikia/libraries/vignette/vignette.js',
		'//extensions/wikia/Recirculation/js/tracker.js',
		'//extensions/wikia/Recirculation/js/utils.js',
		'//extensions/wikia/Recirculation/js/helpers/DiscussionsHelper.js',
		'//extensions/wikia/Recirculation/js/helpers/sponsoredContent.js',
		'//extensions/wikia/Recirculation/js/helpers/recommendationBlacklist.js',
		'//extensions/wikia/Recirculation/js/helpers/recommendedContent.js',
		'//extensions/wikia/Recirculation/js/views/mixedFooter.js',
		'//extensions/wikia/Recirculation/js/recirculation.js',
		'//extensions/wikia/Recirculation/js/discussions.js',
	],
];

$config['recirculation_scss'] = [
	'type' => AssetsManager::TYPE_SCSS,
	'skin' => [ 'oasis' ],
	'assets' => [
		'//extensions/wikia/Recirculation/styles/recirculation.scss',
	],
];

$config['spotlights_js'] = [
	'type' => AssetsManager::TYPE_JS,
	'assets' => [
		// ads
		'//extensions/wikia/Spotlights/js/AdProviderOpenX.js',
		'//extensions/wikia/Spotlights/js/LazyLoadAds.js',
	],
];

$config['tracking_opt_in_js'] = [
	'skin' => [ 'oasis' ],
	'type' => AssetsManager::TYPE_JS,
	'assets' => [
		'//extensions/wikia/TrackingOptIn/dist/tracking-opt-in.min.js',
		'//extensions/wikia/TrackingOptIn/js/trackingOptIn.js',
	],
];

$config['adengine3_top_js'] = [
	'type' => AssetsManager::TYPE_JS,
	'skin' => [ 'oasis' ],
	'assets' => [
		'//extensions/wikia/AdEngine3/dist/ads.js',
		'//extensions/wikia/AdEngine3/module.js'
	],
];
$config['adengine3_dev_top_js'] = [
	'type' => AssetsManager::TYPE_JS,
	'skin' => [ 'oasis' ],
	'assets' => [
		'//extensions/wikia/AdEngine3/dist-dev/ads.js',
		'//extensions/wikia/AdEngine3/alert.js',
		'//extensions/wikia/AdEngine3/module.js'
	],
];

$config['oasis_noads_extensions_js'] = [
	'type' => AssetsManager::TYPE_JS,
	'assets' => [
		'#group_bucky_js',
		'#group_design_system_js',
		'//resources/wikia/libraries/jquery/ellipses.js',
		'//extensions/wikia/CreatePage/js/CreatePage.js',
		'//extensions/wikia/VideoHandlers/js/VideoBootstrap.js',
		'//extensions/wikia/Lightbox/scripts/LightboxLoader.js',
		'#group_imglzy_js',
		'//extensions/wikia/MiniEditor/js/MiniEditor.js',
		// needs to load after MiniEditor
		'#group_articlecomments_js',

		// This needs to load last after all common extensions, please keep this last.
		'//skins/oasis/js/GlobalModal.js',
		'//extensions/wikia/UserLogin/js/UserLogin.js',
		// WikiaBar is enabled sitewide
		'//extensions/wikia/WikiaBar/js/WikiaBar.js',
		// Chat is enabled sitewide
		'//extensions/wikia/Chat2/js/ChatWidget.js',
		'//extensions/wikia/VideoEmbedTool/js/VET_Loader.js',
		// Image and video thumbnail mustache templates
		'//extensions/wikia/Thumbnails/scripts/templates.mustache.js',
		'//extensions/wikia/JSSnippets/js/JSSnippets.js',
	],
];

/**
 * Scripts that are needed very early in execution and thus are worth blocking for.
 *
 * Keep this group small!
 **/

$config['oasis_blocking'] = [
	'type' => AssetsManager::TYPE_JS,
	'assets' => [
		'//resources/wikia/modules/lazyqueue.js',
	],
];

$config['abtesting'] = [
	'type' => AssetsManager::TYPE_JS,
	'skin' => [ 'oasis', 'wikiamobile' ],
	'assets' => [
		'//extensions/wikia/AbTesting/js/AbTest.js',
	],
];

/** jQuery **/
$config['jquery'] = [
	'type' => AssetsManager::TYPE_JS,
	'assets' => [
		'#function_AssetsConfig::getJQueryUrl',
	],
];

$config['oasis_jquery'] = [
	'type' => AssetsManager::TYPE_JS,
	'assets' => [
		// polyfills
		'//resources/wikia/polyfills/jquery.wikia.placeholder.js',
		'//resources/wikia/polyfills/array.js',

		// 3rd party plugins
		'//resources/wikia/libraries/jquery/getcss/jquery.getcss.js',
		'//resources/wikia/libraries/jquery/cookies/jquery.cookies.2.1.0.js',
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
		'//resources/wikia/libraries/jquery/loadLibrary/jquery.wikia.loadExternalLibrary.js',
		'//skins/oasis/js/isTouchScreen.js',

		// jQuery/Oasis specific code
		'//skins/oasis/js/tables.js',

		// BackgroundChanger
		'//skins/oasis/js/BackgroundChanger.js',

		// Search A/B testing
		'//extensions/wikia/Search/js/SearchAbTest.DomUpdater.js',
		'//extensions/wikia/Search/js/SearchAbTest.Context.js',
		'//extensions/wikia/Search/js/SearchAbTest.js',

		// Article length & screen width tracking
		'//skins/oasis/js/ArticleLengthAbTesting.js',

		// rail
		'#group_rail_js',

		'#group_page_share_js',
	],
];

/******** Skins *******/

/** Oasis **/

// core shared JS - used as part of oasis_shared_js_anon or oasis_shared_js_user.
// See BugzId 38541 for details on why it's better to have these 2 different packages!
// (short version: less HTTP requests is more important than optimizing page-weight of the single page after you log in/out)
$config['oasis_shared_js'] = [
	'type' => AssetsManager::TYPE_JS,
	'assets' => [
		// shared libraries
		'#group_oasis_jquery',
		'#group_oasis_nojquery_shared_js',
		'#group_oasis_extensions_js',
	],
];

$config['oasis_nojquery_shared_js_user'] = [
	'type' => AssetsManager::TYPE_JS,
	'assets' => [
		'#group_oasis_nojquery_shared_js',
		// the only time this group is used currently is inside of this _nojquery_ package, for Ad-Loading experiment
		'#group_oasis_noads_extensions_js',
		'#group_oasis_user_js',
	],
];

$config['oasis_nojquery_shared_js_anon'] = [
	'type' => AssetsManager::TYPE_JS,
	'assets' => [
		'#group_oasis_nojquery_shared_js',
		// the only time this group is used currently is inside of this _nojquery_ package, for Ad-Loading experiment
		'#group_oasis_noads_extensions_js',
		'#group_oasis_anon_js',
	],
];

$config['oasis_nojquery_shared_js'] = [
	'type' => AssetsManager::TYPE_JS,
	'assets' => [

		// shared libraries
		'//extensions/wikia/AssetsManager/js/AssetsManager.js',
		'//extensions/wikia/JSMessages/js/JSMessages.js',
		'//extensions/wikia/CategorySelect/js/CategorySelect.view.js',
		'//extensions/wikia/WikiaStyleGuide/js/Form.js',
		'//resources/wikia/modules/csspropshelper.js',
		'//resources/wikia/modules/fluidlayout.js',
		'//resources/wikia/modules/breakpointsLayout.js',

		// oasis specific files
		'//resources/wikia/libraries/bootstrap/tooltip.js',
		'//resources/wikia/libraries/bootstrap/popover.js',
		'//skins/oasis/js/Search.js',
		'//skins/oasis/js/WikiaFooter.js',
		'//skins/oasis/js/buttons.js',
		'//skins/oasis/js/WikiaNotifications.js',
		'//skins/oasis/js/FirefoxFindFix.js',
		'//skins/oasis/js/tabs.js',
		'//skins/oasis/js/Tracking.js',

		'//skins/shared/scripts/onScroll.js',

		'//extensions/wikia/UserTools/scripts/UserTools.js',
	],
];

//anon JS
// Note: Owen moved getSiteJS call from both anon_js and user_js to OasisController::loadJS
// so that common.js is loaded last so it has less chance of breaking other things
$config['oasis_anon_js'] = [
	'type' => AssetsManager::TYPE_JS,
	'assets' => [
		'#group_user_login_js_anon',
		'//skins/oasis/js/LatestActivity.js',
	],
];

$config['user_login_js_anon'] = [
	'type' => AssetsManager::TYPE_JS,
	'skin' => [ 'oasis' ],
	'assets' => [
		'//extensions/wikia/UserLogin/js/MarketingOptIn.js',
		'//extensions/wikia/UserLogin/js/UserBaseAjaxForm.js',
		'//extensions/wikia/UserLogin/js/mixins/UserSignup.mixin.js',
		'//extensions/wikia/UserLogin/js/UserSignupAjaxValidation.js',
		'//extensions/wikia/UserLogin/js/UserLoginAjaxForm.js',
		'//extensions/wikia/UserLogin/js/UserLoginModal.js',
	],
];

/**
 * We allow logged in users to create account without logging out
 */
$config['user_signup_js'] = [
	'type' => AssetsManager::TYPE_JS,
	'assets' => [
		'//extensions/wikia/UserLogin/js/UserSignupAjaxValidation.js',
		'//extensions/wikia/UserLogin/js/MarketingOptIn.js',
		'//extensions/wikia/UserLogin/js/mixins/UserSignup.mixin.js',
		'//extensions/wikia/UserLogin/js/UserSignup.js',
	],
];

/**
 * For logged in users in oasis
 */
$config['oasis_user_js'] = [
	'type' => AssetsManager::TYPE_JS,
	'assets' => [
		'#group_design_system_user_js',
	],
];

/** GameGuides */
$config['gameguides_scss'] = [
	'type' => AssetsManager::TYPE_SCSS,
	'skin' => 'wikiamobile',
	'assets' => [
		'//extensions/wikia/GameGuides/css/GameGuides.scss',
	],
];

//this combines couple of WikiaMobile groups to make it possible to load all js via one request
//also unfortunately loads bit more than needed not to change WikiaMobile assets too much
$config['gameguides_js'] = [
	'type' => AssetsManager::TYPE_JS,
	'skin' => 'wikiamobile',
	'assets' => [
		'//extensions/wikia/GameGuides/js/initGameGuides.js',
		'//extensions/wikia/WikiaMobile/js/html_js_class.js',

		//libraries/frameworks
		'//resources/wikia/libraries/modil/modil.js',
		'//resources/jquery/jquery-2.0.3.js',
		'//resources/wikia/libraries/Ponto/ponto.js',

		//core modules
		'//resources/wikia/modules/window.js',
		'//resources/wikia/modules/location.js',
		'//resources/wikia/modules/nirvana.js',
		'//resources/wikia/modules/loader.js',
		'//resources/wikia/modules/querystring.js',
		'//resources/wikia/modules/history.js',
		'//resources/wikia/modules/log.js',

		//tracker
		'#group_tracker_js',
		'//extensions/wikia/JSMessages/js/JSMessages.js',

		//platform components
		'//extensions/wikia/JSSnippets/js/JSSnippets.js',

		//feature detection
		'//extensions/wikia/WikiaMobile/js/features.js',
		'//extensions/wikia/WikiaMobile/js/feature-detects/positionfixed.wikiamobile.js',
		'//extensions/wikia/WikiaMobile/js/feature-detects/overflow.wikiamobile.js',
		'//extensions/wikia/GameGuides/js/isGameGuides.js',

		//polyfills
		'//extensions/wikia/WikiaMobile/js/viewport.js',
		'//resources/wikia/libraries/iScroll/iscroll.js',

		//groups
		'#group_wikiamobile_tables_js',
		'#group_wikiamobile_mediagallery_js',

		//video
		'//extensions/wikia/VideoHandlers/js/VideoBootstrap.js',

		//modules
		'//resources/wikia/modules/thumbnailer.js',
		'//resources/wikia/libraries/sloth/sloth.js',
		'//extensions/wikia/WikiaMobile/js/toc.js',
		'//extensions/wikia/WikiaMobile/js/lazyload.js',
		'//extensions/wikia/WikiaMobile/js/track.js',
		'//extensions/wikia/WikiaMobile/js/events.js',
		'//extensions/wikia/WikiaMobile/js/throbber.js',
		'//extensions/wikia/WikiaMobile/js/toast.js',
		'//extensions/wikia/WikiaMobile/js/pager.js',
		'//extensions/wikia/WikiaMobile/js/modal.js',
		'//extensions/wikia/WikiaMobile/js/media.class.js',
		'//extensions/wikia/WikiaMobile/js/media.js',
		'//extensions/wikia/WikiaMobile/js/sections.js',
		'//extensions/wikia/WikiaMobile/js/layout.js',

		//entrypoint
		'//extensions/wikia/WikiaMobile/js/WikiaMobile.js',
		'//extensions/wikia/GameGuides/js/GameGuides.js',
	],
];

/** WikiaMobile **/
$config['wikiamobile_scss'] = [
	'type' => AssetsManager::TYPE_SCSS,
	'skin' => 'wikiamobile',
	'assets' => [
		'//extensions/wikia/WikiaMobile/css/WikiaMobile.scss',
	],
];

$config['wikiamobile_404_scss'] = [
	'type' => AssetsManager::TYPE_SCSS,
	'skin' => 'wikiamobile',
	'assets' => [
		'//extensions/wikia/WikiaMobile/css/404.scss',
	],
];

$config['wikiamobile_404_js'] = [
	'type' => AssetsManager::TYPE_JS,
	'skin' => 'wikiamobile',
	'assets' => [
		'//extensions/wikia/WikiaMobile/js/404.js',
	],
];

//loaded at the bottom of the page in the body section
$config['wikiamobile_js_body_minimal'] = [
	'type' => AssetsManager::TYPE_JS,
	'skin' => 'wikiamobile',
	'assets' => [
		//libraries/frameworks
		'//resources/wikia/libraries/modil/modil.js',
		'//resources/jquery/jquery-2.0.3.js',

		//core modules
		'//resources/wikia/modules/window.js',
		'//resources/wikia/modules/document.js',
		'//resources/wikia/modules/location.js',
		'//resources/wikia/modules/querystring.js',
		'//resources/wikia/modules/history.js',
		'//resources/wikia/modules/cookies.js',
		//depends on querystring.js and cookies.js
		'//resources/wikia/modules/log.js',
		'//resources/wikia/modules/abTest.js',
		'//resources/wikia/modules/geo.js',

		//feature detection
		'//extensions/wikia/WikiaMobile/js/features.js',
		'//extensions/wikia/WikiaMobile/js/feature-detects/positionfixed.wikiamobile.js',

		//tracker
		'#group_tracker_js',

		// performance
		'#group_bucky_js',

		//modules
		'//resources/wikia/modules/nirvana.js',
		'//resources/wikia/modules/loader.js',
		'//resources/wikia/modules/cache.js',

		// video
		'//extensions/wikia/VideoHandlers/js/VideoBootstrap.js',
	],
];

//loaded at the bottom of the page in the body section
$config['wikiamobile_js_body_full'] = [
	'type' => AssetsManager::TYPE_JS,
	'skin' => 'wikiamobile',
	'assets' => [
		'#group_wikiamobile_js_body_minimal',

		//feature detection
		'//extensions/wikia/WikiaMobile/js/feature-detects/overflow.wikiamobile.js',

		//polyfills
		'//extensions/wikia/WikiaMobile/js/viewport.js',

		//libraries
		'//resources/wikia/libraries/iScroll/iscroll.js',
		'//extensions/wikia/WikiaMobile/js/webview.js',

		//platform components
		'//extensions/wikia/AssetsManager/js/AssetsManager.js',
		'//extensions/wikia/JSMessages/js/JSMessages.js',
		'//extensions/wikia/JSSnippets/js/JSSnippets.js',

		//modules
		'//resources/wikia/libraries/mustache/mustache.js',
		'//resources/wikia/libraries/sloth/sloth.js',
		'//resources/wikia/modules/thumbnailer.js',
		'//extensions/wikia/WikiaMobile/js/lazyload.js',
		'//extensions/wikia/WikiaMobile/js/track.js',
		'//extensions/wikia/WikiaMobile/js/infobox.js',
		'//extensions/wikia/WikiaMobile/js/events.js',
		'//extensions/wikia/WikiaMobile/js/topbar.js',
		'//extensions/wikia/WikiaMobile/js/sections.js',
		'//extensions/wikia/WikiaMobile/js/throbber.js',
		'//extensions/wikia/WikiaMobile/js/toast.js',
		'//extensions/wikia/WikiaMobile/js/pager.js',
		'//extensions/wikia/WikiaMobile/js/modal.js',
		'//extensions/wikia/WikiaMobile/js/media.class.js',
		'//extensions/wikia/WikiaMobile/js/media.js',
		'//extensions/wikia/WikiaMobile/js/layout.js',
		'//extensions/wikia/WikiaMobile/js/navigation.wiki.js',
		'//extensions/wikia/WikiaMobile/js/curtain.js',

		//entrypoint
		'//extensions/wikia/WikiaMobile/js/WikiaMobile.js',
	],
];

$config['wikiamobile_js_preview'] = [
	'type' => AssetsManager::TYPE_JS,
	'skin' => 'wikiamobile',
	'assets' => [
		'#group_wikiamobile_js_body_full',
	],
];

$config['wikiamobile_scss_preview'] = [
	'type' => AssetsManager::TYPE_SCSS,
	'skin' => 'wikiamobile',
	'assets' => [
		'//extensions/wikia/WikiaMobile/css/WikiaMobile.preview.scss',
	],
];

$config['wikiamobile_js_toc'] = [
	'type' => AssetsManager::TYPE_JS,
	'skin' => 'wikiamobile',
	'assets' => [
		'//extensions/wikia/TOC/js/modules/toc.js',
		'//extensions/wikia/WikiaMobile/js/toc.js',
	],
];

$config['wikiamobile_scss_toc'] = [
	'type' => AssetsManager::TYPE_SCSS,
	'skin' => 'wikiamobile',
	'assets' => [
		'//extensions/wikia/WikiaMobile/css/toc.scss',
	],
];

//mustache is generic but currently only used by smartbanner move if needed
$config['wikiamobile_smartbanner_js'] = [
	'type' => AssetsManager::TYPE_JS,
	'skin' => 'wikiamobile',
	'assets' => [
		'//resources/wikia/libraries/mustache/mustache.js',
		'//extensions/wikia/WikiaMobile/SmartBanner/smartbanner.js',
	],
];

$config['wikiamobile_smartbanner_init_js'] = [
	'type' => AssetsManager::TYPE_JS,
	'skin' => 'wikiamobile',
	'assets' => [
		'//extensions/wikia/WikiaMobile/SmartBanner/smartbanner.bootstrap.js',
	],
];

$config['wikiamobile_tables_js'] = [
	'type' => AssetsManager::TYPE_JS,
	'skin' => 'wikiamobile',
	'assets' => [
		'//extensions/wikia/WikiaMobile/js/tables.js',
	],
];

$config['mobile_base_ads_js'] = [
	'type' => AssetsManager::TYPE_JS,
	'skin' => 'wikiamobile',
	'assets' => [
		// Modules
		'//resources/wikia/modules/domCalculator.js',
		'//resources/wikia/modules/lazyqueue.js',
		'//resources/wikia/modules/iframeWriter.js',
		'//resources/wikia/modules/throttle.js',
		'//resources/wikia/modules/viewportObserver.js',
	],
];

$config['mercury_ads_js'] = [
	'type' => AssetsManager::TYPE_JS,
	'assets' => [
		// Common modules
		'//resources/wikia/libraries/modil/modil.js',
		'#group_tracker_js',
		'//resources/wikia/modules/log.js',
		'//resources/wikia/modules/window.js',
		'//resources/wikia/modules/browserDetect.js',
		'//resources/wikia/modules/document.js',
		'//resources/wikia/modules/location.js',
		'//resources/wikia/modules/querystring.js',
		'//resources/wikia/modules/history.js',
		'//resources/wikia/modules/cookies.js',
		'//resources/wikia/modules/geo.js',

		'#group_mobile_base_ads_js',
		'//resources/wikia/modules/cache.js',

		// Advertisement libs
		'//extensions/wikia/AbTesting/js/AbTest.js',
		'//resources/wikia/modules/abTest.js',
		'#group_jwplayer_mobile_featured_video_ads_js',
	],
];

$config['wikiamobile_ads_js'] = [
	'type' => AssetsManager::TYPE_JS,
	'skin' => 'wikiamobile',
	'assets' => [
		'#group_mobile_base_ads_js',

	],
];

$config['wikiamobile_mediagallery_js'] = [
	'type' => AssetsManager::TYPE_JS,
	'skin' => 'wikiamobile',
	'assets' => [
		'//extensions/wikia/WikiaMobile/js/mediagallery.js',
	],
];

$config['wikiamobile_autocomplete_js'] = [
	'type' => AssetsManager::TYPE_JS,
	'skin' => 'wikiamobile',
	'assets' => [
		'//extensions/wikia/WikiaMobile/js/autocomplete.js',
	],
];

$config['wikiamobile_usersignup_scss'] = [
	'type' => AssetsManager::TYPE_SCSS,
	'skin' => 'wikiamobile',
	'assets' => [
		'//extensions/wikia/UserLogin/css/UserSignup.wikiamobile.scss',
	],
];

$config['wikiamobile_usersignup_js'] = [
	'type' => AssetsManager::TYPE_JS,
	'skin' => 'wikiamobile',
	'assets' => [
		'//resources/wikia/libraries/bootstrap/tooltip.js',
		'//extensions/wikia/WikiaStyleGuide/js/Form.js',
		'//extensions/wikia/UserLogin/js/UserSignupAjaxValidation.js',
		'//extensions/wikia/UserLogin/js/MarketingOptIn.js',
		'//extensions/wikia/UserLogin/js/mixins/UserSignup.mixin.js',
		'//extensions/wikia/UserLogin/js/UserSignup.js',
	],
];

$config['wikiamobile_categorypage_js'] = [
	'type' => AssetsManager::TYPE_JS,
	'skin' => 'wikiamobile',
	'assets' => [
		'//extensions/wikia/WikiaMobile/js/category_page.js',
	],
];

$config['special_contact_wikiamobile_scss'] = [
	'type' => AssetsManager::TYPE_SCSS,
	'skin' => 'wikiamobile',
	'assets' => [
		'//extensions/wikia/SpecialContact2/SpecialContact.wikiamobile.scss',
	],
];

$config['special_contact_wikiamobile_js'] = [
	'type' => AssetsManager::TYPE_JS,
	'skin' => 'wikiamobile',
	'assets' => [
		'//extensions/wikia/SpecialContact2/SpecialContact.wikiamobile.js',
	],
];

/********** Extensions packages **********/

/** Article Comments **/
$config['articlecomments_js'] = [
	'type' => AssetsManager::TYPE_JS,
	'skin' => [ 'oasis' ],
	'assets' => [
		'//extensions/wikia/ArticleComments/js/ArticleComments.js',
	],
];

$config['articlecomments_scss'] = [
	'type' => AssetsManager::TYPE_SCSS,
	'skin' => 'oasis',
	'assets' => [
		'//skins/oasis/css/core/ArticleComments.scss',
	],
];

$config['articlecomments_mini_editor_scss'] = [
	'type' => AssetsManager::TYPE_SCSS,
	'skin' => 'oasis',
	'assets' => [
		'#group_articlecomments_scss',
		'//extensions/wikia/MiniEditor/css/MiniEditor.scss',
		'//extensions/wikia/MiniEditor/css/ArticleComments/ArticleComments.scss',
	],
];

$config['filepage_js_wikiamobile'] = [
	'type' => AssetsManager::TYPE_JS,
	'skin' => 'wikiamobile',
	'assets' => [
		'//extensions/wikia/FilePage/scripts/FilePage.wikiamobile.js',
	],
];

$config['filepage_scss_wikiamobile'] = [
	'type' => AssetsManager::TYPE_SCSS,
	'skin' => 'wikiamobile',
	'assets' => [
		'//extensions/wikia/FilePage/css/FilePage.wikiamobile.scss',
	],
];

$config['relatedpages_wikiamobile_js'] = [
	'type' => AssetsManager::TYPE_JS,
	'skin' => [ 'wikiamobile' ],
	'assets' => [
		'//extensions/wikia/RelatedPages/js/relatedPages.wikiamobile.js',
	],
];

/** EditPageLayout **/
$config['editpage_events_js'] = [
	'type' => AssetsManager::TYPE_JS,
	'assets' => [
		'//extensions/wikia/EditPreview/js/editpage.event.preview.js',
		'//extensions/wikia/EditPreview/js/editpage.event.diff.js',
		'//extensions/wikia/EditPreview/js/editpage.event.helper.js',
		'//extensions/wikia/EditPreview/js/editpage.events.js',
	],
];

$config['editpage_common_js'] = [
	'type' => AssetsManager::TYPE_JS,
	'assets' => [
		'//extensions/wikia/EditPageLayout/js/loaders/EditPageEditorLoader.js',
		'//extensions/wikia/EditPreview/js/preview.js',
		'#group_editpage_events_js',
		'#group_design_system_js',
	],
];

$config['rte'] = [
	'type' => AssetsManager::TYPE_JS,
	'assets' => [
		'#function_AssetsConfig::getRTEAssets',
	],
];
// Generic edit page JavaScript
$config['epl'] = [
	'type' => AssetsManager::TYPE_JS,
	'assets' => [
		'#group_editpage_common_js',
		'#function_AssetsConfig::getEPLAssets',
	],
];
// Generic edit page JavaScript + reskined rich text editor
$config['eplrte'] = [
	'type' => AssetsManager::TYPE_JS,
	'assets' => [
		'#group_epl',
		'#group_rte',
	],
];

/** Ace Editor **/
$config['ace_editor_js'] = [
	'type' => AssetsManager::TYPE_JS,
	'assets' => [
		'#group_editpage_common_js',
		'#group_ace_editor_plugins_js',
		'//resources/wikia/libraries/Ace/wikia.ace.editor.js',
		'//extensions/wikia/EditPageLayout/js/editor/AceEditor.js',
	],
];

$config['ace_editor_plugins_js'] = [
	'type' => AssetsManager::TYPE_JS,
	'assets' => [
		'//extensions/wikia/EditPageLayout/js/editor/WikiaEditor.js',
		'//extensions/wikia/EditPageLayout/js/plugins/Noticearea.js',
	],
];

/** MiniEditor **/
$config['mini_editor_js'] = [
	'type' => AssetsManager::TYPE_JS,
	'assets' => [
		// MediaWiki Edit stack
		'//resources/jquery/jquery.byteLimit.js',
		'//resources/jquery/jquery.textSelection.js',
		'//resources/mediawiki.action/mediawiki.action.edit.js',
		// Edit Page Layout
		'//extensions/wikia/EditPageLayout/js/editor/WikiaEditor.js',
		'//extensions/wikia/EditPageLayout/js/editor/WikiaEditorStorage.js',
		'//extensions/wikia/EditPageLayout/js/editor/Buttons.js',
		'//extensions/wikia/EditPageLayout/js/editor/Modules.js',
		'//extensions/wikia/EditPageLayout/js/plugins/MiniEditor.js',
		'//extensions/wikia/EditPageLayout/js/plugins/Tracker.js',
		'//extensions/wikia/EditPageLayout/js/plugins/Collapsiblemodules.js',
		'//extensions/wikia/EditPageLayout/js/plugins/Cssloadcheck.js',
		'//extensions/wikia/EditPageLayout/js/plugins/Edittools.js',
		'//extensions/wikia/EditPageLayout/js/plugins/Loadingstatus.js',
		'//extensions/wikia/EditPageLayout/js/extras/Buttons.js',
		'//extensions/wikia/EditPageLayout/js/modules/Container.js',
		'//extensions/wikia/EditPageLayout/js/modules/ButtonsList.js',
		'//extensions/wikia/EditPageLayout/js/modules/FormatMiniEditor.js',
		'//extensions/wikia/EditPageLayout/js/modules/FormatMiniEditorSource.js',
		'//extensions/wikia/EditPageLayout/js/modules/Insert.js',
		'//extensions/wikia/EditPageLayout/js/modules/InsertMiniEditor.js',
		'//extensions/wikia/EditPageLayout/js/modules/ModeSwitch.js',
		// Photo and Video tools
		'//extensions/wikia/WikiaPhotoGallery/js/WikiaPhotoGallery.js',
		'//extensions/wikia/WikiaMiniUpload/js/WMU.js',
		// Third Party
		'//resources/jquery.ui/jquery.ui.core.js',
		'//resources/jquery.ui/jquery.ui.widget.js',
		'//resources/jquery.ui/jquery.ui.position.js',
		'//resources/jquery.ui/jquery.ui.autocomplete.js',
		'//resources/wikia/libraries/mustache/mustache.js',
	],
];

$config['mini_editor_rte_js'] = [
	'type' => AssetsManager::TYPE_JS,
	'assets' => [
		'#group_mini_editor_js',
		'#group_rte',
	],
];

$config['chat_js2'] = [
	'type' => AssetsManager::TYPE_JS,
	'assets' => [
		'#group_oasis_jquery',
		'#group_oasis_shared_core_js',
		'//skins/shared/scripts/onScroll.js',

		// shared libraries
		'//extensions/wikia/AssetsManager/js/AssetsManager.js',

		'//resources/wikia/modules/querystring.js',
		'//resources/wikia/modules/history.js',
		'//resources/wikia/modules/cookies.js',
		//depends on querystring.js and cookies.js
		'//resources/wikia/modules/log.js',

		//'//extensions/wikia/Chat2/js/lib/socket.io.client.js',
		// must be before controllers.js
		'//extensions/wikia/Chat2/js/emoticons.js',
		'//extensions/wikia/Chat2/js/lib/underscore.js',
		'//extensions/wikia/Chat2/js/lib/backbone.js',
		'//extensions/wikia/Chat2/js/models/models.js',
		'//extensions/wikia/Chat2/js/controllers/controllers.js',
		'//extensions/wikia/Chat2/js/views/views.js',
		'//extensions/wikia/Chat2/js/views/ChatBanModal.js',
	],
];

/** ThemeDesigner **/
$config['theme_designer_js'] = [
	'type' => AssetsManager::TYPE_JS,
	'assets' => [
		'#group_oasis_jquery',

		'//resources/jquery.ui/jquery.ui.widget.js',
		'//resources/jquery.ui/jquery.ui.mouse.js',
		'//resources/jquery.ui/jquery.ui.slider.js',
		'//resources/jquery.ui/jquery.ui.core.js',
		'//resources/wikia/modules/aim.js',
		'//resources/wikia/libraries/bootstrap/tooltip.js',
		'//resources/wikia/libraries/bootstrap/popover.js',
		'//resources/wikia/libraries/vignette/vignette.js',
		'//extensions/wikia/JSMessages/js/JSMessages.js',
		'//extensions/wikia/ThemeDesigner/js/ThemeDesigner.js',
	],
];

/** MessageWall **/
$config['wall_js'] = [
	'type' => AssetsManager::TYPE_JS,
	'assets' => [
		'//resources/wikia/libraries/jquery/autoresize/jquery.autoresize.js',
		'//resources/wikia/libraries/jquery/scrollto/jquery.scrollTo-1.4.2.js',
		'//extensions/wikia/Wall/js/Wall.js',
		'//extensions/wikia/Wall/js/WallPagination.js',
		'//extensions/wikia/Wall/js/WallBackendBridge.js',
		'//extensions/wikia/Wall/js/WallMessageForm.js',
		'//extensions/wikia/Wall/js/WallNewMessageForm.js',
		'//extensions/wikia/Wall/js/WallEditMessageForm.js',
		'//extensions/wikia/Wall/js/WallReplyMessageForm.js',
		'//extensions/wikia/Wall/js/WallSortingBar.js',
		'//extensions/wikia/Wall/js/WallSetup.js',
	],
];

$config['wall_notifications_js'] = [
	'type' => AssetsManager::TYPE_JS,
	'assets' => [
		'//extensions/wikia/WallNotifications/scripts/WallNotifications.js',
	],
];

$config['wall_mini_editor_js'] = [
	'type' => AssetsManager::TYPE_JS,
	'assets' => [
		'//extensions/wikia/MiniEditor/js/Wall/Wall.Setup.js',
		'//extensions/wikia/MiniEditor/js/Wall/Wall.Animations.js',
		'//extensions/wikia/MiniEditor/js/Wall/Wall.EditMessageForm.js',
		'//extensions/wikia/MiniEditor/js/Wall/Wall.NewMessageForm.js',
		'//extensions/wikia/MiniEditor/js/Wall/Wall.ReplyMessageForm.js',
	],
];

$config['wall_history_js'] = [
	'type' => AssetsManager::TYPE_JS,
	'assets' => [
		'//extensions/wikia/Wall/js/Wall.js',
		'//extensions/wikia/Wall/js/WallHistory.js',
		'//extensions/wikia/Wall/js/WallSortingBar.js',
	],
];

/** Forum **/
$config['forum_js'] = [
	'type' => AssetsManager::TYPE_JS,
	'assets' => [
//		'#group_wall_js',
		'//extensions/wikia/Forum/js/Forum.js',
		'//extensions/wikia/Forum/js/ForumNewMessageForm.js',
		'//extensions/wikia/Forum/js/ForumSortingBar.js',
	],
];

/** Wall MessageTopic (certain parts of Wall and Forum uses this) **/
$config['wall_topic_js'] = [
	'type' => AssetsManager::TYPE_JS,
	'assets' => [
		'//extensions/wikia/Wall/js/MessageTopic.js',
	],
];

$config['forum_mini_editor_js'] = [
	'type' => AssetsManager::TYPE_JS,
	'assets' => [
		'#group_wall_mini_editor_js',
		'//extensions/wikia/MiniEditor/js/Forum/Forum.Setup.js',
//		'//extensions/wikia/MiniEditor/js/Forum/Forum.Animations.js',
//		'//extensions/wikia/MiniEditor/js/Forum/Forum.EditMessageForm.js',
		'//extensions/wikia/MiniEditor/js/Forum/Forum.NewMessageForm.js',
//		'//extensions/wikia/MiniEditor/js/Forum/Forum.ReplyMessageForm.js'
	],
];

$config['VET_js'] = [
	'skin' => [ 'oasis' ],
	'type' => AssetsManager::TYPE_JS,
	'assets' => [
		'//extensions/wikia/WikiaStyleGuide/js/Dropdown.js',
		'//extensions/wikia/VideoEmbedTool/js/VET.js',
		'//resources/jquery.ui/jquery.ui.widget.js',
		'//resources/jquery.ui/jquery.ui.mouse.js',
		'//resources/jquery.ui/jquery.ui.slider.js',
	],
];

/** UserLogin **/
$config['userlogin_scss_wikiamobile'] = [
	'type' => AssetsManager::TYPE_SCSS,
	'skin' => 'wikiamobile',
	'assets' => [
		'//extensions/wikia/UserLogin/css/UserLogin.wikiamobile.scss',
	],
];

$config['userlogin_js_wikiamobile'] = [
	'type' => AssetsManager::TYPE_JS,
	'skin' => 'wikiamobile',
	'assets' => [
		'//extensions/wikia/UserLogin/js/UserLoginSpecial.wikiamobile.js',
	],
];

/** UserProfilePage **/
$config['userprofilepage_scss_wikiamobile'] = [
	'type' => AssetsManager::TYPE_SCSS,
	'skin' => 'wikiamobile',
	'assets' => [
		'//extensions/wikia/UserProfilePageV3/css/UserProfilePage.wikiamobile.scss',
	],
];

/** WAMPage **/
$config['wampage_scss'] = [
	'type' => AssetsManager::TYPE_SCSS,
	'skin' => [ 'oasis' ],
	'assets' => [
		'//extensions/wikia/WAMPage/css/WAMPage.scss',
	],
];

$config['wampage_js'] = [
	'type' => AssetsManager::TYPE_JS,
	'skin' => [ 'oasis' ],
	'assets' => [
		'//extensions/wikia/WAMPage/js/WAMPage.js',
	],
];

/** Places **/
$config['places_js'] = [
	'skin' => [ 'oasis', 'wikiamobile' ],
	'type' => AssetsManager::TYPE_JS,
	'assets' => [
		'//extensions/wikia/Places/js/Places.js',
	],
];

$config['places_css'] = [
	'type' => AssetsManager::TYPE_CSS,
	'skin' => [ 'oasis', 'wikiamobile' ],
	'assets' => [
		'//extensions/wikia/Places/css/Places.css',
	],
];

/** WikiaPhotoGallery **/
$config['wikiaphotogallery_slider_js_wikiamobile'] = [
	'skin' => 'wikiamobile',
	'type' => AssetsManager::TYPE_JS,
	'assets' => [
		'//extensions/wikia/WikiaPhotoGallery/js/WikiaPhotoGallery.slider.wikiamobile.js',
	],
];

$config['wikiaphotogallery_slider_scss_wikiamobile'] = [
	'type' => AssetsManager::TYPE_SCSS,
	'skin' => 'wikiamobile',
	'assets' => [
		'//extensions/wikia/WikiaPhotoGallery/css/WikiaPhotoGallery.slidertag.wikiamobile.scss',
	],
];

$config['wikia_photo_gallery_js'] = [
	'type' => AssetsManager::TYPE_JS,
	'skin' => [ 'oasis' ],
	'assets' => [
		'//extensions/wikia/WikiaPhotoGallery/js/WikiaPhotoGallery.view.js',
	],
];

$config['wikia_photo_gallery_scss'] = [
	'type' => AssetsManager::TYPE_SCSS,
	'skin' => [ 'oasis' ],
	'assets' => [
		'//extensions/wikia/WikiaPhotoGallery/css/gallery.scss',
	],
];

$config['wikia_photo_gallery_slideshow_js'] = [
	'type' => AssetsManager::TYPE_JS,
	'skin' => [ 'oasis' ],
	'assets' => [
		'//resources/wikia/libraries/jquery/slideshow/jquery-slideshow-0.4.js',
		'//extensions/wikia/WikiaPhotoGallery/js/WikiaPhotoGallery.slideshow.js',
	],
];

$config['wikia_photo_gallery_slideshow_scss'] = [
	'type' => AssetsManager::TYPE_SCSS,
	'skin' => [ 'oasis' ],
	'assets' => [
		'//extensions/wikia/WikiaPhotoGallery/css/slideshow.scss',
	],
];

$config['wikia_photo_gallery_slider_js'] = [
	'type' => AssetsManager::TYPE_JS,
	'skin' => [ 'oasis' ],
	'assets' => [
		'//extensions/wikia/WikiaPhotoGallery/js/WikiaPhotoGallery.slider.js',
	],
];

$config['wikia_photo_gallery_slider_scss'] = [
	'type' => AssetsManager::TYPE_SCSS,
	'skin' => [ 'oasis' ],
	'assets' => [
		'//extensions/wikia/WikiaPhotoGallery/css/WikiaPhotoGallery.slidertag.scss',
	],
];

$config['wikia_photo_gallery_mosaic_js'] = [
	'type' => AssetsManager::TYPE_JS,
	'skin' => [ 'oasis' ],
	'assets' => [
		'//resources/wikia/libraries/modernizr/modernizr-2.0.6.js',
		'//extensions/wikia/WikiaPhotoGallery/js/WikiaPhotoGallery.slider.mosaic.js',
	],
];

$config['wikia_photo_gallery_mosaic_scss'] = [
	'type' => AssetsManager::TYPE_SCSS,
	'skin' => [ 'oasis' ],
	'assets' => [
		'//extensions/wikia/WikiaPhotoGallery/css/WikiaPhotoGallery.slidertag.mosaic.scss',
	],
];

/** AnalyticsEngine **/
/** Note: this group is also used in Oasis! */
$config['universal_analytics_js'] = [
	'type' => AssetsManager::TYPE_JS,
	'skin' => [ 'wikiamobile' ],
	'assets' => [
		'//extensions/wikia/AnalyticsEngine/js/universal_analytics.js',
	],
];

/* Special:Leaderboard in AchievementsII extensions */
$config['special_leaderboard_oasis_js'] = [
	'type' => AssetsManager::TYPE_JS,
	'skin' => [ 'oasis' ],
	'assets' => [
		'//resources/wikia/libraries/bootstrap/popover.js',
		'//extensions/wikia/AchievementsII/js/SpecialLeaderboard.js',
		'//skins/oasis/js/Achievements.js',
	],
];

$config['special_leaderboard_oasis_css'] = [
	'type' => AssetsManager::TYPE_SCSS,
	'skin' => [ 'oasis' ],
	'assets' => [
		'//resources/wikia/libraries/bootstrap/popover.scss',
		'//extensions/wikia/AchievementsII/css/leaderboard_oasis.scss',
	],
];

/* Achievements module */
$config['achievements_css'] = [
	'type' => AssetsManager::TYPE_SCSS,
	'skin' => [ 'oasis' ],
	'assets' => [
		'//resources/wikia/libraries/bootstrap/popover.scss',
		'//extensions/wikia/AchievementsII/css/oasis.scss',
	],
];

$config['achievements_js'] = [
	'type' => AssetsManager::TYPE_JS,
	'skin' => [ 'oasis' ],
	'assets' => [
		'//resources/wikia/libraries/bootstrap/popover.js',
		'//skins/oasis/js/Achievements.js',
	],
];

/* Special:Videos */
$config['special_videos_js'] = [
	'type' => AssetsManager::TYPE_JS,
	'skin' => [ 'oasis' ],
	'assets' => [
		'//extensions/wikia/SpecialVideos/scripts/SpecialVideos.js',
		'//extensions/wikia/WikiaStyleGuide/js/Dropdown.js',
	],
];

$config['special_videos_css'] = [
	'type' => AssetsManager::TYPE_SCSS,
	'skin' => [ 'oasis' ],
	'assets' => [
		'//extensions/wikia/SpecialVideos/styles/SpecialVideos.scss',
		'//extensions/wikia/WikiaStyleGuide/css/Dropdown.scss',
	],
];

$config['special_videos_js_mobile'] = [
	'type' => AssetsManager::TYPE_JS,
	'skin' => [ 'wikiamobile' ],
	'assets' => [
		'//extensions/wikia/SpecialVideos/scripts/templates.mustache.js',
		'//extensions/wikia/SpecialVideos/scripts/mobile/collections/video.js',
		'//extensions/wikia/SpecialVideos/scripts/mobile/views/index.js',
		'//extensions/wikia/SpecialVideos/scripts/mobile/controller.js',
	],
];

$config['special_videos_css_mobile'] = [
	'type' => AssetsManager::TYPE_SCSS,
	'skin' => [ 'wikiamobile' ],
	'assets' => [
		'//skins/oasis/css/core/thumbnails.scss',
		'//extensions/wikia/SpecialVideos/styles/mobile.scss',
	],
];

/* CategorySelect */
$config['categoryselect_edit_js'] = [
	'type' => AssetsManager::TYPE_JS,
	'assets' => [
		'//resources/jquery.ui/jquery.ui.core.js',
		'//resources/jquery.ui/jquery.ui.widget.js',
		'//resources/jquery.ui/jquery.ui.mouse.js',
		'//resources/jquery.ui/jquery.ui.sortable.js',
		'//extensions/wikia/CategorySelect/js/CategorySelect.js',
	],
];

/* FilePage */
$config['wikia_file_page_js'] = [
	'type' => AssetsManager::TYPE_JS,
	'assets' => [
		'//extensions/wikia/FilePage/scripts/WikiaFilePage.js',
	],
];
$config['file_page_tabbed_js'] = [
	'type' => AssetsManager::TYPE_JS,
	'assets' => [
		'//extensions/wikia/FilePage/scripts/FilePageTabbed.js',
	],
];
$config['file_page_tabbed_css'] = [
	'type' => AssetsManager::TYPE_SCSS,
	'assets' => [
		'//extensions/wikia/FilePage/css/FilePageTabbed.scss',
	],
];

/* LyricFind */
$config['LyricsFindTracking'] = [
	'type' => AssetsManager::TYPE_JS,
	'skin' => [ 'oasis', 'wikiamobile' ],
	'assets' => [
		'//extensions/3rdparty/LyricWiki/LyricFind/js/modules/LyricFind.Tracker.js',
		'//extensions/3rdparty/LyricWiki/LyricFind/js/tracking.js',
	],
];

/* UI repo JS API */
$config['ui_repo_api_js'] = [
	'type' => AssetsManager::TYPE_JS,
	'skin' => [ 'oasis' ],
	'assets' => [
		'//resources/wikia/modules/nirvana.js',
		'//resources/wikia/modules/uifactory.js',
		'//resources/wikia/modules/uicomponent.js',
	],
];

$config['toc_js'] = [
	'type' => AssetsManager::TYPE_JS,
	'assets' => [
		'//resources/wikia/libraries/mustache/mustache.js',
		'//extensions/wikia/TOC/js/modules/toc.js',
		'//extensions/wikia/TOC/js/tocWikiaArticle.js',
	],
];

// FIXME: paths to dist
$config['api_docs_js'] = [
	'type' => AssetsManager::TYPE_JS,
	'assets' => [
		'//extensions/wikia/ApiDocs/js/lib/jquery-1.8.0.min.js',
		'//extensions/wikia/ApiDocs/js/lib/jquery.wiggle.min.js',
		'//extensions/wikia/ApiDocs/js/lib/jquery.ba-bbq.min.js',
		'//extensions/wikia/ApiDocs/js/lib/jquery.slideto.min.js',
		'//extensions/wikia/ApiDocs/js/lib/highlight.7.3.pack.js',
		'//extensions/wikia/ApiDocs/js/lib/handlebars-1.0.0.js',
		'//extensions/wikia/ApiDocs/js/lib/underscore-min.js',
		'//extensions/wikia/ApiDocs/js/lib/backbone-min.js',
		'//extensions/wikia/ApiDocs/js/lib/swagger.js',

		'//extensions/wikia/ApiDocs/js/jquery.zclip.min.js',

		'//extensions/wikia/ApiDocs/js/doc.js',
		'//extensions/wikia/ApiDocs/js/HeaderView.js',
		'//extensions/wikia/ApiDocs/js/OperationView.js',
		'//extensions/wikia/ApiDocs/js/StatusCodeView.js',
		'//extensions/wikia/ApiDocs/js/ParameterView.js',
		'//extensions/wikia/ApiDocs/js/SignatureView.js',
		'//extensions/wikia/ApiDocs/js/MainView.js',
		'//extensions/wikia/ApiDocs/js/ResourceView.js',
		'//extensions/wikia/ApiDocs/js/ContentTypeView.js',
		'//extensions/wikia/ApiDocs/js/SwaggerUi.js',

		'//extensions/wikia/ApiDocs/templates/handlebars/content_type.handlebars.js',
		'//extensions/wikia/ApiDocs/templates/handlebars/main.handlebars.js',
		'//extensions/wikia/ApiDocs/templates/handlebars/operation.handlebars.js',
		'//extensions/wikia/ApiDocs/templates/handlebars/param.handlebars.js',
		'//extensions/wikia/ApiDocs/templates/handlebars/param_list.handlebars.js',
		'//extensions/wikia/ApiDocs/templates/handlebars/param_readonly.handlebars.js',
		'//extensions/wikia/ApiDocs/templates/handlebars/param_readonly_required.handlebars.js',
		'//extensions/wikia/ApiDocs/templates/handlebars/param_required.handlebars.js',
		'//extensions/wikia/ApiDocs/templates/handlebars/resource.handlebars.js',
		'//extensions/wikia/ApiDocs/templates/handlebars/signature.handlebars.js',
		'//extensions/wikia/ApiDocs/templates/handlebars/status_code.handlebars.js',

	],
];

$config['api_docs_scss'] = [
	'type' => AssetsManager::TYPE_SCSS,
	'assets' => [
		'//extensions/wikia/ApiDocs/css/ApiDocs.scss',
	],
];

$config['qualaroo_js'] = [
	'type' => AssetsManager::TYPE_JS,
	'skin' => [ 'oasis' ],
	'assets' => [
		'//extensions/wikia/Qualaroo/scripts/Qualaroo.js',
	],
];

$config['imglzy_js'] = [
	'type' => AssetsManager::TYPE_JS,
	'assets' => [
		'//extensions/wikia/ImageLazyLoad/js/ImgLzy.module.js',
		'//extensions/wikia/ImageLazyLoad/js/ImageLazyLoad.js',
	],
];

$config['rail_js'] = [
	'type' => AssetsManager::TYPE_JS,
	'skin' => [ 'oasis' ],
	'assets' => [
		'//extensions/wikia/Rail/scripts/Rail.js',
	],
];

/** Qualaroo blocking **/
$config['qualaroo_blocking_js'] = [
	'type' => AssetsManager::TYPE_JS,
	'assets' => [
		'//extensions/wikia/Qualaroo/scripts/QualarooBlocking.js',
	],
];

/** DesignSystem extension */
$config['design_system_js'] = [
	'type' => AssetsManager::TYPE_JS,
	'skin' => [ 'oasis' ],
	'assets' => [
		'//resources/wikia/modules/scrollToLink.js',
		'//extensions/wikia/DesignSystem/scripts/DesignSystemTracking.js',
		'//extensions/wikia/DesignSystem/scripts/DesignSystemDropdowns.js',
		'//extensions/wikia/DesignSystem/scripts/DesignSystemGlobalNavigationScrollToLink.js',
		'//extensions/wikia/DesignSystem/scripts/DesignSystemAuthenticationMenu.js',
		'//extensions/wikia/DesignSystem/scripts/DesignSystemGlobalNavigationSearch.js',
		'//extensions/wikia/DesignSystem/scripts/DesignSystemGlobalNavigationSearchSuggestions.js',
		'//extensions/wikia/DesignSystem/scripts/DesignSystemGlobalFooter.js'
	],
];

$config['design_system_user_js'] = [
	'type' => AssetsManager::TYPE_JS,
	'skin' => [ 'oasis' ],
	'assets' => [
		'//extensions/wikia/DesignSystem/scripts/DesignSystemGlobalNavigationNotifications.js',
	],
];

$config['design_system_on_site_notifications_js'] = [
	'type' => AssetsManager::TYPE_JS,
	'skin' => [ 'oasis' ],
	'assets' => [
		'//extensions/wikia/DesignSystem/scripts/templates.mustache.js',
		'//extensions/wikia/DesignSystem/scripts/DesignSystemGlobalNavigationOnSiteNotifications.js',
		'//extensions/wikia/DesignSystem/scripts/DesignSystemGlobalNavigationOnSiteNotifications.common.js',
		'//extensions/wikia/DesignSystem/scripts/DesignSystemGlobalNavigationOnSiteNotifications.model.js',
		'//extensions/wikia/DesignSystem/scripts/DesignSystemGlobalNavigationOnSiteNotifications.view.js',
		'//extensions/wikia/DesignSystem/scripts/DesignSystemGlobalNavigationOnSiteNotifications.controller.js',
		'//extensions/wikia/DesignSystem/scripts/DesignSystemGlobalNavigationOnSiteNotifications.text-formatter.js',
		'//extensions/wikia/DesignSystem/scripts/DesignSystemGlobalNavigationOnSiteNotifications.tracking.js',
		'//extensions/wikia/DesignSystem/scripts/DesignSystemTemplating.js',
		'//extensions/wikia/DesignSystem/scripts/DesignSystemLoadingSpinner.js',
		'//extensions/wikia/DesignSystem/scripts/DesignSystemEvent.js'
	],
];

/* extension/wikia/Bucky */
$config['bucky_js'] = [
	'type' => AssetsManager::TYPE_JS,
	'skin' => [ 'oasis' ],
	'assets' => [
		'//extensions/wikia/Bucky/vendor/Weppy/dist/weppy.js',
		'//extensions/wikia/Bucky/js/bucky_init.js',
		'//extensions/wikia/Bucky/js/bucky_resources_timing.js',
		'//extensions/wikia/Bucky/js/bucky_metrics.js',
	],
];

$config['media_gallery_js'] = [
	'type' => AssetsManager::TYPE_JS,
	'skin' => [ 'oasis' ],
	'assets' => [
		'//extensions/wikia/MediaGallery/scripts/templates.mustache.js',
		'//extensions/wikia/MediaGallery/scripts/views/caption.js',
		'//extensions/wikia/MediaGallery/scripts/views/media.js',
		'//extensions/wikia/MediaGallery/scripts/views/toggler.js',
		'//extensions/wikia/MediaGallery/scripts/views/gallery.js',
		'//extensions/wikia/MediaGallery/scripts/controllers/galleries.js',
	],
];

$config['banner_notifications_js'] = [
	'type' => AssetsManager::TYPE_SCSS,
	'skin' => [ 'oasis' ],
	'assets' => [
		'//extensions/wikia/BannerNotifications/js/BannerNotifications.js',
	],
];

$config['wikia_in_your_lang_js'] = [
	'type' => AssetsManager::TYPE_JS,
	'skin' => [ 'oasis' ],
	'assets' => [
		'//extensions/wikia/WikiaInYourLang/modules/ext.wikiaInYourLang.js',
	],
];

$config['upload_photos_dialog_js'] = [
	'type' => AssetsManager::TYPE_JS,
	'skin' => [ 'oasis' ],
	'assets' => [
		'//extensions/wikia/WikiaNewFiles/scripts/uploadPhotosDialog.js',
	],
];

$config['upload_photos_dialog_scss'] = [
	'type' => AssetsManager::TYPE_SCSS,
	'skin' => [ 'oasis' ],
	'assets' => [
		'//extensions/wikia/WikiaNewFiles/styles/UploadPhotoDialog.scss',
	],
];

$config['page_share_js'] = [
	'type' => AssetsManager::TYPE_JS,
	'skin' => [ 'oasis' ],
	'assets' => [
		'//extensions/wikia/PageShare/scripts/PageShare.js',
		'//extensions/wikia/PageShare/scripts/PageShareInit.js',
	],
];

$config['page_share_scss'] = [
	'type' => AssetsManager::TYPE_SCSS,
	'skin' => [ 'oasis' ],
	'assets' => [
		'//extensions/wikia/PageShare/styles/PageShare.scss',
	],
];

$config['captcha_js'] = [
	'type' => AssetsManager::TYPE_JS,
	'skin' => [ 'oasis' ],
	'assets' => [
		'//extensions/wikia/Captcha/scripts/Captcha.js',
	],
];

$config['portable_infobox_js'] = [
	'type' => AssetsManager::TYPE_JS,
	'assets' => [
		'//extensions/wikia/PortableInfobox/js/PortableInfobox.js',
	],
];

$config['portable_infobox_scss'] = [
	'type' => AssetsManager::TYPE_SCSS,
	'skin' => [ 'oasis' ],
	'assets' => [
		'//extensions/wikia/PortableInfobox/styles/PortableInfobox.scss',
	],
];

$config['portable_infobox_europa_theme_scss'] = [
	'type' => AssetsManager::TYPE_SCSS,
	'skin' => [ 'oasis' ],
	'assets' => [
		'//extensions/wikia/PortableInfobox/styles/PortableInfoboxEuropaTheme.scss',
	],
];

$config['portable_infobox_builder_js'] = [
	'type' => AssetsManager::TYPE_JS,
	'assets' => [
		'//resources/wikia/libraries/Ponto/ponto.js',
		'//extensions/wikia/PortableInfoboxBuilder/js/PortableInfoboxBuilderPonto.js',
		'//extensions/wikia/PortableInfoboxBuilder/js/PortableInfoboxBuilder.js',
	],
];

$config['portable_infobox_builder_template_classification_helper_js'] = [
	'type' => AssetsManager::TYPE_JS,
	'assets' => [
		'//extensions/wikia/PortableInfoboxBuilder/js/PortableInfoboxBuilderTemplateClassificationHelper.js',
	],
];

$config['portable_infobox_builder_scss'] = [
	'type' => AssetsManager::TYPE_SCSS,
	'skin' => [ 'oasis' ],
	'assets' => [
		'//extensions/wikia/PortableInfoboxBuilder/styles/PortableInfoboxBuilder.scss',
	],
];

$config['portable_infobox_builder_preview_scss'] = [
	'type' => AssetsManager::TYPE_SCSS,
	'skin' => [ 'oasis' ],
	'assets' => [
		'//extensions/wikia/PortableInfoboxBuilder/styles/PortableInfoboxBuilderPreview.scss',
	],
];

$config['special_email_admin_css'] = [
	'type' => AssetsManager::TYPE_SCSS,
	'assets' => [
		'//extensions/wikia/Email/styles/specialSendEmail.scss',
	],
];

$config['sitemap_page_css'] = [
	'type' => AssetsManager::TYPE_SCSS,
	'skin' => [ 'oasis', 'wikiamobile' ],
	'assets' => [
		'//extensions/wikia/SitemapPage/styles/SitemapPage.scss',
	],
];

$config['template_draft'] = [
	'type' => AssetsManager::TYPE_JS,
	'assets' => [
		'//extensions/wikia/TemplateDraft/scripts/templateDraft.run.js',
		'//extensions/wikia/TemplateDraft/scripts/templateDraftTracking.js',
	],
];

$config['content_review_module_js'] = [
	'type' => AssetsManager::TYPE_JS,
	'assets' => [
		'//extensions/wikia/ContentReview/scripts/contentReviewModule.run.js',
		'//extensions/wikia/ContentReview/scripts/contentReviewModule.js',
	],
];

$config['content_review_module_scss'] = [
	'type' => AssetsManager::TYPE_SCSS,
	'skin' => [ 'oasis' ],
	'assets' => [
		'//skins/oasis/css/modules/ContentReview.scss',
	],
];

$config['content_review_test_mode_js'] = [
	'type' => AssetsManager::TYPE_JS,
	'assets' => [
		'//extensions/wikia/ContentReview/scripts/contentReviewTestMode.run.js',
		'//extensions/wikia/ContentReview/scripts/contentReviewTestMode.js',
	],
];

$config['content_review_special_page_js'] = [
	'type' => AssetsManager::TYPE_JS,
	'assets' => [
		'//extensions/wikia/ContentReview/scripts/contentReviewSpecialPage.run.js',
		'//extensions/wikia/ContentReview/scripts/contentReviewSpecialPage.js',
	],
];

$config['content_review_diff_page_js'] = [
	'type' => AssetsManager::TYPE_JS,
	'assets' => [
		'//extensions/wikia/ContentReview/scripts/contentReviewDiffPage.run.js',
		'//extensions/wikia/ContentReview/scripts/contentReviewDiffPage.js',
	],
];

$config['content_review_diff_page_scss'] = [
	'type' => AssetsManager::TYPE_SCSS,
	'assets' => [
		'//extensions/wikia/ContentReview/styles/ContentReviewDiffPage.scss',
	],
];

$config['content_review_special_page_scss'] = [
	'type' => AssetsManager::TYPE_SCSS,
	'assets' => [
		'//extensions/wikia/ContentReview/styles/ContentReviewSpecialPage.scss',
	],
];

$config['auth_modal_js'] = [
	'type' => AssetsManager::TYPE_JS,
	'skin' => [ 'oasis' ],
	'assets' => [
		'//extensions/wikia/AuthModal/js/AuthModal.js',
	],
];

$config['curated_content_tool_button_js'] = [
	'type' => AssetsManager::TYPE_JS,
	'skin' => [ 'oasis' ],
	'assets' => [
		'//resources/wikia/libraries/Ponto/ponto.js',
		'//extensions/wikia/CuratedContent/js/CuratedContentToolButton.js',
		'//extensions/wikia/CuratedContent/js/CuratedContentToolModal.js',
		'//extensions/wikia/CuratedContent/js/CuratedContentToolPontoBridge.js',
	],
];

$config['curated_content_tool_button_scss'] = [
	'type' => AssetsManager::TYPE_SCSS,
	'skin' => [ 'oasis' ],
	'assets' => [
		'//extensions/wikia/CuratedContent/css/CuratedContentTool.scss',
	],
];

$config['visit_source_js'] = [
	'type' => AssetsManager::TYPE_JS,
	'skin' => [ 'oasis' ],
	'assets' => [
		'//resources/wikia/libraries/visit-source/visit-source.js',
		'//extensions/wikia/VisitSource/scripts/VisitSource.js',
	],
];

$config['template_classification_in_view_js'] = [
	'type' => AssetsManager::TYPE_JS,
	'skin' => [ 'oasis' ],
	'assets' => [
		'//extensions/wikia/TemplateClassification/scripts/TemplateClassificationInView.js',
		'//extensions/wikia/TemplateClassification/scripts/TemplateClassificationLabeling.js',
		'//extensions/wikia/TemplateClassification/scripts/TemplateClassificationModal.js',
	],
];

$config['template_classification_in_edit_js'] = [
	'type' => AssetsManager::TYPE_JS,
	'skin' => [ 'oasis' ],
	'assets' => [
		'//extensions/wikia/TemplateClassification/scripts/TemplateClassificationInEdit.js',
		'//extensions/wikia/TemplateClassification/scripts/TemplateClassificationLabeling.js',
		'//extensions/wikia/TemplateClassification/scripts/TemplateClassificationModal.js',
		'//extensions/wikia/TemplateClassification/scripts/TemplateClassificationModalForce.js',
	],
];

$config['template_classification_in_category_js'] = [
	'type' => AssetsManager::TYPE_JS,
	'skin' => [ 'oasis' ],
	'assets' => [
		'//extensions/wikia/TemplateClassification/scripts/TemplateClassificationInCategory.js',
		'//extensions/wikia/TemplateClassification/scripts/TemplateClassificationLabeling.js',
		'//extensions/wikia/TemplateClassification/scripts/TemplateClassificationModal.js',
		'//extensions/wikia/TemplateClassification/scripts/TemplateClassificationGlobalShortcuts.js',
	],
];

$config['template_classification_globalshortcuts_js'] = [
	'type' => AssetsManager::TYPE_JS,
	'skin' => [ 'oasis' ],
	'assets' => [
		'//extensions/wikia/TemplateClassification/scripts/TemplateClassificationGlobalShortcuts.js',
	],
];

$config['template_classification_scss'] = [
	'type' => AssetsManager::TYPE_SCSS,
	'skin' => [ 'oasis' ],
	'assets' => [
		'//extensions/wikia/TemplateClassification/styles/TemplateClassification.scss',
	],
];

$config['insights_module_scss'] = [
	'type' => AssetsManager::TYPE_SCSS,
	'skin' => [ 'oasis' ],
	'assets' => [
		'//skins/oasis/css/modules/InsightsModule.scss',
	],
];

$config['insights_module_js'] = [
	'type' => AssetsManager::TYPE_JS,
	'skin' => [ 'oasis' ],
	'assets' => [
		'//skins/oasis/js/modules/InsightsModule.js',
	],
];

$config['insights_globalshortcuts_js'] = [
	'type' => AssetsManager::TYPE_JS,
	'skin' => [ 'oasis' ],
	'assets' => [
		'//extensions/wikia/InsightsV2/scripts/InsightsGlobalShortcuts.js',
	],
];

$config['templates_hq_scss'] = [
	'type' => AssetsManager::TYPE_SCSS,
	'skin' => [ 'oasis' ],
	'assets' => [
		'//extensions/wikia/TemplateClassification/styles/SpecialTemplates.scss',
	],
];

$config['polldaddy_tag_wikiamobile'] = [
	'type' => AssetsManager::TYPE_JS,
	'skin' => 'wikiamobile',
	'assets' => [
		'//extensions/wikia/PolldaddyTag/scripts/wikiamobile.js',
	],
];

$config['globalshortcuts_js'] = [
	'type' => AssetsManager::TYPE_JS,
	'skin' => [ 'oasis' ],
	'assets' => [
		'//resources/wikia/libraries/jquery/autocomplete/devbridge-autocomplete.js',
		'//extensions/wikia/GlobalShortcuts/scripts/Mousetrap.js',
		'//extensions/wikia/GlobalShortcuts/scripts/PageActions.js',
		'//extensions/wikia/GlobalShortcuts/scripts/GlobalShortcuts.js',
		'//extensions/wikia/GlobalShortcuts/scripts/GlobalShortcutsHelp.js',
		'//extensions/wikia/GlobalShortcuts/scripts/GlobalShortcutsHelpEntryPoint.js',
		'//extensions/wikia/GlobalShortcuts/scripts/GlobalShortcutsSuggestions.js',
		'//extensions/wikia/GlobalShortcuts/scripts/GlobalShortcutsSearch.js',
		'//extensions/wikia/GlobalShortcuts/scripts/GlobalShortcutsRenderKeys.js',
		'//extensions/wikia/GlobalShortcuts/scripts/AddDefaultShortcuts.js',
		'//extensions/wikia/GlobalShortcuts/scripts/GlobalShortcutsTracking.js',
	],
];

$config['globalshortcuts_discussions_js'] = [
	'type' => AssetsManager::TYPE_JS,
	'skin' => [ 'oasis' ],
	'assets' => [
		'//extensions/wikia/GlobalShortcuts/scripts/AddDiscussionsShortcuts.js',
	],
];

$config['globalshortcuts_scss'] = [
	'type' => AssetsManager::TYPE_SCSS,
	'skin' => [ 'oasis' ],
	'assets' => [
		'//extensions/wikia/GlobalShortcuts/styles/GlobalShortcutsHelp.scss',
		'//extensions/wikia/GlobalShortcuts/styles/GlobalShortcutsSearch.scss',
	],
];

$config['special_user_activity_js'] = [
	'type' => AssetsManager::TYPE_JS,
	'assets' => [
		'//extensions/wikia/UserActivity/js/UserActivity.js',
	],
];

$config['special_user_activity_scss'] = [
	'type' => AssetsManager::TYPE_SCSS,
	'assets' => [
		'//extensions/wikia/UserActivity/css/UserActivity.scss',
	],
];

$config['special_discussions_scss'] = [
	'type' => AssetsManager::TYPE_SCSS,
	'assets' => [
		'//extensions/wikia/SpecialDiscussions/css/Discussions_Forms.scss',
	],
];

$config['special_discussions_log_scss'] = [
	'type' => AssetsManager::TYPE_SCSS,
	'assets' => [
		'//extensions/wikia/SpecialDiscussionsLog/css/DiscussionsLog_Forms.scss',
	],
];

$config['community_page_benefits_js'] = [
	'type' => AssetsManager::TYPE_JS,
	'assets' => [
		'//resources/wikia/modules/pageviewsInSession.js',
		'//resources/wikia/modules/sessionStorage.js',
		'//extensions/wikia/CommunityPage/scripts/CommunityPageBenefitsModal.js',
		'//extensions/wikia/CommunityPage/scripts/CommunityPageBenefitsPageviews.js',
	],
];

$config['community_page_benefits_scss'] = [
	'type' => AssetsManager::TYPE_SCSS,
	'assets' => [
		'//extensions/wikia/CommunityPage/styles/benefitsModal/benefitsModal.scss',
	],
];

$config['special_community_page_js'] = [
	'type' => AssetsManager::TYPE_JS,
	'assets' => [
		'//extensions/wikia/CommunityPage/scripts/ext.communityPage.js',
		'//extensions/wikia/CommunityPage/scripts/templates.mustache.js',
	],
];

$config['special_community_page_scss'] = [
	'type' => AssetsManager::TYPE_SCSS,
	'assets' => [
		'//extensions/wikia/CommunityPage/styles/CommunityPage.scss',
		'//extensions/wikia/CommunityPage/styles/CommunityPageOverrides.scss',
	],
];

$config['special_portability_dashboard_scss'] = [
	'type' => AssetsManager::TYPE_SCSS,
	'assets' => [
		'//extensions/wikia/PortabilityDashboard/styles/PortabilityDashboard.scss',
	],
];

$config['community_page_entry_point_js'] = [
	'type' => AssetsManager::TYPE_JS,
	'skin' => 'oasis',
	'assets' => [
		'//extensions/wikia/CommunityPage/scripts/entryPoint.js',
	],
];

$config['community_page_entry_point_scss'] = [
	'type' => AssetsManager::TYPE_SCSS,
	'skin' => 'oasis',
	'assets' => [
		'//extensions/wikia/CommunityPage/styles/entrypoint/EntryPoint.scss',
	],
];

$config['community_page_new_user_modal_js'] = [
	'type' => AssetsManager::TYPE_JS,
	'skin' => 'oasis',
	'assets' => [
		'//extensions/wikia/CommunityPage/scripts/firstEditModal.js',
		'//extensions/wikia/CommunityPage/scripts/templates.mustache.js',
	],
];

$config['community_page_new_user_modal_scss'] = [
	'type' => AssetsManager::TYPE_SCSS,
	'skin' => 'oasis',
	'assets' => [
		'//extensions/wikia/CommunityPage/styles/firstedit/FirstEditModal.scss',
	],
];

$config['embeddable_discussions_js'] = [
	'type' => AssetsManager::TYPE_JS,
	'skin' => 'oasis',
	'assets' => [
		'//extensions/wikia/EmbeddableDiscussions/scripts/ext.embeddableDiscussions.js',
		'//extensions/wikia/EmbeddableDiscussions/scripts/sharing.js',
		'//extensions/wikia/EmbeddableDiscussions/scripts/templates.mustache.js',
	],
];

$config['embeddable_discussions_scss'] = [
	'type' => AssetsManager::TYPE_SCSS,
	'skin' => 'oasis',
	'assets' => [
		'//extensions/wikia/EmbeddableDiscussions/styles/EmbeddableDiscussions.scss',
	],
];

$config['create_new_wiki_js'] = [
	'type' => AssetsManager::TYPE_JS,
	'assets' => [
		'//resources/wikia/modules/stringhelper.js',
		'//extensions/wikia/CreateNewWiki/js/CreateNewWiki.js',
		'//extensions/wikia/ThemeDesigner/js/ThemeDesigner.js',
		'//extensions/wikia/CreateNewWiki/js/CreateNewWikiThemeDesignerOverrides.js',
		'//extensions/wikia/CreateNewWiki/js/WikiBuilder.js',
		'//extensions/wikia/CreateNewWiki/js/CreateNewWikiHelper.js',
		'//extensions/wikia/CreateNewWiki/js/CommunityBuilderOptIn.js',
		'//resources/wikia/libraries/vignette/vignette.js',
	],
];

$config['create_new_wiki_scss'] = [
	'type' => AssetsManager::TYPE_SCSS,
	'assets' => [
		'//extensions/wikia/CreateNewWiki/css/CreateNewWiki.scss',
		'//extensions/wikia/CreateNewWiki/css/CommunityBuilderOptIn.scss',
	],
];

$config['design_system_scss'] = [
	'type' => AssetsManager::TYPE_SCSS,
	'skin' => [ 'oasis' ],
	'assets' => [
		'//extensions/wikia/DesignSystem/styles/design-system.scss'
	],
];

/** Assets for Special:AdminDashboard */
$config['special_admindashboard_scss'] = [
	'type' => AssetsManager::TYPE_SCSS,
	'assets' => [
		'//extensions/wikia/AdminDashboard/css/AdminDashboard.scss',
	],
];

$config['special_admindashboard_js'] = [
	'type' => AssetsManager::TYPE_JS,
	'assets' => [
		'//extensions/wikia/AdminDashboard/js/AdminDashboard.js',
	],
];

$config['jwplayer_scss'] = [
	'type' => AssetsManager::TYPE_SCSS,
	'skin' => [ 'oasis' ],
	'assets' => [
		'//extensions/wikia/ArticleVideo/styles/jwplayer.scss',
		'//extensions/wikia/ArticleVideo/styles/jwplayer-overrides.scss',
		'//extensions/wikia/ArticleVideo/styles/video-feedback.scss',
		'//extensions/wikia/ArticleVideo/styles/video-attribution.scss'
	],
];

$config['jwplayer_js'] = [
	'type' => AssetsManager::TYPE_JS,
	'skin' => [ 'oasis' ],
	'assets' => [
		'//extensions/wikia/ArticleVideo/scripts/which-transition-event.js',
		'//extensions/wikia/ArticleVideo/scripts/featured-video.jwplayer.js',
		'//extensions/wikia/ArticleVideo/scripts/featured-video.jwplayer.on-scroll.js',
		'//extensions/wikia/ArticleVideo/scripts/featured-video.jwplayer.video-feedback.js',
		'//extensions/wikia/ArticleVideo/scripts/featured-video.attribution.js',
		'//extensions/wikia/ArticleVideo/scripts/templates.mustache.js',
		'//extensions/wikia/ArticleVideo/scripts/video-feedback.js'
	],
];

$config['community_header_scss'] = [
	'type' => AssetsManager::TYPE_SCSS,
	'skin' => [ 'oasis' ],
	'assets' => [
		'//extensions/wikia/CommunityHeader/styles/index.scss',
	],
];

$config['community_header_js'] = [
	'type' => AssetsManager::TYPE_JS,
	'skin' => [ 'oasis' ],
	'assets' => [
		'//extensions/wikia/CommunityHeader/scripts/local-navigation-preview.js',
		'//extensions/wikia/CommunityHeader/scripts/more-wiki-buttons.js',
		'//extensions/wikia/CommunityHeader/scripts/tracking.js',
	],
];

$config['page_header_js'] = [
	'type' => AssetsManager::TYPE_JS,
	'skin' => [ 'oasis' ],
	'assets' => [
		'//extensions/wikia/PageHeader/scripts/tracking.js',
	],
];

$config['page_header_scss'] = [
	'type' => AssetsManager::TYPE_SCSS,
	'skin' => [ 'oasis' ],
	'assets' => [
		'//extensions/wikia/PageHeader/styles/index.scss',
	],
];

$config['jwplayer_mobile_featured_video_ads_js'] = [
	'type' => AssetsManager::TYPE_JS,
	'skin' => [ 'oasis', 'wikiamobile' ],
	'assets' => [
		'//extensions/wikia/ArticleVideo/scripts/featured-video.cookies.js',
	],
];

$config['jwplayer_tag_js'] = [
	'type' => AssetsManager::TYPE_JS,
	'skin' => [ 'oasis' ],
	'assets' => [
		'//skins/oasis/js/jwplayer/node_modules/jwplayer-fandom/dist/wikiajwplayer.js',
		'//extensions/wikia/ArticleVideo/scripts/featured-video.cookies.js',
		'//extensions/wikia/JWPlayerTag/scripts/jwplayertag.js',
	],
];

$config['jwplayer_tag_with_featured_video_js'] = [
	'type' => AssetsManager::TYPE_JS,
	'skin' => [ 'oasis' ],
	'assets' => [
		'//extensions/wikia/JWPlayerTag/scripts/jwplayertag.js',
	],
];

$config['jwplayer_tag_css'] = [
	'type' => AssetsManager::TYPE_CSS,
	'skin' => [ 'oasis' ],
	'assets' => [
		'//skins/oasis/js/jwplayer/node_modules/jwplayer-fandom/dist/index.css',
	],
];

$config['jwplayer_tag_scss'] = [
	'type' => AssetsManager::TYPE_SCSS,
	'skin' => [ 'oasis' ],
	'assets' => [
		'//extensions/wikia/JWPlayerTag/styles/jwplayertag.scss'
	]
];

$config['recommended_video_css'] = [
	'type' => AssetsManager::TYPE_CSS,
	'skin' => [ 'oasis' ],
	'assets' => [
		'//skins/oasis/js/jwplayer/node_modules/jwplayer-fandom/dist/index.css',
	],
];

$config['recommended_video_scss'] = [
	'type' => AssetsManager::TYPE_SCSS,
	'skin' => [ 'oasis' ],
	'assets' => [
		'//extensions/wikia/ArticleVideo/styles/recommended-video.scss'
	]
];

$config['recommended_video_js'] = [
	'type' => AssetsManager::TYPE_JS,
	'skin' => [ 'oasis' ],
	'assets' => [
		'//skins/oasis/js/jwplayer/node_modules/jwplayer-fandom/dist/wikiajwplayer.js',
		'//extensions/wikia/ArticleVideo/scripts/featured-video.cookies.js',
		'//extensions/wikia/ArticleVideo/scripts/recommended-video.jwplayer.js',
	]
];

$config['special_contact_forget_account_js'] = [
	'type' => AssetsManager::TYPE_JS,
	'skin' => [ 'oasis' ],
	'assets' => [
		'//extensions/wikia/SpecialContact2/SpecialContactForgetAccount.js',
	],
];

$config['feeds_and_posts_js'] = [
	'type' => AssetsManager::TYPE_JS,
	'assets' => [
		'//extensions/wikia/FeedsAndPosts/scripts/index.js',
	]
];

$config['feeds_and_posts_scss'] = [
	'type' => AssetsManager::TYPE_SCSS,
	'assets' => [
		'//extensions/wikia/FeedsAndPosts/styles/index.scss',
	]
];

$config['fandom_com_migration_js'] = [
	'type' => AssetsManager::TYPE_JS,
	'assets' => [
		'//extensions/wikia/FandomComMigration/scripts/fandom-com-migration.js',
	]
];

$config['wikia_org_migration_js'] = [
	'type' => AssetsManager::TYPE_JS,
	'assets' => [
		'//extensions/wikia/WikiaOrgMigration/scripts/wikia-org-migration.js',
	]
];

$config['language_wikis_index_scss'] = [
	'type' => AssetsManager::TYPE_SCSS,
	'skin' => [ 'oasis' ],
	'assets' => [
		'//extensions/wikia/LanguageWikisIndex/styles/language-wikis-index.scss',
	],
];

$config['seo_tweaks_uncrawlable_urls'] = [
	'type' => AssetsManager::TYPE_JS,
	'skin' => [ 'oasis' ],
	'assets' => [
		'//extensions/wikia/SEOTweaks/scripts/uncrawlable-urls.js',
	],
];

$config['category_page3_scss'] = [
	'type' => AssetsManager::TYPE_SCSS,
	'skin' => [ 'oasis' ],
	'assets' => [
		'//extensions/wikia/CategoryPage3/styles/category-page3.scss',
	],
];

$config['category_page3_layout_selector_scss'] = [
	'type' => AssetsManager::TYPE_SCSS,
	'skin' => [ 'oasis' ],
	'assets' => [
		'//extensions/wikia/CategoryPage3/styles/category-layout-selector.scss',
	],
];

$config['watch_show_scss'] = [
	'type' => AssetsManager::TYPE_SCSS,
	'assets' => [
		'//extensions/wikia/WatchShow/styles/index.scss',
	]
];

$config['watch_show_js'] = [
	'type' => AssetsManager::TYPE_JS,
	'assets' => [
		'//extensions/wikia/WatchShow/scripts/index.js',
	]
];

$config['search_tracking_js'] = [
	'type' => AssetsManager::TYPE_JS,
	'assets' => [
		'//resources/wikia/modules/uuid.js',
		'//skins/oasis/js/search-tracking/node_modules/@wikia/search-tracking/dist/search-tracking.js',
		'//skins/oasis/js/search-tracking/pageOnTimeTracker.js',
	]
];

$config['forum_migration_js'] = [
	'type' => AssetsManager::TYPE_JS,
	'assets' => [
		'//extensions/wikia/Discussions/scripts/forumMigration.js',
	]
];

