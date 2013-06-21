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
$wgAutoloadClasses['UserPreferencesStats'] =  $dir . 'UserPreferencesStats.class.php';

/**
 * controllers
 */
$wgAutoloadClasses['UserPreferencesStatsController'] =  $dir . 'UserPreferencesStatsController.class.php';
$wgAutoloadClasses['UserPreferencesStatsSpecialController'] =  $dir . 'UserPreferencesStatsSpecialController.class.php';

/**
 * special pages
 */
$wgSpecialPages['UserPreferencesStats'] = 'UserPreferencesStatsSpecialController';

/**
 * message files
 */
$app->registerExtensionMessageFile('UserPreferencesStats', $dir . 'UserPreferencesStats.i18n.php');