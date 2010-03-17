<?php
/**
 * Configuration settings introduced by Wikia.
 *
 * Any new variables should be declared here. Since this file is used during
 * installation, the defaults should work on any installation (including local
 * installs).
 *
 * If you want to change their value, edit LocalSettings.php to make a change
 * for this specific installation. To override values for production,
 * edit /wikia-conf/CommonSettings.php
 */

# This is not a valid entry point, perform no further processing unless MEDIAWIKI is defined
if( !defined( 'MEDIAWIKI' ) ) {
	echo "This file is part of MediaWiki and is not a valid entry point\n";
	die( 1 );
}

/**
 * Use revision number
 */
$wgStyleVersion         = '20006';
$wgMergeStyleVersionJS  = '20006';
$wgMergeStyleVersionCSS = '20006';

/**
 * @name $wgCityId
 *
 * contains wiki identifier from city_list table. If wiki is not from wiki.factory
 * contains null!
 */
$wgCityId = null;

/**
 * production wikis use tokyotyrant for sessions
 */
$wgSessionsInTokyoTyrant = false;


/**
 * includes common for all wikis
 */
require_once ( $IP."/includes/wikia/Defines.php" );
require_once ( $IP."/includes/wikia/GlobalFunctions.php" );
require_once ( $IP."/includes/wikia/Wikia.php" );

global $wgDBname;
if($wgDBname != 'uncyclo') {
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
$wgAutoloadClasses["GlobalTitle"]  =  $GLOBALS["IP"]."/includes/wikia/GlobalTitle.php";
#$wgAutoloadClasses["Wikia"] = "includes/wikia/Wikia.php";
$wgAutoloadClasses["WikiFactory"] = $GLOBALS["IP"]."/extensions/wikia/WikiFactory/WikiFactory.php";
$wgAutoloadClasses["WikiMover"] = $GLOBALS["IP"]."/extensions/wikia/WikiFactory/Mover/WikiMover.php";
$wgAutoloadClasses["WikiFactoryHub"] = $GLOBALS["IP"]."/extensions/wikia/WikiFactory/Hubs/WikiFactoryHub.php";

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
$wgAutoloadClasses["WikiaApiQuerySiteInfo"] = "extensions/wikia/WikiaApi/WikiaApiQuerySiteinfo.php";
$wgAutoloadClasses["WikiaApiQueryPageinfo"] = "extensions/wikia/WikiaApi/WikiaApiQueryPageinfo.php";
$wgAutoloadClasses[ "ApiImageThumb"                ] = "{$IP}/extensions/wikia/Our404Handler/ApiImageThumb.php";
$wgAutoloadClasses[ "WikiaApiReportEmail"          ] = "{$IP}/extensions/wikia/WikiaApi/WikiaApiReportEmail.php";
$wgAutoloadClasses[ "WikiaApiCreatorReminderEmail" ] = "{$IP}/extensions/wikia/AutoCreateWiki/WikiaApiCreatorReminderEmail.php";
$wgAutoloadClasses[ "TokyoTyrantSession"           ] = "{$IP}/includes/wikia/TokyoTyrantSessions.php";
$wgAutoloadClasses[ "WikiFactoryTags"              ] = "{$IP}/extensions/wikia/WikiFactory/Tags/WikiFactoryTags.php";

/**
 * registered API methods
 */
global $wgAPIListModules;
$wgAPIListModules[ "wkconfgroups" ] = "WikiaApiQueryConfGroups";
$wgAPIListModules[ "wkdomains"    ] = "WikiaApiQueryDomains";
$wgAPIListModules[ "wkpoppages"   ] = "WikiaApiQueryPopularPages";
$wgAPIListModules[ "wkvoteart"    ] = "WikiaApiQueryVoteArticle";
$wgAPIListModules[ "wkaccessart"  ] = "WikiaApiQueryMostAccessPages";
$wgAPIListModules[ "wkeditpage"   ] = "WikiaApiQueryLastEditPages";
$wgAPIListModules[ "wkedituser"   ] = "WikiaApiQueryTopEditUsers";
$wgAPIListModules[ "wkmostvisit"  ] = "WikiaApiQueryMostVisitedPages";
$wgAPIListModules[ "wkreferer"    ] = "WikiaApiQueryReferers";

/**
 * registered API methods
 */
$wgAPIMetaModules[ "siteinfo"     ] = "WikiaApiQuerySiteInfo";

/**
 * registered Ajax methods
 */
global $wgAjaxExportList;

/**
 * registered Ajax methods
 */
global $wgAPIPropModules;
$wgAPIPropModules[ "info"         ] = "WikiaApiQueryPageinfo";

/**
 * registered Format names
 */
global $wgApiMainListFormats;
$wgApiMainListFormats["wktemplate"] = "WikiaApiFormatTemplate";

/*
 * reqistered API modules
 */
global $wgAPIModules;
$wgAPIModules[ "insert"            ] = "WikiaApiQueryWrite";
$wgAPIModules[ "update"            ] = "WikiaApiQueryWrite";
$wgAPIModules[ "delete"            ] = "ApiDelete";
$wgAPIModules[ "wdelete"           ] = "WikiaApiQueryWrite";
$wgAPIModules[ "featuredcontent"   ] = "ApiFeaturedContent";
$wgAPIModules[ "partnerwikiconfig" ] = "ApiPartnerWikiConfig";
$wgAPIModules[ "ajaxlogin"         ] = "WikiaApiAjaxLogin";
$wgAPIModules[ "imagethumb"        ] = "ApiImageThumb";
$wgAPIModules[ "theschwartz"       ] = "WikiaApiReportEmail";
$wgAPIModules[ "awcreminder"       ] = "WikiaApiCreatorReminderEmail";


/*
 * Widget FrameWork declarations
 */
global $wgWidgetFrameWork;
if ( $wgWidgetFrameWork) {
    require_once ( 'widgetFrameWork/lib/widgetConfig.php' );
}

$wgUseAjax                = true;
$wgValidateUserName       = true;
$wgAjaxAutoCompleteSearch = true;

$wgAjaxExportList[] = "wfDragAndDropReorder";
$wgAjaxExportList[] = "getSuggestedArticleURL";
$wgAjaxExportList[] = "cxValidateUserName";
$wgAjaxExportList[] = "searchSuggest";


/**
 * Wikia custom extensions, enabled sitewide. Pre-required by some skins
 */
include_once( "$IP/extensions/ExtensionFunctions.php" );
include_once( "$IP/extensions/wikia/AjaxFunctions.php" );
include_once( "$IP/extensions/wikia/DataProvider/DataProvider.php" );
include_once( "$IP/extensions/wikia/WidgetFramework/WidgetFramework.php" );
include_once( "$IP/extensions/wikia/SpecialWidgetDashboard/SpecialWidgetDashboard_setup.php" );
include_once( "$IP/extensions/wikia/StaffSig/StaffSig.php" );
include_once( "$IP/extensions/wikia/SpecialSignup/SpecialSignup.php" );
include_once( "$IP/extensions/wikia/AjaxLogin/AjaxLogin.php" );
include_once( "$IP/extensions/wikia/MergeFiles/MergeFiles.php" );
include_once( "$IP/extensions/wikia/TagCloud/TagCloudClass.php" );
include_once( "$IP/extensions/wikia/MostPopularCategories/SpecialMostPopularCategories.php" );
include_once( "$IP/extensions/wikia/MostPopularArticles/SpecialMostPopularArticles.php" );
include_once( "$IP/extensions/wikia/WidgetSpecialPage/WidgetsSpecialPage.php" );

/**
 * onedot is switched off for while
 */
include_once( "$IP/extensions/wikia/MostVisitedPages/SpecialMostVisitedPages.php" );

/**
 * @name $wgSkipSkins
 *
 * NOTE: a few wikis may have local override for this var,
 * you need to modify those by hand.
 * A SELECT on city_variables will get you a list.
 */
$wgSkipSkins = array(
		'answers',
		'armchairgm',
		'cars',
		'chick',
		'cologneblue_view',
		'corporate',
		'corporatebase',
		'corporatehome',
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
		'wowwiki',
		'lostbook',
		'quartz',
		'monaco_old',
		'wikiaphone',
		'efmonaco',
);
/**
 * @name wgSkipOldSkins
 *
 * Remove them only from SkinChooser but let use it if in prefs or ?useskin
 */
$wgSkipOldSkins = array(
		'cologneblue',
		'modern',
		'myskin',
		'simple',
		'standard',
);

/**
 * @name wgReleaseNumber
 * release number is used for building links
 */
$HeadURL = explode('/', '$HeadURL$');
$wgReleaseNumber = ($HeadURL[4] === "trunk" ) ? "trunk" : $HeadURL[5];

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

/**
 * Define Video namespace (used by WikiaVideo extensions)
 * Can not be define directly in extension since it is used in Parser.php and extension is not always enabled
 */
define('NS_VIDEO', '400');

/**
 * register job class
 */
$wgJobClasses[ "ACWLocal" ] = "AutoCreateWikiLocalJob";
//$wgAutoloadClasses[ "AutoCreateWikiLocalJob" ] = $IP . "/extensions/wikia/AutoCreateWiki/AutoCreateWikiLocalJob.php";
include_once( "$IP/extensions/wikia/AutoCreateWiki/AutoCreateWikiLocalJob.php" );

$wgReportTimeViaStomp = false;
$wgPurgeSquidViaStomp = false;
$wgReportMailViaStomp = false;

$wgStompServer = '';
$wgStompUser = '';
$wgStompPassword = '';
$wgAutoloadClasses['Stomp'] = "$IP/lib/Stomp.php";

// StaticChute used to generate merged JS/CSS files on-the-fly
$wgAutoloadClasses['StaticChute'] = "$IP/extensions/wikia/StaticChute/StaticChute.php";

/*
 * @name wgWikiaStaffLanguages
 * array of language codes supported by ComTeam
 */
$wgWikiaStaffLanguages = array();

/**
 * @name wgExternalSharedDB
 * use it when you have $wgSharedDB on an external cluster
 */
$wgExternalSharedDB = false;

/**
 * @name wgDumpsDisabledWikis
 * list of wiki ids not to do dumps for
 */
$wgDumpsDisabledWikis = array();

/**
 * @name wgEnableUploadInfoExt
 *
 * write to dataware information about every upload, it's by default off when
 * you do not use wikia-conf/CommonSettings.php
 */
$wgEnableUploadInfoExt = false;


/**
 * @name wgWikiFactoryTags
 *
 * tags defined in current wiki
 */
$wgWikiFactoryTags = array();

/**
 * external databases
 */
$wgExternalDatawareDB = 'dataware';
$wgExternalArchiveDB = 'archive';
$wgExternalStatsDB = 'dbstats';
$wgStatsDB = 'stats';
$wgExternalWikiaStatsDB = 'wikiastats';

$wgAutoloadClasses['LBFactory_Wikia'] = "$IP/includes/wikia/LBFactory_Wikia.php";

/**
 * @name wgEnableBlogCommentEdit, wgEnabledGroupedBlogComments, wgEnableBlogWatchlist
 * enable:
 * 	* blog comments edit
 * 	* grouped blog comments in RC
 * 	* added blogs to watchlist
 */
$wgEnableBlogCommentEdit = true;
$wgEnabledGroupedBlogComments = true;
$wgEnableBlogWatchlist = true;
$wgEnableGroupedBlogCommentsWatchlist = false;
$wgEnableGroupedArticleCommentsRC = true;

/**
 * @name wgUseWikiaSearchUI
 * enables wikia Special:Search interface
 */
$wgUseWikiaSearchUI = false;

/*
 * @name: $wgSpecialPagesRequiredLogin
 * list of restricted special pages (dbkey) displayed on Special:SpecialPages which required login
 * @see Login friction project
 */
$wgSpecialPagesRequiredLogin = array('Resetpass', 'MyHome', 'Preferences', 'Watchlist', 'Upload', 'CreateBlogPage', 'CreateBlogListingPage', 'MultipleUpload');

/*
 * @name: $wgArticleCommentsMaxPerPage
 * max comments per page under article
 * @see Article comments
 */
$wgArticleCommentsMaxPerPage = 5;

$wgMaxThumbnailArea = 0.9e7;

/*
 * @name $wgWikiaMaxNameChars
 * soft enforced limit of length for new username
 * @see rt#39263
 */
$wgWikiaMaxNameChars = 50;

/**
 * default directory for wikiex
 */
$wgWikiTexDirectory = "/images/w/wikitex/images/";
$wgWikiTexPath      = "http://images.wikia.com/wikitex/images/";

/**
 * @name $IPA
 *
 * path for answers repo
 */
$IPA = "/usr/wikia/source/answers";

/**
 * If this is set to true, then no externals (ads, spotlights, beacons such as google analytics and quantcast)
 * will be used.  This is used to help us get a good baseline for testing performance of in-house stuff only.
 *
 * To change this value, add noexternals=1 to the URL.
 */
$wgNoExternals = false;

/**
 * cache in TT
 * class: TokyoTyrantCache
 */
define( 'CACHE_TT', 666 );
$wgTTCache = null;
include_once("{$IP}/includes/wikia/TokyoTyrantSessions.php");

/**
 * Style path for resources on the CDN.
 *
 * NOTE: while the normal wgStylePath would include /skins/ in it,
 * this path will NOT have that in it so that CSS and other static
 * files can use a correct local path (such as "/skins/common/blank.gif")
 * which would be a completely functioning local path (which will be prepended
 * in the CSS combiner with wgCdnStylePath).  The advantages of this are two-fold:
 * 1) if the combiner fails to prepend the wgCdnStylePath, the link will still work,
 * 2) the combiner WON'T prepend the wgCdnStylePath on development machines so that
 * the local resource is used (makes testing easier).
 *
 * WARNING: Currently we need to dupliate this value into StaticChute::cdnStylePath.
 */
$wgCdnStylePath = '';
$wgBlankImgUrl = $wgCdnStylePath."/skins/common/blank.gif";

/**
 * The actual path to wikia_combined (without rewrites).  Used for development servers.
 *
 * NOTE: Keep this in sync with the value in /wikia-ops/config/varnish/wikia.vcl
 */
$wgWikiaCombinedPrefix = "index.php?action=ajax&rs=WikiaAssets::combined&";
