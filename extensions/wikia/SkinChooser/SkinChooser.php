<?php
/*
 * Allow user to choose prefered skin / theme in user preferences
 *
 * Author: Inez Korczynski
 * Author: Inez Korczynski
 */

// basic permissions
$wgGroupPermissions['sysop']['setadminskin'] = true;
$wgGroupPermissions['staff']['setadminskin'] = true;

// register class
$wgAutoloadClasses['SkinChooser'] = dirname(__FILE__).'/SkinChooser.class.php';

// register hooks
$wgHooks['ModifyPreferencesValue'][] = 'SkinChooser::setThemeForPreferences';
$wgHooks['SavePreferencesHook'][] = 'SkinChooser::savePreferencesSkinChooser';
$wgHooks['UserToggles'][] = 'SkinChooser::skinChooserExtraToggle';
$wgHooks['AlternateSkinPreferences'][] = 'SkinChooser::wikiaSkinPreferences';
$wgHooks['AlternateGetSkin'][] = 'SkinChooser::wikiaGetSkin';
