<?php
if ( ! defined( 'MEDIAWIKI' ) )
	die( 1 );

$wgExtensionCredits['specialpage'][] = array(
	'name' => 'image Serving',
	'author' => 'Tomasz Odrobny',
	'descriptionmsg' => 'imageserving-desc',
	'version' => '1.0.0',
);

$dir = dirname(__FILE__) . '/';
/*Auto loader setup */
$wgAutoloadClasses['imageServing']  = $dir . 'imageServing.class.php';
$wgAutoloadClasses['imageServingHelper']  = $dir . 'imageServingHelper.class.php';
$wgAutoloadClasses['topImage']  = $dir . 'topImage.class.php';
$wgHooks['LinksUpdateComplete'][] = 'imageServingHelper::buildIndexOnPageEdit';
/* parser hook */

$wgHooks['ImageBeforeProduceHTML'][] = 'imageServingHelper::replaceImages';

if (isset($wgHooks['BeforeParserrenderImageGallery'])) {
	$wgHooks['BeforeParserrenderImageGallery'] = array_merge(array( 'imageServingHelper::replaceGallery' ), $wgHooks['BeforeParserrenderImageGallery'] );	
} else {
	$wgHooks['BeforeParserrenderImageGallery'] = array( 'imageServingHelper::replaceGallery' );
}
