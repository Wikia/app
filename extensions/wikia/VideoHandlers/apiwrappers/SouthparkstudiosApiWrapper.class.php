<?php

class SouthparkstudiosApiWrapper extends LegacyVideoApiWrapper {
	// inherit all functions from parent
	protected static $aspectRatio = 1.22866894;	// 360 x 293

	public static function isMatchingHostname( $hostname ) {
		return endsWith($hostname, "southparkstudios.com" ) ? true : false;
	}

	public static function newFromUrl( $url ) {

		wfProfileIn( __METHOD__ );

		$parsed = explode( "/", $url );
		if( is_array( $parsed ) ) {
			$mdata = array_pop( $parsed );
			if ( ('' != $mdata ) && ( false === strpos( $mdata, "?" ) ) ) {
				$videoId = $mdata;
			} else {
				$videoId = array_pop( $parsed );
			}

			wfProfileOut( __METHOD__ );
			return new static( $videoId );
		}

		wfProfileOut( __METHOD__ );
		return null;
	}

}