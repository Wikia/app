<?php
/**
 * MobileApi
 *
 *A set of experimental APIs for Wikia mobile app
 *
 * @file
 * @ingroup Extensions
 * @author Federico "Lox" Lucignano <federico@wikia-inc.com>
 * @date 2010-11-15
 * @version 1.0
 * @copyright Copyright © 2010 Federico "Lox" Lucignano, Wikia Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	echo "This is a MediaWiki extension named MobileApp.\n";
	exit ( 1 );
}

$wgExtensionCredits['specialpage'][] = array(
	'name' => 'MobileApi',
	'version' => '1.0',
	'author' => array(
		'Federico "Lox" Lucignano'
	),
	'descriptionmsg' => 'mobileapi-desc'
);

$dir = dirname( __FILE__ ) . '/';

//classes
$wgAutoloadClasses[ 'MobileApiBase' ] = "{$dir}MobileApiBase.class.php";
$wgAutoloadClasses[ 'MobileApiException' ] = "{$dir}MobileApiException.class.php";


//modules
global $wgMobileApiModules;//TODO: add to DefaultSettings.php in includes/wikia

$wgMobileApiModules = array(
	'MobileApiRecommendedContent' => "{$dir}modules/MobileApiRecommendedContent.class.php",
	'MobileApiSearch' => "{$dir}modules/MobileApiSearch.class.php"
);

// i18n
$wgExtensionMessagesFiles['MobileApp'] = "{$dir}MobileApi.i18n.php";

//ajax exports
global $wgAjaxExportList;
$wgAjaxExportList[] = 'MobileApi';

function MobileApi() {
	global $wgMobileApiModules, $wgAutoloadClasses, $wgRequest;
	wfProfileIn( __METHOD__ );
	$out = new AjaxResponse();
	$module = null;
	$err = null;
	
	try {
		$moduleName = $wgRequest->getVal( 'module' );
		$methodName = $wgRequest->getVal( 'method' );
		

		if( !empty( $wgMobileApiModules[ $moduleName ] ) ) {

			$wgAutoloadClasses[ $moduleName ] = $wgMobileApiModules[ $moduleName ];

			if( method_exists( $moduleName, $methodName ) ) {
				$module = new $moduleName( $wgRequest );
				
				if( $module->$methodName() !== false ){
					$out->addText( $module->getResponseContent() );
					$out->setContentType( $module->getResponseContentType() );
					$out->setResponseCode( $module->getResponseStatusCode() );
				} else {
					$err = "{$module}::{$methodName} returned false, aborting";
				}
			}
		}
	} catch ( MobileApiException $e ) {
		$out->addText( (string) $e );
		$out->setResponseCode( $e->getStatusCode() );
	} catch( Exception $e ) {
		$out->addText( (string) $e );
		$out->setResponseCode( '501 Not Implemented' );//500 gets redirected to Iowa, avoid unnecessary overhead
	}
	
	if( empty( $module ) ) {
		$out->addText( 'Not found' );
		$out->setResponseCode('404 Not Found');
	}
	
	wfProfileOut(__METHOD__);
	return $out;
}
