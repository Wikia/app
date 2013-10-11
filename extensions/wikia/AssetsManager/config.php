<?php
$config = array();

/******** Shared libraries and assets *******/

$config['oasis_shared_core_js'] = array(
	'type' => AssetsManager::TYPE_JS,
	'assets' => array(
		'#group_oasis_wikia_js',
		'//resources/wikia/libraries/sloth/sloth.js',
		'//resources/wikia/libraries/mustache/mustache.js'
	),
);

$config['oasis_extensions_js'] = array(
	'type' => AssetsManager::TYPE_JS,
	'assets' => array(
		'#group_oasis_ads_js',
		'#group_oasis_noads_extensions_js'
	)
);

$config['tracker_js'] = array(
	'type' => AssetsManager::TYPE_JS,
	'assets' => array(
		'//resources/wikia/modules/tracker.stub.js',
		'//resources/wikia/modules/tracker.js',
	)
);

$config['liftium_ads_js'] = array(
	'type' => AssetsManager::TYPE_JS,
	'assets' => array(
		'//extensions/wikia/AdEngine/liftium/Liftium.js',
		// TODO: get rid of those:
		'//extensions/wikia/AdEngine/liftium/Wikia.Athena.js',
		'//extensions/wikia/AdEngine/liftium/Wikia.AQ.js',
		'//extensions/wikia/AdEngine/liftium/Wikia.meerkat.js',
		'//extensions/wikia/AdEngine/liftium/Wikia.ve_alternate.js',
	),
);

$config['adengine2_js'] = array(
	'type' => AssetsManager::TYPE_JS,
	'assets' => array(
		// core
		'//extensions/wikia/AdEngine/ghost/gw-12.4.4/lib/gw.min.js',
		'//extensions/wikia/AdEngine/js/gw.config.js',

		'//extensions/wikia/AdEngine/js/Krux.js',
		'//extensions/wikia/AdEngine/js/SlotTweaker.js',
		'//extensions/wikia/AdEngine/js/ScriptWriter.js',
		'//extensions/wikia/AdEngine/js/AdEngine2.js',

		// high prio
		'//extensions/wikia/AdEngine/js/OoyalaTracking.js',
		'//extensions/wikia/AdEngine/js/DartUrl.js',
		'//extensions/wikia/AdEngine/js/WikiaDartHelper.js',
		'//extensions/wikia/AdEngine/js/WikiaDartVideoHelper.js',
		'//extensions/wikia/AdEngine/js/WikiaFullGptHelper.js',
		'//extensions/wikia/AdEngine/js/EvolveHelper.js',
		'//extensions/wikia/AdEngine/js/AdProviderEvolve.js',
		'//extensions/wikia/AdEngine/js/AdProviderGamePro.js',
		'//extensions/wikia/AdEngine/js/AdProviderGpt.js',
		'//extensions/wikia/AdEngine/js/AdProviderLater.js',
		'//extensions/wikia/AdEngine/js/AdProviderNull.js',
		'//extensions/wikia/AdEngine/js/AdTemplateSkin.js',
		'//extensions/wikia/AdEngine/js/AdLogicDartSubdomain.js',
		'//extensions/wikia/AdEngine/js/AdLogicHighValueCountry.js',
		'//extensions/wikia/AdEngine/js/AdLogicPageLevelParams.js',
		'//extensions/wikia/AdEngine/js/AdLogicPageLevelParamsLegacy.js',
		'//extensions/wikia/AdEngine/js/AdLogicPageDimensions.js',
		'//extensions/wikia/AdEngine/js/AdConfig2.js',
		'//extensions/wikia/AdEngine/js/AdEngine2.run.js',

		// low prio
		// not here! @see adengine2 low prio section someplace else
	),
);

$config['oasis_ads_js'] = array(
	'type' => AssetsManager::TYPE_JS,
	'assets' => array(
		// ads
		'//extensions/wikia/AdEngine/AdMeldAPIClient.js',
		'//extensions/wikia/AdEngine/AdProviderOpenX.js',
		'//extensions/wikia/AdEngine/LazyLoadAds.js',

		// adengine2 low prio
		// @requires adengine2 core already loaded
		// @requires liftium loaded later (TODO FIXME)
		'//extensions/wikia/AdEngine/js/AdProviderLiftium2Dom.js',
		'//extensions/wikia/AdEngine/js/AdConfig2Late.js',
		'//extensions/wikia/AdEngine/js/AdEngine2.configLateAds.js',

		'#group_liftium_ads_js',

		'//extensions/wikia/AdEngine/liftium/AdsInContent.js',
	),
);

$config['oasis_noads_extensions_js'] = array(
	'type' => AssetsManager::TYPE_JS,
	'assets' => array(
		'//extensions/wikia/VideoHandlers/js/VideoHandlers.js',
		'//extensions/wikia/CreatePage/js/CreatePage.js',
		'//extensions/wikia/VideoHandlers/js/VideoBootstrap.js',
		'//extensions/wikia/Lightbox/js/LightboxLoader.js',
		'//extensions/wikia/ImageLazyLoad/js/ImageLazyLoad.js',
		'//extensions/wikia/AjaxLogin/AjaxLoginBindings.js',
		// We allow logged in users to change login without logging out
		'//extensions/wikia/UserLogin/js/UserLoginAjaxForm.js',
		// We allow logged in users to create account without logging out
		'//extensions/wikia/UserLogin/js/UserSignupAjaxForm.js',
		// TODO: do we need to load this for logged-in?
		'//extensions/wikia/UserLogin/js/UserLoginModal.js',
		'//extensions/wikia/MiniEditor/js/MiniEditor.js',
		// needs to load after MiniEditor
		'#group_articlecomments_js',
		'//extensions/FBConnect/fbconnect.js',
		'//extensions/wikia/GlobalNotification/GlobalNotification.js',
		// This needs to load last after all common extensions, please keep this last.
		'//skins/oasis/js/GlobalModal.js',
		'//extensions/wikia/UserLogin/js/UserLogin.js',
		// Needs to load after Krux.js, jQuery and AdEngine2.run.js
		'//extensions/wikia/AdEngine/js/Krux.run.js',
		// WikiaBar is enabled sitewide
		'//extensions/wikia/WikiaBar/js/WikiaBar.js',
		// Related Forum Discussion is on all article pages
		'//extensions/wikia/Forum/js/RelatedForumDiscussion.js',
		'//extensions/wikia/VideoEmbedTool/js/VET_Loader.js',
	)
);

/** Site specific CSS **/
$config['site_anon_css'] = array(
	'type' => AssetsManager::TYPE_CSS,
	'assets' => array(
		'#function_AssetsConfig::getSiteCSS'
	)
);

/** User specific CSS **/
$config['site_user_css'] = array(
	'type' => AssetsManager::TYPE_CSS,
	'assets' => array(
		'#group_site_anon_css',
	)
);

/**
 * Scripts that are needed very early in execution and thus are worth blocking for.
 *
 * Keep this group small!
 **/

$config['oasis_blocking'] = array(
	'type' => AssetsManager::TYPE_JS,
	'assets' => array(
		'//skins/wikia/js/WikiaScriptLoader.js',
		'//skins/wikia/js/JqueryLoader.js',
		'//resources/wikia/modules/lazyqueue.js',
	)
);
$config['abtesting'] = array(
	'type' => AssetsManager::TYPE_JS,
	'skin' => [ 'oasis', 'wikiamobile' ],
	'assets' => array(
		'//extensions/wikia/AbTesting/js/AbTest.js',
	)
);

/** jQuery **/
$config['jquery'] = array(
	'type' => AssetsManager::TYPE_JS,
	'assets' => array(
		'#function_AssetsConfig::getJQueryUrl'
	)
);

$config['oasis_jquery'] = array(
	'type' => AssetsManager::TYPE_JS,
	'assets' => array(
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

		// jQuery/Oasis specific code
		'//skins/oasis/js/tables.js',

		// Search A/B testing
		'//extensions/wikia/Search/js/SearchAbTest.DomUpdater.js',
		'//extensions/wikia/Search/js/SearchAbTest.Context.js',
		'//extensions/wikia/Search/js/SearchAbTest.js',

		// Darwin A/B testing
		'//skins/oasis/js/DarwinAbTesting.js',
		// Fixed global nav ABTesting
		'//skins/oasis/js/GlobalHeader.js',
	)
);

/** Wikia **/
$config['oasis_wikia_js'] = array(
	'type' => AssetsManager::TYPE_JS,
	'assets' => array(
		// classes
		'//resources/wikia/libraries/my.class/my.class.js'
	)
);

/******** Skins *******/

/** Oasis **/

// core shared JS - used as part of oasis_shared_js_anon or oasis_shared_js_user.
// See BugzId 38541 for details on why it's better to have these 2 different packages!
// (short version: less HTTP requests is more important than optimizing page-weight of the single page after you log in/out)
$config['oasis_shared_js'] = array(
	'type' => AssetsManager::TYPE_JS,
	'assets' => array(
		// shared libraries
		'#group_oasis_jquery',
		'#group_oasis_nojquery_shared_js',
		'#group_oasis_extensions_js',
	)
);

$config['oasis_nojquery_shared_js_user'] = array(
	'type' => AssetsManager::TYPE_JS,
	'assets' => array(
		'#group_oasis_nojquery_shared_js',
		// the only time this group is used currently is inside of this _nojquery_ package, for Ad-Loading experiment
		'#group_oasis_noads_extensions_js',
		'#group_oasis_user_js',
	)
);

$config['oasis_nojquery_shared_js_anon'] = array(
	'type' => AssetsManager::TYPE_JS,
	'assets' => array(
		'#group_oasis_nojquery_shared_js',
		// the only time this group is used currently is inside of this _nojquery_ package, for Ad-Loading experiment
		'#group_oasis_noads_extensions_js',
		'#group_oasis_anon_js',
	)
);

$config['oasis_nojquery_shared_js'] = array(
	'type' => AssetsManager::TYPE_JS,
	'assets' => array(

		// shared libraries
		'//extensions/wikia/AssetsManager/js/AssetsManager.js',
		'//extensions/wikia/JSMessages/js/JSMessages.js',
		'//extensions/wikia/CategorySelect/js/CategorySelect.view.js',
		'//extensions/wikia/WikiaStyleGuide/js/Form.js',
		'//resources/wikia/modules/csspropshelper.js',
		'//extensions/wikia/EditPreview/js/preview.js',

		// oasis specific files
		'//resources/wikia/libraries/bootstrap/tooltip.js',
		'//resources/wikia/libraries/bootstrap/popover.js',
		'//skins/oasis/js/hoverMenu.js',
		'//skins/oasis/js/PageHeader.js',
		'//skins/oasis/js/Search.js',
		'//skins/oasis/js/WikiaFooter.js',
		'//skins/oasis/js/CorporateFooter.js',
		'//skins/oasis/js/buttons.js',
		'//skins/oasis/js/WikiHeader.js',
		'//skins/oasis/js/Interlang.js',
		'//skins/oasis/js/WikiaNotifications.js',
		'//skins/oasis/js/FirefoxFindFix.js',
		'//skins/oasis/js/isTouchScreen.js',
		'//skins/oasis/js/tabs.js',
		'//skins/oasis/js/SharingToolbar/SharingToolbarLoader.js',
		'//skins/oasis/js/Tracking.js',
	)
);

//anon JS
// Note: Owen moved getSiteJS call from both anon_js and user_js to OasisController::loadJS
// so that common.js is loaded last so it has less chance of breaking other things
$config['oasis_anon_js'] = array(
	'type' => AssetsManager::TYPE_JS,
	'assets' => array(
		'//extensions/wikia/AdEngine/js/Exitstitial.js',
		'//extensions/wikia/UserLogin/js/UserLoginFacebook.js',
		'//extensions/wikia/UserLogin/js/UserLoginFacebookForm.js',
		'//extensions/wikia/UserLogin/js/UserLoginDropdown.js',
	)
);

//user JS
$config['oasis_user_js'] = array(
	'type' => AssetsManager::TYPE_JS,
	'assets' => array(
		'//extensions/wikia/UserLogin/js/UserLoginFacebook.js',
		'//extensions/wikia/UserLogin/js/UserLoginFacebookForm.js',
	)
);

/** GameGuides */
$config['gameguides_scss'] = array(
	'type' => AssetsManager::TYPE_SCSS,
	'skin' => 'wikiamobile',
	'assets' => array(
		'//extensions/wikia/GameGuides/css/GameGuides.scss'
	)
);

//this combines couple of WikiaMobile groups to make it possible to load all js via one request
//also unfortunately loads bit more than needed not to change WikiaMobile assets too much
$config['gameguides_js'] = array(
	'type' => AssetsManager::TYPE_JS,
	'skin' => 'wikiamobile',
	'assets' => array(
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
		'//resources/wikia/modules/log.js',

		//tracker
		'#group_tracker_js',

		//platform components
		'//extensions/wikia/JSMessages/js/JSMessages.js',
		'//extensions/wikia/JSSnippets/js/JSSnippets.js',

		//feature detection
		'//extensions/wikia/WikiaMobile/js/features.js',
		'//extensions/wikia/WikiaMobile/js/feature-detects/positionfixed.wikiamobile.js',
		'//extensions/wikia/WikiaMobile/js/feature-detects/overflow.wikiamobile.js',
		'//extensions/wikia/GameGuides/js/isGameGuides.js',

		//polyfills
		'//extensions/wikia/WikiaMobile/js/viewport.js',

		//groups
		'#group_wikiamobile_tables_js',
		'#group_wikiamobile_scroll_js',
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
	)
);

/** WikiaMobile **/
$config['wikiamobile_scss'] = array(
	'type' => AssetsManager::TYPE_SCSS,
	'skin' => 'wikiamobile',
	'assets' => array(
		'//extensions/wikia/WikiaMobile/css/WikiaMobile.scss',
	)
);

$config['wikiamobile_404_scss'] = array(
	'type' => AssetsManager::TYPE_SCSS,
	'skin' => 'wikiamobile',
	'assets' => array(
		'//extensions/wikia/WikiaMobile/css/404.scss',
	)
);

$config['wikiamobile_404_js'] = array(
	'type' => AssetsManager::TYPE_JS,
	'skin' => 'wikiamobile',
	'assets' => array(
		'//extensions/wikia/WikiaMobile/js/404.js',
	)
);

//loaded at the bottom of the page in the body section
$config['wikiamobile_js_body_minimal'] = array(
	'type' => AssetsManager::TYPE_JS,
	'skin' => 'wikiamobile',
	'assets' => array(
		//libraries/frameworks
		'//resources/wikia/libraries/modil/modil.js',
		'//resources/jquery/jquery-2.0.3.js',

		//core modules
		'//resources/wikia/modules/window.js',
		'//resources/wikia/modules/location.js',
		'//resources/wikia/modules/localStorage.js',
		'//resources/wikia/modules/querystring.js',
		'//resources/wikia/modules/cookies.js',
		//depends on querystring.js and cookies.js
		'//resources/wikia/modules/log.js',

		//feature detection
		'//extensions/wikia/WikiaMobile/js/features.js',
		'//extensions/wikia/WikiaMobile/js/feature-detects/positionfixed.wikiamobile.js',

		//tracker
		'#group_tracker_js',

		//modules
		'//resources/wikia/modules/nirvana.js',
		'//resources/wikia/modules/loader.js',
		'//resources/wikia/modules/cache.js',

		// video
		'//extensions/wikia/VideoHandlers/js/VideoBootstrap.js',
	)
);

//loaded at the bottom of the page in the body section
$config['wikiamobile_js_body_full'] = array(
	'type' => AssetsManager::TYPE_JS,
	'skin' => 'wikiamobile',
	'assets' => array(
		'#group_wikiamobile_js_body_minimal',

		//feature detection
		'//extensions/wikia/WikiaMobile/js/feature-detects/overflow.wikiamobile.js',

		//polyfills
		'//extensions/wikia/WikiaMobile/js/viewport.js',

		//platform components
		'//extensions/wikia/AssetsManager/js/AssetsManager.js',
		'//extensions/wikia/JSMessages/js/JSMessages.js',
		'//extensions/wikia/JSSnippets/js/JSSnippets.js',

		//modules
		'//resources/wikia/libraries/sloth/sloth.js',
		'//resources/wikia/modules/thumbnailer.js',
		'//extensions/wikia/WikiaMobile/js/lazyload.js',
		'//extensions/wikia/WikiaMobile/js/track.js',
		'//extensions/wikia/WikiaMobile/js/events.js',
		'//extensions/wikia/WikiaMobile/js/toc.js',
		'//extensions/wikia/WikiaMobile/js/throbber.js',
		'//extensions/wikia/WikiaMobile/js/toast.js',
		'//extensions/wikia/WikiaMobile/js/pager.js',
		'//extensions/wikia/WikiaMobile/js/modal.js',
		'//extensions/wikia/WikiaMobile/js/media.class.js',
		'//extensions/wikia/WikiaMobile/js/media.js',
		'//extensions/wikia/WikiaMobile/js/sections.js',
		'//extensions/wikia/WikiaMobile/js/layout.js',
		'//extensions/wikia/WikiaMobile/js/navigation.wiki.js',
		'//extensions/wikia/WikiaMobile/js/topbar.js',
		'//extensions/wikia/WikiaMobile/js/popover.js',
		'//extensions/wikia/WikiaMobile/js/hide_url_bar.js',
		'//extensions/wikia/WikiaMobile/js/share.js',

		//entrypoint
		'//extensions/wikia/WikiaMobile/js/WikiaMobile.js',
	)
);

//mustache is generic but currently only used by smartbanner move if needed
$config['wikiamobile_smartbanner_js'] = [
	'type' => AssetsManager::TYPE_JS,
	'skin' => 'wikiamobile',
	'assets' => [
		'//resources/wikia/libraries/mustache/mustache.js',
		'//extensions/wikia/WikiaMobile/SmartBanner/smartbanner.js',
	]
];

$config['wikiamobile_smartbanner_init_js'] = [
	'type' => AssetsManager::TYPE_JS,
	'skin' => 'wikiamobile',
	'assets' => [
		'//extensions/wikia/WikiaMobile/SmartBanner/smartbanner.bootstrap.js',
	]
];

$config['wikiamobile_tables_js'] = array(
	'type' => AssetsManager::TYPE_JS,
	'skin' => 'wikiamobile',
	'assets' => array(
		'//extensions/wikia/WikiaMobile/js/tables.js'
	)
);

$config['wikiamobile_js_ads'] = array(
	'type' => AssetsManager::TYPE_JS,
	'skin' => 'wikiamobile',
	'assets' => array(
		//libraries
		//I wan't to minimize how much data we have to transfer
		//We currently don't have JS minimizer so I used minified version of it
		'//resources/wikia/libraries/postscribe/postscribe.min.js',

		//advertisement "core"
		'//extensions/wikia/AdEngine/js/AdLogicPageLevelParams.js',
		'//extensions/wikia/AdEngine/js/DartUrl.js',
		'//extensions/wikia/AdEngine/js/WikiaDartMobileHelper.js',
		'//extensions/wikia/AdEngine/js/WikiaDartVideoHelper.js',

		//modules
		'//resources/wikia/modules/geo.js',
		'//extensions/wikia/WikiaMobile/js/ads.js',
		'//extensions/wikia/WikiaMobile/js/floatingAd.js'
	)
);

$config['wikiamobile_mediagallery_js'] = array(
	'type' => AssetsManager::TYPE_JS,
	'skin' => 'wikiamobile',
	'assets' => array(
		'//extensions/wikia/WikiaMobile/js/mediagallery.js'
	)
);

$config['wikiamobile_autocomplete_js'] = array(
	'type' => AssetsManager::TYPE_JS,
	'skin' => 'wikiamobile',
	'assets' => array(
		'//extensions/wikia/WikiaMobile/js/autocomplete.js'
	)
);

$config['wikiamobile_scroll_js'] = array(
	'type' => AssetsManager::TYPE_JS,
	'skin' => 'wikiamobile',
	'assets' => array(
		'//extensions/wikia/WikiaMobile/js/scroll.wikiamobile.js'
	)
);

$config['wikiamobile_categorypage_js'] = array(
	'type' => AssetsManager::TYPE_JS,
	'skin' => 'wikiamobile',
	'assets' => array(
		'//extensions/wikia/WikiaMobile/js/category_page.js',
	)
);

$config['wikiapoll_wikiamobile_scss'] = array(
	'type' => AssetsManager::TYPE_SCSS,
	'skin' => 'wikiamobile',
	'assets' => array(
		'//extensions/wikia/WikiaPoll/css/WikiaPoll.wikiamobile.scss',
	)
);

$config['wikiapoll_wikiamobile_js'] = array(
	'type' => AssetsManager::TYPE_JS,
	'skin' => 'wikiamobile',
	'assets' => array(
		'//extensions/wikia/WikiaPoll/js/WikiaPoll.wikiamobile.js',
	)
);


$config['special_contact_wikiamobile_scss'] = array(
	'type' => AssetsManager::TYPE_SCSS,
	'skin' => 'wikiamobile',
	'assets' => array(
		'//extensions/wikia/SpecialContact2/SpecialContact.wikiamobile.scss',
	)
);

$config['special_contact_wikiamobile_js'] = array(
	'type' => AssetsManager::TYPE_JS,
	'skin' => 'wikiamobile',
	'assets' => array(
		'//extensions/wikia/SpecialContact2/SpecialContact.wikiamobile.js',
	)
);

/** MonoBook **/
$config['monobook_js'] = array(
	'type' => AssetsManager::TYPE_JS,
	'assets' => array(
		'#group_oasis_wikia_js',
		'#group_oasis_jquery',
		'#group_articlecomments_js',

		// TODO: remove dependency on YUI (see BugId:3116)
		'//resources/wikia/libraries/yui/utilities/utilities.js',
		'//resources/wikia/libraries/yui/cookie/cookie-beta.js',
		'//resources/wikia/libraries/yui/container/container.js',
		'//resources/wikia/libraries/yui/autocomplete/autocomplete.js',
		'//resources/wikia/libraries/yui/logger/logger.js',
		'//resources/wikia/libraries/yui/menu/menu.js',
		'//resources/wikia/libraries/yui/tabview/tabview.js',
		'//resources/wikia/libraries/yui/extra/tools-min.js',

//		'//resources/mediawiki/mediawiki.util.js', # instead of //skins/common/wikibits.js'
//		'//skins/common/ajax.js',

		'//skins/monobook/main.js',
		'//resources/wikia/modules/lazyqueue.js',
		'//extensions/wikia/JSMessages/js/JSMessages.js',
		'//extensions/wikia/AjaxLogin/AjaxLoginBindings.js',
		'//extensions/wikia/ImageLazyLoad/js/ImageLazyLoad.js',
		'//extensions/FBConnect/fbconnect.js',
		'//extensions/wikia/AdEngine/AdProviderOpenX.js',
		'//extensions/wikia/AdEngine/LazyLoadAds.js',
		'//extensions/wikia/AdEngine/ghost/gw-12.4.4/lib/gw.src.js',
		'//extensions/wikia/GlobalNotification/GlobalNotification.js',
		'//extensions/wikia/VideoHandlers/js/VideoBootstrap.js',

		'//resources/wikia/libraries/bootstrap/tooltip.js',
		'//resources/wikia/libraries/bootstrap/popover.js',
	)
);

/********** Extensions packages **********/

/** Article Comments **/
$config['articlecomments_js'] = array(
	'type' => AssetsManager::TYPE_JS,
	'skin' => array('oasis', 'monobook'),
	'assets' => array(
		'//extensions/wikia/ArticleComments/js/ArticleComments.js'
	)
);

$config['articlecomments_scss'] = array(
	'type' => AssetsManager::TYPE_SCSS,
	'skin' => 'oasis',
	'assets' => array(
		'//skins/oasis/css/core/ArticleComments.scss'
	)
);

$config['articlecomments_mini_editor_scss'] = array(
	'type' => AssetsManager::TYPE_SCSS,
	'skin' => 'oasis',
	'assets' => array(
		'#group_articlecomments_scss',
		'//extensions/wikia/MiniEditor/css/MiniEditor.scss',
		'//extensions/wikia/MiniEditor/css/ArticleComments/ArticleComments.scss'
	)
);

$config['articlecomments_js_wikiamobile'] = array(
	'type' => AssetsManager::TYPE_JS,
	'skin' => 'wikiamobile',
	'assets' => array(
		'//extensions/wikia/ArticleComments/js/ArticleComments.wikiamobile.js'
	)
);

$config['articlecomments_init_js_wikiamobile'] = array(
	'type' => AssetsManager::TYPE_JS,
	'skin' => 'wikiamobile',
	'assets' => array(
		'//extensions/wikia/ArticleComments/js/ArticleComments_init.wikiamobile.js'
	)
);

$config['articlecomments_scss_wikiamobile'] = array(
	'type' => AssetsManager::TYPE_SCSS,
	'skin' => 'wikiamobile',
	'assets' => array(
		'//extensions/wikia/ArticleComments/css/ArticleComments.wikiamobile.scss'
	)
);

$config['filepage_js_wikiamobile'] = array(
	'type' => AssetsManager::TYPE_JS,
	'skin' => 'wikiamobile',
	'assets' => array(
		'//extensions/wikia/FilePage/js/FilePage.wikiamobile.js'
	)
);

$config['filepage_scss_wikiamobile'] = array(
	'type' => AssetsManager::TYPE_SCSS,
	'skin' => 'wikiamobile',
	'assets' => array(
		'//extensions/wikia/FilePage/css/FilePage.wikiamobile.scss'
	)
);

$config['relatedpages_js'] = array(
	'type' => AssetsManager::TYPE_JS,
	'skin' => [ 'oasis', 'monobook', 'wikiamobile' ],
	'assets' => array(
		'//resources/wikia/libraries/sloth/sloth.js',
		'//resources/wikia/libraries/mustache/mustache.js',
		'//extensions/wikia/RelatedPages/js/RelatedPages.js'
	)
);

/** EditPageLayout **/
$config['rte'] = array(
	'type' => AssetsManager::TYPE_JS,
	'assets' => array(
			'#function_AssetsConfig::getRTEAssets'
	)
);
// Generic edit page JavaScript
$config['epl'] = array(
	'type' => AssetsManager::TYPE_JS,
	'assets' => array(
			'#function_AssetsConfig::getEPLAssets',
	)
);
// Generic edit page JavaScript + reskined rich text editor
$config['eplrte'] = array(
	'type' => AssetsManager::TYPE_JS,
	'assets' => array(
		'#group_epl',
		'#group_rte'
	)
);

/** MiniEditor **/
$config['mini_editor_js'] = array(
	'type' => AssetsManager::TYPE_JS,
	'assets' => array(
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
	)
);

$config['mini_editor_rte_js'] = array(
	'type' => AssetsManager::TYPE_JS,
	'assets' => array(
		'#group_mini_editor_js',
		'#group_rte'
	)
);

$config['chat_js2'] = array(
	'type' => AssetsManager::TYPE_JS,
	'assets' => array(
		'#group_oasis_jquery',

		// shared libraries
		'//extensions/wikia/AssetsManager/js/AssetsManager.js',
		'//extensions/wikia/JSMessages/js/JSMessages.js',

		'//resources/wikia/modules/querystring.js',
		'//resources/wikia/modules/cookies.js',
		//depends on querystring.js and cookies.js
		'//resources/wikia/modules/log.js',

		'//extensions/wikia/Chat2/js/lib/socket.io.client.js',
		// must be before controllers.js
		'//extensions/wikia/Chat2/js/emoticons.js',
		'//extensions/wikia/Chat2/js/lib/underscore.js',
		'//extensions/wikia/Chat2/js/lib/backbone.js',
		'//extensions/wikia/Chat2/js/models/models.js',
		'//extensions/wikia/Chat2/js/controllers/controllers.js',
		'//extensions/wikia/Chat2/js/views/views.js',
		'//extensions/wikia/Chat2/js/views/ChatBanModal.js',
	)
);

$config['chat_ban_js'] = array(
	'type' => AssetsManager::TYPE_JS,
	'assets' => array(
		'//extensions/wikia/Chat2/js/views/ChatBanModal.js',
		'//extensions/wikia/Chat2/js/controllers/ChatBanModalLogs.js'
	)
);

/** ThemeDesigner **/
$config['theme_designer_js'] = array(
	'type' => AssetsManager::TYPE_JS,
	'assets' => array(
		'#group_oasis_wikia_js',
		'#group_oasis_jquery',

		'//resources/jquery.ui/jquery.ui.widget.js',
		'//resources/jquery.ui/jquery.ui.mouse.js',
		'//resources/jquery.ui/jquery.ui.slider.js',
		'//resources/jquery.ui/jquery.ui.core.js',
		'//resources/wikia/modules/aim.js',
		'//resources/wikia/libraries/bootstrap/tooltip.js',
		'//resources/wikia/libraries/bootstrap/popover.js',
		'//extensions/wikia/JSMessages/js/JSMessages.js',
		'//extensions/wikia/ThemeDesigner/js/ThemeDesigner.js'
	)
);

/** PhotoPop **/
$config['photopop'] = array(
	'type' => AssetsManager::TYPE_JS,
	'assets' => array(
		'//resources/wikia/modules/cookies.js',
		'//resources/wikia/modules/querystring.js',
		'//resources/wikia/modules/log.js',
		'//resources/wikia/libraries/mustache/mustache.js',
		'//resources/wikia/libraries/my.class/my.class.js',
		'//extensions/wikia/PhotoPop/shared/lib/store.js',
		'//extensions/wikia/PhotoPop/shared/lib/observable.js',
		'//extensions/wikia/PhotoPop/shared/lib/reqwest.js',
		'//extensions/wikia/PhotoPop/shared/lib/classlist.js',
		'//extensions/wikia/PhotoPop/shared/lib/wikia.js',
		'//extensions/wikia/PhotoPop/shared/lib/require.js',
		'#group_tracker_js',
	)
);

/** MessageWall **/
$config['wall_js'] = array(
	'type' => AssetsManager::TYPE_JS,
	'assets' => array(
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
		'//extensions/wikia/Wall/js/WallSetup.js'
	)
);

$config['wall_mini_editor_js'] = array(
	'type' => AssetsManager::TYPE_JS,
	'assets' => array(
		'//extensions/wikia/MiniEditor/js/Wall/Wall.Setup.js',
		'//extensions/wikia/MiniEditor/js/Wall/Wall.Animations.js',
		'//extensions/wikia/MiniEditor/js/Wall/Wall.EditMessageForm.js',
		'//extensions/wikia/MiniEditor/js/Wall/Wall.NewMessageForm.js',
		'//extensions/wikia/MiniEditor/js/Wall/Wall.ReplyMessageForm.js'
	)
);

$config['wall_history_js'] = array(
	'type' => AssetsManager::TYPE_JS,
	'assets' => array(
		'//extensions/wikia/Wall/js/Wall.js',
		'//extensions/wikia/Wall/js/WallHistory.js',
		'//extensions/wikia/Wall/js/WallSortingBar.js'
	)
);

/** Forum **/
$config['forum_js'] = array(
	'type' => AssetsManager::TYPE_JS,
	'assets' => array(
//		'#group_wall_js',
		'//extensions/wikia/Forum/js/Forum.js',
		'//extensions/wikia/Forum/js/ForumNewMessageForm.js',
		'//extensions/wikia/Forum/js/ForumSortingBar.js'
	)
);

/** Wall MessageTopic (certain parts of Wall and Forum uses this) **/
$config['wall_topic_js'] = array(
	'type' => AssetsManager::TYPE_JS,
	'assets' => array(
		'//extensions/wikia/Wall/js/MessageTopic.js',
	)
);

$config['forum_mini_editor_js'] = array(
	'type' => AssetsManager::TYPE_JS,
	'assets' => array(
		'#group_wall_mini_editor_js',
		'//extensions/wikia/MiniEditor/js/Forum/Forum.Setup.js',
//		'//extensions/wikia/MiniEditor/js/Forum/Forum.Animations.js',
//		'//extensions/wikia/MiniEditor/js/Forum/Forum.EditMessageForm.js',
		'//extensions/wikia/MiniEditor/js/Forum/Forum.NewMessageForm.js',
//		'//extensions/wikia/MiniEditor/js/Forum/Forum.ReplyMessageForm.js'
	)
);

/** RelatedVideos **/
$config['relatedvideos_js'] = array(
	'skin' => array( 'oasis' ), //we have no support for relatedvideos in wikiamobile and monobook as for now
	'type' => AssetsManager::TYPE_JS,
	'assets' => array(
		'//extensions/wikia/RelatedVideos/js/RelatedVideos.js'
	)
);

$config['relatedvideos_scss'] = array(
	'type' => AssetsManager::TYPE_SCSS,
	'skin' => array( 'oasis' ), //we have no support for relatedvideos in wikiamobile and monobook as for now
	'assets' => array(
		'//extensions/wikia/RelatedVideos/css/RelatedVideos.scss'
	)
);

$config['VET_js'] = array(
	'skin' => array( 'oasis' ),
	'type' => AssetsManager::TYPE_JS,
	'assets' => array(
		'//extensions/wikia/WikiaStyleGuide/js/Dropdown.js',
		'//extensions/wikia/VideoEmbedTool/js/VET.js',
		'//resources/jquery.ui/jquery.ui.widget.js',
		'//resources/jquery.ui/jquery.ui.mouse.js',
		'//resources/jquery.ui/jquery.ui.slider.js',
	)
);

/**
 * @name VideoPageTool
 * @description Assets for the VideoPageTool, same styles as SpecialMarketingToolbox
 * @TODO: decide if we want to split the js/css into two different packages for index and edit pages
 */

$config['videopageadmin_js'] = array(
	'skin' => array( 'oasis' ),
	'type' => AssetsManager::TYPE_JS,
	'assets' => array(
		// Library Dependencies
		'//resources/jquery.ui/jquery.ui.core.js',
		'//resources/jquery.ui/jquery.ui.datepicker.js',
		'//resources/jquery/jquery.validate.js',
		'//resources/wikia/modules/aim.js',
		'//extensions/wikia/WikiaMiniUpload/js/WMU.js',
		// TODO: probably move this jQuery plugin to /resources at some point
		'//extensions/wikia/VideoPageTool/js/views/jquery.switcher.js',

		'//extensions/wikia/VideoPageTool/js/models/videopageadmin.datepicker.js',
		'//extensions/wikia/VideoPageTool/js/models/videopageadmin.thumbnail.js',
		'//extensions/wikia/VideoPageTool/js/models/videopageadmin.validator.js',
		'//extensions/wikia/VideoPageTool/js/views/videopageadmin.datepicker.js',
		'//extensions/wikia/VideoPageTool/js/views/videopageadmin.index.js',
		'//extensions/wikia/VideoPageTool/js/views/videopageadmin.thumbnailupload.js',
		'//extensions/wikia/VideoPageTool/js/views/videopageadmin.edit.js',
	)
);

$config['videopageadmin_css'] = array(
	'skin' => array( 'oasis' ),
	'type' => AssetsManager::TYPE_CSS,
	'assets' => array(
		'//resources/jquery.ui/themes/default/jquery.ui.datepicker.css'
	)
);

$config['videopageadmin_scss'] = array(
	'skin' => array( 'oasis' ),
	'type' => AssetsManager::TYPE_SCSS,
	'assets' => array(
		'//skins/oasis/css/modules/CorporateDatepicker.scss',
		'//extensions/wikia/WikiaMiniUpload/css/WMU.scss',
		'//extensions/wikia/VideoPageTool/css/Admin/VideoPageTool.scss',
		'//extensions/wikia/VideoPageTool/css/Admin/VideoPageTool_Header.scss',
	)
);

/*
 * @name videohomepage
 * @description Assets for http://video.wikia.com/
 */

$config['videohomepage_js'] = array(
	'skin' => array( 'oasis' ),
	'type' => AssetsManager::TYPE_JS,
	'assets' => array(
		'//resources/wikia/libraries/jquery/bxslider/jquery.bxslider.js',
		'//extensions/wikia/VideoPageTool/js/models/videohomepage.featured.js',
		'//extensions/wikia/VideoPageTool/js/views/videohomepage.featured.js',
		'//extensions/wikia/VideoPageTool/js/views/videohomepage.search.js',
		'//extensions/wikia/VideoPageTool/js/views/videohomepage.index.js',
	)
);

$config['videohomepage_scss'] = array(
	'skin' => array( 'oasis' ),
	'type' => AssetsManager::TYPE_SCSS,
	'assets' => array(
		// Dependencies
		'//resources/wikia/libraries/jquery/bxslider/jquery.bxslider.scss',
		// VideoHomePage
		'//extensions/wikia/VideoPageTool/css/HomePage/main.scss',
		'//extensions/wikia/VideoPageTool/css/HomePage/featured.scss',
	)
);

/** UserLogin **/
$config['userlogin_scss_wikiamobile'] = array(
	'type' => AssetsManager::TYPE_SCSS,
	'skin' => 'wikiamobile',
	'assets' => array(
			'//extensions/wikia/UserLogin/css/UserLogin.wikiamobile.scss'
	)
);

$config['userlogin_js_wikiamobile'] = array(
	'type' => AssetsManager::TYPE_JS,
	'skin' => 'wikiamobile',
	'assets' => array(
			'//extensions/wikia/UserLogin/js/UserLoginSpecial.wikiamobile.js'
	)
);

$config['userlogin_js_wikiamobile_fbconnect'] = array(
	'type' => AssetsManager::TYPE_JS,
	'skin' => 'wikiamobile',
	'assets' => array(
		'#external_http://connect.facebook.net/en_US/all.js',
		'#group_userlogin_js_wikiamobile',
		'//extensions/wikia/UserLogin/js/UserLoginFacebook.wikiamobile.js',
	)
);

$config['userlogin_facebook_js_wikiamobile'] = array(
	'type' => AssetsManager::TYPE_JS,
	'skin' => 'wikiamobile',
	'assets' => array(
		'//extensions/wikia/UserLogin/js/UserLoginFacebook.wikiamobile.js'
	)
);

/** UserProfilePage **/
$config['userprofilepage_scss_wikiamobile'] = array(
	'type' => AssetsManager::TYPE_SCSS,
	'skin' => 'wikiamobile',
	'assets' => array(
		'//extensions/wikia/UserProfilePageV3/css/UserProfilePage.wikiamobile.scss'
	)
);

/** WikiaHomepage **/
$config['wikiahomepage_scss'] = array(
	'type' => AssetsManager::TYPE_SCSS,
	'skin' => 'oasis',
	'assets' => array(
		'//resources/wikia/libraries/bootstrap/popover.scss',
		'//skins/oasis/css/wikiagrid.scss',
		'//skins/oasis/css/modules/WikiaMediaCarousel.scss',
	)
);

$config['wikiahomepage_js'] = array(
	'type' => AssetsManager::TYPE_JS,
	'skin' => 'oasis',
	'assets' => array(
		'//resources/wikia/libraries/bootstrap/popover.js',
		'//extensions/wikia/WikiaHomePage/js/WikiaHomePage.js',
	)
);

$config['wikiahomepage_scss_wikiamobile'] = array(
	'type' => AssetsManager::TYPE_SCSS,
	'skin' => 'wikiamobile',
	'assets' => array(
		'//extensions/wikia/WikiaHomePage/css/WikiaHomePage.wikiamobile.scss'
	)
);

/** WikiaHubsV2 **/
$config['wikiahubs_v2'] = array(
	'type' => AssetsManager::TYPE_JS,
	'skin' => array('oasis'),
	'assets' => array(
		'//extensions/wikia/WikiaHubsV2/js/WikiaHubsV2.js'
	)
);

$config['wikiahubs_v2_modal'] = array(
	'type' => AssetsManager::TYPE_JS,
	'skin' => array('oasis'),
	'assets' => array(
		'//extensions/wikia/WikiaHubsV2/js/WikiaHubsV2Modals.js'
	)
);

$config['wikiahubs_v2_scss'] = array(
	'type' => AssetsManager::TYPE_SCSS,
	'skin' => array('oasis'),
	'assets' => array(
		'//extensions/wikia/WikiaHubsV2/css/WikiaHubsV2.scss'
	)
);

$config['wikiahubs_v2_scss_mobile'] = array(
	'type' => AssetsManager::TYPE_SCSS,
	'skin' => array('wikiamobile'),
	'assets' => array(
		'//extensions/wikia/WikiaHubsV2/css/WikiaHubsV2Mobile.scss'
	)
);

/** WAMPage **/
$config['wampage_scss'] = array(
	'type' => AssetsManager::TYPE_SCSS,
	'skin' => array('oasis'),
	'assets' => array(
		'//extensions/wikia/WAMPage/css/WAMPage.scss'
	)
);

$config['wampage_js'] = array(
	'type' => AssetsManager::TYPE_JS,
	'skin' => array('oasis'),
	'assets' => array(
		'//extensions/wikia/WAMPage/js/WAMPage.js',
	)
);

/** WikiaSearch **/
$config['wikiasearch_js_wikiamobile'] = array(
    'type' => AssetsManager::TYPE_JS,
    'skin' => 'wikiamobile',
    'assets' => array(
        '//extensions/wikia/Search/js/WikiaSearch.wikiamobile.js'
    )
);

$config['wikiasearch_scss_wikiamobile'] = array(
    'type' => AssetsManager::TYPE_SCSS,
    'skin' => 'wikiamobile',
    'assets' => array(
        '//extensions/wikia/Search/css/WikiaSearch.wikiamobile.scss'
    )
);

/** Places **/
$config['places_js'] = array(
	'skin' => array( 'oasis', 'monobook', 'wikiamobile' ),
	'type' => AssetsManager::TYPE_JS,
	'assets' => array(
			'//extensions/wikia/Places/js/Places.js'
	)
);

$config['places_css'] = array(
	'type' => AssetsManager::TYPE_CSS,
	'skin' => array( 'oasis', 'monobook', 'wikiamobile' ),
	'assets' => array(
			'//extensions/wikia/Places/css/Places.css',
	)
);

/** WikiaPhotoGallery **/
$config['wikiaphotogallery_slider_js_wikiamobile'] = array(
	'skin' => 'wikiamobile',
	'type' => AssetsManager::TYPE_JS,
	'assets' => array(
			'//extensions/wikia/WikiaPhotoGallery/js/WikiaPhotoGallery.slider.wikiamobile.js'
	)
);

$config['wikiaphotogallery_slider_scss_wikiamobile'] = array(
	'type' => AssetsManager::TYPE_SCSS,
	'skin' => 'wikiamobile',
	'assets' => array(
			'//extensions/wikia/WikiaPhotoGallery/css/WikiaPhotoGallery.slidertag.wikiamobile.scss'
	)
);

// ImageDrop
$config['imagedrop_js'] = array(
	'skin' => array( 'monobook', 'oasis' ),
	'type' => AssetsManager::TYPE_JS,
	'assets' => array(
		'//extensions/wikia/hacks/ImageDrop/js/ImageDrop.js',
		'//resources/wikia/libraries/jquery/filedrop/jquery.filedrop.js'
	)
);

$config['imagedrop_scss'] = array(
	'type' => AssetsManager::TYPE_SCSS,
	'skin' => array( 'monobook', 'oasis' ),
	'assets' => array(
		'//extensions/wikia/ImageDrop/css/ImageDrop.scss'
	)
);

/** AnalyticsEngine **/
/** Note: this group is also used in Oasis! */
$config['analytics_gas_js'] = array(
	'type' => AssetsManager::TYPE_JS,
	'skin' => array( 'wikiamobile' ),
	'assets' => array(
		'//extensions/wikia/AnalyticsEngine/js/analytics_prod.js'
	)
);

/** WikiMap Extension **/
$config['wiki_map_js'] = array(
    'type' => AssetsManager::TYPE_JS,
    'assets' => array(
        '//extensions/wikia/WikiMap/js/d3.v2.js',
        '//extensions/wikia/WikiMap/js/jquery.xcolor.js',
        '//extensions/wikia/WikiMap/js/wikiMapIndexContent.js'
    )
);

/* Special:Leaderboard in AchievementsII extensions */
$config['special_leaderboard_oasis_js'] = array(
	'type' => AssetsManager::TYPE_JS,
	'skin' => array( 'oasis' ),
	'assets' => array(
		'//resources/wikia/libraries/bootstrap/popover.js',
		'//extensions/wikia/AchievementsII/js/SpecialLeaderboard.js',
		'//skins/oasis/js/Achievements.js',
	)
);

$config['special_leaderboard_oasis_css'] = array(
	'type' => AssetsManager::TYPE_SCSS,
	'skin' => array( 'oasis' ),
	'assets' => array(
		'//resources/wikia/libraries/bootstrap/popover.scss',
		'//extensions/wikia/AchievementsII/css/leaderboard_oasis.scss',
	)
);

/* Achievements module */
$config['achievements_css'] = array(
	'type' => AssetsManager::TYPE_SCSS,
	'skin' => array( 'oasis' ),
	'assets' => array(
		'//resources/wikia/libraries/bootstrap/popover.scss',
		'//extensions/wikia/AchievementsII/css/oasis.scss',
	)
);

$config['achievements_js'] = array(
	'type' => AssetsManager::TYPE_JS,
	'skin' => array( 'oasis' ),
	'assets' => array(
		'//resources/wikia/libraries/bootstrap/popover.js',
		'//skins/oasis/js/Achievements.js',
	)
);

/* Special:Videos */
$config['special_videos_js'] = array(
	'type' => AssetsManager::TYPE_JS,
	'skin' => array( 'oasis', 'monobook' ),
	'assets' => array(
		'//extensions/wikia/SpecialVideos/js/SpecialVideos.js',
		'//extensions/wikia/WikiaStyleGuide/js/Dropdown.js',
	)
);

$config['special_videos_css'] = array(
	'type' => AssetsManager::TYPE_SCSS,
	'skin' => array( 'oasis', 'monobook' ),
	'assets' => array(
		'//extensions/wikia/SpecialVideos/css/SpecialVideos.scss',
		'//extensions/wikia/WikiaStyleGuide/css/Dropdown.scss',
	)
);

$config['special_videos_css_monobook'] = array(
	'type' => AssetsManager::TYPE_SCSS,
	'skin' => array( 'monobook' ),
	'assets' => array(
		'//skins/oasis/css/wikiagrid.scss',
	)
);

/* SharingToolbar */
$config['sharingtoolbar_js'] = array(
	'type' => AssetsManager::TYPE_JS,
	'assets' => array(
		'//skins/oasis/js/SharingToolbar/SharingToolbar.js',
		'//extensions/wikia/ShareButtons/js/ShareButtons.js',
		'#function_SharingToolbarController::getAssets'
	)
);

/* CategorySelect */
$config['categoryselect_edit_js'] = array(
	'type' => AssetsManager::TYPE_JS,
	'assets' => array(
		'//resources/jquery.ui/jquery.ui.core.js',
		'//resources/jquery.ui/jquery.ui.widget.js',
		'//resources/jquery.ui/jquery.ui.mouse.js',
		'//resources/jquery.ui/jquery.ui.sortable.js',
		'//extensions/wikia/CategorySelect/js/CategorySelect.js',
	)
);

/* FilePage */
$config['wikia_file_page_js'] = array(
	'type'=> AssetsManager::TYPE_JS,
	'assets' => array(
		'//extensions/wikia/FilePage/js/WikiaFilePage.js',
	)
);
$config['file_page_tabbed_js'] = array(
	'type'=> AssetsManager::TYPE_JS,
	'assets' => array(
		'//extensions/wikia/FilePage/js/FilePageTabbed.js',
	)
);
$config['file_page_tabbed_css'] = array(
	'type' =>AssetsManager::TYPE_SCSS,
	'assets' => array(
		'//extensions/wikia/FilePage/css/FilePageTabbed.scss',
	)
);

/* LyricFind */
$config['LyricsFindTracking'] = array(
	'type' => AssetsManager::TYPE_JS,
	'assets' => array(
		'//extensions/3rdparty/LyricWiki/LyricFind/js/modules/LyricFind.Tracker.js',
		'//extensions/3rdparty/LyricWiki/LyricFind/js/tracking.js',
	)
);

/* ManageWikiaHome */
$config['manage_wikia_home_js'] = array(
	'type' => AssetsManager::TYPE_JS,
	'assets' => array(
		'//extensions/wikia/SpecialManageWikiaHome/js/ManageWikiaHome.js',
		'//extensions/wikia/SpecialManageWikiaHome/js/CollectionsSetup.js',
		'//extensions/wikia/SpecialManageWikiaHome/js/CollectionsNavigation.js',
	)
);

$config['licensed_video_swap_js'] = array(
	'type' => AssetsManager::TYPE_JS,
	'assets' => array(
		'//extensions/wikia/LicensedVideoSwap/js/lvsTracker.js',
		'//extensions/wikia/LicensedVideoSwap/js/lvsCommonAjax.js',
		'//extensions/wikia/LicensedVideoSwap/js/lvsVideoControls.js',
		'//extensions/wikia/LicensedVideoSwap/js/lvsCallout.js',
		'//extensions/wikia/LicensedVideoSwap/js/lvsEllipses.js',
		'//extensions/wikia/LicensedVideoSwap/js/lvsSuggestions.js',
		'//extensions/wikia/LicensedVideoSwap/js/lvsSwapKeep.js',
		'//extensions/wikia/LicensedVideoSwap/js/lvsUndo.js',
		'//extensions/wikia/LicensedVideoSwap/js/lvsHistoryPage.js',
		'//extensions/wikia/LicensedVideoSwap/js/LicensedVideoSwap.js',
	),
);

/* SpecialCSS */
$config['special_css_js'] = array(
	'type' => AssetsManager::TYPE_JS,
	'assets' => array(
		'//extensions/wikia/SpecialCss/js/SpecialCss.js',
		'//resources/wikia/libraries/mustache/mustache.js',
		'//resources/wikia/libraries/mustache/jquery.mustache.js'
	)
);

/* UI repo JS API */
$config['ui_repo_api_js'] = array(
	'type' => AssetsManager::TYPE_JS,
	'assets' => array(
		'//resources/wikia/modules/nirvana.js',
		'//resources/wikia/modules/uifactory.js',
		'//resources/wikia/libraries/mustache/mustache.js',
		'//resources/wikia/modules/uicomponent.js'
	)
);

$config['touchstorm_scss'] = array(
	'type' => AssetsManager::TYPE_SCSS,
	'assets' => array(
		'//extensions/wikia/TouchStorm/css/TouchStorm.scss'
	)
);
$config['touchstorm_js'] = array(
	'type' => AssetsManager::TYPE_JS,
	'assets' => array(
		'//extensions/wikia/TouchStorm/js/TouchStorm.js'
	)
);


// FIXME: paths to dist
$config['api_docs_js'] = array(
	'type' => AssetsManager::TYPE_JS,
	'assets' => array(
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

	)
);

$config['api_docs_scss'] = array(
	'type' => AssetsManager::TYPE_SCSS,
	'assets' => array(
		'//extensions/wikia/ApiDocs/css/ApiDocs.scss',
	)
);
