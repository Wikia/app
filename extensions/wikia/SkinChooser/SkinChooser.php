<?php
/*
 * Allow user to choose prefered skin / theme in user preferences
 *
 * Author: Inez Korczynski
 */

// basic permissions
$wgGroupPermissions['sysop']['setadminskin'] = true;
$wgGroupPermissions['staff']['setadminskin'] = true;

// register class
$wgAutoloadClasses['SkinChooser'] = dirname(__FILE__).'/SkinChooser.class.php';

// register hooks
$wgHooks['ModifyPreferencesValue'][] = 'SkinChooser::setThemeForPreferences';
$wgHooks['SavePreferencesHook'][] = 'SkinChooser::savePreferences';
$wgHooks['SavePreferences'][] = 'SkinChooser::savePreferencesAfter';
$wgHooks['UserToggles'][] = 'SkinChooser::skinChooserExtraToggle';
$wgHooks['AlternateSkinPreferences'][] = 'SkinChooser::renderSkinPreferencesForm';
$wgHooks['AlternateGetSkin'][] = 'SkinChooser::getSkin';
