<?php
/**
 * User: artur
 * Date: 16.04.13
 * Time: 10:31
 */

class GWTLocalCache {
	private $map = array();

	function get( $key ) {
		if ( isset ($map[$key]) ) return $map[$key];
		return false;
	}

	function set( $key, $value ) {
		$map[$key] = $value;
	}

}
