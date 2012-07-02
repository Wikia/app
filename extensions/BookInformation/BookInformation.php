<?php
/**
 * Extension allows Special:Booksource to obtain basic details
 * about a book from available web services
 *
 * @file
 * @ingroup Extensions
 * @author Rob Church <robchur@gmail.com>
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	echo( "This file is an extension to the MediaWiki software and cannot be used standalone.\n" );
	die( 1 );
}

$wgExtensionCredits['other'][] = array(
	'path' => __FILE__,
	'name' => 'Book Information',
	'author' => 'Rob Church',
	'descriptionmsg' => 'bookinformation-desc',
	'url' => 'https://www.mediawiki.org/wiki/Extension:BookInformation',
);

$wgExtensionMessagesFiles['BookInformation'] = dirname( __FILE__ ) . '/BookInformation.i18n.php';

$wgAutoloadClasses['BookInformation'] = dirname( __FILE__ ) . '/drivers/Worker.php';
$wgAutoloadClasses['BookInformationCache'] = dirname( __FILE__ ) . '/drivers/Cache.php';
$wgAutoloadClasses['BookInformationDriver'] = dirname( __FILE__ ) . '/drivers/Driver.php';
$wgAutoloadClasses['BookInformationResult'] = dirname( __FILE__ ) . '/drivers/Result.php';

$wgAutoloadClasses['BookInformationAmazon'] = dirname( __FILE__ ) . '/drivers/Amazon.php';
$wgAutoloadClasses['BookInformationIsbnDb'] = dirname( __FILE__ ) . '/drivers/IsbnDb.php';

$wgHooks['BookInformation'][] = 'efBookInformation';
$wgHooks['BeforePageDisplay'][] = 'efBookInformationAddCss';

/**
 * Enables caching of results when the "bookinfo" table is available
 */
$wgBookInformationCache = false;

/**
 * The book information driver in use
 * (Please see docs/drivers.htm for more information)
 */
$wgBookInformationDriver = 'Amazon';

/**
 * Service identification/authentication information
 * (Consult driver documentation for specifics)
 */
$wgBookInformationService = array();

/**
 * Hook handling function
 *
 * @param string $isbn ISBN to be queried
 * @param OutputPage $output OutputPage to use
 */
function efBookInformation( $isbn, $output ) {
	BookInformation::show( $isbn, $output );
	return true;
}

/**
 * Add extra CSS to the skin
 *
 * @param string $css Additional CSS
 * @return mixed
 */
function efBookInformationAddCss( $out, &$sk ) {
	global $wgScriptPath;

	if ( $out->getTitle()->isSpecial( 'Booksources' ) ) {
		$out->addExtensionStyle( "$wgScriptPath/extensions/BookInformation/BookInformation.css" );
	}
	return true;
}
