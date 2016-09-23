<?php

/**
 * @author Jakub Kurcek <jakub at wikia-inc.com>
 * @author Will Lee <wlee at wikia-inc.com>
 * @author Piotr Bablok <pbablok at wikia-inc.com>
 * @author Jacek Jursza <jacek at wikia-inc.com>
 * @author Saipetch Kongkatong <saipetch at wikia-inc.com>
 * @author Liz Lee <Liz at wikia-inc.com>
 * @author Garth Webb <garth at wikia-inc.com>
 * @author James Sutterfield <james at wikia-inc.com>
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
		"Saipetch Kongkatong <saipetch at wikia-inc.com>",
		"Liz Lee <liz at wikia-inc.com>",
		"Garth Webb <garth at wikia-inc.com>",
		"James Sutterfield <james at wikia-inc.com>",
	),
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/VideoHandlers',
	'descriptionmsg' => 'wikia-videohandlers-desc',
);

$wgWikiaVideoGalleryId = 0;
$wgWikiaVETLoaded = false;
$wgWikiaVideosFoundInTemplates = 0;

$dir = dirname( __FILE__ );

// Main classes
$wgAutoloadClasses[ 'VideoHandlerController' ] = $dir . '/VideoHandlerController.class.php';
$wgAutoloadClasses[ 'VideoHandlerHooks' ] = $dir . '/VideoHandlerHooks.class.php';
$wgAutoloadClasses[ 'VideoFileUploader' ] = $dir . '/VideoFileUploader.class.php';
$wgAutoloadClasses[ 'VideoHandlerHelper' ] = $dir . '/VideoHandlerHelper.class.php';
$wgAutoloadClasses[ 'UpdateThumbnailTask' ] = $dir . '/UpdateThumbnailTask.class.php';

// actions
$wgAutoloadClasses[ 'WikiaRevertVideoAction'] = $dir . '/actions/WikiaRevertVideoAction.php';

// api wrappers
$wgAutoloadClasses[ 'ApiWrapperFactory' ] = $dir . '/apiwrappers/ApiWrapperFactory.class.php';
$wgAutoloadClasses[ 'ApiWrapper' ] = $dir . '/apiwrappers/ApiWrapper.class.php';
$wgAutoloadClasses[ 'PseudoApiWrapper' ] = $dir . '/apiwrappers/ApiWrapper.class.php';
$wgAutoloadClasses[ 'IngestionApiWrapper' ] = $dir . '/apiwrappers/ApiWrapper.class.php';
$wgAutoloadClasses[ 'LegacyVideoApiWrapper'] = $dir . '/apiwrappers/ApiWrapper.class.php';

// api exceptions and errors
$wgAutoloadClasses[ 'EmptyResponseException'] = 	$dir . '/apiwrappers/ApiWrapper.class.php' ;
$wgAutoloadClasses[ 'VideoNotFoundException'] = 	$dir . '/apiwrappers/ApiWrapper.class.php' ;
$wgAutoloadClasses[ 'VideoQuotaExceededException'] = 	$dir . '/apiwrappers/ApiWrapper.class.php' ;
$wgAutoloadClasses[ 'VideoIsPrivateException'] = 	$dir . '/apiwrappers/ApiWrapper.class.php' ;
$wgAutoloadClasses[ 'UnsuportedTypeSpecifiedException'] =  $dir . '/apiwrappers/ApiWrapper.class.php' ;
$wgAutoloadClasses[ 'VideoNotFound'] =  $dir . '/apiwrappers/ApiWrapper.class.php' ;

// file repo
$wgAutoloadClasses[ 'OldWikiaLocalFile' ] = $dir . '/filerepo/OldWikiaLocalFile.class.php';
$wgAutoloadClasses[ 'WikiaForeignDBFile' ] = $dir . '/filerepo/WikiaForeignDBFile.class.php';
$wgAutoloadClasses[ 'WikiaForeignDBViaLBRepo' ] = $dir . '/filerepo/WikiaForeignDBViaLBRepo.class.php';
$wgAutoloadClasses[ 'WikiaLocalFile' ] = $dir . '/filerepo/WikiaLocalFile.class.php';
$wgAutoloadClasses[ 'WikiaLocalFileShared'] = $dir . '/filerepo/WikiaLocalFileShared.class.php';
$wgAutoloadClasses[ 'WikiaLocalRepo' ] = $dir . '/filerepo/WikiaLocalRepo.class.php';
$wgAutoloadClasses[ 'WikiaNoArticleLocalFile' ] = $dir . '/filerepo/WikiaNoArticleLocalFile.class.php';

// handler
$wgAutoloadClasses[ 'VideoHandler'] = 		$dir . '/handlers/VideoHandler.class.php' ;

// video controller
$wgAutoloadClasses[ 'VideosController'] =  $dir . '/VideosController.class.php' ;

// video info
$wgAutoloadClasses[ 'VideoInfo'] =  $dir . '/videoInfo/VideoInfo.class.php' ;
$wgAutoloadClasses[ 'VideoInfoHelper'] =  $dir . '/videoInfo/VideoInfoHelper.class.php' ;
$wgAutoloadClasses[ 'VideoInfoHooksHelper'] =  $dir . '/videoInfo/VideoInfoHooksHelper.class.php' ;

/**
 * messages
 */
$wgExtensionMessagesFiles['VideoHandlers'] = "$dir/VideoHandlers.i18n.php";

/**
 * hooks
 *
**/

$wgHooks['MWNamespace:isMovable'][] = 'VideoHandlerHooks::WikiaVideo_isMovable';
$wgHooks['ParserBeforeStrip'][] = 'VideoHandlerHooks::WikiaVideoParserBeforeStrip'; // <videogallery>

$wgHooks['FileRevertFormBeforeUpload'][] = 'VideoHandlerHooks::onFileRevertFormBeforeUpload';
$wgHooks['SetupAfterCache'][] = 'VideoHandlerHooks::onSetupAfterCache';
$wgHooks['LinkerMakeThumbLink2FileOriginalSize'][] = 'VideoHandlerHooks::onLinkerMakeThumbLink2FileOriginalSize';
$wgHooks['ParserAfterStrip'][] = 'VideoHandlerHooks::convertOldInterwikiToNewInterwiki';
$wgHooks['File::checkExtensionCompatibilityResult'][] = 'VideoHandlerHooks::checkExtensionCompatibilityResult';
$wgHooks['FindRedirectedFile'][] = 'VideoHandlerHooks::onFindRedirectedFile';
$wgHooks['UploadFromUrlReallyFetchFile'][] = 'VideoHandlerHooks::onUploadFromUrlReallyFetchFile';


$wgHooks['ArticleSaveComplete'][] = 'VideoInfoHooksHelper::onArticleSaveComplete';
$wgHooks['FileDeleteComplete'][] = 'VideoInfoHooksHelper::onFileDeleteComplete';
$wgHooks['FileUndeleteComplete'][] = 'VideoInfoHooksHelper::onFileUndeleteComplete';
$wgHooks['SpecialMovepageAfterMove'][] = 'VideoInfoHooksHelper::onFileRenameComplete';
$wgHooks['AddPremiumVideo'][] = 'VideoInfoHooksHelper::onAddPremiumVideo';
$wgHooks['ArticleDeleteComplete'][] = 'VideoInfoHooksHelper::onArticleDeleteComplete';
$wgHooks['UndeleteComplete'][] = 'VideoInfoHooksHelper::onUndeleteComplete';
$wgHooks['ForeignFileDeleted'][] = 'VideoInfoHooksHelper::onForeignFileDeleted';
$wgHooks['RemovePremiumVideo'][] = 'VideoInfoHooksHelper::onRemovePremiumVideo';
$wgHooks['WikiFilePageCheckFile'][] = 'VideoInfoHooksHelper::onCheckGhostFile';
if ( !empty( $wgUseVideoVerticalFilters ) ) {
	$wgHooks['ArticleDelete'][] = 'VideoInfoHooksHelper::onArticleDelete';
	$wgHooks['ArticleUpdateBeforeRedirect'][] = 'VideoInfoHooksHelper::onArticleUpdateBeforeRedirect';
	$wgHooks['CategorySelectSave'][] = 'VideoInfoHooksHelper::onCategorySelectSave';
}

$wgHooks['ParserFirstCallInit'][] = 'VideoHandlerHooks::initParserHook';

$wgHooks['VideoInfoSaveToCache'][] = 'VideoHandlerHooks::clearVideoCache';
$wgHooks['VideoInfoInvalidateCache'][] = 'VideoHandlerHooks::clearVideoCache';

/*
 * handlers
 */

$wgAutoloadClasses['DailymotionVideoHandler'] =  $dir . '/handlers/DailymotionVideoHandler.class.php';
$wgAutoloadClasses['DailymotionApiWrapper'] =  $dir . '/apiwrappers/DailymotionApiWrapper.class.php';
$wgMediaHandlers['video/dailymotion'] = 'DailymotionVideoHandler';

$wgAutoloadClasses['HuluVideoHandler'] =  $dir . '/handlers/HuluVideoHandler.class.php';
$wgAutoloadClasses['HuluApiWrapper'] =  $dir . '/apiwrappers/HuluApiWrapper.class.php';
$wgMediaHandlers['video/hulu'] = 'HuluVideoHandler';

$wgAutoloadClasses['FiveminVideoHandler'] =  $dir . '/handlers/FiveminVideoHandler.class.php';
$wgAutoloadClasses['FiveminApiWrapper'] =  $dir . '/apiwrappers/FiveminApiWrapper.class.php';
$wgMediaHandlers['video/fivemin'] = 'FiveminVideoHandler';

$wgAutoloadClasses['GametrailersVideoHandler'] =  $dir . '/handlers/GametrailersVideoHandler.class.php';
$wgAutoloadClasses['GametrailersApiWrapper'] =  $dir . '/apiwrappers/GametrailersApiWrapper.class.php';
$wgMediaHandlers['video/gametrailers'] = 'GametrailersVideoHandler';

$wgAutoloadClasses['MovieclipsVideoHandler'] =  $dir . '/handlers/MovieclipsVideoHandler.class.php';
$wgAutoloadClasses['MovieclipsApiWrapper'] =  $dir . '/apiwrappers/MovieclipsApiWrapper.class.php';
$wgMediaHandlers['video/movieclips'] = 'MovieclipsVideoHandler';

// Uses Ooyala for video handler
$wgAutoloadClasses['ScreenplayApiWrapper'] =  $dir . '/apiwrappers/ScreenplayApiWrapper.class.php';

$wgAutoloadClasses['IgnVideoHandler'] =  $dir . '/handlers/IgnVideoHandler.class.php';
$wgAutoloadClasses['IgnApiWrapper'] =  $dir . '/apiwrappers/IgnApiWrapper.class.php';
$wgMediaHandlers['video/ign'] = 'IgnVideoHandler';

$wgAutoloadClasses['SevenloadVideoHandler'] =  $dir . '/handlers/SevenloadVideoHandler.class.php';
$wgAutoloadClasses['SevenloadApiWrapper'] =  $dir . '/apiwrappers/SevenloadApiWrapper.class.php';
$wgMediaHandlers['video/sevenload'] = 'SevenloadVideoHandler';

$wgAutoloadClasses['SouthparkstudiosVideoHandler'] =  $dir . '/handlers/SouthparkstudiosVideoHandler.class.php';
$wgAutoloadClasses['SouthparkstudiosApiWrapper'] =  $dir . '/apiwrappers/SouthparkstudiosApiWrapper.class.php';
$wgMediaHandlers['video/southparkstudios'] = 'SouthparkstudiosVideoHandler';

$wgAutoloadClasses['ViddlerVideoHandler'] =  $dir . '/handlers/ViddlerVideoHandler.class.php';
$wgAutoloadClasses['ViddlerApiWrapper'] =  $dir . '/apiwrappers/ViddlerApiWrapper.class.php';
$wgMediaHandlers['video/viddler'] = 'ViddlerVideoHandler';

$wgAutoloadClasses['VimeoVideoHandler'] =  $dir . '/handlers/VimeoVideoHandler.class.php';
$wgAutoloadClasses['VimeoApiWrapper'] =  $dir . '/apiwrappers/VimeoApiWrapper.class.php';
$wgMediaHandlers['video/vimeo'] = 'VimeoVideoHandler';

$wgAutoloadClasses['YoutubeVideoHandler'] =  $dir . '/handlers/YoutubeVideoHandler.class.php';
$wgAutoloadClasses['YoutubeApiWrapper'] =  $dir . '/apiwrappers/YoutubeApiWrapper.class.php';
$wgMediaHandlers['video/youtube'] = 'YoutubeVideoHandler';

$wgAutoloadClasses['GamestarVideoHandler'] =  $dir . '/handlers/GamestarVideoHandler.class.php';
$wgAutoloadClasses['GamestarApiWrapper'] =  $dir . '/apiwrappers/GamestarApiWrapper.class.php';
$wgMediaHandlers['video/gamestar'] = 'GamestarVideoHandler';

$wgAutoloadClasses['AnyclipVideoHandler'] =  $dir . '/handlers/AnyclipVideoHandler.class.php';
$wgAutoloadClasses['AnyclipApiWrapper'] =  $dir . '/apiwrappers/AnyclipApiWrapper.class.php';
$wgMediaHandlers['video/anyclip'] = 'AnyclipVideoHandler';

$wgAutoloadClasses['TwitchtvVideoHandler'] =  $dir . '/handlers/TwitchtvVideoHandler.class.php';
$wgAutoloadClasses['TwitchtvApiWrapper'] =  $dir . '/apiwrappers/TwitchtvApiWrapper.class.php';
$wgMediaHandlers['video/twitchtv'] = 'TwitchtvVideoHandler';

$wgAutoloadClasses[ 'OoyalaVideoHandler'] =  $dir . '/handlers/OoyalaVideoHandler.class.php' ;
$wgAutoloadClasses[ 'OoyalaApiWrapper'] =  $dir . '/apiwrappers/OoyalaApiWrapper.class.php' ;
$wgMediaHandlers['video/ooyala'] = 'OoyalaVideoHandler';

$wgAutoloadClasses[ 'IvaVideoHandler'] =  $dir . '/handlers/IvaVideoHandler.class.php' ;
$wgAutoloadClasses[ 'IvaApiWrapper'] =  $dir . '/apiwrappers/IvaApiWrapper.class.php' ;
$wgMediaHandlers['video/iva'] = 'IvaVideoHandler';

$wgAutoloadClasses['UstreamVideoHandler'] =  $dir . '/handlers/UstreamVideoHandler.class.php';
$wgAutoloadClasses['UstreamApiWrapper'] =  $dir . '/apiwrappers/UstreamApiWrapper.class.php';
$wgMediaHandlers['video/ustream'] = 'UstreamVideoHandler';

$wgAutoloadClasses['YoukuApiWrapper'] =  $dir . '/apiwrappers/YoukuApiWrapper.class.php';
$wgAutoloadClasses['YoukuVideoHandler'] =  $dir . '/handlers/YoukuVideoHandler.class.php';
$wgMediaHandlers['video/youku'] = 'YoukuVideoHandler';

$wgAutoloadClasses['CrunchyrollApiWrapper'] =  $dir . '/apiwrappers/CrunchyrollApiWrapper.class.php';
$wgAutoloadClasses['CrunchyrollVideoHandler'] =  $dir . '/handlers/CrunchyrollVideoHandler.class.php';
$wgMediaHandlers['video/crunchyroll'] = 'CrunchyrollVideoHandler';

$wgAutoloadClasses['MakerstudiosApiWrapper'] =  $dir . '/apiwrappers/MakerstudiosApiWrapper.class.php';
$wgAutoloadClasses['MakerstudiosVideoHandler'] =  $dir . '/handlers/MakerstudiosVideoHandler.class.php';
$wgMediaHandlers['video/makerstudios'] = 'MakerstudiosVideoHandler';

/**
 * Feed ingesters
 */
$wgAutoloadClasses[ 'VideoFeedIngester' ] = $dir . '/feedingesters/VideoFeedIngester.class.php';
$wgAutoloadClasses[ 'RemoteAssetFeedIngester' ] = $dir . '/feedingesters/RemoteAssetFeedIngester.class.php';
$wgAutoloadClasses[ 'ScreenplayFeedIngester' ] = $dir . '/feedingesters/ScreenplayFeedIngester.class.php';
$wgAutoloadClasses[ 'IgnFeedIngester' ] = $dir . '/feedingesters/IgnFeedIngester.class.php';
$wgAutoloadClasses[ 'AnyclipFeedIngester' ] = $dir . '/feedingesters/AnyclipFeedIngester.class.php';
$wgAutoloadClasses[ 'OoyalaFeedIngester' ] = $dir . '/feedingesters/OoyalaFeedIngester.class.php';
$wgAutoloadClasses[ 'IvaFeedIngester' ] = $dir . '/feedingesters/IvaFeedIngester.class.php';
$wgAutoloadClasses[ 'CrunchyrollFeedIngester' ] = $dir . '/feedingesters/CrunchyrollFeedIngester.class.php';
$wgAutoloadClasses[ 'MakerstudiosFeedIngester' ] = $dir . '/feedingesters/MakerstudiosFeedIngester.class.php';
$wgAutoloadClasses[ 'TestVideoFeedIngester' ] = $dir . '/tests/TestVideoFeedIngester.class.php';

$wgAutoloadClasses[ 'FeedIngesterDataNormalizer' ] = $dir . '/feedingesters/FeedIngesterDataNormalizer.class.php';
$wgAutoloadClasses[ 'FeedIngesterFactory' ] = $dir . '/feedingesters/FeedIngesterFactory.class.php';
$wgAutoloadClasses[ 'FeedIngesterLogger' ] = $dir . '/feedingesters/FeedIngesterLogger.class.php';

$wgAutoloadClasses[ 'OoyalaAsset' ] = $dir . '/feedingesters/OoyalaAsset.class.php';


$wgVideoMigrationProviderMap = array(
	4 => 'Fivemin',
	5 => 'Youtube',
	6 => 'Hulu',
	12 => 'Sevenload',
	13 => 'Vimeo',
	18 => 'Dailymotion',
	19 => 'Viddler',
	21 => 'Screenplay',
	22 => 'Movieclips',
	/*
	// a trick to make video.wikia and local files accessible via wrappers:
	24 => 'Wikia',
	*/
	25 => 'Gamestar',
	26 => 'Anyclip',
	27 => 'Twitchtv',
	28 => 'Ooyala',
	29 => 'Iva',
	31 => 'Ustream',
	32 => 'Youku'
);
