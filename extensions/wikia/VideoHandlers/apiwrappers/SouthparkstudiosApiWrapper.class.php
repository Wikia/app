<?php

class SouthparkstudiosApiWrapper extends NullApiWrapper {
	// inherit all functions from parent

	public static function isHostnameFromProvider( $hostname ) {
		return endsWith($hostname, "SOUTHPARKSTUDIOS.COM" ) ? true : false;
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
			return static( $videoId );
		}

		return null;
	}

}