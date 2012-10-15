<?php

class GametrailersApiWrapper extends LegacyVideoApiWrapper {
	// inherit all functions from parent
	protected static $aspectRatio = 1.77777778;	// 512 x 288

	public static function isMatchingHostname( $hostname ) {
		return strpos($hostname, "gametrailers") !== false ? true : false;
	}

	public static function newFromUrl( $url ) {
		wfProfileIn( __METHOD__ );
		$parsed = explode( "/", $url );
		if( is_array( $parsed ) ) {
			$id = explode("?",array_pop( $parsed ));
			wfProfileOut( __METHOD__ );
			return new static( $id );
		}
		wfProfileOut( __METHOD__ );
		return null;
	}

}