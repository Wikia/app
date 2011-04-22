<?php
// Initialise common MW code
require ( dirname( __FILE__ ) . '/includes/WebStart.php' );

$response = F::build( 'App' )->dispatch();

$response->sendHeaders();
$response->render();
