<?php

class GametrailersApiWrapper extends NullApiWrapper {
	// inherit all functions from parent

	public static function isHostnameFromProvider( $hostname ) {
		return strpos($hostname, "GAMETRAILERS") !== false ? true : false;
	}

	public static function newFromUrl( $url ) {
		$parsed = explode( "/", $url );
		if( is_array( $parsed ) ) {
			$id = explode("?",array_pop( $parsed ));
			return static( $id );
		}
		return null;
	}

}