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

// i18n mapping
$wgExtensionMessagesFiles['MediaGallery'] = $dir . 'MediaGallery.i18n.php';

JSMessages::registerPackage('MediaGallery', array(
	'mediagallery-show-more',
	'mediagallery-show-less',
));
