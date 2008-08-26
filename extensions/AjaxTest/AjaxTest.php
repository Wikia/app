<?php

/**
 * AjaxTest extension
 *
 * @addtogroup Extensions
 * @author Daniel Kinzler <duesentrieb@brightbyte.de>
 * @copyright © 2006 Daniel Kinzler
 * @licence GNU General Public Licence 2.0 or later
 */
 
if( !defined( 'MEDIAWIKI' ) ) {
	echo( "This file is an extension to the MediaWiki software and cannot be used standalone.\n" );
	die( 1 );
}

/**
* Abort if AJAX is not enabled
**/
if ( !$wgUseAjax ) {
	#NOTE: GlobalFunctions is not yet loaded, so use standard API only.
	trigger_error( 'CategoryTree: $wgUseAjax is not enabled, aborting extension setup.', E_USER_WARNING );
	return;
}

/**
 * Register extension setup hook and credits
 */
$wgExtensionFunctions[] = 'efAjaxTestSetup';
$wgSpecialPages['AjaxTest'] = 'AjaxTestPage';
$wgAutoloadClasses['AjaxTestPage'] = dirname( __FILE__ ) . '/AjaxTestPage.php';

/**
 * register Ajax function
 */
$wgAjaxExportList[] = 'efAjaxTest';

/**
 * Hook it up
 */
function efAjaxTestSetup() {
	global $wgParser, $wgCategoryTreeAllowTag;
}

/**
 * Entry point for Ajax, registered in $wgAjaxExportList.
 * This loads CategoryTreeFunctions.php and calls CategoryTree::ajax()
 */
function efAjaxTest( $text, $usestring, $httpcache, $lastmod, $error ) {
	$text = htmlspecialchars($text) . "(".wfTimestampNow().")";
	
	if ($usestring) return $text;
	else {
		$response= new AjaxResponse($text);
		
		if ($error) throw new Exception( $text );
		
		if ($httpcache) $response->setCacheDuration( 24*60*60 ); #cache for a day
		
		if ($lastmod) {
			$response->checkLastModified( '19700101000001' ); #never modified
		}
	
		return $response;
	}
}


