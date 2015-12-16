<?php
/**
 * Wikia Special:Image Review Mercury
 *
 * @author Rafal Wilinski <rwilinski(at)wikia-inc.com>
 */


$dir = dirname(__FILE__) . '/';

/**
 * classes
 */
$wgAutoloadClasses['ImageReviewMercury'] =  $dir . 'ImageReviewMercury.class.php';
$wgAutoloadClasses['ImageReviewMercuryController'] =  $dir . 'ImageReviewMercuryController.class.php';

/**
 * special pages
 */
$wgSpecialPages['ImageReviewMercury'] = 'ImageReviewMercuryController';

/**
 * message files
 */
$wgExtensionMessagesFiles['ImageReviewMercury'] = $dir . 'ImageReviewMercury.i18n.php' ;

$wgExtensionCredits['other'][] = array(
	'name'				=> 'Wikia Special:ImageReviewMercury',
	'version'			=> '0.1',
	'author'			=> 'Rafal Wilinski',
	'descriptionmsg'	=> 'image-review embedded from mercury',
	'url'               => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/ImageReviewMercury'
);
