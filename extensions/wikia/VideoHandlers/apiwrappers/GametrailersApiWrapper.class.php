<?php

class GametrailersApiWrapper extends NullApiWrapper {
	// inherit all functions from parent
	protected static $aspectRatio = 1.77777778;	// 512 x 288

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