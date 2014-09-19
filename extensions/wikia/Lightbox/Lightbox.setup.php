<?php
/**
 * Lightbox setup
 *
 * @author Hyun Lim, Liz Lee, Saipetch Kongkatong
 *
 */

$wgExtensionCredits['lightbox'][] = array(
	'name' => 'Lightbox',
	'author' => array(
		'Hyun Lim',
		'Liz Lee',
		'Saipetch Kongkatong',
		'Garth Webb',
		'James Sutterfield',
	),
);

$dir = dirname(__FILE__) . '/';

//classes
$wgAutoloadClasses['LightboxController'] =  $dir . 'LightboxController.class.php';
$wgAutoloadClasses['LightboxHelper'] =  $dir . 'LightboxHelper.class.php';
$wgAutoloadClasses['LightboxHooks'] =  $dir . 'LightboxHooks.class.php';

// hooks
$wgHooks['MakeGlobalVariablesScript'][] = 'LightboxHooks::onMakeGlobalVariablesScript';

// i18n mapping
$wgExtensionMessagesFiles['Lightbox'] = $dir . 'Lightbox.i18n.php';

JSMessages::registerPackage('Lightbox', array(
	'lightbox-carousel-more-items',
));
