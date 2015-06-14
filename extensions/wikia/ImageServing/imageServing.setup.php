<?php
if ( ! defined( 'MEDIAWIKI' ) )
	die( 1 );

$wgExtensionCredits['specialpage'][] = array(
	'name' => 'Image Serving',
	'author' => 'Tomasz Odrobny',
	'descriptionmsg' => 'imageserving-desc',
	'version' => '1.0.1',
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/ImageServing'
);

$dir = __DIR__ . '/';

/*Auto loader setup */
$wgAutoloadClasses['ImageServing'] =  $dir . 'imageServing.class.php';
$wgAutoloadClasses['ImageServingHelper'] =  $dir . 'imageServingHelper.class.php';
$wgAutoloadClasses['ImageServingDriverBase'] =  $dir . 'drivers/ImageServingDriverBase.class.php';
$wgAutoloadClasses['ImageServingDriverMainNS'] =  $dir . 'drivers/ImageServingDriverMainNS.class.php';
$wgAutoloadClasses['ImageServingDriverCategoryNS'] =  $dir . 'drivers/ImageServingDriverCategoryNS.class.php';
$wgAutoloadClasses['ImageServingDriverUserNS'] =  $dir . 'drivers/ImageServingDriverUserNS.class.php';
$wgAutoloadClasses['ImageServingDriverFileNS'] =  $dir . 'drivers/ImageServingDriverFileNS.class.php';
$wgAutoloadClasses['ImageServingController'] =  $dir . 'ImageServingController.class.php';

$wgImageServingDrivers = array(
	 NS_USER => 'ImageServingDriverUserNS',
	 NS_FILE => 'ImageServingDriverFileNS',
	 NS_CATEGORY => 'ImageServingDriverCategoryNS'
);

$wgAutoloadClasses['FakeImageGalleryImageServing'] = $dir . 'FakeImageGalleryImageServing.class.php';

// hooks
$wgHooks['LinksUpdateComplete'][] = 'ImageServingHelper::onLinksUpdateComplete';
$wgHooks['ImageBeforeProduceHTML'][] = 'ImageServingHelper::onImageBeforeProduceHTML';

if (isset($wgHooks['BeforeParserrenderImageGallery'])) {
	$wgHooks['BeforeParserrenderImageGallery'] = array_merge(array( 'ImageServingHelper::onBeforeParserrenderImageGallery' ), $wgHooks['BeforeParserrenderImageGallery'] );
} else {
	$wgHooks['BeforeParserrenderImageGallery'] = array( 'ImageServingHelper::onBeforeParserrenderImageGallery' );
}

// i18n
$wgExtensionMessagesFiles['ImageServing'] = $dir . 'ImageServing.i18n.php';

/* Adds imageCrop api to lists */
$wgAutoloadClasses[ "WikiaApiCroppedImage"         ] = "{$dir}/api/WikiaApiCroppedImage.php";
$wgAPIModules[ "imagecrop" ] = "WikiaApiCroppedImage";

// Load the MediaWiki API endpoint for ImageServing
$wgAutoloadClasses[ "WikiaApiImageServing"         ] = "{$dir}/api//WikiaApiImageServing.php";
$wgAPIModules['imageserving'] = 'WikiaApiImageServing';

// query page for caching images popularity (see PLAQTFORM-817)
$wgSpecialPages[ 'MostLinkedFilesInContent' ] =  'MostimagesInContentPage';
$wgSpecialPageGroups['MostLinkedFilesInContent'] = 'maintenance';

$wgAutoloadClasses[ 'MostimagesInContentPage' ] = "{$dir}/querypage/MostimagesInContentPage.class.php";

$wgHooks['wgQueryPages'][] = function( Array &$wgQueryPages ) {
	//                  QueryPage subclass         Special page name
	$wgQueryPages[] = [ 'MostimagesInContentPage', 'MostLinkedFilesInContent' ];
	return true;
};
