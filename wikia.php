<?php
// Initialise common MW code
require ( dirname( __FILE__ ) . '/includes/WebStart.php' );

if ( !empty( $wgEnableNirvanaAPI ) ){
	$app = F::app();
	
	// initialize skin if requested
	$app->initSkin( (bool) $app->wg->Request->getVal( "skin", false ) );
	
	$response = $app->sendRequest( null, null, null, false );
	
	// commit any open transactions just in case the controller forgot to
	$app->commit();
	
	$response->sendHeaders();
	$response->render();
} else {
	header( "HTTP/1.0 503 Service Unavailable", true, 503 );
}