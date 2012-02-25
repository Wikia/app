<?php

class SouthparkstudiosApiWrapper extends NullApiWrapper {
	// inherit all functions from parent

	public static function isMatchingHostname( $hostname ) {
		return endsWith($hostname, "southparkstudios.com" ) ? true : false;
	}

	public static function newFromUrl( $url ) {
		$parsed = explode( "/", $url );
		if( is_array( $parsed ) ) {
			$mdata = array_pop( $parsed );
			if ( ('' != $mdata ) && ( false === strpos( $mdata, "?" ) ) ) {
				$videoId = $mdata;
			} else {
				$videoId = array_pop( $parsed );
			}
			return new static( $videoId );
		}

		return null;
	}

}