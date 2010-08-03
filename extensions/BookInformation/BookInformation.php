<?php

/**
 * Extension allows Special:Booksource to obtain basic details
 * about a book from available web services
 *
 * @addtogroup Extensions
 * @author Rob Church <robchur@gmail.com>
 */

if( !defined( 'MEDIAWIKI' ) ) {
	echo( "This file is an extension to the MediaWiki software and cannot be used standalone.\n" );
	die( 1 );
}

$wgExtensionCredits['other'][] = array(
	'name' => 'Book Information',
	'svn-date' => '$LastChangedDate: 2008-11-30 04:15:22 +0100 (ndz, 30 lis 2008) $',
	'svn-revision' => '$LastChangedRevision: 44056 $',
	'author' => 'Rob Church',
	'description' => 'Expands [[Special:Booksources]] with information from a web service',
	'descriptionmsg' => 'bookinfo-desc',
	'url' => 'http://www.mediawiki.org/wiki/Extension:BookInformation',
);

$wgExtensionMessagesFiles['BookInformation'] = dirname(__FILE__) . '/BookInformation.i18n.php';

$wgAutoloadClasses['BookInformation'] = dirname( __FILE__ ) . '/drivers/Worker.php';
$wgAutoloadClasses['BookInformationCache'] = dirname( __FILE__ ) . '/drivers/Cache.php';
$wgAutoloadClasses['BookInformationDriver'] = dirname( __FILE__ ) . '/drivers/Driver.php';
$wgAutoloadClasses['BookInformationResult'] = dirname( __FILE__ ) . '/drivers/Result.php';

$wgAutoloadClasses['BookInformationAmazon'] = dirname( __FILE__ ) . '/drivers/Amazon.php';
$wgAutoloadClasses['BookInformationIsbnDb'] = dirname( __FILE__ ) . '/drivers/IsbnDb.php';

$wgExtensionFunctions[] = 'efBookInformationSetup';
$wgHooks['BookInformation'][] = 'efBookInformation';
$wgHooks['SkinTemplateSetupPageCss'][] = 'efBookInformationCss';

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
* Extension setup function
*/
function efBookInformationSetup() {
	wfLoadExtensionMessages( 'BookInformation' );
}

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
function efBookInformationCss( &$css ) {
	global $wgTitle;
	if( $wgTitle->isSpecial( 'Booksources' ) ) {
		$file = dirname( __FILE__ ) . '/BookInformation.css';
		$css .= "/*<![CDATA[*/\n" . htmlspecialchars( file_get_contents( $file ) ) . "\n/*]]>*/";
	}
	return true;
}
