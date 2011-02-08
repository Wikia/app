<?php
// Initialise common MW code
require ( dirname( __FILE__ ) . '/includes/WebStart.php' );

$response = WF::build( 'App' )->dispatch();

$response->sendHeaders();
$response->printText();
