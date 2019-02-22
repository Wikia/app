<?php
// Mirrors logic
if ( !empty( $_SERVER['HTTP_FASTLY_FF'] ) && !empty($_SERVER[ 'X-Staging' ]) ) {
	if ( $_SERVER[ 'X-Staging' ] == 'externaltest' ) {
		// externaltest is a mirror to our production communities where AdOperations test ads campaigns
		include "$IP/../config/externaltest.php";
	}

	if ( $_SERVER[ 'X-Staging' ] == 'showcase' ) {
		// showcase is a mirror to our production communities where AdOperations target demo ads campaigns and Sales demonstate it to our clients
		include "$IP/../config/showcase.php";
	}
}
