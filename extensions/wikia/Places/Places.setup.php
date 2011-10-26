<?php

/**
 * Places
 *
 * Provides <place> and <places> parser hooks and Special:Places
 *
 * @author Jakub Kurcek <jakub at wikia-inc.com>
 * @author Maciej Brencz <macbre at wikia-inc.com>
 * @date 2010-10-11
 * @copyright Copyright (C) 2010 Jakub Kurcek, Wikia Inc.
 * @copyright Copyright (C) 2010 Maciej Brencz, Wikia Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

$wgExtensionCredits['specialpage'][] = array(
	'name' => 'Places',
	'version' => '1.0',
	'author' => array(
		'Maciej Brencz',
		'Jakub Kurcek' ),
	'descriptionmsg' => 'places-desc'
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
$app->registerClass('PlacesSpecialController', $dir . '/PlacesSpecialController.class.php');
$app->registerSpecialPage('Places', 'PlacesSpecialController');

/**
 * models
 */

$app->registerClass('PlacesModel', $dir . '/models/PlacesModel.class.php');
$app->registerClass('PlaceModel', $dir . '/models/PlaceModel.class.php');
$app->registerClass('PlaceStorage', $dir . '/models/PlaceStorage.class.php');

/**
 * hooks
 */

$app->registerHook('ParserFirstCallInit', 'PlacesHookHandler', 'onParserFirstCallInit');
$app->registerHook('BeforePageDisplay', 'PlacesHookHandler', 'onBeforePageDisplay');
$app->registerHook('ArticleSaveComplete', 'PlacesHookHandler', 'onArticleSaveComplete');
$app->registerHook('RTEUseDefaultPlaceholder', 'PlacesHookHandler', 'onRTEUseDefaultPlaceholder');

// for later
// $app->registerHook('OutputPageMakeCategoryLinks', 'PlacesHookHandler', 'onOutputPageMakeCategoryLinks');

/**
 * messages
 */
$app->registerExtensionMessageFile( 'Places', $dir . '/Places.i18n.php' );

/**
 * constructors
 */
F::addClassConstructor( 'PlacesController', array( 'app' => $app ) );
F::addClassConstructor( 'PlaceStorage', array(), 'newFromId' );