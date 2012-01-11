<?php

/**
 * @author Jakub Kurcek <jakub at wikia-inc.com>
 * @date 2011-12-06
 * @copyright Copyright (C) 2010 Jakub Kurcek, Wikia Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

/**
 * setup
 */
$wgLocalFileRepo = array(
	'class' => 'WikiaLocalRepo',
	'name' => 'local',
	'directory' => $wgUploadDirectory,
	'url' => $wgUploadBaseUrl ? $wgUploadBaseUrl . $wgUploadPath : $wgUploadPath,
	'hashLevels' => $wgHashedUploadDirectory ? 2 : 0,
	'thumbScriptUrl' => $wgThumbnailScriptPath,
	'transformVia404' => !$wgGenerateThumbnailOnParse,
	'deletedDir' => $wgFileStore['deleted']['directory'],
	'deletedHashLevels' => $wgFileStore['deleted']['hash']
);

/**
 * @var WikiaApp
 */
$app = F::app();
$dir = dirname( __FILE__ );
$app->registerClass( 'VideoHandler',	$dir . '/handlers/VideoHandler.class.php' );
$app->registerClass( 'VideoHandlerHooks', $dir . '/VideoHandlerHooks.class.php' );
$app->registerClass( 'WikiaVideoPage',	$dir . '/VideoPage.php' );
$app->registerClass( 'ThumbnailVideo',	$dir . '/ThumbnailVideo.class.php' );
$app->registerClass( 'WikiaLocalFile',	$dir . '/filerepo/WikiaLocalFile.class.php' );
$app->registerClass( 'WikiaLocalRepo',	$dir . '/filerepo/WikiaLocalRepo.class.php' );
$app->registerClass( 'WikiaLocalFileShared',	$dir . '/filerepo/WikiaLocalFileShared.class.php' );
$app->registerClass( 'ApiWrapper',	$dir . '/apiwrappers/ApiWrapper.class.php' );

/**
 * SpecialPages
 */
$app->registerClass( 'VideoHandlerSpecialController', $dir . '/VideoHandlerSpecialController.class.php' );
$app->registerSpecialPage('VideoHandler', 'VideoHandlerSpecialController');
/**
 * hooks
 */
$app->registerHook( 'ArticleFromTitle', 'VideoHandlerHooks', 'onArticleFromTitle' );

// permissions
$wgAvailableRights[] = 'specialvideohandler';
$wgGroupPermissions['staff']['specialvideohandler'] = true;