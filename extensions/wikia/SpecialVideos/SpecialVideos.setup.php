<?php
/**
 * SpecialVideos
 *
 * @author Liz Lee, Saipetch Kongkatong
 */

$wgExtensionCredits['specialpage'][] = [
	'name' => 'SpecialVideos',
	'author' => [ 'Liz Lee', 'Saipetch Kongkatong' ],
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/SpecialVideos',
	'descriptionmsg' => 'specialvideos-desc'
];

$dir = dirname( __FILE__ ) . '/';

//classes
$wgAutoloadClasses['SpecialVideosSpecialController'] = $dir . 'SpecialVideosSpecialController.class.php';
$wgAutoloadClasses['SpecialVideosHelper'] = $dir . 'SpecialVideosHelper.class.php';
$wgAutoloadClasses['SpecialVideosHooks'] = $dir . 'SpecialVideosHooks.class.php';

// i18n mapping

// special pages
$wgSpecialPages['Videos'] = 'SpecialVideosSpecialController';

$wgHooks['AfterPageHeaderButtons'][] = 'SpecialVideosHooks::onAfterPageHeaderButtons';

JSMessages::registerPackage(
	'SpecialVideos',
	[
		'specialvideos-remove-modal-title',
		'specialvideos-remove-modal-message'
	]
);
