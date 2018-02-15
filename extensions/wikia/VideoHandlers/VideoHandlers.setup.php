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
$wgHooks['ParserBeforeStrip'][] = 'VideoHandlerHooks::WikiaVideoParserBeforeStrip'; // <videogallery>

$wgHooks['FileRevertFormBeforeUpload'][] = 'VideoHandlerHooks::onFileRevertFormBeforeUpload';
$wgHooks['SetupAfterCache'][] = 'VideoHandlerHooks::onSetupAfterCache';
$wgHooks['LinkerMakeThumbLink2FileOriginalSize'][] = 'VideoHandlerHooks::onLinkerMakeThumbLink2FileOriginalSize';
$wgHooks['ParserAfterStrip'][] = 'VideoHandlerHooks::convertOldInterwikiToNewInterwiki';
$wgHooks['File::checkExtensionCompatibilityResult'][] = 'VideoHandlerHooks::checkExtensionCompatibilityResult';
$wgHooks['FindRedirectedFile'][] = 'VideoHandlerHooks::onFindRedirectedFile';
$wgHooks['UploadFromUrlReallyFetchFile'][] = 'VideoHandlerHooks::onUploadFromUrlReallyFetchFile';


$wgHooks['FileDeleteComplete'][] = 'VideoInfoHooksHelper::onFileDeleteComplete';
$wgHooks['FileUndeleteComplete'][] = 'VideoInfoHooksHelper::onFileUndeleteComplete';
$wgHooks['SpecialMovepageAfterMove'][] = 'VideoInfoHooksHelper::onFileRenameComplete';
$wgHooks['ForeignFileDeleted'][] = 'VideoInfoHooksHelper::onForeignFileDeleted';
$wgHooks['WikiFilePageCheckFile'][] = 'VideoInfoHooksHelper::onCheckGhostFile';

$wgHooks['ParserFirstCallInit'][] = 'VideoHandlerHooks::initParserHook';

$wgHooks['VideoInfoSaveToCache'][] = 'VideoHandlerHooks::clearVideoCache';
$wgHooks['VideoInfoInvalidateCache'][] = 'VideoHandlerHooks::clearVideoCache';

/*
 * handlers
 */

$wgAutoloadClasses['DailymotionVideoHandler'] =  $dir . '/handlers/DailymotionVideoHandler.class.php';
$wgAutoloadClasses['DailymotionApiWrapper'] =  $dir . '/apiwrappers/DailymotionApiWrapper.class.php';
$wgMediaHandlers['video/dailymotion'] = 'DailymotionVideoHandler';

$wgAutoloadClasses['IgnVideoHandler'] =  $dir . '/handlers/IgnVideoHandler.class.php';
$wgAutoloadClasses['IgnApiWrapper'] =  $dir . '/apiwrappers/IgnApiWrapper.class.php';
$wgMediaHandlers['video/ign'] = 'IgnVideoHandler';

$wgAutoloadClasses['VimeoVideoHandler'] =  $dir . '/handlers/VimeoVideoHandler.class.php';
$wgAutoloadClasses['VimeoApiWrapper'] =  $dir . '/apiwrappers/VimeoApiWrapper.class.php';
$wgMediaHandlers['video/vimeo'] = 'VimeoVideoHandler';

$wgAutoloadClasses['YoutubeVideoHandler'] =  $dir . '/handlers/YoutubeVideoHandler.class.php';
$wgAutoloadClasses['YoutubeApiWrapper'] =  $dir . '/apiwrappers/YoutubeApiWrapper.class.php';
$wgMediaHandlers['video/youtube'] = 'YoutubeVideoHandler';

$wgAutoloadClasses['YoukuApiWrapper'] =  $dir . '/apiwrappers/YoukuApiWrapper.class.php';
$wgAutoloadClasses['YoukuVideoHandler'] =  $dir . '/handlers/YoukuVideoHandler.class.php';
$wgMediaHandlers['video/youku'] = 'YoukuVideoHandler';

$wgVideoMigrationProviderMap = array(
	5 => 'Youtube',
	13 => 'Vimeo',
	18 => 'Dailymotion',
	/*
	// a trick to make video.wikia and local files accessible via wrappers:
	24 => 'Wikia',
	*/
	32 => 'Youku'
);
