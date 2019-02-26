<?php
// Mirrors logic
if ( !empty( $_SERVER['HTTP_FASTLY_FF'] ) && !empty($_SERVER[ 'HTTP_X_STAGING' ]) ) {
	if ( $_SERVER[ 'HTTP_X_STAGING' ] == 'externaltest' ) {
		// externaltest is a mirror to our production communities where AdOperations test ads campaigns
		include "$IP/../config/externaltest.php";
	}

	if ( $_SERVER[ 'HTTP_X_STAGING' ] == 'showcase' ) {
	// ADEN-8318 - find a way to distinguish externaltest.* from showcase.*
		// showcase is a mirror to our production communities where AdOperations target demo ads campaigns and Sales demonstate it to our clients
		include "$IP/../config/showcase.php";
	}
}
