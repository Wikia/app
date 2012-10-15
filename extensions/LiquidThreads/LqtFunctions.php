<?php
if ( !defined( 'MEDIAWIKI' ) )
	die();

/*
* Get a value from a global array if it exists, otherwise use $default
*/
function efArrayDefault( $name, $key, $default ) {
	global $$name;
	if ( isset( $$name ) && is_array( $$name ) && array_key_exists( $key, $$name ) ) {
		$foo = $$name;
		return $foo[$key];
	} else {
		return $default;
	}
}
