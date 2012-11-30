<?
/* User preferences V2 extension setup file
*
* @author Marcin Maciejewski <marcin(at)wikia.com>
*
*/

$app = F::app();
$dir = dirname(__FILE__) . '/';

/**
 * new default user preferences
 */
$wgDefaultUserOptions['watchdeletion'] = 1;

/**
 * classes
 */
$app->registerClass('UserPreferencesV2', $dir . 'UserPreferencesV2.class.php');

/**
 * hooks
 */
$app->registerHook('GetPreferences', 'UserPreferencesV2', 'onGetPreferences');
$app->registerHook('SpecialPreferencesBeforeResetUserOptions', 'UserPreferencesV2', 'onSpecialPreferencesBeforeResetUserOptions');
$app->registerHook('SpecialPreferencesAfterResetUserOptions', 'UserPreferencesV2', 'onSpecialPreferencesAfterResetUserOptions');
$app->registerHook('PreferencesTrySetUserEmail', 'UserPreferencesV2', 'onPreferencesTrySetUserEmail');
$app->registerHook('SavePreferences', 'UserPreferencesV2', 'onSavePreferences');
$app->registerHook('UserGetDefaultOptions', 'UserPreferencesV2', 'onUserGetDefaultOptions');

/**
 * messages
 */
$app->registerExtensionMessageFile('UserPreferencesV2', $dir . '/UserPreferencesV2.i18n.php');