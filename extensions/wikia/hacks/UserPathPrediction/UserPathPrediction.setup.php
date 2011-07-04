<?php
/**
 * User Path Prediction extension
 *
 * @author Federico "Lox" Lucignano <federico(at)wikia-inc.com>
 * @author Jakub Olek <bukaj.kelo(at)gmail.com>
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	echo "This file is part of MediaWiki, it is not a valid entry point.\n";
	exit( 1 );
}

$app = F::app();
$dir = dirname( __FILE__ );

/**
 * info
 */
$app->wg->append(
	'wgExtensionCredits',
	array(
		"name" => "User Path Prediction",
		"description" => "User Path Prediction",
		"descriptionmsg" => "userpathprediction-desc",
		"url" => "http://help.wikia.com/wiki/Help:UserPathPrediction",
		"author" => array(
			'Federico "Lox" Lucignano <federico(at)wikia-inc.com>',
			'Jakub Olek <bukaj.kelo(at)gmail.com>'
		)
	),
	'other'
);

/**
 * classes
 */

/**
 * services
 */
$app->wg->set( 'wgAutoloadClasses', "{$dir}/UserPathPredictionSerivce.class.php", 'UserPathPredictionService' );

/**
 * controllers
 */
$app->wg->set( 'wgAutoloadClasses', "{$dir}/UserPathPredictionController.class.php", 'UserPathPredictionController' );
//$app->wg->set( 'wgAutoloadClasses', "{$dir}/UserPathPredictionSpecialController.class.php", 'UserPathPredictionSpecialController' );

/**
 * special pages
 */
/*
$app->wg->set( 'wgSpecialPages', 'UserPathPredictionSpecialController', 'UserPathPrediction' );
*/

/**
 * message files
 */
$app->wg->set( 'wgExtensionMessagesFiles', "{$dir}/UserPathPrediction.i18n.php", 'UserPathPrediction' );

/**
 * setup functions
 */
$app->wg->append( 'wgExtensionFunctions', 'wfUserPathPredictionInit');

function wfUserPathPredictionInit() {
	//TODO: place extension init stuff here
	
	return true; // needed so that other extension initializations continue
}
