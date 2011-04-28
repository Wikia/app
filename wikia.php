<?php
// Initialise common MW code
require ( dirname( __FILE__ ) . '/includes/WebStart.php' );

$response = F::app()->dispatch( null, null, null, false );

$response->sendHeaders();
$response->render();
