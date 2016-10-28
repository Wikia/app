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

$dir = dirname( __FILE__ );

/**
 * info
 */
$wgExtensionCredits['other'][] =
	array(
		"name" => "WikiaMobile",
		"descriptionmsg" => "wikiamobile-desc",
		"author" => array(
			'Federico "Lox" Lucignano <federico(at)wikia-inc.com>',
			'Jakub Olek <jakubolek(at)wikia-inc.com>'
		),
		'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/WikiaMobile'
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
$wgAutoloadClasses['ResourceVariablesGetter'] = "includes/wikia/resourceloader/ResourceVariablesGetter.class.php";

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
$wgAutoloadClasses['WikiaMobileTrendingArticlesService'] = "{$dir}/WikiaMobileTrendingArticlesService.class.php";

/**
 * models
 */
$wgAutoloadClasses['WikiaMobileCategoryModel'] = "{$dir}/models/WikiaMobileCategoryModel.class.php";
$wgAutoloadClasses['WikiaMobileStatsModel'] = "{$dir}/models/WikiaMobileStatsModel.class.php";

/**
 * controllers
 */
$wgAutoloadClasses['WikiaMobileController'] = "{$dir}/WikiaMobileController.class.php";

/**
 * special pages
 */

/**
 * message files
 */
$wgExtensionMessagesFiles['WikiaMobile'] = "{$dir}/WikiaMobile.i18n.php";

// initialize i18ns
JSMessages::registerPackage( 'WkMbl', [
	'adengine-advertisement',
	'wikiamobile-hide-section',
	'wikiamobile-sharing-media-image',
	'wikiamobile-sharing-page-text',
	'wikiamobile-sharing-modal-text',
	'wikiamobile-sharing-email-text',
	'wikiamobile-image-not-loaded',
	'wikiamobile-video-not-friendly',
	'wikiamobile-video-not-friendly-header',
	'wikiamobile-ad-label',
	'wikiamobile-shared-file-not-available'
] );

JSMessages::registerPackage( 'SmartBanner', [
	'wikiasmartbanner-appstore',
	'wikiasmartbanner-googleplay',
	'wikiasmartbanner-price',
	'wikiasmartbanner-view'
] );

/**
 * hooks
 */
$wgHooks['ParserBeforeStrip'][] = 'WikiaMobileHooks::onParserBeforeStrip';
$wgHooks['ParserAfterTidy'][] = 'WikiaMobileHooks::onParserAfterTidy';
$wgHooks['ParserLimitReport'][] = 'WikiaMobileHooks::onParserLimitReport';
$wgHooks['MakeHeadline'][] = 'WikiaMobileHooks::onMakeHeadline';
$wgHooks['LinkBegin'][] = 'WikiaMobileHooks::onLinkBegin';
$wgHooks['CategoryPageView'][] = 'WikiaMobileHooks::onCategoryPageView';
$wgHooks['ArticlePurge'][] = 'WikiaMobileHooks::onArticlePurge';
$wgHooks['DoEditSectionLink'][] = 'WikiaMobileHooks::onDoEditSectionLink';

//404 Pages
$wgHooks['BeforeDisplayNoArticleText'][] = 'WikiaMobileHooks::onBeforeDisplayNoArticleText';
$wgHooks['BeforePageDisplay'][] = 'WikiaMobileHooks::onBeforePageDisplay';


/*
 * settings
 */

//global menu for the mobile skin
if ( empty($wgWikiaMobileGlobalNavigationMenu ) ) {
	$wgWikiaMobileGlobalNavigationMenu = '*Special:Random|randompage';
}

//list of special pages (canonical names) to strip out from the navigation menu
if ( empty( $wgWikiaMobileNavigationBlacklist ) ) {
	$wgWikiaMobileNavigationBlacklist = array( 'Chat', 'WikiActivity', 'NewFiles', 'Images' );
}

// white list of JS globals
if ( empty( $wgWikiaMobileIncludeJSGlobals ) ) {
	$wgWikiaMobileIncludeJSGlobals =
		[
			//analytics
			'_gaq',
			'wgEnableKruxTargeting',
			'wgKruxCategoryId',
			'cscoreCat',
			'wgGaStaging',

			//ads
			'ads',
			'wgGaHasAds',

			//ads legacy -- should be removed at some point
			'adEnginePageType',
			'wgAdDriverUseAdsAfterInfobox',
			'wgAdDriverWikiIsTop1000',
			'wgDartCustomKeyValues',
			'wgShowAds',
			'wgWikiDirectedAtChildren',
			'wikiaPageIsHub',
			'wikiaPageType',

			//vertical&categories
			'wgWikiVertical',
			'wgWikiCategories',

			//server/wiki
			'wgServer',
			'wgDBname',
			'wgCityId',
			'wgScript',
			'wgScriptPath',
			'wgCdnRootUrl',
			'wgAssetsManagerQuery',
			'wgContentLanguage',
			'wgResourceBasePath',
			'wgMainPageTitle',
			'wgSitename',
			'wgCookieDomain',
			'wgCookiePath',
			'wgDisableAnonymousEditing',
			'wgNamespaceIds',
			'wgExtensionsPath',
			'wikiaPageIsCorporate',

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

			//login
			'fbAppId',
			'wgLoginToken',

			//signup
			'wgUserSignupDisableCaptcha',

			//AbTesting
			'wgCdnApiUrl',

			// performance
			'wgWeppyConfig',
			'wgTransactionContext',
		];
}
