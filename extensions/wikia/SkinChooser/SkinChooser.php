<?php
/*
 * Allow user to choose prefered skin / theme in user preferences
 *
 * Author: Inez Korczynski
 */

// basic permissions
#$wgGroupPermissions['sysop']['setadminskin'] = true; #rt74835
$wgGroupPermissions['staff']['setadminskin'] = true;

$dir = dirname(__FILE__) . '/';

// register class
$wgAutoloadClasses['SkinChooser'] = $dir . 'SkinChooser.class.php';

// i18n
$wgExtensionMessagesFiles['SkinChooser'] = $dir . 'SkinChooser.i18n.php';

// register hooks
$wgHooks['ModifyPreferencesValue'][] = 'SkinChooser::setThemeForPreferences';
$wgHooks['SavePreferencesHook'][] = 'SkinChooser::savePreferences';
$wgHooks['SavePreferences'][] = 'SkinChooser::savePreferencesAfter';
$wgHooks['UserToggles'][] = 'SkinChooser::skinChooserExtraToggle';
$wgHooks['AlternateSkinPreferences'][] = 'SkinChooser::renderSkinPreferencesForm';
$wgHooks['AlternateGetSkin'][] = 'SkinChooser::getSkin';
