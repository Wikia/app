<?php
// This is from google translate, just return early.
if ( $_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
	header ( "HTTP/1.1 200", true, 200);
	return;
}

// Initialise common MW code
require ( dirname( __FILE__ ) . '/includes/WebStart.php' );

// Construct a tag for newrelic -- wgRequest is global in this scope
if( function_exists( 'newrelic_name_transaction' ) ) {
	if (is_object($wgRequest)) {
		$controller = $wgRequest->getVal( 'controller' );
		$method = $wgRequest->getVal( 'method' );
		newrelic_name_transaction( "$controller/$method" );
	}
}

if ( !empty( $wgEnableNirvanaAPI ) ){
	$app = F::app();
	
	// Ensure that we have a title stub, otherwise parser does not work BugId: 12901
	$app->wg->title = Wikia::createTitleFromRequest( $app->wg->Request );
	
	// initialize skin if requested
	$app->initSkin( (bool) $app->wg->Request->getVal( "skin", false ) );
	
	$response = $app->sendRequest( null, null, null, false );
	
	// commit any open transactions just in case the controller forgot to
	$app->commit();

	//if cache policy wasn't explicitly set (e.g. WikiaResponse::setCacheValidity)
	//then force no cache to reflect api.php default behavior
	$cacheControl = $response->getHeader( 'Cache-Control' );

	if ( empty( $cacheControl ) ) {
		$response->setHeader( 'Cache-Control', 'private', true );
	}

	$response->sendHeaders();
	$response->render();
} else {
	header( "HTTP/1.1 503 Service Unavailable", true, 503 );
}