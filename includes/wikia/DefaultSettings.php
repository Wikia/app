<?php
/**
 *
 *                 NEVER EDIT THIS FILE
 *
 *
 * To customize your installation, edit "LocalSettings.php". If you make
 * changes here, they will be lost on next upgrade of MediaWiki!
 *
 * Note that since all these string interpolations are expanded
 * before LocalSettings is included, if you localize something
 * like $wgScriptPath, you must also localize everything that
 * depends on it.
 *
 * Documentation is in the source and on:
 * http://www.mediawiki.org/wiki/Manual:Configuration_settings
 *
 */

# This is not a valid entry point, perform no further processing unless MEDIAWIKI is defined
if( !defined( 'MEDIAWIKI' ) ) {
	echo "This file is part of MediaWiki and is not a valid entry point\n";
	die( 1 );
}

/**
 * Use revision number
 */

$wgStyleVersion         = '2638';
$wgMergeStyleVersionJS  = '2638';
$wgMergeStyleVersionCSS = '2521';

/**
 * @name $wgCityId
 *
 * contains wiki identifier from city_list table. If wiki is not from wiki.factory
 * contains null!
 */
$wgCityId = null;


/**
 * includes common for all wikis
 */
require_once ( $IP."/includes/wikia/Defines.php" );
require_once ( $IP."/includes/wikia/GlobalFunctions.php" );

global $wgDBname, $wgKennisnet;
if($wgDBname != 'uncyclo' && !$wgKennisnet) {
	include_once( "$IP/extensions/wikia/SkinChooser/SkinChooser.php" );
}

/**
 * autoload classes
 */
global $wgAutoloadClasses;

/**
 * custom wikia classes
 */
$wgAutoloadClasses["EasyTemplate"]  =  $GLOBALS["IP"]."/includes/wikia/EasyTemplate.php";
$wgAutoloadClasses["Wikia"] = "includes/wikia/Wikia.php";
$wgAutoloadClasses["WikiFactory"] = $GLOBALS["IP"]."/extensions/wikia/WikiFactory/WikiFactory.php";
$wgAutoloadClasses["WikiMover"] = $GLOBALS["IP"]."/extensions/wikia/WikiFactory/Mover/WikiMover.php";
$wgAutoloadClasses["WikiFactoryHub"] = $GLOBALS["IP"]."/extensions/wikia/WikiFactory/Hubs/WikiFactoryHub.php";;

/**
 * API classes
 */

$wgAutoloadClasses["WikiaApiQuery"] = "extensions/wikia/WikiaApi/WikiaApiQuery.php";
$wgAutoloadClasses["WikiaApiQueryConfGroups"] = "extensions/wikia/WikiaApi/WikiaApiQueryConfGroups.php";
$wgAutoloadClasses["WikiaApiQueryDomains"] = "extensions/wikia/WikiaApi/WikiaApiQueryDomains.php";
$wgAutoloadClasses["WikiaApiQueryPopularPages"]  = "extensions/wikia/WikiaApi/WikiaApiQueryPopularPages.php";
$wgAutoloadClasses["WikiaApiFormatTemplate"]  = "extensions/wikia/WikiaApi/WikiaApiFormatTemplate.php";
$wgAutoloadClasses["WikiaApiQueryVoteArticle"] = "extensions/wikia/WikiaApi/WikiaApiQueryVoteArticle.php";
$wgAutoloadClasses["WikiaApiQueryWrite"] = "extensions/wikia/WikiaApi/WikiaApiQueryWrite.php";
$wgAutoloadClasses["WikiaApiQueryMostAccessPages"] = "extensions/wikia/WikiaApi/WikiaApiQueryMostAccessPages.php";
$wgAutoloadClasses["WikiaApiQueryLastEditPages"] = "extensions/wikia/WikiaApi/WikiaApiQueryLastEditPages.php";
$wgAutoloadClasses["WikiaApiQueryTopEditUsers"] = "extensions/wikia/WikiaApi/WikiaApiQueryTopEditUsers.php";
$wgAutoloadClasses["WikiaApiQueryMostVisitedPages"] = "extensions/wikia/WikiaApi/WikiaApiQueryMostVisitedPages.php";
$wgAutoloadClasses["WikiaApiQueryReferers"] = "extensions/wikia/WikiaApi/WikiaApiQueryReferers.php";
$wgAutoloadClasses["ApiFeaturedContent"] = "extensions/wikia/FeaturedContent/ApiFeaturedContent.php";
$wgAutoloadClasses["ApiPartnerWikiConfig"] = "extensions/wikia/FeaturedContent/ApiPartnerWikiConfig.php";
$wgAutoloadClasses["WikiaApiAjaxLogin"] = "extensions/wikia/WikiaApi/WikiaApiAjaxLogin.php";
$wgAutoloadClasses["ApiImageThumb"] = $GLOBALS["IP"]."/extensions/wikia/Our404Handler/ApiImageThumb.php";
//$wgAutoloadClasses["ApiRecentChangesCombined"] = "extensions/wikia/RecentChangesCombined/ApiRecentChangesCombined.php";
$wgAutoloadClasses["WikiaApiQuerySiteInfo"] = "extensions/wikia/WikiaApi/WikiaApiQuerySiteinfo.php";


/**
 * registered API methods
 */
global $wgApiQueryListModules;
$wgApiQueryListModules["wkconfgroups"] = "WikiaApiQueryConfGroups";
$wgApiQueryListModules["wkdomains"] = "WikiaApiQueryDomains";
$wgApiQueryListModules["wkpoppages"] = "WikiaApiQueryPopularPages";
$wgApiQueryListModules["wkvoteart"] = "WikiaApiQueryVoteArticle";
$wgApiQueryListModules["wkaccessart"] = "WikiaApiQueryMostAccessPages";
$wgApiQueryListModules["wkeditpage"] = "WikiaApiQueryLastEditPages";
$wgApiQueryListModules["wkedituser"] = "WikiaApiQueryTopEditUsers";
$wgApiQueryListModules["wkmostvisit"] = "WikiaApiQueryMostVisitedPages";
$wgApiQueryListModules["wkreferer"] = "WikiaApiQueryReferers";

/**
 * registered API methods
 */
$wgApiQueryMetaModules["siteinfo"] = "WikiaApiQuerySiteInfo";

/**
 * registered Ajax methods
 */
global $wgAjaxExportList;


/**
 * registered Format names
 */
global $wgApiMainListFormats;
$wgApiMainListFormats["wktemplate"] = "WikiaApiFormatTemplate";

/*
 * reqistered API modules
 */
global $wgAPIModules;
$wgAPIModules["insert"] = "WikiaApiQueryWrite";
$wgAPIModules["update"] = "WikiaApiQueryWrite";
$wgAPIModules["delete"] = "WikiaApiQueryWrite";
//$wgAPIModules["recentchangescombined"] = "ApiRecentChangesCombined";
$wgAPIModules["featuredcontent"] = "ApiFeaturedContent";
$wgAPIModules["partnerwikiconfig"] = "ApiPartnerWikiConfig";
$wgAPIModules["ajaxlogin"] = "WikiaApiAjaxLogin";
$wgAPIModules["imagethumb"] = "ApiImageThumb";

/*
 * Widget FrameWork declarations
 */
global $wgWidgetFrameWork;
if ( $wgWidgetFrameWork) {
    require_once ( 'widgetFrameWork/lib/widgetConfig.php' );
}


/**
 * Wikia custom extensions, enabled sitewide. Pre-required by some skins
 */
include_once( "$IP/extensions/ExtensionFunctions.php" );
include_once( "$IP/extensions/wikia/DataProvider/DataProvider.php" );
include_once( "$IP/extensions/wikia/WidgetFramework/WidgetFramework.php" );
include_once( "$IP/extensions/wikia/SpecialWidgetDashboard/SpecialWidgetDashboard_setup.php" );
include_once( "$IP/extensions/wikia/StaffSig/StaffSig.php" );
include_once( "$IP/extensions/wikia/AjaxLogin/AjaxLogin.php" );
include_once( "$IP/extensions/wikia/MergeFiles/MergeFiles.php" );
include_once( "$IP/extensions/wikia/TagCloud/TagCloudClass.php" );
include_once( "$IP/extensions/wikia/MostPopularCategories/SpecialMostPopularCategories.php" );
include_once( "$IP/extensions/wikia/MostPopularArticles/SpecialMostPopularArticles.php" );
include_once( "$IP/extensions/wikia/MostVisitedPages/SpecialMostVisitedPages.php" );
include_once( "$IP/extensions/wikia/WidgetSpecialPage/WidgetsSpecialPage.php" );

include_once( "$IP/extensions/ParserDiffTest/ParserDiffTest.php" );

/**
 * Wikia libmemcached client
 */
require_once( "$IP/includes/wikia/MemcachePoolClientForWiki.php" );

if( isset( $wgMemCachedClassLocal ) && is_string( $wgMemCachedClassLocal ) ) {
	$wgMemCachedClass = $wgMemCachedClassLocal;
}
else {
	$wgMemCachedClass = "MemCachedClientforWiki"; #  "MemcachePoolClientForWiki";
}

$wgSkipSkins = array(
		'armchairgm',
		'cars',
		'chick',
		'cologneblue_view',
		'curse',
		'entertainment',
		'food',
		'games',
		'gwmonobook',
		'halo',
		'halogamespot',
		'health',
		'home',
		'law',
		'local',
		'memalpha',
		'music',
		'nostalgia',
		'politics',
		'psn',
		'restaurants',
		'searchwikia',
		'search',
		'test',
		'uncyclopedia',
		'wikikids',
		'wowwiki',
);

/**
 * @name wgReleaseNumber
 * release number is used for building links
 */
$HeadURL = split('/', '$HeadURL$');
$wgReleaseNumber = ($HeadURL[4] === "trunk" ) ? "trunk" : $HeadURL[5];

/**
 * Enable FAST extension for this branch only
 */
$wgEnableFASTExt = true;

/**
 * Definition of new log type (settings), related to ticket #2657,
 * will be me moved to different configuration file
 */
$wgLogTypes[] = 'var_log';
$wgLogHeaders['var_log'] = 'var_logheader';
$wgLogNames['var_log'] = 'var_logtext';
$wgLogNames['var_set'] = 'var_set';
$wgLogActions['var_log/var_set'] = 'var_set';

/**
 * @name $wgBiggestCategoriesBlacklist
 * Lists phrases that disqualify a category from appearing in
 * the biggest category list (Monaco sidebar)
 */
$wgBiggestCategoriesBlacklist = array();

/**
 * extensions path as seen by users
 */
$wgExtensionsPath = false; /// defaults to "{$wgScriptPath}/extensions"

/**
 * Auxiliary variables for CreateWikiTask
 */
$wgHubCreationVariables = array();
$wgLangCreationVariables = array();
