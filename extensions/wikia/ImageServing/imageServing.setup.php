<?php
if ( ! defined( 'MEDIAWIKI' ) )
	die( 1 );

$wgExtensionCredits['specialpage'][] = array(
	'name' => 'Image Serving',
	'author' => 'Tomasz Odrobny',
	'descriptionmsg' => 'imageserving-desc',
	'version' => '1.0.1',
);


$app = F::app();
$dir = dirname(__FILE__) . '/';

/*Auto loader setup */
$app->registerClass('ImageServing', $dir . 'imageServing.class.php');
$app->registerClass('ImageServingHelper', $dir . 'imageServingHelper.class.php');

$app->registerClass('ImageServingDriverBase', $dir . 'drivers/ImageServingDriverBase.class.php');
$app->registerClass('ImageServingDriverMainNS', $dir . 'drivers/ImageServingDriverMainNS.class.php');
$app->registerClass('ImageServingDriverCategoryNS', $dir . 'drivers/ImageServingDriverCategoryNS.class.php');


$app->registerClass('ImageServingDriverUserNS', $dir . 'drivers/ImageServingDriverUserNS.class.php');
$app->registerClass('ImageServingDriverFileNS', $dir . 'drivers/ImageServingDriverFileNS.class.php');

$app->registerClass('ImageServingController', $dir . 'ImageServingController.class.php');


$wgImageServingDrivers = array(
	 NS_USER => 'ImageServingDriverUserNS',
	 NS_FILE => 'ImageServingDriverFileNS',
	 NS_CATEGORY => 'ImageServingDriverCategoryNS'
);


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
$wgAutoloadClasses[ "WikiaApiCroppedImage"         ] = "{$IP}/extensions/wikia/WikiaApi/WikiaApiCroppedImage.php";
$wgAPIModules[ "imagecrop" ] = "WikiaApiCroppedImage";

// Load the MediaWiki API endpoint for ImageServing
$wgAutoloadClasses[ "WikiaApiImageServing"         ] = "{$IP}/extensions/wikia/WikiaApi/WikiaApiImageServing.php";
$wgAPIModules['imageserving'] = 'WikiaApiImageServing';
