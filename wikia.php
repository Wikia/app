<?php

// This is from google translate, just return early.
if ( $_SERVER['REQUEST_METHOD'] == 'OPTIONS' ) {
	header ( "HTTP/1.1 200", true, 200 );
	return;
}

// prevent $_GET['title'] from being overwritten on API calls (BAC-906)
define( 'DONT_INTERPOLATE_TITLE', true );

// Initialise common MW code
require ( dirname( __FILE__ ) . '/includes/WebStart.php' );

Profiler::instance()->setTemplated( true );

// Construct a tag for newrelic -- wgRequest is global in this scope
Transaction::setEntryPoint( Transaction::ENTRY_POINT_NIRVANA );
if ( is_object( $wgRequest ) ) {
	Transaction::setAttribute( Transaction::PARAM_CONTROLLER, $wgRequest->getVal( 'controller' ) );
	Transaction::setAttribute( Transaction::PARAM_METHOD, $wgRequest->getVal( 'method' ) );
}

if ( function_exists( 'newrelic_disable_autorum' ) ) {
	newrelic_disable_autorum();
}

if ( !empty( $wgEnableNirvanaAPI ) ) {
	// temporarily force ApiDocs extension regardless of config
	require_once $IP . "/extensions/wikia/ApiDocs/ApiDocs.setup.php";
	// same for JsonFormat
	require_once $IP . "/extensions/wikia/JsonFormat/JsonFormat.setup.php";
	Wikia\Logger\WikiaLogger::instance()->info( 'APP');

	$app = F::app();

	if ( empty( $wgRequest->getVal( 'controller' ) ) ) {
		header( "HTTP/1.1 400 Bad Request", true, 400 );
		return;
	}
	Wikia\Logger\WikiaLogger::instance()->info( 'title');

	// Ensure that we have a title stub, otherwise parser does not work BugId: 12901
	$app->wg->title = Wikia::createTitleFromRequest( $app->wg->Request );

	Wikia\Logger\WikiaLogger::instance()->info( 'purge');
	// support "mcache" URL parameter to ease debugging
	Wikia::setUpMemcachePurge( $app->wg->Request, $app->wg->User );

	Wikia\Logger\WikiaLogger::instance()->info( 'skin');
	// initialize skin if requested
	$app->initSkin( (bool) $app->wg->Request->getVal( "skin", false ) );

	try {

		Wikia\Logger\WikiaLogger::instance()->info( 'REQUEST');
		$response = $app->sendExternalRequest( null, null, null );

		Wikia\Logger\WikiaLogger::instance()->info( 'CacheControl');
		// if cache policy wasn't explicitly set (e.g. WikiaResponse::setCacheValidity)
		// then force no cache to reflect api.php default behavior
		$cacheControl = $response->getHeader( 'Cache-Control' );

		if ( empty( $cacheControl ) ) {
			$response->setHeader( 'Cache-Control', 'private', true );

			Wikia\Logger\WikiaLogger::instance()->info( 'wikia-php.caching-disabled', [
				'controller' => $response->getControllerName(),
				'method' => $response->getMethodName()
			] );
		}
		Wikia\Logger\WikiaLogger::instance()->info( 'Exception');

		// PLATFORM-1633: decrease the noise in reported transactions
		$ex = $response->getException();

		if ( $ex instanceof ControllerNotFoundException || $ex instanceof MethodNotFoundException ) {
			Transaction::setAttribute( Transaction::PARAM_CONTROLLER, 'notFound' );
			Transaction::setAttribute( Transaction::PARAM_METHOD, '' );

			Wikia\Logger\WikiaLogger::instance()->info( 'wikia-php.not-found', [
				'controller' => $response->getControllerName(),
				'method' => $response->getMethodName()
			] );
		}

		Wikia\Logger\WikiaLogger::instance()->info( 'Handle domain');
		wfHandleCrossSiteAJAXdomain(); // PLATFORM-1719

		Wikia\Logger\WikiaLogger::instance()->info( 'send header');
		$response->sendHeaders();
		Wikia\Logger\WikiaLogger::instance()->info( 'hook');
		Hooks::run( 'NirvanaAfterRespond', [ $app, $response ] );

		Wikia\Logger\WikiaLogger::instance()->info( 'render');
		$response->render();
	} catch ( WikiaHttpException $e ) {
		http_response_code( $e->getCode() );
		header('Content-Type: application/json; charset=utf-8');
		echo json_encode( [
			'status' => $e->getCode(),
			'error' => get_class( $e ),
			'details' => $e->getDetails()
		]);

		if ( $e->getCode() >= WikiaResponse::RESPONSE_CODE_INTERNAL_SERVER_ERROR ) {
			Wikia\Logger\WikiaLogger::instance()->error( 'Unhandled API error', [
				'status'=> $e->getCode(),
				'exception' => $e
			] );
		}
	} catch ( Exception $e ) {
		header( "HTTP/1.1 500 Internal Server Error", true, WikiaResponse::RESPONSE_CODE_INTERNAL_SERVER_ERROR );
		header('Content-Type: application/json; charset=utf-8');
		echo json_encode( [
			'status' => $e->getCode(),
			'error' => get_class( $e ),
			'message' => $e->getMessage()
		]);

		Wikia\Logger\WikiaLogger::instance()->error( 'Unhandled API error', [
			'status' => WikiaResponse::RESPONSE_CODE_INTERNAL_SERVER_ERROR,
			'exception' => $e
		] );
	}
	Wikia\Logger\WikiaLogger::instance()->info( 'Kill MW');
	// Execute common request shutdown procedure
	$mw = new MediaWiki();
	$mw->restInPeace();
	Wikia\Logger\WikiaLogger::instance()->info( 'Killed MW');
} else {
	header( "HTTP/1.1 503 Service Unavailable", true, 503 );
}
