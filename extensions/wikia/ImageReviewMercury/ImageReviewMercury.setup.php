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
	'path'				=> __FILE__,
	'name'				=> 'Wikia Special:ImageReviewMercury',
	'version'			=> '0.1',
	'author'			=> 'Rafal Wilinski',
	'description'		=> 'Internal tool to help review images post-upload and remove Terms of Use violations',
	'descriptionmsg'	=> 'imagereviewmercury-desc',
	'url'				=> 'https://github.com/Wikia/app/tree/dev/extensions/wikia/ImageReviewMercury'
);
