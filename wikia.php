<?php

// This is from google translate, just return early.
if ( $_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
	header ( "HTTP/1.1 200", true, 200);
	return;
}

// Initialise common MW code
require ( dirname( __FILE__ ) . '/includes/WebStart.php' );

if ($wgProfiler instanceof Profiler) {
	$wgProfiler->setTemplated(true);
}

// Construct a tag for newrelic -- wgRequest is global in this scope
if( function_exists( 'newrelic_name_transaction' ) ) {
	if ( function_exists( 'newrelic_disable_autorum') ) {
		newrelic_disable_autorum();
	}
	newrelic_name_transaction('Nirvana');
	if ( function_exists( 'newrelic_add_custom_parameter' ) && is_object($wgRequest)) {
		newrelic_add_custom_parameter( 'controller', $wgRequest->getVal( 'controller' ) );
		newrelic_add_custom_parameter( 'method', $wgRequest->getVal( 'method' ) );
	}
}

if ( !empty( $wgEnableNirvanaAPI ) ){
	// temporarily force ApiDocs extension regardless of config
	require $IP."/extensions/wikia/ApiDocs/ApiDocs.setup.php";
	
	$app = F::app();

	// Ensure that we have a title stub, otherwise parser does not work BugId: 12901
	$app->wg->title = Wikia::createTitleFromRequest( $app->wg->Request );

	// support "mcache" URL parameter to ease debugging
	Wikia::setUpMemcachePurge( $app->wg->Request, $app->wg->User );

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

	wfLogProfilingData();

} else {
	header( "HTTP/1.1 503 Service Unavailable", true, 503 );
}
