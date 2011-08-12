<?php


/**
 * @author Pawe³ Rych³y
 *	Script finds last updated cases and save it to memcached
 */


if( file_exists('../../../../maintenance/commandLine.inc') ) {
	require_once ( '../../../../maintenance/commandLine.inc' );
} else {
	require_once ('/usr/wikia/source/trunk/maintenance/commandLine.inc');
}

global $wgRequest, $wgHTTPProxy, $wgFogbugzAPIConfig;

$command = $wgRequest->getText('cmd');
$myFBService = new FogbugzService( $wgFogbugzAPIConfig['apiUrl'], $wgFogbugzAPIConfig['username'],
	$wgFogbugzAPIConfig['password'], $wgHTTPProxy
);


$myFBService->logon()->findAndSaveCasesToMemc("lastupdated:\"Today\"");
$myFBService->logoff();


?>