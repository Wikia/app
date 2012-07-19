<?php

/**
 * gamingMaps
 *
 * Provides <GamingMaps> parser hooks
 *
 * @author Dariusz Musielak <@@ at wikia-inc.com>
 * @copyright Copyright (C) 2012 Dariusz Musielak, Wikia Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

$wgExtensionCredits['specialpage'][] = array(
    'name' => 'GamingMaps',
    'version' => '0.1',
    'author' => array(
        'Dariusz Musielak'),
    'descriptionmsg' => 'gamingMaps-desc'   //do tłumaczenia
);

/**
 * @var WikiaApp
 */
$app = F::app();
$dir = dirname( __FILE__ );

/**
 * classes
 */

$app->registerClass('GamingMapsHooks', $dir . '/GamingMapsHooks.class.php');
$app->registerClass('GamingMaps', $dir . '/GamingMaps.class.php');

/*$app->registerClass('PlacesHooks', $dir . '/PlacesHooks.class.php');
$app->registerClass('PlacesParserHookHandler', $dir . '/PlacesParserHookHandler.class.php');
$app->registerClass('WikiaApiPlaces', $dir . '/WikiaApiPlaces.class.php');*/

/**
 * controllers
 */

$app->registerClass('GamingMapsController', $dir . '/GamingMapsController.class.php');

/*$app->registerClass('PlacesController', $dir . '/PlacesController.class.php');
$app->registerClass('PlacesCategoryController', $dir . '/PlacesCategoryController.class.php');
$app->registerClass('PlacesEditorController', $dir . '/PlacesEditorController.class.php');
$app->registerClass('PlacesSpecialController', $dir . '/PlacesSpecialController.class.php');
$app->registerSpecialPage('Places', 'PlacesSpecialController');*/

/**
 * models
 */

/*$app->registerClass('PlacesModel', $dir . '/models/PlacesModel.class.php');
$app->registerClass('PlaceModel', $dir . '/models/PlaceModel.class.php');
$app->registerClass('PlaceStorage', $dir . '/models/PlaceStorage.class.php');
$app->registerClass('PlaceCategory', $dir . '/models/PlaceCategory.class.php');*/

/**
 * hooks
 */

$app->registerHook('ParserFirstCallInit', 'GamingMapsHooks', 'onParserFirstCallInit');
/*$app->registerHook('BeforePageDisplay', 'PlacesHooks', 'onBeforePageDisplay');
$app->registerHook('ArticleSaveComplete', 'PlacesHooks', 'onArticleSaveComplete');
$app->registerHook('RTEUseDefaultPlaceholder', 'PlacesHooks', 'onRTEUseDefaultPlaceholder');
$app->registerHook('OutputPageBeforeHTML', 'PlacesHooks', 'onOutputPageBeforeHTML');
$app->registerHook('PageHeaderIndexExtraButtons', 'PlacesHooks', 'onPageHeaderIndexExtraButtons');
$app->registerHook('EditPage::showEditForm:initial', 'PlacesHooks', 'onShowEditForm');*/

// for later
// $app->registerHook('OutputPageMakeCategoryLinks', 'PlacesHooks', 'onOutputPageMakeCategoryLinks');

/**
 * API module
 */
$wgAPIModules['places'] = 'WikiaApiPlaces';

/**
 * messages
 */
$app->registerExtensionMessageFile('GamingMaps', $dir . '/GamingMaps.i18n.php');

/*
F::build('JSMessages')->registerPackage('GamingMaps', array(
    'places-toolbar-button-*',
    'places-editor-*',
    'ok',
));*/

/**
 * constructors
 */
/*F::addClassConstructor( 'PlacesCategoryController', array( 'app' => $app ) );
F::addClassConstructor( 'PlacesController', array( 'app' => $app ) );
F::addClassConstructor( 'PlaceStorage', array(), 'newFromId' );*/

/*
 * user rights
 */
/*$wgAvailableRights[] = 'places-enable-category-geolocation';
$wgGroupPermissions['*']['places-enable-category-geolocation'] = false;
$wgGroupPermissions['sysop']['places-enable-category-geolocation'] = true;*/