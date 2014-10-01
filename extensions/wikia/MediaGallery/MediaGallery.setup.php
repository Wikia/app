<?php
/**
 * MediaGallery setup
 *
 * @author Liz Lee, Garth Webb, James Sutterfield, Armon Rabiyan
 *
 */

$wgExtensionCredits['other'][] = array(
	'name' => 'MediaGallery',
	'author' => array(
		'Liz Lee',
		'Garth Webb',
		'James Sutterfield',
		'Armon Rabiyan',
	),
);

$dir = dirname(__FILE__) . '/';

//classes
$wgAutoloadClasses['MediaGalleryController'] =  $dir . 'MediaGalleryController.class.php';
$wgAutoloadClasses['MediaGalleryHelper'] =  $dir . 'MediaGalleryHelper.class.php';
$wgAutoloadClasses['MediaGalleryModel'] =  $dir . 'MediaGalleryModel.class.php';

// hooks
$wgAutoloadClasses['MediaGalleryHooks'] =  $dir . 'MediaGalleryHooks.class.php';
$wgHooks['OutputPageBeforeHTML'][] = 'MediaGalleryHooks::onOutputPageBeforeHTML';
$wgHooks['MakeGlobalVariablesScript'][] = 'MediaGalleryHooks::onMakeGlobalVariablesScript';

// i18n mapping
$wgExtensionMessagesFiles['MediaGallery'] = $dir . 'MediaGallery.i18n.php';

JSMessages::registerPackage('MediaGallery', array(
	'mediagallery-show-more',
	'mediagallery-show-less',
));
