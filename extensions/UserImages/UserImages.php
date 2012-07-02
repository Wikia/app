<?php

/**
 * Parser hook which generates a gallery of the last X images
 * uploaded by a particular user
 *
 * @file
 * @ingroup Extensions
 * @author Rob Church <robchur@gmail.com>
 */

# Not a valid entry point, skip unless MEDIAWIKI is defined
if (!defined('MEDIAWIKI')) {
	echo "UserImages extension";
	exit(1);
}

$wgExtensionCredits['parserhook'][] = array(
	'path' => __FILE__,
	'name' => 'User Image Gallery',
	'version' => '1.2',
	'author' => 'Rob Church',
	'descriptionmsg' => 'userimages-desc',
	'url' => 'https://www.mediawiki.org/wiki/Extension:User_Image_Gallery',
);

$dir = dirname(__FILE__) . '/';
$wgExtensionMessagesFiles['UserImages'] = $dir . 'UserImages.i18n.php';
$wgAutoloadClasses['UserImagesGallery'] = $dir . 'UserImages.class.php';
$wgHooks['ParserFirstCallInit'][] = 'efUserImagesSetHook';

/**
 * Set this to true to disable the parser cache for pages which
 * contain a <userimages> tag; this keeps the galleries up to date
 * at the cost of a performance overhead on page views
 */
$wgUserImagesNoCache = false;

/**
 * Extension initialisation function
 */
function efUserImagesSetHook( $parser ) {
	$parser->setHook( 'userimages', 'efUserImagesRender' );
	return true;
}

/**
 * Extension rendering function
 *
 * @param $text Text inside <userimages> tags
 * @param $args Tag arguments
 * @param $parser Parent parser
 * @param $frame PPFrame
 * @return string
 */
function efUserImagesRender( $text, $args, $parser, $frame ) {
	global $wgUserImagesNoCache;
	if( $wgUserImagesNoCache )
		$parser->disableCache();
	$uig = new UserImagesGallery( $args, $parser );
	return $uig->render();
}
