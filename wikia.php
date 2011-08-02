<?php
// Initialise common MW code
require ( dirname( __FILE__ ) . '/includes/WebStart.php' );

$app = F::app();

// initialize skin if requested
$app->initSkin( (bool) $app->wg->Request->getVal( "skin", false ) );

$response = $app->sendRequest( null, null, null, false );

// commit any open transactions just in case the controller forgot to
if ($app->wg->Request->wasPosted()) {
	$factory = wfGetLBFactory();
	$factory->commitMasterChanges();  // commits only if writes were done on connection
}

$response->sendHeaders();
$response->render();
