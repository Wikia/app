<?php
/*
 * Allow user to choose prefered skin / theme in user preferences
 *
 * Author: Inez Korczynski
 */

$wgExtensionCredits['other'][] = array(
	'name'           => 'SkinChooser',
	'author'         => 'Inez Korczynski',
	'descriptionmsg' => 'skinchooser-desc',
);

// basic permissions
#$wgGroupPermissions['sysop']['setadminskin'] = true; #rt74835
$wgGroupPermissions['staff']['setadminskin'] = true;

$dir = dirname(__FILE__) . '/';

// register class
$wgAutoloadClasses['SkinChooser'] = $dir . 'SkinChooser.class.php';

// i18n
$wgExtensionMessagesFiles['SkinChooser'] = $dir . 'SkinChooser.i18n.php';

// register hooks
$wgHooks['GetPreferences'][] = 'SkinChooser::onGetPreferences';
$wgHooks['RequestContextCreateSkin'][] = 'SkinChooser::onGetSkin';
