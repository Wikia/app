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

$wgMobileApiModules;
$dir = dirname( __FILE__ ) . '/';

//modules
global $wgMobileApiModules;
$wgMobileApiModules = array(
	'MobileApiRecommendedContent' => "{$dir}/modules/MobileApiRecommendedContent.class.php"
);

// i18n
$wgExtensionMessagesFiles['MobileApp'] = $dir . '/MobileApi.i18n.php';

//ajax exports
global $wgAjaxExportList;
$wgAjaxExportList['MobileApi'] = 'mobileApiMain';

function mobileApiMain( WebRequest $request = null ) {
	global $wgMobileApiModules, $wgAutoloadClasses;
	wfProfileIn( __METHOD__ );
	
	if ( empty( $request ) ) {
		global $wgRequest;
		$request = $wgRequest;
	}
	
	$moduleName = $request->getVal( 'module' );
	$actionName = $request->getVal( 'action' );
	$out = null;
	$module = null;
	
	if( in_array( $moduleName, $wgMobileApiModules ) ) {
		
		$wgAutoloadClasses[ $moduleName ] = $wgMobileApiModules[ $moduleName ];
		
		if( method_exists( $moduleName, $actionName ) ) {
			$module = new $moduleName();
			$out = $module->$actionName($request);
		}
	}
	
	if( empty( $module ) ) {
		$request->response()->header( 'HTTP/1.1 404 Not Found' );
	}
	
	wfProfileOut(__METHOD__);
	return $out;
}
