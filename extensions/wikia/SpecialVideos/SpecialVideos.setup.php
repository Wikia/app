<?php
/**
 * SpecialVideos
 * @author Liz Lee, Saipetch Kongkatong
 */

$wgExtensionCredits['specialpage'][] = array(
	'name' => 'SpecialVideos',
	'author' => array( 'Liz Lee', 'Saipetch Kongkatong' )
);

$dir = dirname(__FILE__) . '/';
$app = F::app();

//classes
$app->registerClass( 'SpecialVideosSpecialController', $dir.'SpecialVideosSpecialController.class.php' );
$app->registerClass( 'SpecialVideosHelper', $dir.'SpecialVideosHelper.class.php' );

// i18n mapping
$app->registerExtensionMessageFile( 'SpecialVideos', $dir.'SpecialVideos.i18n.php' );

// special pages
$app->registerSpecialPage( 'Videos', 'SpecialVideosSpecialController' );
