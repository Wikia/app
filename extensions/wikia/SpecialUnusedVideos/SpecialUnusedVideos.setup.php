<?php
/**
 * SpecialUnusedVideos
 * @author Garth Webb, Hyun Lim, Liz Lee, Saipetch Kongkatong
 */

$wgExtensionCredits['specialpage'][] = array(
	'name' => 'SpecialUnusedVideos',
	'author' => array( 'Garth Webb', 'Hyun Lim', 'Liz Lee', 'Saipetch Kongkatong' )
);

$dir = dirname(__FILE__) . '/';
$app = F::app();

//classes
$wgAutoloadClasses[ 'SpecialUnusedVideos'] =  $dir.'SpecialUnusedVideos.class.php' ;
$wgAutoloadClasses[ 'SpecialUnusedVideosHooks'] =  $dir.'SpecialUnusedVideosHooks.class.php' ;

// Hook
$app->registerHook( 'wgQueryPages', 'SpecialUnusedVideosHooks', 'registerUnusedVideos' );

// i18n mapping
$app->registerExtensionMessageFile( 'SpecialUnusedVideos', $dir.'SpecialUnusedVideos.i18n.php' );
$app->registerExtensionMessageFile( 'SpecialUnusedVideosAliases', $dir.'SpecialUnusedVideos.alias.php' );

// special pages
$wgSpecialPages[ 'UnusedVideos' ] =  'SpecialUnusedVideos';

$wgSpecialPageGroups['UnusedVideos'] = 'maintenance';
