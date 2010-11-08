<?php
if ( ! defined( 'MEDIAWIKI' ) )
	die( 1 );

$wgExtensionCredits['specialpage'][] = array(
	'name' => 'Image Serving',
	'author' => 'Tomasz Odrobny',
	'descriptionmsg' => 'imageserving-desc',
	'version' => '1.0.1',
);

$dir = dirname(__FILE__) . '/';
/*Auto loader setup */
$wgAutoloadClasses['imageServing']  = $dir . 'imageServing.class.php';
$wgAutoloadClasses['imageServingHelper']  = $dir . 'imageServingHelper.class.php';
$wgHooks['LinksUpdateComplete'][] = 'imageServingHelper::buildIndexOnPageEdit';
/* parser hook */

$wgHooks['ImageBeforeProduceHTML'][] = 'imageServingHelper::replaceImages';

if (isset($wgHooks['BeforeParserrenderImageGallery'])) {
	$wgHooks['BeforeParserrenderImageGallery'] = array_merge(array( 'imageServingHelper::replaceGallery' ), $wgHooks['BeforeParserrenderImageGallery'] );
} else {
	$wgHooks['BeforeParserrenderImageGallery'] = array( 'imageServingHelper::replaceGallery' );
}

// i18n
$wgExtensionMessagesFiles['ImageServing'] = $dir . 'ImageServing.i18n.php';

/* Adds imageCrop api to lists */
if ( !empty( $wgEnablePartnerFeedExt ) ) {
	global $wgAPIModules;
	$wgAutoloadClasses[ "WikiaApiCroppedImage"         ] = "{$IP}/extensions/wikia/WikiaApi/WikiaApiCroppedImage.php";
	$wgAPIModules[ "imagecrop" ] = "WikiaApiCroppedImage";
}
