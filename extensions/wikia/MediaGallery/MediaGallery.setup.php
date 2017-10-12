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
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/MediaGallery',
	'descriptionmsg' => 'mediagallery-desc'
);

$dir = dirname(__FILE__) . '/';

//classes
$wgAutoloadClasses['MediaGalleryController'] =  $dir . 'MediaGalleryController.class.php';
$wgAutoloadClasses['MediaGalleryHelper'] =  $dir . 'MediaGalleryHelper.class.php';
$wgAutoloadClasses['MediaGalleryModel'] =  $dir . 'MediaGalleryModel.class.php';

// hooks
$wgAutoloadClasses['MediaGalleryHooks'] =  $dir . 'MediaGalleryHooks.class.php';
$wgHooks['OutputPageBeforeHTML'][] = 'MediaGalleryHooks::onOutputPageBeforeHTML';
$wgHooks['OasisSkinAssetGroups'][] = 'MediaGalleryHooks::onOasisSkinAssetGroups';
$wgHooks['MakeGlobalVariablesScript'][] = 'MediaGalleryHooks::onMakeGlobalVariablesScript';
$wgHooks['WikiFeatures::afterToggleFeature'][] = 'MediaGalleryHooks::afterToggleFeature';

// i18n mapping
$wgExtensionMessagesFiles['MediaGallery'] = $dir . 'MediaGallery.i18n.php';

JSMessages::registerPackage('MediaGallery', array(
	'mediagallery-show-more',
	'mediagallery-show-less',
));
