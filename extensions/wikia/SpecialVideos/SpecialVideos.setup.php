<?php
/**
 * SpecialVideos
 * @author Liz Lee, Saipetch Kongkatong
 */

$wgExtensionCredits['specialpage'][] = array(
	'name' => 'SpecialVideos',
	'author' => array( 'Liz Lee', 'Saipetch Kongkatong' ),
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/SpecialVideos',
	'descriptionmsg' => 'specialvideos-desc'
);

$dir = dirname(__FILE__) . '/';

//classes
$wgAutoloadClasses[ 'SpecialVideosSpecialController'] =  $dir.'SpecialVideosSpecialController.class.php' ;
$wgAutoloadClasses[ 'SpecialVideosHelper'] =  $dir.'SpecialVideosHelper.class.php' ;

// i18n mapping
$wgExtensionMessagesFiles['SpecialVideos'] = $dir.'SpecialVideos.i18n.php' ;
$wgExtensionMessagesFiles['SpecialVideosAliases'] = $dir.'SpecialVideos.alias.php' ;

// special pages
$wgSpecialPages[ 'Videos' ] =  'SpecialVideosSpecialController';

JSMessages::registerPackage('SpecialVideos', array(
	'specialvideos-remove-modal-title',
	'specialvideos-remove-modal-message'
));