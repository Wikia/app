<?php
/**
 * WikiaMobile
 *
 * @author Jakub Olek, Federico Lucignano
 */
if ( !defined( 'MEDIAWIKI' ) ) {
	echo "This file is part of MediaWiki, it is not a valid entry point.\n";
	exit( 1 );
}

$app = F::app();
$dir = dirname( __FILE__ );

/**
 * info
 */
$app->wg->append(
	'wgExtensionCredits',
	array(
		"name" => "WikiaMobile",
		"description" => "Mobile Skin for Wikia",
		"author" => array(
			'Federico "Lox" Lucignano <federico(at)wikia-inc.com>',
			'Jakub Olek <jakubolek(at)wikia-inc.com>'
		)
	),
	'other'
);

/**
 * settings
 */
//used internally to avoid an infinite wikitext expansion loop in galleries
//it might be moved to CommonSettings if it turns out to be desireable for wider usage
$wgWikiaMobileDisableMediaGrouping = false;

/**
 * classes
 */
$wgAutoloadClasses['WikiaMobileHooks'] = "{$dir}/WikiaMobileHooks.class.php";
$wgAutoloadClasses['WikiaMobileCategoryItem'] = "{$dir}/models/WikiaMobileCategoryModel.class.php";
$wgAutoloadClasses['WikiaMobileCategoryItemsCollection'] = "{$dir}/models/WikiaMobileCategoryModel.class.php";
$wgAutoloadClasses['WikiaMobileCategoryContents'] = "{$dir}/models/WikiaMobileCategoryModel.class.php";
$wgAutoloadClasses['ResourceVariablesGetter'] = "{$dir}/ResourceVariablesGetter.class.php";

/**
 * services
 */
$wgAutoloadClasses['WikiaMobileService'] = "{$dir}/WikiaMobileService.class.php";
$wgAutoloadClasses['WikiaMobileBodyService'] = "{$dir}/WikiaMobileBodyService.class.php";
$wgAutoloadClasses['WikiaMobilePageHeaderService'] = "{$dir}/WikiaMobilePageHeaderService.class.php";
$wgAutoloadClasses['WikiaMobileNavigationService'] = "{$dir}/WikiaMobileNavigationService.class.php";
$wgAutoloadClasses['WikiaMobileFooterService'] = "{$dir}/WikiaMobileFooterService.class.php";
$wgAutoloadClasses['WikiaMobileAdService'] = "{$dir}/WikiaMobileAdService.class.php";
$wgAutoloadClasses['WikiaMobileCategoryService'] = "{$dir}/WikiaMobileCategoryService.class.php";
$wgAutoloadClasses['WikiaMobileSharingService'] = "{$dir}/WikiaMobileSharingService.class.php";
$wgAutoloadClasses['WikiaMobileErrorService'] = "{$dir}/WikiaMobileErrorService.class.php";
$wgAutoloadClasses['WikiaMobileMediaService'] = "{$dir}/WikiaMobileMediaService.class.php";

/**
 * models
 */
$wgAutoloadClasses['WikiaMobileCategoryModel'] = "{$dir}/models/WikiaMobileCategoryModel.class.php";
$wgAutoloadClasses['WikiaMobileStatsModel'] = "{$dir}/models/WikiaMobileStatsModel.class.php";

/**
 * controllers
 */
$wgAutoloadClasses['WikiaMobileAppCacheController'] = "{$dir}/WikiaMobileAppCacheController.class.php";
$wgAutoloadClasses['WikiaMobileController'] = "{$dir}/WikiaMobileController.class.php";

/**
 * special pages
 */

/**
 * message files
 */
$wgExtensionMessagesFiles['WikiaMobile'] = "{$dir}/WikiaMobile.i18n.php";

JSMessages::registerPackage( 'WkMbl', array(
	'wikiamobile-hide-section',
	'wikiamobile-sharing-media-image',
	'wikiamobile-sharing-page-text',
	'wikiamobile-sharing-modal-text',
	'wikiamobile-sharing-email-text',
	'wikiamobile-image-not-loaded',
	'wikiamobile-video-not-friendly',
	'wikiamobile-video-not-friendly-header'
) );

JSMessages::registerPackage( 'SmartBanner', [
	'wikiasmartbanner-appstore',
	'wikiasmartbanner-googleplay',
	'wikiasmartbanner-price',
	'wikiasmartbanner-view'
] );

/**
 * hooks
 */
$app->registerHook( 'ParserBeforeStrip', 'WikiaMobileHooks', 'onParserBeforeStrip' );
$app->registerHook( 'ParserAfterTidy', 'WikiaMobileHooks', 'onParserAfterTidy' );
$app->registerHook( 'ParserLimitReport', 'WikiaMobileHooks', 'onParserLimitReport' );
$app->registerHook( 'MakeHeadline', 'WikiaMobileHooks', 'onMakeHeadline' );
$app->registerHook( 'LinkBegin', 'WikiaMobileHooks', 'onLinkBegin' );
$app->registerHook( 'CategoryPageView', 'WikiaMobileHooks', 'onCategoryPageView' );
$app->registerHook( 'ArticlePurge', 'WikiaMobileHooks', 'onArticlePurge' );

//404 Pages
$app->registerHook( 'BeforeDisplayNoArticleText', 'WikiaMobileHooks', 'onBeforeDisplayNoArticleText' );
$app->registerHook( 'BeforePageDisplay', 'WikiaMobileHooks', 'onBeforePageDisplay' );


/*
 * settings
 */

//global menu for the mobile skin
if ( empty($app->wg->WikiaMobileGlobalNavigationMenu ) ) {
	$app->wg->set( 'wgWikiaMobileGlobalNavigationMenu', '*Special:Random|randompage' );
}

//list of special pages (canonical names) to strip out from the navigation menu
if ( empty( $app->wg->WikiaMobileNavigationBlacklist ) ) {
	$app->wg->set( 'wgWikiaMobileNavigationBlacklist', array( 'Chat', 'WikiActivity', 'NewFiles' ) );
}

//black list of JS globals
if ( empty( $app->wg->WikiaMobileIncludeJSGlobals ) ) {
	$app->wg->set( 'wgWikiaMobileIncludeJSGlobals',
		[
			//analytics
			'_gaq',
			'wgEnableKruxTargeting',
			'wgKruxCategoryId',
			'cscoreCat',

			//ads
			'wgDartCustomKeyValues',
			'cityShort',
			'wikiaPageIsHub',
			'wikiaPageType',

			//server/wiki
			'wgServer',
			'wgDBname',
			'wgCityId',
			'wgScript',
			'wgScriptPath',
			'wgCdnRootUrl',
			'wgAssetsManagerQuery',
			'wgContentLanguage',
			'wgMedusaSlot',
			'wgResourceBasePath',
			'wgMainPageTitle',
			'wgSitename',
			'wgCookieDomain',
			'wgCookiePath',
			'wgDisableAnonymousEditing',
			'wgNamespaceIds',
			'wgExtensionsPath',

			//article
			'wgArticlePath',
			'wgArticleId',
			'wgNamespaceNumber',
			'wgIsGASpecialWiki',
			'wgCanonicalSpecialPageName',
			'wgPageName',
			'wgTitle',
			'wgRevisionId',

			//user
			'wgUserName',
			'wgUserLanguage',

			//configs
			'wgSassParams',
			'wgStyleVersion',
			'wgMessages',
			'wgJSMessagesCB',
			'wgTrackID',
			'wgCookiePrefix',
			'JSSnippetsStack',

			//skin
			'skin',

			//facebook login
			'fbAppId',
			'fbUseMarkup'
		]
	);
}

//list of Videos provides that we support
if ( empty( $app->wg->WikiaMobileSupportedVideos ) ) {
	$app->wg->set( 'wgWikiaMobileSupportedVideos', [
		'screenplay',
		'ign',
		'ooyala',
		'youtube',
		'dailymotion',
		'vimeo',
		'bliptv'
	]);
}
