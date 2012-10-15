<?php
/**
 * AjaxTest extension
 *
 * @file
 * @ingroup Extensions
 * @author Daniel Kinzler <duesentrieb@brightbyte.de>
 * @copyright © 2006 Daniel Kinzler
 * @license GNU General Public Licence 2.0 or later
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	echo( "This file is an extension to the MediaWiki software and cannot be used standalone.\n" );
	die( 1 );
}

/**
* Abort if AJAX is not enabled
**/
if ( !$wgUseAjax ) {
	# NOTE: GlobalFunctions is not yet loaded, so use standard API only.
	trigger_error( 'CategoryTree: $wgUseAjax is not enabled, aborting extension setup.', E_USER_WARNING );
	return;
}

/**
 * Register extension setup hook and credits
 */
$wgExtensionCredits['specialpage'][] = array(
	'path' => __FILE__,
	'name' => 'AjaxTest',
	'author' => 'Daniel Kinzler',
	'descriptionmsg' => 'ajaxtest-desc',
);

$wgSpecialPages['AjaxTest'] = 'AjaxTestPage';

$dir = dirname( __FILE__ ) . '/';
$wgExtensionMessagesFiles['AjaxTest'] = $dir . 'AjaxTest.i18n.php';
$wgExtensionMessagesFiles['AjaxTestAlias'] = $dir . 'AjaxTest.alias.php';
$wgAutoloadClasses['AjaxTestPage'] = $dir . 'AjaxTestPage.php';

/**
 * register Ajax function
 */
$wgAjaxExportList[] = 'efAjaxTest';

/**
 * Entry point for Ajax, registered in $wgAjaxExportList.
 * This loads CategoryTreeFunctions.php and calls CategoryTree::ajax()
 */
function efAjaxTest( $text, $usestring, $httpcache, $lastmod, $error ) {
	$text = htmlspecialchars( $text ) . "(" . wfTimestampNow() . ")";

	if ( $usestring ) return $text;
	else {
		$response = new AjaxResponse( $text );

		if ( $error ) throw new Exception( $text );

		if ( $httpcache ) $response->setCacheDuration( 24 * 60 * 60 ); # cache for a day

		if ( $lastmod ) {
			$response->checkLastModified( '19700101000001' ); # never modified
		}

		return $response;
	}
}
