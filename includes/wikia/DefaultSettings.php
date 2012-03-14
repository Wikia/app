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
include "$IP/includes/wikia/wgCacheBuster.php";
$wgStyleVersion = $wgMergeStyleVersionJS = $wgMergeStyleVersionCSS = $wgCacheBuster;

/**
 * @name wgAkamaiGlobalVersion
 *
 * this variable is used for purging all images on akamai. increasing this value
 * will expire (change all image links) on all wikis
 */
$wgAkamaiGlobalVersion = 1;

/**
 * @name wgAkamaiLocalVersion
 *
 * this variable is used for purging all images on akamai for one particular
 * wiki. Here is just initialization, if you want to change value of this variable
 * you should use WikiFactory interface. By default it is equal global version
 */
$wgAkamaiLocalVersion = $wgAkamaiGlobalVersion;


/**
 * @name $wgCityId
 *
 * contains wiki identifier from city_list table. If wiki is not from wiki.factory
 * contains null!
 */
$wgCityId = null;

/**
 * replace ExternalStoreDB with our version for other clusters than main
 */
$wgUseFakeExternalStoreDB = false;


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
 * Framework classes
 */
$wgAutoloadClasses['F'] = $IP . '/includes/wikia/WikiaSuperFactory.class.php';
$wgAutoloadClasses['WF'] = $IP . '/includes/wikia/WikiaSuperFactory.class.php';
$wgAutoloadClasses['WikiaApp'] = $IP . '/includes/wikia/WikiaApp.class.php';
$wgAutoloadClasses['WikiaObject'] = $IP . '/includes/wikia/WikiaObject.class.php';
$wgAutoloadClasses['WikiaHookDispatcher'] = $IP . '/includes/wikia/WikiaHookDispatcher.class.php';
$wgAutoloadClasses['WikiaRegistry'] = $IP . '/includes/wikia/WikiaRegistry.class.php';
$wgAutoloadClasses['WikiaGlobalRegistry'] = $IP . '/includes/wikia/WikiaGlobalRegistry.class.php';
$wgAutoloadClasses['WikiaLocalRegistry'] = $IP . '/includes/wikia/WikiaLocalRegistry.class.php';
$wgAutoloadClasses['WikiaDispatcher'] = $IP . '/includes/wikia/WikiaDispatcher.class.php';
$wgAutoloadClasses['WikiaDispatchableObject'] = $IP . '/includes/wikia/WikiaDispatchableObject.class.php';
$wgAutoloadClasses['WikiaController'] = $IP . '/includes/wikia/WikiaController.class.php';
$wgAutoloadClasses['WikiaService'] = $IP . '/includes/wikia/WikiaService.class.php';
$wgAutoloadClasses['WikiaModel'] = $IP . '/includes/wikia/WikiaModel.class.php';
$wgAutoloadClasses['WikiaSpecialPageController'] = $IP . '/includes/wikia/WikiaSpecialPageController.class.php';
$wgAutoloadClasses['WikiaErrorController'] = $IP . '/includes/wikia/WikiaErrorController.class.php';
$wgAutoloadClasses['WikiaRequest'] = $IP . '/includes/wikia/WikiaRequest.class.php';
$wgAutoloadClasses['WikiaResponse'] = $IP . '/includes/wikia/WikiaResponse.class.php';
$wgAutoloadClasses['WikiaView'] = $IP . '/includes/wikia/WikiaView.class.php';
$wgAutoloadClasses['WikiaFunctionWrapper'] = $IP . '/includes/wikia/WikiaFunctionWrapper.class.php';
$wgAutoloadClasses['WikiaBaseTest'] = $IP . '/includes/wikia/tests/WikiaBaseTest.class.php';

F::setInstance( 'App', new WikiaApp() );

$wgAutoloadClasses['AssetsManager'] = $IP . '/extensions/wikia/AssetsManager/AssetsManager.class.php';
$wgAutoloadClasses['AssetsConfig'] = $IP . '/extensions/wikia/AssetsManager/AssetsConfig.class.php';


/**
 * custom wikia classes
 */
$wgAutoloadClasses["Tyrant_Exception"] = "$IP/lib/Tyrant/Exception.php";
$wgAutoloadClasses["EasyTemplate"]  =  "$IP/includes/wikia/EasyTemplate.php";
$wgAutoloadClasses["GlobalTitle"]  =  "$IP/includes/wikia/GlobalTitle.php";
#$wgAutoloadClasses["Wikia"] = "includes/wikia/Wikia.php";
$wgAutoloadClasses["WikiFactory"] = "$IP/extensions/wikia/WikiFactory/WikiFactory.php";
$wgAutoloadClasses["WikiMover"] = "$IP/extensions/wikia/WikiFactory/Mover/WikiMover.php";
$wgAutoloadClasses["WikiFactoryHub"] = "$IP/extensions/wikia/WikiFactory/Hubs/WikiFactoryHub.php";
$wgAutoloadClasses['AnalyticsEngine'] = "$IP/extensions/wikia/AnalyticsEngine/AnalyticsEngine.php";
$wgAutoloadClasses['SimplePie'] = "$IP/lib/SimplePie/simplepie.inc";
$wgAutoloadClasses['FakeLocalFile'] = "$IP/includes/wikia/FakeLocalFile.class.php";
$wgAutoloadClasses['PayflowAPI'] = "$IP/includes/wikia/PayflowAPI.php";
$wgAutoloadClasses['Curl'] = "$IP/includes/wikia/Curl.php";
$wgAutoloadClasses['WikiaException'] = "$IP/includes/wikia/WikiaException.php";
$wgAutoloadClasses['WikiaDispatchedException'] = "$IP/includes/wikia/WikiaDispatchedException.class.php";
$wgAutoloadClasses['WikiaSkinMonoBook'] = "$IP/skins/wikia/WikiaMonoBook.php";
$wgAutoloadClasses['PaginationController'] = "$IP/includes/wikia/services/PaginationController.class.php";
$wgAutoloadClasses['MemcacheSync'] = "$IP/includes/wikia/MemcacheSync.class.php";
$wgAutoloadClasses['LibmemcachedBagOStuff'] = "$IP/includes/wikia/LibmemcachedBagOStuff.php";
$wgAutoloadClasses['LibmemcachedSessionHandler'] = "$IP/includes/wikia/LibmemcachedSessionHandler.php";


//AutomaticWikiAdoption
$wgAutoloadClasses['AutomaticWikiAdoptionGatherData']  =  $IP.'/extensions/wikia/AutomaticWikiAdoption/maintenance/AutomaticWikiAdoptionGatherData.php';

// core
//$wgAutoloadClasses['View']  =  $IP.'/includes/wikia/View.php';
$wgAutoloadClasses['Module']  =  $IP.'/includes/wikia/Module.php';

// services
$wgAutoloadClasses['Service']  =  $IP.'/includes/wikia/services/Service.php';
$wgAutoloadClasses['ApiService']  =  $IP.'/includes/wikia/services/ApiService.class.php';
$wgAutoloadClasses['ArticleService'] = $IP.'/includes/wikia/services/ArticleService.class.php';
$wgAutoloadClasses['AvatarService'] = $IP.'/includes/wikia/services/AvatarService.class.php';
$wgAutoloadClasses['ImagesService'] = $IP.'/includes/wikia/services/ImagesService.class.php';
$wgAutoloadClasses['NavigationService']  =  $IP.'/includes/wikia/services/NavigationService.class.php';
$wgAutoloadClasses['WikiNavigationService']  =  $IP.'/includes/wikia/services/WikiNavigationService.class.php';
$wgAutoloadClasses['OasisService']  =  $IP.'/includes/wikia/services/OasisService.php';
$wgAutoloadClasses['PageStatsService']  =  $IP.'/includes/wikia/services/PageStatsService.class.php';
$wgAutoloadClasses['UserContribsProviderService'] = $IP.'/includes/wikia/services/UserContribsProviderService.class.php';
$wgAutoloadClasses['UserStatsService'] = $IP.'/includes/wikia/services/UserStatsService.class.php';
$wgAutoloadClasses['PaypalPaymentService'] = $IP.'/includes/wikia/services/PaypalPaymentService.class.php';
$wgHooks['PayPalInstantPaymentNotification'][] = 'PaypalPaymentService::onInstantPaymentNotification';
$wgAutoloadClasses['CategoriesService'] = $IP.'/includes/wikia/services/CategoriesService.class.php';
$wgAutoloadClasses['UserCommandsService'] = $IP.'/includes/wikia/services/UserCommandsService.class.php';
$wgAutoloadClasses['ToolbarService'] = $IP.'/includes/wikia/services/OasisToolbarService.class.php';
$wgAutoloadClasses['OasisToolbarService'] = $IP.'/includes/wikia/services/OasisToolbarService.class.php';
$wgAutoloadClasses['FogbugzService'] = $IP . '/includes/wikia/services/FogbugzService.class.php';
$wgAutoloadClasses['CsvService'] = $IP . '/includes/wikia/services/CsvService.class.php';
$wgAutoloadClasses['MobileService'] = $IP . '/includes/wikia/services/MobileService.class.php';
$wgAutoloadClasses['TemplateService'] = $IP . '/includes/wikia/services/TemplateService.class.php';
$wgAutoloadClasses['SpriteService'] = $IP . '/includes/wikia/services/SpriteService.class.php';
$wgAutoloadClasses['SocialSharingService'] = $IP . '/includes/wikia/services/SocialSharingService.class.php';
	$wgAutoloadClasses['FacebookSharing'] = $IP . '/includes/wikia/services/FacebookSharing.class.php';
	$wgAutoloadClasses['TwitterSharing'] = $IP . '/includes/wikia/services/TwitterSharing.class.php';
	$wgAutoloadClasses['PlusoneSharing'] = $IP . '/includes/wikia/services/PlusoneSharing.class.php';
	$wgAutoloadClasses['StumbleuponSharing'] = $IP . '/includes/wikia/services/StumbleuponSharing.class.php';
	$wgAutoloadClasses['RedditSharing'] = $IP . '/includes/wikia/services/RedditSharing.class.php';
	$wgAutoloadClasses['EmailSharing'] = $IP . '/includes/wikia/services/EmailSharing.class.php';
$wgAutoloadClasses['HubService'] = $IP . '/includes/wikia/services/HubService.class.php';
$wgAutoloadClasses['PageSpeedAPI'] = $IP . '/includes/wikia/services/PageSpeedAPI.class.php';

// controllers
$wgAutoloadClasses['SimpleSearchService']  =  $IP.'/includes/wikia/services/SimpleSearchService.class.php';
	$wgAutoloadClasses['SimpleSearchTooManyResultsException']  =  $IP.'/includes/wikia/services/SimpleSearchController.class.php';
	$wgAutoloadClasses['SimpleSearchDisabledException']  =  $IP.'/includes/wikia/services/SimpleSearchController.class.php';
	$wgAutoloadClasses['SimpleSearchEngineException']  =  $IP.'/includes/wikia/services/SimpleSearchController.class.php';
	$wgAutoloadClasses['SimpleSearchEmptyKeyException']  =  $IP.'/includes/wikia/services/SimpleSearchController.class.php';
$wgAutoloadClasses['MobileStatsController']  =  $IP.'/includes/wikia/services/MobileStatsController.class.php';
	$wgAutoloadClasses['MobileStatsExternalRequestException']  =  $IP.'/includes/wikia/services/MobileStatsController.class.php';
	$wgAutoloadClasses['MobileStatsMissingParametersException']  =  $IP.'/includes/wikia/services/MobileStatsController.class.php';

// modules
$wgAutoloadClasses['OasisModule'] = $IP.'/skins/oasis/modules/OasisModule.class.php';
$wgAutoloadClasses['BodyModule'] = $IP.'/skins/oasis/modules/BodyModule.class.php';
$wgAutoloadClasses['ContentDisplayModule'] = $IP.'/skins/oasis/modules/ContentDisplayModule.class.php';
$wgAutoloadClasses['GlobalHeaderModule'] = $IP.'/skins/oasis/modules/GlobalHeaderModule.class.php';
$wgAutoloadClasses['CorporateFooterModule'] = $IP.'/skins/oasis/modules/CorporateFooterModule.class.php';
$wgAutoloadClasses['WikiHeaderModule'] = $IP.'/skins/oasis/modules/WikiHeaderModule.class.php';
$wgAutoloadClasses['WikiHeaderV2Module'] = $IP.'/skins/oasis/modules/WikiHeaderV2Module.class.php';
$wgAutoloadClasses['SearchModule'] = $IP.'/skins/oasis/modules/SearchModule.class.php';
$wgAutoloadClasses['PageHeaderModule'] = $IP.'/skins/oasis/modules/PageHeaderModule.class.php';
$wgAutoloadClasses['LatestActivityModule'] = $IP.'/skins/oasis/modules/LatestActivityModule.class.php';
$wgAutoloadClasses['LatestPhotosModule'] = $IP.'/skins/oasis/modules/LatestPhotosModule.class.php';
$wgAutoloadClasses['FooterModule'] = $IP.'/skins/oasis/modules/FooterModule.class.php';
$wgAutoloadClasses['ArticleCategoriesModule'] = $IP.'/skins/oasis/modules/ArticleCategoriesModule.class.php';
$wgAutoloadClasses['AchievementsModule'] = $IP.'/skins/oasis/modules/AchievementsModule.class.php';
$wgAutoloadClasses['AccountNavigationModule'] = $IP.'/skins/oasis/modules/AccountNavigationModule.class.php';
$wgAutoloadClasses['RailModule'] = $IP.'/skins/oasis/modules/RailModule.class.php';
$wgAutoloadClasses['AdModule'] = $IP.'/skins/oasis/modules/AdModule.class.php';
$wgAutoloadClasses['FollowedPagesModule'] = $IP.'/skins/oasis/modules/FollowedPagesModule.class.php';
$wgAutoloadClasses['MyToolsModule'] = $IP.'/skins/oasis/modules/MyToolsModule.class.php';
$wgAutoloadClasses['UserPagesHeaderModule'] = $IP.'/skins/oasis/modules/UserPagesHeaderModule.class.php';
$wgAutoloadClasses['SpotlightsModule'] = $IP.'/skins/oasis/modules/SpotlightsModule.class.php';
$wgAutoloadClasses['MenuButtonModule'] = $IP.'/skins/oasis/modules/MenuButtonModule.class.php';
$wgAutoloadClasses['CommentsLikesModule'] = $IP.'/skins/oasis/modules/CommentsLikesModule.class.php';
$wgAutoloadClasses['BlogListingModule'] = $IP.'/skins/oasis/modules/BlogListingModule.class.php';
$wgAutoloadClasses['NotificationsModule'] = $IP.'/skins/oasis/modules/NotificationsModule.class.php';
$wgAutoloadClasses['LatestEarnedBadgesModule'] = $IP.'/extensions/wikia/AchievementsII/modules/LatestEarnedBadgesModule.class.php';
$wgAutoloadClasses['HotSpotsModule'] = $IP.'/skins/oasis/modules/HotSpotsModule.class.php';
$wgAutoloadClasses['CommunityCornerModule'] = $IP.'/skins/oasis/modules/CommunityCornerModule.class.php';
$wgAutoloadClasses['PopularBlogPostsModule'] = $IP.'/skins/oasis/modules/PopularBlogPostsModule.class.php';
$wgAutoloadClasses['RandomWikiModule'] = $IP.'/skins/oasis/modules/RandomWikiModule.class.php';
$wgAutoloadClasses['ArticleInterlangModule'] = $IP.'/skins/oasis/modules/ArticleInterlangModule.class.php';
$wgAutoloadClasses['PagesOnWikiModule'] = $IP.'/skins/oasis/modules/PagesOnWikiModule.class.php';
$wgAutoloadClasses['EditPageModule'] = $IP.'/skins/oasis/modules/EditPageModule.class.php';
$wgAutoloadClasses['HuluVideoPanelModule'] = $IP.'/skins/oasis/modules/HuluVideoPanelModule.class.php';
$wgAutoloadClasses['ContributeMenuModule'] = $IP.'/skins/oasis/modules/ContributeMenuModule.class.php';
$wgAutoloadClasses['WikiNavigationModule'] = $IP.'/skins/oasis/modules/WikiNavigationModule.class.php';
$wgAutoloadClasses['SharingToolbarModule'] = $IP.'/skins/oasis/modules/SharingToolbarModule.class.php';
$wgAutoloadClasses['WikiaFormModule'] = $IP.'/skins/oasis/modules/WikiaFormModule.class.php';


$wgAutoloadClasses['UploadPhotosModule'] = $IP.'/skins/oasis/modules/UploadPhotosModule.class.php';
$wgAutoloadClasses['WikiaTempFilesUpload'] = $IP.'/includes/wikia/WikiaTempFilesUpload.class.php';

$wgAutoloadClasses['ThemeSettings'] = $IP.'/extensions/wikia/ThemeDesigner/ThemeSettings.class.php';
$wgAutoloadClasses['ThemeDesignerHelper'] = $IP."/extensions/wikia/ThemeDesigner/ThemeDesignerHelper.class.php";//FB#22659 - dependency for ThemeSettings

$wgAutoloadClasses['ErrorModule'] = $IP.'/skins/oasis/modules/ErrorModule.class.php';

// TODO:move this inclusion to CommonExtensions?
require_once( $IP.'/extensions/wikia/Oasis/Oasis_setup.php' );

/**
 * i18n support for jquery.timeago.js (used in History Dropdown)
 */
include_once( "$IP/extensions/wikia/TimeAgoMessaging/TimeAgoMessaging_setup.php" );

/**
 * Updated layout for edit pages (Oasis only)
 */
//include_once("$IP/extensions/wikia/EditPageLayout/EditPageLayout_setup.php");

/**
 * MW messages in JS
 */
include_once("$IP/extensions/wikia/JSMessages/JSMessages_setup.php");

/**
 * Code lint
 */
include_once("$IP/extensions/wikia/CodeLint/CodeLint.setup.php");

/**
 * API classes
 */

$wgAutoloadClasses[ "WikiaApiQuery"                 ] = "{$IP}/extensions/wikia/WikiaApi/WikiaApiQuery.php";
$wgAutoloadClasses[ "WikiaApiQueryConfGroups"       ] = "{$IP}/extensions/wikia/WikiaApi/WikiaApiQueryConfGroups.php";
$wgAutoloadClasses[ "WikiaApiQueryDomains"          ] = "{$IP}/extensions/wikia/WikiaApi/WikiaApiQueryDomains.php";
$wgAutoloadClasses[ "WikiaApiQueryPopularPages"     ]  = "{$IP}/extensions/wikia/WikiaApi/WikiaApiQueryPopularPages.php";
$wgAutoloadClasses[ "WikiaApiQueryVoteArticle"      ] = "{$IP}/extensions/wikia/WikiaApi/WikiaApiQueryVoteArticle.php";
$wgAutoloadClasses[ "WikiaApiQueryWrite"            ] = "{$IP}/extensions/wikia/WikiaApi/WikiaApiQueryWrite.php";
$wgAutoloadClasses[ "WikiaApiQueryMostAccessPages"  ] = "{$IP}/extensions/wikia/WikiaApi/WikiaApiQueryMostAccessPages.php";
$wgAutoloadClasses[ "WikiaApiQueryLastEditPages"    ] = "{$IP}/extensions/wikia/WikiaApi/WikiaApiQueryLastEditPages.php";
$wgAutoloadClasses[ "WikiaApiQueryTopEditUsers"     ] = "{$IP}/extensions/wikia/WikiaApi/WikiaApiQueryTopEditUsers.php";
$wgAutoloadClasses[ "WikiaApiQueryMostVisitedPages" ] = "{$IP}/extensions/wikia/WikiaApi/WikiaApiQueryMostVisitedPages.php";
$wgAutoloadClasses[ "WikiaApiAjaxLogin"             ] = "{$IP}/extensions/wikia/WikiaApi/WikiaApiAjaxLogin.php";
$wgAutoloadClasses[ "WikiaApiQuerySiteInfo"         ] = "{$IP}/extensions/wikia/WikiaApi/WikiaApiQuerySiteinfo.php";
$wgAutoloadClasses[ "WikiaApiQueryPageinfo"         ] = "{$IP}/extensions/wikia/WikiaApi/WikiaApiQueryPageinfo.php";
$wgAutoloadClasses[ "WikiaApiReportEmail"           ] = "{$IP}/extensions/wikia/WikiaApi/WikiaApiReportEmail.php";
$wgAutoloadClasses[ "WikiaApiCreatorReminderEmail"  ] = "{$IP}/extensions/wikia/AutoCreateWiki/WikiaApiCreatorReminderEmail.php";
$wgAutoloadClasses[ "WikiFactoryTags"               ] = "{$IP}/extensions/wikia/WikiFactory/Tags/WikiFactoryTags.php";
$wgAutoloadClasses[ "WikiaApiQueryEventsData"       ] = "{$IP}/extensions/wikia/WikiaApi/WikiaApiQueryEventsData.php";
$wgAutoloadClasses[ "WikiaApiQueryAllUsers"         ] = "{$IP}/extensions/wikia/WikiaApi/WikiaApiQueryAllUsers.php";
$wgAutoloadClasses[ "WikiaApiQueryLastEditors"      ] = "{$IP}/extensions/wikia/WikiaApi/WikiaApiQueryLastEditors.php";
$wgAutoloadClasses[ "ApiRunJob"                     ] = "{$IP}/extensions/wikia/WikiaApi/ApiRunJob.php";

if( $wgUseFakeExternalStoreDB !== true ) {
	$wgAutoloadClasses[ "WikiaApiQueryBlob"         ] = "{$IP}/extensions/wikia/WikiaApi/WikiaApiQueryBlob.php";
}

/*
 * validators
 */

$wgAutoloadClasses["WikiaValidator"] = "includes/wikia/validators/WikiaValidator.class.php";
$wgAutoloadClasses["WikiaValidationError"] = "includes/wikia/validators/WikiaValidationError.class.php";
$wgAutoloadClasses["WikiaValidatorString"] = "includes/wikia/validators/WikiaValidatorString.class.php";
$wgAutoloadClasses["WikiaValidatorNumeric"] = "includes/wikia/validators/WikiaValidatorNumeric.class.php";
$wgAutoloadClasses["WikiaValidatorInteger"] = "includes/wikia/validators/WikiaValidatorInteger.class.php";
$wgAutoloadClasses["WikiaValidatorRegex"] = "includes/wikia/validators/WikiaValidatorRegex.class.php";
$wgAutoloadClasses["WikiaValidatorSelect"] = "includes/wikia/validators/WikiaValidatorSelect.class.php";
$wgAutoloadClasses["WikiaValidatorMail"] = "includes/wikia/validators/WikiaValidatorMail.class.php";
$wgAutoloadClasses["WikiaValidatorsSet"] = "includes/wikia/validators/WikiaValidatorsSet.class.php";
$wgAutoloadClasses["WikiaValidatorsAnd"] = "includes/wikia/validators/WikiaValidatorsAnd.class.php";

$wgAutoloadClasses["WikiaValidatorListBase"] = "includes/wikia/validators/WikiaValidatorListBase.class.php";
$wgAutoloadClasses["WikiaValidatorListValue"] = "includes/wikia/validators/WikiaValidatorListValue.class.php";
//$wgAutoloadClasses["WikiaValidatorListUnique"] = "includes/wikia/validators/WikiaValidatorListUnique.class.php";

$wgAutoloadClasses["WikiaValidatorCompare"] = "includes/wikia/validators/WikiaValidatorCompare.class.php";
$wgAutoloadClasses["WikiaValidatorCompareValueIF"] = "includes/wikia/validators/WikiaValidatorCompareValueIF.class.php";
$wgAutoloadClasses["WikiaValidatorCompareEmptyIF"] = "includes/wikia/validators/WikiaValidatorCompareEmptyIF.class.php";
$wgAutoloadClasses[ "ExternalUser_Wikia"            ] = "{$IP}/includes/wikia/ExternalUser_Wikia.php";

/*
$wgAutoloadClasses["WikiaValidationError"] = "includes/wikia/validators/WikiaValidationError.class.php";
*/

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


/**
 * registered API methods
 */
$wgAPIMetaModules[ "siteinfo"     ] = "WikiaApiQuerySiteInfo";
$wgAPIListModules[ "allusers"     ] = "WikiaApiQueryAllUsers";

/**
 * registered Ajax methods
 */
global $wgAjaxExportList;

/**
 * registered Ajax methods
 */
global $wgAPIPropModules;
$wgAPIPropModules[ "info"         ] = "WikiaApiQueryPageinfo";
$wgAPIPropModules[ "wkevinfo"     ] = "WikiaApiQueryEventsData";
$wgAPIPropModules[ "wkevent"      ] = "WikiaApiQueryEventInfo";
$wgAPIPropModules[ "wkevents"     ] = "WikiaApiQueryScribeEvents";
$wgAPIPropModules[ "wklasteditors"] = "WikiaApiQueryLastEditors";

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
$wgAPIModules[ "theschwartz"       ] = "WikiaApiReportEmail";
$wgAPIModules[ "awcreminder"       ] = "WikiaApiCreatorReminderEmail";
$wgAPIModules[ "runjob"            ] = "ApiRunJob";


if( $wgUseFakeExternalStoreDB !== true ) {
	$wgAPIModules[ "blob"              ] = "WikiaApiQueryBlob";
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
include_once( "$IP/extensions/wikia/StaffSig/StaffSig.php" );
include_once( "$IP/extensions/wikia/TagCloud/TagCloudClass.php" );
include_once( "$IP/extensions/wikia/MostPopularCategories/SpecialMostPopularCategories.php" );
include_once( "$IP/extensions/wikia/AssetsManager/AssetsManager_setup.php" );
include_once( "$IP/extensions/wikia/JSSnippets/JSSnippets_setup.php" );
include_once( "$IP/extensions/wikia/WikiaTracker/WikiaTracker.setup.php" );
include_once( "$IP/extensions/wikia/EmailsStorage/EmailsStorage.setup.php" );
include_once( "$IP/extensions/wikia/ShareButtons/ShareButtons.setup.php" );

/**
 * @name $wgSkipSkins
 *
 * NOTE: a few wikis may have local override for this var,
 * you need to modify those by hand.
 * A SELECT on city_variables will get you a list.
 */
$wgSkipSkins = array(
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
		'lyricsminimal',
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
		'wikiaapp',
		'wikiaphone',
		'wikiaphoneold',
		'smartphone',
		'efmonaco',
		'answers',
		'vector',
		'campfire',
		'wikiamobile'
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
$wgReleaseNumber = (!isset($HeadURL[4]) || $HeadURL[4] === "trunk" ) ? "trunk" : $HeadURL[5];

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
 define('NS_LEGACY_VIDEO', '400');

/**
 * register job class
 */
$wgJobClasses[ "ACWLocal" ] = "AutoCreateWikiLocalJob";
include_once( "$IP/extensions/wikia/AutoCreateWiki/AutoCreateWikiLocalJob.php" );

// new version
$wgJobClasses[ "CWLocal" ] = "CreateWikiLocalJob";
include_once( "$IP/extensions/wikia/AutoCreateWiki/CreateWikiLocalJob.php" );


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
$wgStatsDB = 'stats';
$wgDatamartDB = 'datamart';
$wgStatsDBEnabled = true;
$wgExternalWikiaStatsDB = 'wikiastats';
$wgSharedKeyPrefix = "wikicities"; // default value for shared key prefix, @see wfSharedMemcKey

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

/**
 * Transpaent 1x1 GIF URI-encoded (BugId:9975)
 */
$wgBlankImgUrl = 'data:image/gif;base64,R0lGODlhAQABAIABAAAAAP///yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D';

/**
 * Serve jQuery from Google's CDN. Disable this variable to serve jQuery as a part of AssetsManager package.
 */
$wgUseJQueryFromCDN = true;

/**
 * The actual path to wikia_combined (without rewrites).  Used for development servers.
 *
 * NOTE: Keep this in sync with the value in /wikia-ops/config/varnish/wikia.vcl
 */
$wgWikiaCombinedPrefix = "index.php?action=ajax&rs=WikiaAssets::combined&";

/**
 * Override MW default enable of EE
 */
$wgUseExternalEditor = false;

/**
 * riak section
 * @see lib/riak/riak.php
 * @see lib/riak/docs/index.html
 * @see http://riak.basho.com/edoc/raw-http-howto.txt for HTTP interface
 */
define( "CACHE_RIAK", 10 );
$wgSessionsInRiak = false;

$wgRiakStorageNodes = array(
	"default" => array(
		"host" => "127.0.0.1",
		"port" => "8098",
		"prefix" => "riak",
		"proxy" => false
	)
);
/**
 * riak connection data used in RiakCache handler or wfGetSolidCacheStorage
 *
 * @see includes/wikia/GlobalFunctions.php
 * @see includes/wikia/RiakCache.php
 *
 */
$wgRiakDefaultNode = "default";

/**
 * riak connection data used in session handler
 * @see includes/wikia/RiakSessionsHandler.php
 */
$wgRiakSessionNode = "default";

/**
 * libmemcached related stuff
 */
define( "CACHE_LIBMEMCACHED", 11 );
$wgSessionsInLibmemcached = false;


$wgAutoloadClasses[ "RiakClient" ] = "{$IP}/lib/riak/riak.php";
$wgAutoloadClasses[ "RiakCache"  ] = "{$IP}/includes/wikia/RiakCache.php";
$wgAutoloadClasses[ "ExternalStoreRiak"  ] = "{$IP}/includes/wikia/ExternalStoreRiak.php";
$wgSolidCacheType = CACHE_MEMCACHED;
$wgWikiFactoryCacheType = CACHE_MEMCACHED;

/*
 * @name $wgWikiaHideImportsFromIrc
 * hides Special:Import imports from IRC feed.
 * @see rt#43025
 */
$wgWikiaHideImportsFromIrc = true;

/**
 * disable autofollow blogs by default
 */
$wgBlogsEnableStaffAutoFollow = false;

/**
 * @name wgEnableCOPPA
 * toggles COPPA birthyear check on user creation
 */
$wgEnableCOPPA = true;

/**
 * Include helper-functions for allowing SASS to be used
 * in our system.
 */
require_once( "$IP/extensions/wikia/SASS/SassUtil.php" );

/**
 * Default value for ThemeDesigner history
 */
$wgOasisThemeSettingsHistory = array();

/**
 * @name wgPreWikiFactoryValues
 * optionally stores variable values as they were before overridden by WikiFactory
 */
$wgPreWikiFactoryValues = array();

/**
 * @name wgEnableWatchlistNotificationTimeout
 * Toggles watchlist notification timeout hack
 */
$wgEnableWatchlistNotificationTimeout = false;

/**
 * @name wgWatchlistNotificationTimeout
 * Watchlist notification block timeout (in seconds)
 * Default is: 24 hours (but disabled above)
 * @see rt#55604
 */
$wgWatchlistNotificationTimeout = 24 * 60 * 60;

/**
 * @name $wgExcludedWantedFiles
 * don't show those files on Special:WantedFiles
 */
$wgExcludedWantedFiles = array (0 => 'Placeholder', 1 => 'Welcome-user-page');

/**
 *  @name $wgExtensionNamespacesFiles
 * list of namespace localization files for extensions
 */
$wgExtensionNamespacesFiles = array();

/**
 * @name $wgSuppressNamespacePrefix
 * list of namespace that won't display a prefix in the article title shown in Oasis page header
 */
$wgSuppressNamespacePrefix = array();

/**
 * @name $wgMaxCommentsToDelete
 * number of comment to be removed in one request
 */
$wgMaxCommentsToDelete = 100;

/**
 * @name $wgMaxCommentsToMove
 * number of comment to be moved in one request
 */
$wgMaxCommentsToMove = 50;

/**
 * @name wgGoogleSiteVerificationAlwaysValid
 * @see extensions/wikia/Sitemap/SpecialSitemap_body.php
 */
$wgGoogleSiteVerificationAlwaysValid = false;

/**
 * is Semantic Mediawiki uses external database cluster
 * @name $smwgUseExternalDB
 *
 * @see includes/wikia/LBFactory_Multi.php
 */
$smwgUseExternalDB = false;

/**
 * Show the performance-stats from 'loadtime' cookie in the footer-toolbar
 * in the new skin for Staff.
 */
$wgEnableShowPerformanceStatsExt = true;

/**
 * Default value for AB testing array
 */

$wgABTests = array();

/**
 * default numbers of jobs done in ApiRunJob
 * @see extensions/wikia/WikiaApi/ApiRunJob.php
 */
$wgApiRunJobsPerRequest = 20;

/**
 * default configuration for paypal payments
 *
 */
$wgPayPalPaymentDBName = 'paypal';
$wgPayPalUrl = 'https://www.sandbox.paypal.com/cgi-bin/webscr?cmd=_express-checkout&token=';
$wgPayflowProAPIUrl = 'https://pilot-payflowpro.paypal.com';
$wgPayflowProCredentials = array();
$wgWikiPaymentAdsFreePrice = 4.99;	//used in WikiPayment/WikiBuilder

/**
 * sets memcached timeout back to what it was in mw1.15
 */

$wgMemCachedTimeout = 500000; //Data timeout in microseconds

/**
 * Fogbugz API config
 */
$wgFogbugzAPIConfig = array();

$wgAssetsManagerQuery = '/__am/%4$d/%1$s/%3$s/%2$s';
//$wgAssetsManagerQuery = '/index.php?action=ajax&rs=AssetsManagerEntryPoint&__am&type=%1$s&cb=%4$d&params=%3$s&oid=%2$s';
$wgSassExecutable = '/var/lib/gems/1.8/bin/sass';

/**
 * global user_options
 */
$wgGlobalUserProperties = array('language');

/**
 * debug level for memcached
 */
$wgMemCachedDebugLevel = 1;

/**
 * enable this by default, since we 100% include it in assetmanager now
 */
$wgEnableMWSuggest = true;

/**
 * define binary for wgUseTex usage
 * @name wgTexvc
 */
$wgTexvc = "$IP/math/texvc";

/**
 * enable extension to output OpenGraph meta tags so that facebook sharing
 * and liking works well
 *
 * @name wgEnableOpenGraphMetaExt
 * @see /extensions/OpenGraphMeta
 * @see /extensions/wikia/OpenGraphMetaCustomizations
 */
$wgEnableOpenGraphMetaExt = true;

/**
 * List of internal usernames that shouldn't be allowed in Special:EditCount, e.g. "Default", bots
 * Please use lowercase.
 *
 * @see /extensions/wikia/EditCount/SpecialEditCount_body.php
 */
$wgSpecialEditCountExludedUsernames = array(
	'default'
);

/**
 * List of mobile skins
 */
$wgMobileSkins = array( 'wikiphone', 'wikiaapp', 'wikiamobile' );

/**
 * variable for disabling memcached deleted key replication
 */
$wgDisableMemCachedReplication = false;

/**
 * variable for enabling Nirvana's per-skin template override
 * @see includes/wikia/WikiaView.class.php
 */
$wgEnableSkinTemplateOverride = false;

/**
 * variable for enabling Nirvana's API entrypoint wikia.php,
 * requests will be served with a 503 status code if this is false or not set
 * @see wikia.php
 */
$wgEnableNirvanaAPI = true;

/**
 * Array of disabled article actions which will fallback to "view" action (BugId:9964)
 */
$wgDisabledActionsWithViewFallback = array();

/**
 * Variable for enabling Special:ApiExplorer which lets users browse the documentation for the API
 * on that specific wiki (uses the actual API to build the documentation).
 */
$wgEnableApiExplorerExt = true;

/**
 * Default settings used by wiki navigation
 */
$wgMaxLevelOneNavElements = 4;
$wgMaxLevelTwoNavElements = 7;
$wgMaxLevelThreeNavElements = 10;

/**
 * Extension for running multiple version of Mediawiki
 */
if( !isset( $wgUseMedusa ) ) {
	$wgUseMedusa = false;
}

/**
 * Memcached class name
 */
$wgMemCachedClass = 'MemCachedClientforWiki';

/**
 * Extra configuration options for memcached when using libmemcached/pecl-memcached
 */
$wgLibMemCachedOptions = array();

/**
 * 'user_properties' table is not shared on our platform
 */
if( in_array( 'user_properties', $wgSharedTables ) ) {
	foreach( $wgSharedTables as $key => $value ) {
		if( $value == 'user_properties' ) {
			unset( $wgSharedTables[ $key ] );
			break;
		}
	}
}

/**
 * predis client initialization and redis initialization
 */
include "$IP/lib/predis/Predis.php";
$wgRedis = new Predis_Client( array(
	array( 'host' => '127.0.0.1', 'port' => 6379 ),
));

/**
 * Video
 */
$wgAutoloadClasses['WikiaVideoService'] = $IP.'/includes/wikia/services/WikiaVideoService.class.php';
