<?php

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
