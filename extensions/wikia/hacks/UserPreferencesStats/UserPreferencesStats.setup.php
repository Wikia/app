<?php
/**
 * Extension setup file
 *
 * @author Marooned
 *
 */

$app = F::app();
$dir = dirname(__FILE__) . '/';

/**
 * classes
 */
$app->registerClass('UserPreferencesStats', $dir . 'UserPreferencesStats.class.php');

/**
 * controllers
 */
$app->registerClass('UserPreferencesStatsController', $dir . 'UserPreferencesStatsController.class.php');
$app->registerClass('UserPreferencesStatsSpecialController', $dir . 'UserPreferencesStatsSpecialController.class.php');

/**
 * special pages
 */
$app->registerSpecialPage('UserPreferencesStats', 'UserPreferencesStatsSpecialController');

/**
 * message files
 */
$app->registerExtensionMessageFile('UserPreferencesStats', $dir . 'UserPreferencesStats.i18n.php');