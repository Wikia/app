<?php
/**
 * WikiaMobile
 *
 * @author Jakub Olek, Federico Lucignano, Sean Colombo
 */
if ( !defined( 'MEDIAWIKI' ) ) {
	echo "This file is part of MediaWiki, it is not a valid entry point.\n";
	exit( 1 );
}

$dir = dirname( __FILE__ );

/**
 * info
 */
$wgExtensionCredits['other'][] =
	array(
		"name" => "PhotoPop",
		"description" => "Photo guessing game",
		"author" => array(
			'Federico "Lox" Lucignano <federico(at)wikia-inc.com>',
			'Jakub Olek <bukaj.kelo(at)gmail.com>',
			'[http://www.seancolombo.com Sean Colombo]'
		),
		'descriptionmsg' => 'photopop-desc',
		'version' => '0.1',
		'api' => array (
			'controllers' => 'PhotoPopController',
			'methods' => 'index',
			'examples' => array(
				'api.php?action=wikia&controller=PhotoPop',
				'api.php?action=wikia&controller=PhotoPop&format=html',
				'api.php?action=wikia&controller=PhotoPop&format=json'
			)
		)
	);

/**
 * rights
 */
$AvailableRights[] = 'photopop_setup';
//Nirvana doesn't give access to multi-dimensional global arrays :(
$wgGroupPermissions['*']['photopop_setup'] = false;
$wgGroupPermissions['staff']['photopop_setup'] = true;

/**
 * classes
 */

/**
 * models
 */
$wgAutoloadClasses['PhotoPopModel'] = "{$dir}/PhotoPopModel.class.php";

/**
 * services
 */

/**
 * controllers
 */
$wgAutoloadClasses['PhotoPopController'] = "{$dir}/PhotoPopController.class.php";
$wgAutoloadClasses['PhotoPopSpecialPageController'] = "{$dir}/PhotoPopSpecialPageController.class.php";
$wgAutoloadClasses['PhotoPopAppCacheController'] = "{$dir}/PhotoPopAppCacheController.class.php";

/**
 * special pages
 */
if ( !empty ( $wgAllowPhotoPopGame ) ){
	$wgSpecialPages['PhotoPopSetup'] = 'PhotoPopSpecialPageController';
}

/**
 * message files
 */
$wgExtensionMessagesFiles['PhotoPop'] = "{$dir}/PhotoPop.i18n.php";

/**
 * hooks
 */

/*
 * settings
 */

JSMessages::registerPackage( 'PhotoPop', array(
	"photopop-game-round",
	"photopop-game-correct",
	"photopop-game-points",
	"photopop-game-total",
	"photopop-game-score",
	"photopop-game-wiki",
	"photopop-game-date",
	"photopop-game-timeup",
	"photopop-game-please-wait",
	"photopop-game-loading-image",
	"photopop-game-loading",
	"photopop-game-highscore",
	"photopop-game-highscores",
	"photopop-game-continue",
	"photopop-game-yougot",
	"photopop-game-outof",
	"photopop-game-progress",
	"photopop-game-image-load-error",
	"photopop-game-tutorial-intro",
	"photopop-game-tutorial-continue",
	"photopop-game-tutorial-drawer",
	"photopop-game-tutorial-tile",
	"photopop-game-new-highscore",
	"photopop-game-loading-image",
	"photopop-game-paused",
	"photopop-game-month-0",
	"photopop-game-month-1",
	"photopop-game-month-2",
	"photopop-game-month-3",
	"photopop-game-month-4",
	"photopop-game-month-5",
	"photopop-game-month-6",
	"photopop-game-month-7",
	"photopop-game-month-8",
	"photopop-game-month-9",
	"photopop-game-month-10",
	"photopop-game-month-11",
	"photopop-game-no-highscore",
	"photopop-game-error-text",
	"photopop-game-finished"
) );
