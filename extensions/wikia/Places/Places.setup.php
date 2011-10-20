<?php

/**
 * Places
 *
 * Provides <place> and <places> parser hooks and Special:Places
 */

$wgExtensionCredits['specialpage'][] = array(
	'name' => 'Places',
	'version' => '1.0',
	'author' => array(
		'Maciej Brencz',
		'Jakub Kurcek' ),
	'description-msg' => 'places-desc'
);

/**
 * @var WikiaApp
 */
$app = F::app();
$dir = dirname( __FILE__ );

/**
 * classes
 */

$app->registerClass('PlacesHookHandler', $dir . '/Places.hooks.php');
$app->registerClass('PlacesParserHookHandler', $dir . '/PlacesParserHookHandler.class.php');

/**
 * controllers
 */

$app->registerClass('PlacesController', $dir . '/PlacesController.class.php');

/**
 * models
 */

$app->registerClass('PlacesModel', $dir . '/Models/PlacesModel.class.php');
$app->registerClass('PlaceModel', $dir . '/Models/PlaceModel.class.php');

/**
 * hooks
 */

$app->registerHook('ParserFirstCallInit', 'PlacesParserHookHandler', 'PlacesSetup');

// for later
// $app->registerHook('OutputPageMakeCategoryLinks', 'PlacesHookHandler', 'onOutputPageMakeCategoryLinks');

/**
 * messages
 */
$app->registerExtensionMessageFile( 'Places', $dir . '/Places.i18n.php' );
F::addClassConstructor( 'PlacesController', array( 'app' => $app ) );
