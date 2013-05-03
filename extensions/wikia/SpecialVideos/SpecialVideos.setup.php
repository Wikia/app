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
$wgAutoloadClasses[ 'SpecialVideosSpecialController'] =  $dir.'SpecialVideosSpecialController.class.php' ;
$wgAutoloadClasses[ 'SpecialVideosHelper'] =  $dir.'SpecialVideosHelper.class.php' ;

// i18n mapping
$app->registerExtensionMessageFile( 'SpecialVideos', $dir.'SpecialVideos.i18n.php' );
$app->registerExtensionMessageFile( 'SpecialVideosAliases', $dir.'SpecialVideos.alias.php' );

// special pages
$wgSpecialPages[ 'Videos' ] =  'SpecialVideosSpecialController';

JSMessages::registerPackage('SpecialVideos', array(
	'specialvideos-remove-modal-title',
	'specialvideos-remove-modal-message',
));

$wgGroupPermissions['*']['specialvideosdelete'] = false;
$wgGroupPermissions['staff']['specialvideosdelete'] = true;
$wgGroupPermissions['sysop']['specialvideosdelete'] = true;
$wgGroupPermissions['helper']['specialvideosdelete'] = true;
$wgGroupPermissions['vstf']['specialvideosdelete'] = true;