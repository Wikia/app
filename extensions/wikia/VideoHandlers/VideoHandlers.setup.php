<?php

/**
 * @author Jakub Kurcek <jakub at wikia-inc.com>
 * @author Will Lee <wlee at wikia-inc.com>
 * @author Piotr Bablok <pbablok at wikia-inc.com>
 * @author Jacek Jursza <jacek at wikia-inc.com>
 * @date 2011-12-06
 * @copyright Copyright (C) 2010 Jakub Kurcek, Wikia Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

$wgExtensionCredits['videohandlers'][] = array(
	'name' => 'VideoHandlers',
	'author' => array(
		"Jakub Kurcek <jakub at wikia-inc.com>",
		"Will Lee <wlee at wikia-inc.com>",
		"Piotr Bablok <pbablok at wikia-inc.com>",
		"Jacek Jursza <jacek at wikia-inc.com>",
	),
	'url' => 'http://video.wikia.com',
	'descriptionmsg' => 'wikia-videohandlers-desc',
);

/**
 * setup
 */
$wgNamespaceAliases[ 'Video' ] = 6;
$wgNamespaceAliases['Video_talk'] = 7;
define( 'NS_VIDEO', 6 );


$wgWikiaVideoGalleryId = 0;
$wgWikiaVETLoaded = false;
$wgWikiaVideosFoundInTemplates = 0;

/**
 * @var WikiaApp
 */
$app = F::app();
$dir = dirname( __FILE__ );
$app->registerClass( 'ThumbnailVideo',		$dir . '/ThumbnailVideo.class.php' );
$app->registerClass( 'VideoHandlerController',	$dir . '/VideoHandlerController.class.php' );
$app->registerClass( 'VideoHandlerHooks',	$dir . '/VideoHandlerHooks.class.php' );
$app->registerClass( 'VideoFileUploader',	$dir . '/VideoFileUploader.class.php' );
$app->registerClass( 'WikiaVideoPage',		$dir . '/VideoPage.php' );

// api wrappers
$app->registerClass( 'ApiWrapperFactory',		$dir . '/apiwrappers/ApiWrapperFactory.class.php' );
$app->registerClass( 'ApiWrapper',		$dir . '/apiwrappers/ApiWrapper.class.php' );
$app->registerClass( 'PseudoApiWrapper',	$dir . '/apiwrappers/ApiWrapper.class.php' );
$app->registerClass( 'IngestionApiWrapper',	$dir . '/apiwrappers/ApiWrapper.class.php' );
$app->registerClass( 'LegacyVideoApiWrapper',		$dir . '/apiwrappers/ApiWrapper.class.php' );
// api exceptions and errors
$app->registerClass( 'EmptyResponseException',	$dir . '/apiwrappers/ApiWrapper.class.php' );
$app->registerClass( 'VideoNotFoundException',	$dir . '/apiwrappers/ApiWrapper.class.php' );
$app->registerClass( 'VideoQuotaExceededException',	$dir . '/apiwrappers/ApiWrapper.class.php' );
$app->registerClass( 'VideoIsPrivateException',	$dir . '/apiwrappers/ApiWrapper.class.php' );
$app->registerClass( 'UnsuportedTypeSpecifiedException', $dir . '/apiwrappers/ApiWrapper.class.php' );
$app->registerClass( 'VideoNotFound', $dir . '/apiwrappers/ApiWrapper.class.php' );

// file repo
$app->registerClass( 'OldWikiaLocalFile',	$dir . '/filerepo/OldWikiaLocalFile.class.php' );
//mech: missing WikiaFileRevertForm class breaks the unit tests, so I commented it out
//$app->registerClass( 'WikiaFileRevertForm',	$dir . '/filerepo/WikiaFileRevertForm.class.php');
$app->registerClass( 'WikiaForeignDBFile',	$dir . '/filerepo/WikiaForeignDBFile.class.php' );
$app->registerClass( 'WikiaForeignDBViaLBRepo',	$dir . '/filerepo/WikiaForeignDBViaLBRepo.class.php' );
$app->registerClass( 'WikiaLocalFile',		$dir . '/filerepo/WikiaLocalFile.class.php' );
$app->registerClass( 'WikiaLocalFileShared',	$dir . '/filerepo/WikiaLocalFileShared.class.php' );
$app->registerClass( 'WikiaLocalRepo',		$dir . '/filerepo/WikiaLocalRepo.class.php' );
$app->registerClass( 'WikiaNoArticleLocalFile',	$dir . '/filerepo/WikiaNoArticleLocalFile.class.php' );

// handler
$app->registerClass( 'VideoHandler',		$dir . '/handlers/VideoHandler.class.php' );

// video controller
$app->registerClass( 'VideosController', $dir . '/VideosController.class.php' );

// video info
$app->registerClass( 'VideoInfo', $dir . '/videoInfo/VideoInfo.class.php' );
$app->registerClass( 'VideoInfoHelper', $dir . '/videoInfo/VideoInfoHelper.class.php' );
$app->registerClass( 'VideoInfoHooksHelper', $dir . '/videoInfo/VideoInfoHooksHelper.class.php' );

/**
 * messages
 */
$wgExtensionMessagesFiles['VideoHandlers'] = "$dir/VideoHandlers.i18n.php";

/**
 * hooks
 *
**/

$app->registerHook( 'MWNamespace:isMovable', 'VideoHandlerHooks', 'WikiaVideo_isMovable');
$app->registerHook( 'SpecialNewImages::beforeQuery', 'VideoHandlerHooks', 'WikiaVideoNewImagesBeforeQuery');
$app->registerHook( 'Parser::FetchTemplateAndTitle', 'VideoHandlerHooks', 'WikiaVideoFetchTemplateAndTitle');
$app->registerHook( 'ParserBeforeStrip', 'VideoHandlerHooks', 'WikiaVideoParserBeforeStrip'); // <videogallery>

$app->registerHook( 'FileRevertFormBeforeUpload', 'VideoHandlerHooks', 'onFileRevertFormBeforeUpload' );
$app->registerHook( 'ArticleFromTitle', 'VideoHandlerHooks', 'onArticleFromTitle' );
$app->registerHook( 'SetupAfterCache', 'VideoHandlerHooks', 'onSetupAfterCache' );
$app->registerHook( 'BeforePageDisplay', 'VideoHandlerHooks', 'onBeforePageDisplay' );
$app->registerHook( 'LinkerMakeThumbLink2FileOriginalSize', 'VideoHandlerHooks', 'onLinkerMakeThumbLink2FileOriginalSize' );
$app->registerHook( 'ParserAfterStrip', 'VideoHandlerHooks', 'convertOldInterwikiToNewInterwiki' );
$app->registerHook( 'File::checkExtensionCompatibilityResult', 'VideoHandlerHooks', 'checkExtensionCompatibilityResult' );

// (BugId:44086) hiding front end for now while back end if being worked on
//$app->registerHook( 'SkinTemplateNavigation', 'VideoHandlerHooks', 'onSkinTemplateNavigation' );

$app->registerHook( 'FileUpload', 'VideoInfoHooksHelper', 'onFileUpload' );
$app->registerHook( 'ArticleSaveComplete', 'VideoInfoHooksHelper', 'onArticleSaveComplete' );
$app->registerHook( 'FileDeleteComplete', 'VideoInfoHooksHelper', 'onFileDeleteComplete' );
$app->registerHook( 'FileUndeleteComplete', 'VideoInfoHooksHelper', 'onFileUndeleteComplete' );
$app->registerHook( 'SpecialMovepageAfterMove', 'VideoInfoHooksHelper', 'onFileRenameComplete' );
$app->registerHook( 'AddPremiumVideo', 'VideoInfoHooksHelper', 'onAddPremiumVideo' );

if(!empty($wgVideoHandlersVideosMigrated)) {
	$app->registerHook( 'ParserFirstCallInit', 'VideoHandlerHooks', 'initParserHook' );
}

// permissions
$wgAvailableRights[] = 'specialvideohandler';
$wgGroupPermissions['staff']['specialvideohandler'] = true;

/*
 * handlers
 */

$app->registerClass('BliptvVideoHandler', $dir . '/handlers/BliptvVideoHandler.class.php');
$app->registerClass('BliptvApiWrapper', $dir . '/apiwrappers/BliptvApiWrapper.class.php');
$wgMediaHandlers['video/bliptv'] = 'BliptvVideoHandler';

$app->registerClass('DailymotionVideoHandler', $dir . '/handlers/DailymotionVideoHandler.class.php');
$app->registerClass('DailymotionApiWrapper', $dir . '/apiwrappers/DailymotionApiWrapper.class.php');
$wgMediaHandlers['video/dailymotion'] = 'DailymotionVideoHandler';

$app->registerClass('HuluVideoHandler', $dir . '/handlers/HuluVideoHandler.class.php');
$app->registerClass('HuluApiWrapper', $dir . '/apiwrappers/HuluApiWrapper.class.php');
$wgMediaHandlers['video/hulu'] = 'HuluVideoHandler';

$app->registerClass('FiveminVideoHandler', $dir . '/handlers/FiveminVideoHandler.class.php');
$app->registerClass('FiveminApiWrapper', $dir . '/apiwrappers/FiveminApiWrapper.class.php');
$wgMediaHandlers['video/fivemin'] = 'FiveminVideoHandler';

$app->registerClass('GametrailersVideoHandler', $dir . '/handlers/GametrailersVideoHandler.class.php');
$app->registerClass('GametrailersApiWrapper', $dir . '/apiwrappers/GametrailersApiWrapper.class.php');
$wgMediaHandlers['video/gametrailers'] = 'GametrailersVideoHandler';

$app->registerClass('MetacafeVideoHandler', $dir . '/handlers/MetacafeVideoHandler.class.php');
$app->registerClass('MetacafeApiWrapper', $dir . '/apiwrappers/MetacafeApiWrapper.class.php');
$wgMediaHandlers['video/metacafe'] = 'MetacafeVideoHandler';

$app->registerClass('MovieclipsVideoHandler', $dir . '/handlers/MovieclipsVideoHandler.class.php');
$app->registerClass('MovieclipsApiWrapper', $dir . '/apiwrappers/MovieclipsApiWrapper.class.php');
$wgMediaHandlers['video/movieclips'] = 'MovieclipsVideoHandler';

$app->registerClass('MyvideoVideoHandler', $dir . '/handlers/MyvideoVideoHandler.class.php');
$app->registerClass('MyvideoApiWrapper', $dir . '/apiwrappers/MyvideoApiWrapper.class.php');
$wgMediaHandlers['video/myvideo'] = 'MyvideoVideoHandler';

$app->registerClass('RealgravityVideoHandler', $dir . '/handlers/RealgravityVideoHandler.class.php');
$app->registerClass('RealgravityApiWrapper', $dir . '/apiwrappers/RealgravityApiWrapper.class.php');
$wgMediaHandlers['video/realgravity'] = 'RealgravityVideoHandler';

$app->registerClass('ScreenplayVideoHandler', $dir . '/handlers/ScreenplayVideoHandler.class.php');
$app->registerClass('ScreenplayApiWrapper', $dir . '/apiwrappers/ScreenplayApiWrapper.class.php');
$wgMediaHandlers['video/screenplay'] = 'ScreenplayVideoHandler';

$app->registerClass('IgnVideoHandler', $dir . '/handlers/IgnVideoHandler.class.php');
$app->registerClass('IgnApiWrapper', $dir . '/apiwrappers/IgnApiWrapper.class.php');
$wgMediaHandlers['video/ign'] = 'IgnVideoHandler';

$app->registerClass('SevenloadVideoHandler', $dir . '/handlers/SevenloadVideoHandler.class.php');
$app->registerClass('SevenloadApiWrapper', $dir . '/apiwrappers/SevenloadApiWrapper.class.php');
$wgMediaHandlers['video/sevenload'] = 'SevenloadVideoHandler';

$app->registerClass('SouthparkstudiosVideoHandler', $dir . '/handlers/SouthparkstudiosVideoHandler.class.php');
$app->registerClass('SouthparkstudiosApiWrapper', $dir . '/apiwrappers/SouthparkstudiosApiWrapper.class.php');
$wgMediaHandlers['video/southparkstudios'] = 'SouthparkstudiosVideoHandler';

$app->registerClass('ViddlerVideoHandler', $dir . '/handlers/ViddlerVideoHandler.class.php');
$app->registerClass('ViddlerApiWrapper', $dir . '/apiwrappers/ViddlerApiWrapper.class.php');
$wgMediaHandlers['video/viddler'] = 'ViddlerVideoHandler';

$app->registerClass('VimeoVideoHandler', $dir . '/handlers/VimeoVideoHandler.class.php');
$app->registerClass('VimeoApiWrapper', $dir . '/apiwrappers/VimeoApiWrapper.class.php');
$wgMediaHandlers['video/vimeo'] = 'VimeoVideoHandler';

$app->registerClass('YoutubeVideoHandler', $dir . '/handlers/YoutubeVideoHandler.class.php');
$app->registerClass('YoutubeApiWrapper', $dir . '/apiwrappers/YoutubeApiWrapper.class.php');
$wgMediaHandlers['video/youtube'] = 'YoutubeVideoHandler';

$app->registerClass('GamestarVideoHandler', $dir . '/handlers/GamestarVideoHandler.class.php');
$app->registerClass('GamestarApiWrapper', $dir . '/apiwrappers/GamestarApiWrapper.class.php');
$wgMediaHandlers['video/gamestar'] = 'GamestarVideoHandler';

/**
 * Feed ingesters
 */
$app->registerClass('VideoFeedIngester', $dir . '/feedingesters/VideoFeedIngester.class.php');
$app->registerClass('RealgravityFeedIngester', $dir . '/feedingesters/RealgravityFeedIngester.class.php');
$app->registerClass('ScreenplayFeedIngester', $dir . '/feedingesters/ScreenplayFeedIngester.class.php');
$app->registerClass('IgnFeedIngester', $dir . '/feedingesters/IgnFeedIngester.class.php');

$wgVideoMigrationProviderMap = array(
	4 => 'Fivemin',
	5 => 'Youtube',
	6 => 'Hulu',
	10 => 'Bliptv',
	11 => 'Metacafe',
	12 => 'Sevenload',
	13 => 'Vimeo',
	15 => 'Myvideo',
	18 => 'Dailymotion',
	19 => 'Viddler',
	21 => 'Screenplay',
	22 => 'Movieclips',
	23 => 'Realgravity',
	/*
	// a trick to make video.wikia and local files accessible via wrappers:
	24 => 'Wikia',
	*/
	25 => 'Gamestar',
);


/*
 * After migration
 */
if(!empty($wgVideoHandlersVideosMigrated)) {

	/**
	 * SpecialPages
	 */
	//$app->registerClass( 'VideoHandlerSpecialController', $dir . '/VideoHandlerSpecialController.class.php' );
	//$app->registerSpecialPage('VideoHandler', 'VideoHandlerSpecialController');

}
