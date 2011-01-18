<?php
/**
 * EzAPI (formerly MobileAPI)
 *
 * A KISS system for implementing AJAX API methods
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
	echo "This is a MediaWiki extension named EzAPI.\n";
	exit ( 1 );
}

$wgExtensionCredits['specialpage'][] = array(
	'name' => 'EzAPI',
	'version' => '1.0',
	'author' => array(
		'Federico "Lox" Lucignano'
	),
	'descriptionmsg' => 'ezapi-desc'
);

$dir = dirname( __FILE__ ) . '/';

//classes
$wgAutoloadClasses[ 'EzApiModuleBase' ] = "{$dir}EzApiModuleBase.class.php";
$wgAutoloadClasses[ 'EzApiException' ] = "{$dir}exceptions/EzApiException.class.php";
$wgAutoloadClasses[ 'EzApiNotImplementedException' ] = "{$dir}exceptions/EzApiNotImplementedException.class.php";
$wgAutoloadClasses[ 'EzApiRequestNotPostedException' ] = "{$dir}exceptions/EzApiRequestNotPostedException.class.php";
$wgAutoloadClasses[ 'EzApiContentTypes' ] = "{$dir}enums/EzApiContentTypes.class.php";
$wgAutoloadClasses[ 'EzApiCharsets' ] = "{$dir}enums/EzApiCharsets.class.php";
$wgAutoloadClasses[ 'EzApiStatusCodes' ] = "{$dir}enums/EzApiStatusCodes.class.php";

// i18n
$wgExtensionMessagesFiles[ 'EzAPI' ] = "{$dir}EzAPI.i18n.php";

//ajax exports
global $wgAjaxExportList;
$wgAjaxExportList[] = 'EzAPI';

//functions

function EzApiSendErrorHeader( Exception $e ){
	header( "EzApiError: {$e->getMessage()} in {$e->getFile()} at line {$e->getLine()}" );
}

/**
 * The EzAPI entry point
 * 
 * @author Federico "Lox" Lucignano
 */
function EzAPI() {
	global $wgEzApiModules, $wgAutoloadClasses, $wgRequest;
	wfProfileIn( __METHOD__ );
	$out = new AjaxResponse();
	$module = null;
	
	wfLoadExtensionMessages( 'EzAPI' );
	
	try {
		$moduleName = $wgRequest->getText( 'module' );
		$methodName = $wgRequest->getText( 'method' );
		
		if( !empty( $moduleName ) && !empty( $methodName ) && !empty( $wgEzApiModules[ $moduleName ] ) ) {
			$wgAutoloadClasses[ $moduleName ] = $wgEzApiModules[ $moduleName ];

			if( method_exists( $moduleName, $methodName ) ) {
				$module = new $moduleName( $wgRequest );
				$module->$methodName();
				$out->addText( $module->getResponseContent() );
				$out->setContentType( $module->getResponseContentType() );
				$out->setResponseCode( $module->getResponseStatusCode() );
			}
		}
		
		if( empty( $module ) ) {
			throw new EzApiNotImplementedException();
		}
	} catch ( EzApiException $e ) {
		EzApiSendErrorHeader( $e );
		$out->setResponseCode( $e->getStatusCode() );
	} catch( Exception $e ) {
		$exception = new EzApiException( (string) $e );
		EzApiSendErrorHeader( $exception );
		$out->setResponseCode( $exception->getStatusCode() );
	}
	
	wfProfileOut(__METHOD__);
	return $out;
}
