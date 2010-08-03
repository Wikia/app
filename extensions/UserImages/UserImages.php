<?php

/**
 * Parser hook which generates a gallery of the last X images
 * uploaded by a particular user
 *
 * @addtogroup Extensions
 * @author Rob Church <robchur@gmail.com>
 */

# Not a valid entry point, skip unless MEDIAWIKI is defined
if (!defined('MEDIAWIKI')) {
	echo "UserImages extension";
	exit(1);
}

$wgExtensionCredits['parserhook'][] = array(
	'name' => 'User Image Gallery',
	'svn-date' => '$LastChangedDate: 2008-12-18 06:56:43 +0100 (czw, 18 gru 2008) $',
	'svn-revision' => '$LastChangedRevision: 44752 $',
	'version' => '1.1',
	'author' => 'Rob Church',
	'description' => 'Generate galleries of user-uploaded images with <code><nowiki><userimage /></nowiki></code>',
	'descriptionmsg' => 'userimages-desc',
	'url' => 'http://www.mediawiki.org/wiki/Extension:User_Image_Gallery',
);

$dir = dirname(__FILE__) . '/';
$wgExtensionMessagesFiles['UserImages'] = $dir . 'UserImages.i18n.php';
$wgAutoloadClasses['UserImagesGallery'] = $dir . 'UserImages.class.php';
$wgExtensionFunctions[] = 'efUserImages';

/**
 * Set this to true to disable the parser cache for pages which
 * contain a <userimages> tag; this keeps the galleries up to date
 * at the cost of a performance overhead on page views
 */
$wgUserImagesNoCache = false;

/**
 * Extension initialisation function
 */
function efUserImages() {
	global $wgParser;
	$wgParser->setHook( 'userimages', 'efUserImagesRender' );
}

/**
 * Extension rendering function
 *
 * @param $text Text inside <userimages> tags
 * @param $args Tag arguments
 * @param $parser Parent parser
 * @return string
 */
function efUserImagesRender( $text, $args, &$parser ) {
	global $wgUserImagesNoCache;
	if( $wgUserImagesNoCache )
		$parser->disableCache();
	$uig = new UserImagesGallery( $args, $parser );
	return $uig->render();
}
