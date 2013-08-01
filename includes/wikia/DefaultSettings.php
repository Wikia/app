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
require_once ( $IP."/includes/wikia/WikiaMailer.php" );
require_once ( $IP."/extensions/Math/Math.php" );

global $wgDBname;
if($wgDBname != 'uncyclo') {
	include_once( "$IP/extensions/wikia/SkinChooser/SkinChooser.php" );
}

/**
 * autoload classes
 */
global $wgAutoloadClasses;


/**
 * Nirvana framework classes
 */
$wgAutoloadClasses['F'] = $IP . '/includes/wikia/nirvana/WikiaSuperFactory.class.php';
$wgAutoloadClasses['WF'] = $IP . '/includes/wikia/nirvana/WikiaSuperFactory.class.php';
$wgAutoloadClasses['WikiaApp'] = $IP . '/includes/wikia/nirvana/WikiaApp.class.php';
$wgAutoloadClasses['WikiaObject'] = $IP . '/includes/wikia/nirvana/WikiaObject.class.php';
$wgAutoloadClasses['WikiaHookDispatcher'] = $IP . '/includes/wikia/nirvana/WikiaHookDispatcher.class.php';
$wgAutoloadClasses['WikiaRegistry'] = $IP . '/includes/wikia/nirvana/WikiaRegistry.class.php';
$wgAutoloadClasses['WikiaGlobalRegistry'] = $IP . '/includes/wikia/nirvana/WikiaGlobalRegistry.class.php';
$wgAutoloadClasses['WikiaLocalRegistry'] = $IP . '/includes/wikia/nirvana/WikiaLocalRegistry.class.php';
$wgAutoloadClasses['WikiaDispatcher'] = $IP . '/includes/wikia/nirvana/WikiaDispatcher.class.php';
$wgAutoloadClasses['WikiaDispatchableObject'] = $IP . '/includes/wikia/nirvana/WikiaDispatchableObject.class.php';
$wgAutoloadClasses['WikiaController'] = $IP . '/includes/wikia/nirvana/WikiaController.class.php';
$wgAutoloadClasses['WikiaService'] = $IP . '/includes/wikia/nirvana/WikiaService.class.php';
$wgAutoloadClasses['WikiaModel'] = $IP . '/includes/wikia/nirvana/WikiaModel.class.php';
$wgAutoloadClasses['WikiaSpecialPageController'] = $IP . '/includes/wikia/nirvana/WikiaSpecialPageController.class.php';
$wgAutoloadClasses['WikiaErrorController'] = $IP . '/includes/wikia/nirvana/WikiaErrorController.class.php';
$wgAutoloadClasses['WikiaRequest'] = $IP . '/includes/wikia/nirvana/WikiaRequest.class.php';
$wgAutoloadClasses['WikiaResponse'] = $IP . '/includes/wikia/nirvana/WikiaResponse.class.php';
$wgAutoloadClasses['WikiaView'] = $IP . '/includes/wikia/nirvana/WikiaView.class.php';
$wgAutoloadClasses['WikiaSkin'] = $IP . '/includes/wikia/nirvana/WikiaSkin.class.php';
$wgAutoloadClasses['WikiaSkinTemplate'] = $IP . '/includes/wikia/nirvana/WikiaSkinTemplate.class.php';
$wgAutoloadClasses['WikiaFunctionWrapper'] = $IP . '/includes/wikia/nirvana/WikiaFunctionWrapper.class.php';
// unit tests related classes
$wgAutoloadClasses['WikiaBaseTest'] = $IP . '/includes/wikia/tests/core/WikiaBaseTest.class.php';
$wgAutoloadClasses['WikiaAppMock'] = $IP . '/includes/wikia/tests/core/WikiaAppMock.class.php';
$wgAutoloadClasses['WikiaMockProxy'] = $IP . '/includes/wikia/tests/core/WikiaMockProxy.class.php';
$wgAutoloadClasses['WikiaMockProxyAction'] = $IP . '/includes/wikia/tests/core/WikiaMockProxyAction.class.php';
$wgAutoloadClasses['WikiaMockProxyInvocation'] = $IP . '/includes/wikia/tests/core/WikiaMockProxyInvocation.class.php';
$wgAutoloadClasses['WikiaGlobalVariableMock'] = $IP . '/includes/wikia/tests/core/WikiaGlobalVariableMock.class.php';

/**
 * Exceptions
 */
$wgAutoloadClasses['WikiaException'] = "{$IP}/includes/wikia/nirvana/WikiaException.php";
$wgAutoloadClasses['WikiaDispatchedException'] = "{$IP}/includes/wikia/nirvana/WikiaException.php";
$wgAutoloadClasses['WikiaHttpException'] = "{$IP}/includes/wikia/nirvana/WikiaException.php";
$wgAutoloadClasses['BadRequestException'] = "{$IP}/includes/wikia/nirvana/WikiaException.php";
$wgAutoloadClasses['ForbiddenException'] = "{$IP}/includes/wikia/nirvana/WikiaException.php";
$wgAutoloadClasses['NotFoundException'] = "{$IP}/includes/wikia/nirvana/WikiaException.php";
$wgAutoloadClasses['MethodNotAllowedException'] = "{$IP}/includes/wikia/nirvana/WikiaException.php";
$wgAutoloadClasses['NotImplementedException'] = "{$IP}/includes/wikia/nirvana/WikiaException.php";

$wgAutoloadClasses['AssetsManager'] = $IP . '/extensions/wikia/AssetsManager/AssetsManager.class.php';
$wgAutoloadClasses['AssetsConfig'] = $IP . '/extensions/wikia/AssetsManager/AssetsConfig.class.php';

/**
 * Wikia API
 * (based on Nirvana)
 */

//holds a list of all the registered API controllers
//@see WikiaApp::registerApiController
$wgWikiaAPIControllers = array();

//ApiGate dependencies
include_once( "$IP/lib/vendor/ApiGate/config.php" );

//Wikia API Hooks
$wgHooks['ArticleUpdateCategoryCounts'][] = 'ArticlesApiController::onArticleUpdateCategoryCounts';

$wgAutoloadClasses[ 'ApiHooks'] =  "{$IP}/includes/wikia/api/ApiHooks.class.php" ;

$wgHooks['WikiFactoryChanged'][] = 'ApiHooks::onWikiFactoryChanged';
$wgHooks['MessageCacheReplace'][] = 'ApiHooks::onMessageCacheReplace';
$wgHooks['ArticleDeleteComplete'][] = 'ApiHooks::onArticleDeleteComplete';
$wgHooks['ArticleSaveComplete'][] = 'ApiHooks::onArticleSaveComplete';
$wgHooks['ArticleRollbackComplete'][] = 'ApiHooks::onArticleRollbackComplete';
$wgHooks['TitleMoveComplete'][] = 'ApiHooks::onTitleMoveComplete';
$wgHooks['ArticleCommentListPurgeComplete'][] = 'ApiHooks::ArticleCommentListPurgeComplete';


//Wikia API base controller, all the others extend this class
$wgAutoloadClasses[ 'WikiaApiController'] =  "{$IP}/includes/wikia/api/WikiaApiController.class.php" ;

//Wikia API controllers
$wgAutoloadClasses['DiscoverApiController'] = "{$IP}/includes/wikia/api/DiscoverApiController.class.php";
$wgAutoloadClasses['NavigationApiController'] = "{$IP}/includes/wikia/api/NavigationApiController.class.php";
$wgAutoloadClasses['ArticlesApiController'] = "{$IP}/includes/wikia/api/ArticlesApiController.class.php";
$wgAutoloadClasses['SearchSuggestionsApiController'] = "{$IP}/includes/wikia/api/SearchSuggestionsApiController.class.php";
$wgAutoloadClasses['StatsApiController'] = "{$IP}/includes/wikia/api/StatsApiController.class.php";
$wgAutoloadClasses['WikiaHubsApiController'] = "{$IP}/includes/wikia/api/WikiaHubsApiController.class.php";
$wgAutoloadClasses['RelatedPagesApiController'] = "{$IP}/includes/wikia/api/RelatedPagesApiController.class.php";
$wgAutoloadClasses['ActivityApiController'] = "{$IP}/includes/wikia/api/ActivityApiController.class.php";
$wgAutoloadClasses['UserApiController'] = "{$IP}/includes/wikia/api/UserApiController.class.php";

$wgWikiaApiControllers['DiscoverApiController'] = "{$IP}/includes/wikia/api/DiscoverApiController.class.php";
$wgWikiaApiControllers['NavigationApiController'] = "{$IP}/includes/wikia/api/NavigationApiController.class.php";
$wgWikiaApiControllers['ArticlesApiController'] = "{$IP}/includes/wikia/api/ArticlesApiController.class.php";
$wgWikiaApiControllers['SearchSuggestionsApiController'] = "{$IP}/includes/wikia/api/SearchSuggestionsApiController.class.php";
$wgWikiaApiControllers['StatsApiController'] = "{$IP}/includes/wikia/api/StatsApiController.class.php";
$wgWikiaApiControllers['WikiaHubsApiController'] = "{$IP}/includes/wikia/api/WikiaHubsApiController.class.php";
$wgWikiaApiControllers['RelatedPagesApiController'] = "{$IP}/includes/wikia/api/RelatedPagesApiController.class.php";
$wgWikiaApiControllers['ActivityApiController'] = "{$IP}/includes/wikia/api/ActivityApiController.class.php";
$wgWikiaApiControllers['UserApiController'] = "{$IP}/includes/wikia/api/UserApiController.class.php";

//Wikia Api exceptions classes
$wgAutoloadClasses[ 'BadRequestApiException'] =  "{$IP}/includes/wikia/api/ApiExceptions.php" ;
$wgAutoloadClasses[ 'OutOfRangeApiException'] =  "{$IP}/includes/wikia/api/ApiExceptions.php" ;
$wgAutoloadClasses[ 'MissingParameterApiException'] =  "{$IP}/includes/wikia/api/ApiExceptions.php" ;
$wgAutoloadClasses[ 'InvalidParameterApiException'] =  "{$IP}/includes/wikia/api/ApiExceptions.php" ;
$wgAutoloadClasses[ 'LimitExceededApiException'] =  "{$IP}/includes/wikia/api/ApiExceptions.php" ;
$wgAutoloadClasses[ 'NotFoundApiException'] =  "{$IP}/includes/wikia/api/ApiExceptions.php" ;

/**
 * Wikia API end
 */

/**
 * Wikia Skins
 *
 * this need to be autoloaded to avoid PHPUnit replacing the classes definition with mocks
 * and brake the world; Monobook is already autoloaded in /includes/DefaultSettings.php
 */
$wgAutoloadClasses[ 'SkinOasis'] =  "{$IP}/skins/Oasis.php" ;
$wgAutoloadClasses[ 'SkinWikiaMobile'] =  "{$IP}/skins/WikiaMobile.php" ;

$wgAutoloadClasses['SpamBlacklist'] = $IP . '/extensions/SpamBlacklist/SpamBlacklist_body.php';
$wgAutoloadClasses['BaseBlacklist'] = $IP . '/extensions/SpamBlacklist/BaseBlacklist.php';
$wgAutoloadClasses['SpamRegexBatch'] = $IP . '/extensions/SpamBlacklist/SpamRegexBatch.php';
$wgAutoloadClasses['WikiaSpamRegexBatch'] = $IP . '/extensions/wikia/WikiaSpamRegexBatch/WikiaSpamRegexBatch.php';

/**
 * Wikia Templating System
 */
$wgAutoloadClasses[ 'Wikia\Template\Engine' ] = "{$IP}/includes/wikia/template/Engine.class.php";
$wgAutoloadClasses[ 'Wikia\Template\PHPEngine' ] = "{$IP}/includes/wikia/template/PHPEngine.class.php";
$wgAutoloadClasses[ 'Wikia\Template\MustacheEngine' ] = "{$IP}/includes/wikia/template/MustacheEngine.class.php";
//deprecated, will be removed
$wgAutoloadClasses[ 'EasyTemplate' ] = "{$IP}/includes/wikia/EasyTemplate.php";

/**
 * Custom wikia classes
 */
$wgAutoloadClasses[ "GlobalTitle"                     ] = "$IP/includes/wikia/GlobalTitle.php";
$wgAutoloadClasses[ "GlobalFile"                      ] = "$IP/includes/wikia/GlobalFile.class.php";
$wgAutoloadClasses[ "WikiFactory"                     ] = "$IP/extensions/wikia/WikiFactory/WikiFactory.php";
$wgAutoloadClasses[ "WikiMover"                       ] = "$IP/extensions/wikia/WikiFactory/Mover/WikiMover.php";
$wgAutoloadClasses[ "WikiFactoryHub"                  ] = "$IP/extensions/wikia/WikiFactory/Hubs/WikiFactoryHub.php";
$wgAutoloadClasses[ 'SimplePie'                       ] = "$IP/lib/vendor/SimplePie/simplepie.inc";
$wgAutoloadClasses[ 'MustachePHP'                     ] = "$IP/lib/vendor/mustache.php/Mustache.php";
$wgAutoloadClasses[ 'Minify_CSS_Compressor'           ] = "$IP/lib/vendor/Minify_CSS_Compressor.php";
$wgAutoloadClasses[ 'GMetricClient'                   ] = "$IP/lib/vendor/GMetricClient.class.php";
$wgAutoloadClasses[ 'FakeLocalFile'                   ] = "$IP/includes/wikia/FakeLocalFile.class.php";
$wgAutoloadClasses[ 'PayflowAPI'                      ] = "$IP/includes/wikia/PayflowAPI.php";
$wgAutoloadClasses[ 'Curl'                            ] = "$IP/includes/wikia/Curl.php";
$wgAutoloadClasses[ 'WikiaPageType'                   ] = "$IP/includes/wikia/WikiaPageType.class.php";
$wgAutoloadClasses[ 'WikiaSkinMonoBook'               ] = "$IP/skins/wikia/WikiaMonoBook.php";
$wgAutoloadClasses[ 'PaginationController'            ] = "$IP/includes/wikia/services/PaginationController.class.php";
$wgAutoloadClasses[ 'MemcacheSync'                    ] = "$IP/includes/wikia/MemcacheSync.class.php";
$wgAutoloadClasses[ 'LibmemcachedBagOStuff'           ] = "$IP/includes/cache/wikia/LibmemcachedBagOStuff.php";
$wgAutoloadClasses[ 'LibmemcachedSessionHandler'      ] = "$IP/includes/cache/wikia/LibmemcachedSessionHandler.php";
$wgAutoloadClasses[ 'WikiaAssets'                     ] = "$IP/includes/wikia/WikiaAssets.class.php";
$wgAutoloadClasses[ "ExternalUser_Wikia"              ] = "$IP/includes/wikia/ExternalUser_Wikia.php";
$wgAutoloadClasses[ 'AutomaticWikiAdoptionGatherData' ] = "$IP/extensions/wikia/AutomaticWikiAdoption/maintenance/AutomaticWikiAdoptionGatherData.php";
$wgAutoloadClasses[ 'FakeSkin'                        ] = "$IP/includes/wikia/FakeSkin.class.php";
$wgAutoloadClasses[ 'WikiaUpdater'                    ] = "$IP/includes/wikia/WikiaUpdater.php";
$wgHooks          [ 'LoadExtensionSchemaUpdates'      ][] = 'WikiaUpdater::update';
$wgAutoloadClasses[ 'phpFlickr'                       ] = "$IP/lib/vendor/phpFlickr/phpFlickr.php";
$wgAutoloadClasses[ 'WikiaDataAccess'                 ] = "$IP/includes/wikia/WikiaDataAccess.class.php";
$wgAutoloadClasses[ 'ImageReviewStatuses'             ] = "$IP/extensions/wikia/ImageReview/ImageReviewStatuses.class.php";
$wgAutoloadClasses[ 'WikiaUserPropertiesController'   ] = "$IP/includes/wikia/WikiaUserPropertiesController.class.php";
$wgAutoloadClasses[ 'TitleBatch'                      ] = "$IP/includes/wikia/cache/TitleBatch.php";
$wgAutoloadClasses[ 'WikiaUserPropertiesHandlerBase'  ] = "$IP/includes/wikia/models/WikiaUserPropertiesHandlerBase.class.php";
$wgAutoloadClasses[ 'ParserPool'                      ] = "$IP/includes/wikia/parser/ParserPool.class.php";
$wgAutoloadClasses[ 'WikiDataSource'                  ] = "$IP/includes/wikia/WikiDataSource.php";
$wgAutoloadClasses[ 'DateFormatHelper'                ] = "$IP/includes/wikia/DateFormatHelper.php";
$wgAutoloadClasses[ 'CategoryHelper'                  ] = "$IP/includes/wikia/helpers/CategoryHelper.class.php";

/**
 * Resource Loader enhancements
 */
$wgAutoloadClasses[ 'ResourceLoaderGlobalWikiModule'  ]  = "$IP/includes/wikia/resourceloader/ResourceLoaderGlobalWikiModule.class.php";
$wgAutoloadClasses[ 'ResourceLoaderCustomWikiModule'  ]  = "$IP/includes/wikia/resourceloader/ResourceLoaderCustomWikiModule.class.php";
$wgAutoloadClasses[ 'ResourceLoaderHooks'  ]             = "$IP/includes/wikia/resourceloader/ResourceLoaderHooks.class.php";
$wgHooks['ResourceLoaderRegisterModules'][]              = "ResourceLoaderHooks::onResourceLoaderRegisterModules";
$wgHooks['ResourceLoaderUserOptionsModuleGetOptions'][]  = "ResourceLoaderHooks::onResourceLoaderUserOptionsModuleGetOptions";
$wgHooks['ResourceLoaderFileModuleConcatenateScripts'][] = 'ResourceLoaderHooks::onResourceLoaderFileModuleConcatenateScripts';
$wgHooks['ResourceLoaderSiteModule::getPages'][]         = 'ResourceLoaderHooks::onResourceLoaderSiteModuleGetPages';
$wgHooks['ResourceLoaderUserModule::getPages'][]         = 'ResourceLoaderHooks::onResourceLoaderUserModuleGetPages';
$wgHooks['ResourceLoaderCacheControlHeaders'][]          = "ResourceLoaderHooks::onResourceLoaderCacheControlHeaders";
$wgHooks['AlternateResourceLoaderURL'][]                 = "ResourceLoaderHooks::onAlternateResourceLoaderURL";
$wgHooks['ResourceLoaderMakeQuery'][]                    = "ResourceLoaderHooks::onResourceLoaderMakeQuery";
$wgHooks['ResourceLoaderModifyMaxAge'][]                 = "ResourceLoaderHooks::onResourceLoaderModifyMaxAge";

// services
$wgAutoloadClasses['Service']  =  $IP.'/includes/wikia/services/Service.php';
$wgAutoloadClasses['ApiService']  =  $IP.'/includes/wikia/services/ApiService.class.php';
$wgAutoloadClasses['ArticleService'] = $IP.'/includes/wikia/services/ArticleService.class.php';
$wgAutoloadClasses['AvatarService'] = $IP.'/includes/wikia/services/AvatarService.class.php';
$wgAutoloadClasses['MediaQueryService'] = $IP.'/includes/wikia/services/MediaQueryService.class.php';
$wgHooks['ArticleEditUpdates'][] = 'MediaQueryService::onArticleEditUpdates';
$wgAutoloadClasses['OasisService']  =  $IP.'/includes/wikia/services/OasisService.php';
$wgAutoloadClasses['PageStatsService']  =  $IP.'/includes/wikia/services/PageStatsService.class.php';
$wgAutoloadClasses['UserContribsProviderService'] = $IP.'/includes/wikia/services/UserContribsProviderService.class.php';
$wgAutoloadClasses['UserStatsService'] = $IP.'/includes/wikia/services/UserStatsService.class.php';
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
$wgAutoloadClasses['HubService'] = $IP . '/includes/wikia/services/HubService.class.php';
$wgAutoloadClasses['ImagesService'] = $IP . '/includes/wikia/services/ImagesService.class.php';
$wgAutoloadClasses['WikiService'] = $IP . '/includes/wikia/services/WikiService.class.php';
$wgAutoloadClasses['DataMartService'] = $IP . '/includes/wikia/services/DataMartService.class.php';
$wgAutoloadClasses['WAMService'] = $IP . '/includes/wikia/services/WAMService.class.php';
$wgAutoloadClasses['VideoService'] = $IP . '/includes/wikia/services/VideoService.class.php';
$wgAutoloadClasses['UserService']  =  $IP.'/includes/wikia/services/UserService.class.php';
$wgAutoloadClasses['MustacheService'] = $IP . '/includes/wikia/services/MustacheService.class.php';
$wgAutoloadClasses['RevisionService'] = $IP . '/includes/wikia/services/RevisionService.class.php';
$wgAutoloadClasses['InfoboxesService'] = $IP . '/includes/wikia/services/InfoboxesService.class.php';
$wgAutoloadClasses['RenderContentOnlyHelper'] = $IP . '/includes/wikia/RenderContentOnlyHelper.class.php';
$wgAutoloadClasses['SolrDocumentService'] = $IP . '/includes/wikia/services/SolrDocumentService.class.php';
$wgAutoloadClasses['FormBuilderService']  =  $IP.'/includes/wikia/services/FormBuilderService.class.php';

// data models
$wgAutoloadClasses['WikisModel'] = "{$IP}/includes/wikia/models/WikisModel.class.php";
$wgAutoloadClasses['NavigationModel'] = "{$IP}/includes/wikia/models/NavigationModel.class.php";
$wgAutoloadClasses['WikiaCollectionsModel'] = "{$IP}/includes/wikia/models/WikiaCollectionsModel.class.php";
$wgAutoloadClasses['WikiaCorporateModel'] = "{$IP}/includes/wikia/models/WikiaCorporateModel.class.php";

// modules
$wgAutoloadClasses['OasisController'] = $IP.'/skins/oasis/modules/OasisController.class.php';
$wgAutoloadClasses['BodyController'] = $IP.'/skins/oasis/modules/BodyController.class.php';
$wgAutoloadClasses['BodyContentOnlyController'] = $IP.'/skins/oasis/modules/BodyContentOnlyController.class.php';
$wgAutoloadClasses['ContentDisplayController'] = $IP.'/skins/oasis/modules/ContentDisplayController.class.php';
$wgAutoloadClasses['GlobalHeaderController'] = $IP.'/skins/oasis/modules/GlobalHeaderController.class.php';
$wgAutoloadClasses['CorporateFooterController'] = $IP.'/skins/oasis/modules/CorporateFooterController.class.php';
$wgAutoloadClasses['WikiHeaderController'] = $IP.'/skins/oasis/modules/WikiHeaderController.class.php';
$wgAutoloadClasses['SearchController'] = $IP.'/skins/oasis/modules/SearchController.class.php';
$wgAutoloadClasses['PageHeaderController'] = $IP.'/skins/oasis/modules/PageHeaderController.class.php';
$wgAutoloadClasses['LatestActivityController'] = $IP.'/skins/oasis/modules/LatestActivityController.class.php';
$wgAutoloadClasses['LatestPhotosController'] = $IP.'/skins/oasis/modules/LatestPhotosController.class.php';
$wgAutoloadClasses['FooterController'] = $IP.'/skins/oasis/modules/FooterController.class.php';
$wgAutoloadClasses['GameStarLogoController'] = $IP.'/skins/oasis/modules/GameStarLogoController.class.php';
$wgAutoloadClasses['ArticleCategoriesController'] = $IP.'/skins/oasis/modules/ArticleCategoriesController.class.php';
$wgAutoloadClasses['AchievementsController'] = $IP.'/skins/oasis/modules/AchievementsController.class.php';
$wgAutoloadClasses['AccountNavigationController'] = $IP.'/skins/oasis/modules/AccountNavigationController.class.php';
$wgAutoloadClasses['RailController'] = $IP.'/skins/oasis/modules/RailController.class.php';
$wgAutoloadClasses['AdController'] = $IP.'/skins/oasis/modules/AdController.class.php';
$wgAutoloadClasses['FollowedPagesController'] = $IP.'/skins/oasis/modules/FollowedPagesController.class.php';
$wgAutoloadClasses['MyToolsController'] = $IP.'/skins/oasis/modules/MyToolsController.class.php';
$wgAutoloadClasses['UserPagesHeaderController'] = $IP.'/skins/oasis/modules/UserPagesHeaderController.class.php';
$wgAutoloadClasses['SpotlightsController'] = $IP.'/skins/oasis/modules/SpotlightsController.class.php';
$wgAutoloadClasses['MenuButtonController'] = $IP.'/skins/oasis/modules/MenuButtonController.class.php';
$wgAutoloadClasses['CommentsLikesController'] = $IP.'/skins/oasis/modules/CommentsLikesController.class.php';
$wgAutoloadClasses['BlogListingController'] = $IP.'/skins/oasis/modules/BlogListingController.class.php';
$wgAutoloadClasses['NotificationsController'] = $IP.'/skins/oasis/modules/NotificationsController.class.php';
$wgAutoloadClasses['LatestEarnedBadgesController'] = $IP.'/extensions/wikia/AchievementsII/modules/LatestEarnedBadgesController.class.php';
$wgAutoloadClasses['HotSpotsController'] = $IP.'/skins/oasis/modules/HotSpotsController.class.php';
$wgAutoloadClasses['CommunityCornerController'] = $IP.'/skins/oasis/modules/CommunityCornerController.class.php';
$wgAutoloadClasses['PopularBlogPostsController'] = $IP.'/skins/oasis/modules/PopularBlogPostsController.class.php';
$wgAutoloadClasses['RandomWikiController'] = $IP.'/skins/oasis/modules/RandomWikiController.class.php';
$wgAutoloadClasses['ArticleInterlangController'] = $IP.'/skins/oasis/modules/ArticleInterlangController.class.php';
$wgAutoloadClasses['PagesOnWikiController'] = $IP.'/skins/oasis/modules/PagesOnWikiController.class.php';
$wgAutoloadClasses['ContributeMenuController'] = $IP.'/skins/oasis/modules/ContributeMenuController.class.php';
$wgAutoloadClasses['WikiNavigationController'] = $IP.'/skins/oasis/modules/WikiNavigationController.class.php';
$wgAutoloadClasses['SharingToolbarController'] = $IP.'/skins/oasis/modules/SharingToolbarController.class.php';
$wgAutoloadClasses['UploadPhotosController'] = $IP.'/skins/oasis/modules/UploadPhotosController.class.php';
$wgAutoloadClasses['WikiaTempFilesUpload'] = $IP.'/includes/wikia/WikiaTempFilesUpload.class.php';
$wgAutoloadClasses['ThemeSettings'] = $IP.'/extensions/wikia/ThemeDesigner/ThemeSettings.class.php';
$wgAutoloadClasses['ThemeDesignerHelper'] = $IP."/extensions/wikia/ThemeDesigner/ThemeDesignerHelper.class.php";//FB#22659 - dependency for ThemeSettings
$wgAutoloadClasses['ErrorController'] = $IP.'/skins/oasis/modules/ErrorController.class.php';
$wgAutoloadClasses['WikiaMediaCarouselController'] = $IP.'/skins/oasis/modules/WikiaMediaCarouselController.class.php';
$wgAutoloadClasses['LeftMenuController'] = $IP.'/skins/oasis/modules/LeftMenuController.class.php';

// Sass-related classes
$wgAutoloadClasses['SassService']              = $IP.'/includes/wikia/services/sass/SassService.class.php';

// Wikia Style Guide
$wgAutoloadClasses['Wikia\UI\Factory'] = $IP . '/includes/wikia/ui/Factory.class.php';
$wgAutoloadClasses['Wikia\UI\Component'] = $IP . '/includes/wikia/ui/Component.class.php';
$wgAutoloadClasses['Wikia\UI\TemplateException'] = $IP . '/includes/wikia/ui/exceptions/TemplateException.class.php';
$wgAutoloadClasses['Wikia\UI\DataException'] = $IP . '/includes/wikia/ui/exceptions/DataException.class.php';


// Register \Wikia\Sass namespace
spl_autoload_register( function( $class ) {
	if ( strpos( $class, 'Wikia\\Sass\\' ) !== false ) {
		$class = preg_replace( '/^\\\\?Wikia\\\\Sass\\\\/', '', $class );
		$file = $GLOBALS['IP'] . '/includes/wikia/services/sass/'.strtr( $class, '\\', '/' ).'.class.php';
		require_once( $file );
		return true;
	}
	return false;
});

// TODO:move this inclusions to CommonExtensions?
require_once( $IP.'/extensions/wikia/ImageTweaks/ImageTweaks.setup.php' );
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
 * Custom MediaWiki API modules
 */

$wgAutoloadClasses[ "WikiaApiQuery"                 ] = "$IP/extensions/wikia/WikiaApi/WikiaApiQuery.php";
$wgAutoloadClasses[ "WikiaApiQueryDomains"          ] = "$IP/extensions/wikia/WikiaApi/WikiaApiQueryDomains.php";
$wgAutoloadClasses[ "WikiaApiQueryPopularPages"     ] = "$IP/extensions/wikia/WikiaApi/WikiaApiQueryPopularPages.php";
$wgAutoloadClasses[ "WikiaApiQueryVoteArticle"      ] = "$IP/extensions/wikia/WikiaApi/WikiaApiQueryVoteArticle.php";
$wgAutoloadClasses[ "WikiaApiQueryWrite"            ] = "$IP/extensions/wikia/WikiaApi/WikiaApiQueryWrite.php";
$wgAutoloadClasses[ "WikiaApiQueryMostAccessPages"  ] = "$IP/extensions/wikia/WikiaApi/WikiaApiQueryMostAccessPages.php";
$wgAutoloadClasses[ "WikiaApiQueryLastEditPages"    ] = "$IP/extensions/wikia/WikiaApi/WikiaApiQueryLastEditPages.php";
$wgAutoloadClasses[ "WikiaApiQueryTopEditUsers"     ] = "$IP/extensions/wikia/WikiaApi/WikiaApiQueryTopEditUsers.php";
$wgAutoloadClasses[ "WikiaApiQueryMostVisitedPages" ] = "$IP/extensions/wikia/WikiaApi/WikiaApiQueryMostVisitedPages.php";
$wgAutoloadClasses[ "WikiaApiAjaxLogin"             ] = "$IP/extensions/wikia/WikiaApi/WikiaApiAjaxLogin.php";
$wgAutoloadClasses[ "WikiaApiQuerySiteInfo"         ] = "$IP/extensions/wikia/WikiaApi/WikiaApiQuerySiteinfo.php";
$wgAutoloadClasses[ "WikiaApiQueryPageinfo"         ] = "$IP/extensions/wikia/WikiaApi/WikiaApiQueryPageinfo.php";
$wgAutoloadClasses[ "WikiaApiCreatorReminderEmail"  ] = "$IP/extensions/wikia/CreateNewWiki/WikiaApiCreatorReminderEmail.php";
$wgAutoloadClasses[ "WikiFactoryTags"               ] = "$IP/extensions/wikia/WikiFactory/Tags/WikiFactoryTags.php";
$wgAutoloadClasses[ "WikiaApiQueryEventsData"       ] = "$IP/extensions/wikia/WikiaApi/WikiaApiQueryEventsData.php";
$wgAutoloadClasses[ "WikiaApiQueryAllUsers"         ] = "$IP/extensions/wikia/WikiaApi/WikiaApiQueryAllUsers.php";
$wgAutoloadClasses[ "WikiaApiQueryLastEditors"      ] = "$IP/extensions/wikia/WikiaApi/WikiaApiQueryLastEditors.php";
$wgAutoloadClasses[ "WikiaApiResetPasswordTime"     ] = "$IP/extensions/wikia/WikiaApi/WikiaApiResetPasswordTime.php";
$wgAutoloadClasses[ "ApiRunJob"                     ] = "$IP/extensions/wikia/WikiaApi/ApiRunJob.php";
$wgAutoloadClasses[ "ApiFetchBlob"                  ] = "$IP/includes/api/wikia/ApiFetchBlob.php";

/**
 * validators
 */
$wgAutoloadClasses[ "WikiaValidator"                ] = "$IP/includes/wikia/validators/WikiaValidator.class.php";
$wgAutoloadClasses[ "WikiaValidationError"          ] = "$IP/includes/wikia/validators/WikiaValidationError.class.php";
$wgAutoloadClasses[ "WikiaValidatorString"          ] = "$IP/includes/wikia/validators/WikiaValidatorString.class.php";
$wgAutoloadClasses[ "WikiaValidatorNumeric"         ] = "$IP/includes/wikia/validators/WikiaValidatorNumeric.class.php";
$wgAutoloadClasses[ "WikiaValidatorInteger"         ] = "$IP/includes/wikia/validators/WikiaValidatorInteger.class.php";
$wgAutoloadClasses[ "WikiaValidatorRegex"           ] = "$IP/includes/wikia/validators/WikiaValidatorRegex.class.php";
$wgAutoloadClasses[ "WikiaValidatorSelect"          ] = "$IP/includes/wikia/validators/WikiaValidatorSelect.class.php";
$wgAutoloadClasses[ "WikiaValidatorMail"            ] = "$IP/includes/wikia/validators/WikiaValidatorMail.class.php";
$wgAutoloadClasses[ "WikiaValidatorUrl"             ] = "$IP/includes/wikia/validators/WikiaValidatorUrl.class.php";
$wgAutoloadClasses[ "WikiaValidatorsSet"            ] = "$IP/includes/wikia/validators/WikiaValidatorsSet.class.php";
$wgAutoloadClasses[ "WikiaValidatorsAnd"            ] = "$IP/includes/wikia/validators/WikiaValidatorsAnd.class.php";
$wgAutoloadClasses[ "WikiaValidatorListBase"        ] = "$IP/includes/wikia/validators/WikiaValidatorListBase.class.php";
$wgAutoloadClasses[ "WikiaValidatorListValue"       ] = "$IP/includes/wikia/validators/WikiaValidatorListValue.class.php";
$wgAutoloadClasses[ "WikiaValidatorCompare"         ] = "$IP/includes/wikia/validators/WikiaValidatorCompare.class.php";
$wgAutoloadClasses[ "WikiaValidatorCompareValueIF"  ] = "$IP/includes/wikia/validators/WikiaValidatorCompareValueIF.class.php";
$wgAutoloadClasses[ "WikiaValidatorCompareEmptyIF"  ] = "$IP/includes/wikia/validators/WikiaValidatorCompareEmptyIF.class.php";
$wgAutoloadClasses[ "WikiaValidatorFileTitle"       ] = "$IP/includes/wikia/validators/WikiaValidatorFileTitle.class.php";
$wgAutoloadClasses[ "WikiaValidatorImageSize"       ] = "$IP/includes/wikia/validators/WikiaValidatorImageSize.class.php";
$wgAutoloadClasses[ "WikiaValidatorDependent"       ] = "$IP/includes/wikia/validators/WikiaValidatorDependent.class.php";
include_once("$IP/includes/wikia/validators/WikiaValidatorsExceptions.php");


/**
 * registered API methods
 */
global $wgAPIListModules;
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
$wgAPIPropModules[ "wklasteditors"] = "WikiaApiQueryLastEditors";

/*
 * reqistered API modules
 */
global $wgAPIModules;
$wgAPIModules[ "insert"            ] = "WikiaApiQueryWrite";
$wgAPIModules[ "update"            ] = "WikiaApiQueryWrite";
$wgAPIModules[ "delete"            ] = "ApiDelete";
$wgAPIModules[ "wdelete"           ] = "WikiaApiQueryWrite";
$wgAPIModules[ "ajaxlogin"         ] = "WikiaApiAjaxLogin";
$wgAPIModules[ "awcreminder"       ] = "WikiaApiCreatorReminderEmail";
$wgAPIModules[ "runjob"            ] = "ApiRunJob";
$wgAPIModules[ "fetchblob"         ] = "ApiFetchBlob";
$wgAPIModules[ "resetpasswordtime" ] = 'WikiaApiResetPasswordTime';

$wgUseAjax                = true;
$wgValidateUserName       = true;
$wgAjaxAutoCompleteSearch = true;

/**
 * Wikia custom extensions, enabled sitewide. Pre-required by some skins
 */
include_once( "$IP/extensions/ExtensionFunctions.php" );
include_once( "$IP/extensions/wikia/AnalyticsEngine/AnalyticsEngine.setup.php" );
include_once( "$IP/extensions/wikia/AjaxFunctions.php" );
include_once( "$IP/extensions/wikia/DataProvider/DataProvider.php" );
include_once( "$IP/extensions/wikia/StaffSig/StaffSig.php" );
include_once( "$IP/extensions/wikia/TagCloud/TagCloudClass.php" );
include_once( "$IP/extensions/wikia/MostPopularCategories/SpecialMostPopularCategories.php" );
include_once( "$IP/extensions/wikia/AssetsManager/AssetsManager_setup.php" );
include_once( "$IP/extensions/wikia/JSSnippets/JSSnippets_setup.php" );
include_once( "$IP/extensions/wikia/EmailsStorage/EmailsStorage.setup.php" );
include_once( "$IP/extensions/wikia/ShareButtons/ShareButtons.setup.php" );
include_once( "$IP/extensions/wikia/SpecialUnlockdb/SpecialUnlockdb.setup.php" );
include_once( "$IP/extensions/wikia/WikiaWantedQueryPage/WikiaWantedQueryPage.setup.php" );
include_once( "$IP/extensions/wikia/ImageServing/imageServing.setup.php" );
include_once( "$IP/extensions/wikia/ImageServing/Test/ImageServingTest.setup.php" );
include_once( "$IP/extensions/wikia/AdEngine/AdEngine2.setup.php" );
include_once( "$IP/extensions/wikia/VideoHandlers/VideoHandlers.setup.php" );
include_once( "$IP/extensions/wikia/SpecialUnusedVideos/SpecialUnusedVideos.setup.php" );
include_once( "$IP/extensions/wikia/ArticleSummary/ArticleSummary.setup.php" );
include_once( "$IP/extensions/wikia/FilePage/FilePage.setup.php" );
include_once( "$IP/extensions/wikia/CityVisualization/CityVisualization.setup.php" );

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
$wgJobClasses[ "CWLocal" ] = "CreateWikiLocalJob";
include_once( "$IP/extensions/wikia/CreateNewWiki/CreateWikiLocalJob.php" );

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
$wgKnowledgeDB = 'dataknowledge';
$wgDatamartDB = 'statsdb_mart';
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
 * libmemcached related stuff
 */
define( "CACHE_LIBMEMCACHED", 11 );
$wgObjectCaches[ CACHE_LIBMEMCACHED ] = array( 'factory' => 'LibmemcachedBagOStuff::newFromGlobals' );
$wgSessionsInLibmemcached = false;


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
 * We keep this enabled to support monobook
 **/
$wgEnableMWSuggest = true;

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
$wgMobileSkins = array( 'wikiaapp', 'wikiamobile' );

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
 * Disable the slow updating of MySQL search index. We use Lucene/Solr.
 */
$wgDisableSearchUpdate = true;

/**
 * New search code needs a default type to avoid falling back to SearchMySQL.
 */
$wgSearchType = 'SearchEngineDummy';

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
 * Media
 */
$wgAutoloadClasses['WikiaFileHelper'] = $IP.'/includes/wikia/services/WikiaFileHelper.class.php';
$wgAutoloadClasses['ArticlesUsingMediaQuery'] = $IP.'/includes/wikia/ArticlesUsingMediaQuery.class.php';
$wgHooks['ArticleSaveComplete'][] = 'ArticlesUsingMediaQuery::onArticleSaveComplete';
$wgHooks['ArticleDelete'][] = 'ArticlesUsingMediaQuery::onArticleDelete';

/**
 * Password reminder name
 */
$wgPasswordSenderName = 'Wikia';

/**
 * Defines the mapping for per-skin Common.js/css
 * IMPORTANT: use non-capitalized skin names here!
 *
 * @var array
 */
$wgResourceLoaderAssetsSkinMapping = array(
	'oasis' => 'wikia', // in Oasis we use Wikia.js (and Wikia.css) instead of Oasis.js (Oasis.css)
);

$wgWikiaHubsPages = array();

/**
 * @see https://wikia.fogbugz.com/default.asp?36946
 * core mediawiki feature variable
 */
$wgArticleCountMethod = "comma";

/**
 * Javascript minifier used by ResourceLoader
 * @var false|callback
 */
$wgResourceLoaderJavascriptMinifier = false;

/**
 * CSS minifier used by ResourceLoader
 * @var false|callback
 */
$wgResourceLoaderCssMinifier = false;

/**
 * by default we are not on central wiki
 * @var false|callback
 */
$wgWikiaIsCentralWiki = false;


/**
 * Is bulk mode in Memcached routines enabled?
 * (eg. get_multi())
 * @var boolean
 */
$wgEnableMemcachedBulkMode = false;

/**
 * WikiaSeasons flags
 */
$wgWikiaSeasonsGlobalHeader = false;
$wgWikiaSeasonsWikiaBar = false;
$wgWikiaSeasonsPencilUnit = false;

/**
 * @name $wgEnableWAMPageExt
 * Enables WAMPage extension (corporate pages extension)
 */
$wgEnableWAMPageExt = false;

/**
 * @name $wgWAMPageConfig
 * WAMPage extension configuration -- default configuration
 */
$wgWAMPageConfig = array(
	'pageName' => 'WAM',
	'faqPageName' => 'WAM/FAQ',
	'tabsNames' => array(
		'Top wikis',
		'The biggest gainers',
		'Top video games wikis',
		'Top entertainment wikis',
		'Top lifestyle wikis',
	),
);

/**
 * @name $wgEnableQuickToolsExt
 * Enables QuickTools extension
 */
$wgEnableQuickToolsExt = true;

/**
 * @name $wgPhalanxService
 * Use phalanx external service
 */
$wgPhalanxService = false;
$wgPhalanxServiceUrl = "http://phalanx";
$wgPhalanxServiceOptions = [];


/**
 * @name $wgWikiaHubsFileRepoDBName
 * DB name of wiki that contains images for WikiaHubs
 */
$wgWikiaHubsFileRepoDBName = 'corp';

/**
 * @name $wgWikiaHubsFileRepoPath
 * URL prefix for the wiki with hubs images
 */
$wgWikiaHubsFileRepoPath = 'http://corp.wikia.com/';

/**
 * @name $wgWikiaHubsFileRepoDirectory
 * filesystem path for hubs' images
 */
$wgWikiaHubsFileRepoDirectory = '/images/c/corp/images';

/**
 * @name $wgEnableAmazonDirectTargetedBuy
 * Enables AmazonDirectTargetedBuy integration
 */
$wgEnableAmazonDirectTargetedBuy = true;

/**
 * @name $wgEnableJavaScriptErrorLogging
 * Enables JavaScript error logging mechanism
 */
$wgEnableJavaScriptErrorLogging = false;

/**
 * @name $wgEnableAdEngineExt
 * Enables ad engine
 */
$wgEnableAdEngineExt = true;

/**
 * @name $wgAdVideoTargeting
 * Enables page-level video ad targeting
 */
$wgAdVideoTargeting = false;

/**
 * trusted proxy service registry
 */
$wgAutoloadClasses[ 'TrustedProxyService'] =  "$IP/includes/wikia/services/TrustedProxyService.class.php" ;
$wgHooks['IsTrustedProxy'][] = 'TrustedProxyService::onIsTrustedProxy';

/**
 * @name $wgChatDebugEnabled
 * Enables verbose logging from chat
 */
//$wgChatDebugEnabled = true;
