<?php
/**
 * SpecialUnusedVideos
 * @author Garth Webb, Hyun Lim, Liz Lee, Saipetch Kongkatong
 */

$wgExtensionCredits['specialpage'][] = array(
	'name' => 'SpecialUnusedVideos',
	'author' => array( 'Garth Webb', 'Hyun Lim', 'Liz Lee', 'Saipetch Kongkatong' ),
	'descriptionmsg' => 'unusedvideos-desc',
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/SpecialUnusedVideos'
);

$dir = dirname(__FILE__) . '/';

//classes
$wgAutoloadClasses[ 'SpecialUnusedVideos'] =  $dir.'SpecialUnusedVideos.class.php' ;
$wgAutoloadClasses[ 'SpecialUnusedVideosHooks'] =  $dir.'SpecialUnusedVideosHooks.class.php' ;

// Hook
$wgHooks['wgQueryPages'][] = 'SpecialUnusedVideosHooks::registerUnusedVideos';

// i18n mapping
$wgExtensionMessagesFiles['SpecialUnusedVideos'] = $dir.'SpecialUnusedVideos.i18n.php' ;
$wgExtensionMessagesFiles['SpecialUnusedVideosAliases'] = $dir.'SpecialUnusedVideos.alias.php' ;

// special pages
$wgSpecialPages[ 'UnusedVideos' ] =  'SpecialUnusedVideos';

$wgSpecialPageGroups['UnusedVideos'] = 'maintenance';
