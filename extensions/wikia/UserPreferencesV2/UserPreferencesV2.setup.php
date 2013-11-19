<?php

/**
 * User preferences V2 extension setup file
 *
 * @author Marcin Maciejewski <marcin(at)wikia.com>
 *
 */

/**
 * new default user preferences
 */
$wgDefaultUserOptions['watchdeletion'] = 1;

/**
 * classes
 */
$wgAutoloadClasses['UserPreferencesV2'] =  __DIR__ . '/UserPreferencesV2.class.php';

/**
 * hooks
 */
$wgHooks['GetPreferences'][] = 'UserPreferencesV2::onGetPreferences';
$wgHooks['SpecialPreferencesBeforeResetUserOptions'][] = 'UserPreferencesV2::onSpecialPreferencesBeforeResetUserOptions';
$wgHooks['SpecialPreferencesAfterResetUserOptions'][] = 'UserPreferencesV2::onSpecialPreferencesAfterResetUserOptions';
$wgHooks['PreferencesTrySetUserEmail'][] = 'UserPreferencesV2::onPreferencesTrySetUserEmail';
$wgHooks['SavePreferences'][] = 'UserPreferencesV2::onSavePreferences';
$wgHooks['UserGetDefaultOptions'][] = 'UserPreferencesV2::onUserGetDefaultOptions';

/**
 * messages
 */
$wgExtensionMessagesFiles['UserPreferencesV2'] = __DIR__ . '/UserPreferencesV2.i18n.php';
