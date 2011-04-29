<?php
// Initialise common MW code
require ( dirname( __FILE__ ) . '/includes/WebStart.php' );

$app = F::app();
$response = $app->getDispatcher()->dispatch( $app, null );

$response->sendHeaders();
$response->render();
