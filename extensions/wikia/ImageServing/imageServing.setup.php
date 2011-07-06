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
$wgAutoloadClasses['ImageServing']  = $dir . 'imageServing.class.php';
$wgAutoloadClasses['ImageServingHelper']  = $dir . 'imageServingHelper.class.php';
$wgHooks['LinksUpdateComplete'][] = 'ImageServingHelper::buildIndexOnPageEdit';
/* parser hook */

$wgHooks['ImageBeforeProduceHTML'][] = 'ImageServingHelper::replaceImages';

if (isset($wgHooks['BeforeParserrenderImageGallery'])) {
	$wgHooks['BeforeParserrenderImageGallery'] = array_merge(array( 'ImageServingHelper::replaceGallery' ), $wgHooks['BeforeParserrenderImageGallery'] );
} else {
	$wgHooks['BeforeParserrenderImageGallery'] = array( 'ImageServingHelper::replaceGallery' );
}

// i18n
$wgExtensionMessagesFiles['ImageServing'] = $dir . 'ImageServing.i18n.php';

/* Adds imageCrop api to lists */
if ( !empty( $wgEnablePartnerFeedExt ) ) {
	global $wgAPIModules;
	$wgAutoloadClasses[ "WikiaApiCroppedImage"         ] = "{$IP}/extensions/wikia/WikiaApi/WikiaApiCroppedImage.php";
	$wgAPIModules[ "imagecrop" ] = "WikiaApiCroppedImage";
}

// Load the MediaWiki API endpoint for ImageServing
$wgAutoloadClasses[ "WikiaApiImageServing"         ] = "{$IP}/extensions/wikia/WikiaApi/WikiaApiImageServing.php";
$wgAPIModules['imageserving'] = 'WikiaApiImageServing';
