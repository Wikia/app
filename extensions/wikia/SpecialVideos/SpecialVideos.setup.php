<?php
/**
 * SpecialVideos
 * @author Liz Lee, Saipetch Kongkatong
 */

$wgExtensionCredits['specialpage'][] = [
	'name' => 'SpecialVideos',
	'author' => [ 'Liz Lee', 'Saipetch Kongkatong' ],
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/SpecialVideos',
	'descriptionmsg' => 'specialvideos-desc'
];


// classes
$wgAutoloadClasses['SpecialVideosSpecialController'] =  __DIR__ . '/SpecialVideosSpecialController.class.php';
$wgAutoloadClasses['SpecialVideosHelper'] =  __DIR__ . '/SpecialVideosHelper.class.php';
$wgAutoloadClasses['SpecialVideosHooks'] = __DIR__ . '/SpecialVideosHooks.class.php';

// i18n mapping
$wgExtensionMessagesFiles['SpecialVideos'] = __DIR__ . '/SpecialVideos.i18n.php';
$wgExtensionMessagesFiles['SpecialVideosAliases'] = __DIR__ . '/SpecialVideos.alias.php';

// special pages
$wgSpecialPages['Videos'] =  'SpecialVideosSpecialController';

// hooks
$wgHooks['PageHeaderIndexExtraButtons'][] = 'SpecialVideosHooks::onPageHeaderIndexExtraButtons';

JSMessages::registerPackage( 'SpecialVideos', array(
	'specialvideos-remove-modal-title',
	'specialvideos-remove-modal-message'
));

