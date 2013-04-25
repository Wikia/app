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
$app->registerExtensionMessageFile( 'SpecialVideosAliases', $dir.'SpecialVideos.alias.php' );

// special pages
$app->registerSpecialPage( 'Videos', 'SpecialVideosSpecialController' );

// redirects from Video to Videos
class RedirectToVideos extends SpecialRedirectToSpecial {
	function __construct() {
		parent::__construct( 'Video', 'Videos', false, array() );
	}
}

// Fake special page for 301 redirect (Video->Videos)
$app->registerSpecialPage('Video', 'RedirectToVideos');

F::build('JSMessages')->registerPackage('SpecialVideos', array(
	'specialvideos-remove-modal-title',
	'specialvideos-remove-modal-message',
));

$wgGroupPermissions['*']['specialvideosdelete'] = false;
$wgGroupPermissions['staff']['specialvideosdelete'] = true;
$wgGroupPermissions['sysop']['specialvideosdelete'] = true;
$wgGroupPermissions['helper']['specialvideosdelete'] = true;
$wgGroupPermissions['vstf']['specialvideosdelete'] = true;