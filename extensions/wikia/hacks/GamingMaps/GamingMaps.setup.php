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
    'author' => array('Dariusz Musielak'),
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

/**
 * controllers
 */
$app->registerClass('GamingMapsController', $dir . '/GamingMapsController.class.php');


/**
 * hooks
 */
$app->registerHook('ParserFirstCallInit', 'GamingMapsHooks', 'onParserFirstCallInit');


/**
 * API module
 */
$wgAPIModules['places'] = 'WikiaApiPlaces';

/**
 * messages
 */
$app->registerExtensionMessageFile('GamingMaps', $dir . '/GamingMaps.i18n.php');
