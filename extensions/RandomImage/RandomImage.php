<?php

/**
 * Parser hook extension to add a <randomimage> tag
 *
 * @file
 * @ingroup Extensions
 * @author Rob Church <robchur@gmail.com>
 * @copyright © 2006 Rob Church
 * @licence GNU General Public Licence 2.0
 */
 
if( !defined( 'MEDIAWIKI' ) ) {
	echo( "This file is an extension to the MediaWiki software and cannot be used standalone.\n" );
	exit( 1 );
}

$wgAutoloadClasses['RandomImage'] = dirname( __FILE__ ) . '/RandomImage.class.php';
$wgExtensionCredits['parserhook'][] = array(
	'path'           => __FILE__,
	'name'           => 'RandomImage',
	'author'         => 'Rob Church',
	'url'            => 'https://www.mediawiki.org/wiki/Extension:RandomImage',
	'descriptionmsg' => 'randomimage-desc',
);
$wgExtensionMessagesFiles['RandomImage'] = dirname(__FILE__) . '/RandomImage.i18n.php';
$wgHooks['ParserAfterStrip'][] = 'RandomImage::stripHook';
$wgHooks['ParserFirstCallInit'][] = 'efRandomImage';

/**
 * Set this to true to disable the parser cache for pages which
 * contain a <randomimage> tag; this keeps the galleries up to date
 * at the cost of a performance overhead on page views
 */
$wgRandomImageNoCache = false;

/**
 * Set this to true to ensure that images selected from the database
 * have an "IMAGE" MIME type
 */
$wgRandomImageStrict = !$wgMiserMode;

/**
 * Hook setup
 */
function efRandomImage(&$parser) {
	$parser->setHook( 'randomimage', 'RandomImage::renderHook' );
	return true;
}

