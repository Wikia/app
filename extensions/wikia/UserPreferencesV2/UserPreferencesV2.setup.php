<?
/* User preferences V2 extension setup file
*
* @author Marcin Maciejewski <marcin(at)wikia.com>
*
*/

$app = F::app();
$dir = dirname(__FILE__) . '/';

/**
* classes
*/
$app->registerClass('UserPreferencesV2', $dir . 'UserPreferencesV2.class.php');

/**
* hooks
*/
$app->registerHook('GetPreferences', 'UserPreferencesV2', 'onGetPreferences');
