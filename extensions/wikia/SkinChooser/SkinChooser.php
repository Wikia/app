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
	'url'            => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/SkinChooser'
);

$dir = dirname(__FILE__) . '/';

// register class
$wgAutoloadClasses['SkinChooser'] = $dir . 'SkinChooser.class.php';

// i18n

// register hooks
$wgHooks['GetPreferences'][] = 'SkinChooser::onGetPreferences';
$wgHooks['RequestContextCreateSkin'][] = 'SkinChooser::onGetSkin';
