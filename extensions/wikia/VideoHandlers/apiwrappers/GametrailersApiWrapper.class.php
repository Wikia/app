<?php

class GametrailersApiWrapper extends NullApiWrapper {
	// inherit all functions from parent

	public static function isMatchingHostname( $hostname ) {
		return strpos($hostname, "gametrailers") !== false ? true : false;
	}

	public static function newFromUrl( $url ) {
		$parsed = explode( "/", $url );
		if( is_array( $parsed ) ) {
			$id = explode("?",array_pop( $parsed ));
			return new static( $id );
		}
		return null;
	}

}