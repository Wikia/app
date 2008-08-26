<?php
/**
 * A Special Page extension that displays Wiki Google Webtools stats.
 * This page can be accessed from Special:Datalag
 * @addtogroup Extensions
 *
 * @author Andrew Yasinsky <andrewy@wikia.com>
 */

if (!defined('MEDIAWIKI')) {
        echo <<<EOT
To install this extension, put the following line in LocalSettings.php:
require_once( "$IP/extensions/wikia/Datalag/Datalag.php" );
EOT;
        exit( 1 );
}

$wgAjaxExportList[] = 'datalagAjax';
$wgAjaxExportList[] = 'datalagsAjax';


function datalagAjax() {
  global $wgLoadBalancer;
  $lag = 0;
  $host = 'none';
 
 if( !empty( $wgLoadBalancer->mServers ) ){
 	
  
  if( count( $wgLoadBalancer->mServers) > 1){  	

  list( $host, $lag ) = $wgLoadBalancer->getMaxLag();
    $name = gethostbyaddr( $host );
	
	if ( $name !== false ) {
		$host = $name;
	}
   
  }
 }	
	$response = array('maxlag_host'=>$host, 'maxlag_sec'=>$lag);
	return new AjaxResponse( Wikia::json_encode( $response ) );
}

function datalagsAjax() {
  global $wgLoadBalancer;
  $res = 'none';
 
 if( !empty( $wgLoadBalancer->mServers ) ){
  if( count( $wgLoadBalancer->mServers) > 1){  	
	$res = $wgLoadBalancer->getLagTimes();
  }
 }	
	$response = array('lagdata'=>$res);
	return new AjaxResponse( Wikia::json_encode( $response ) );
}
