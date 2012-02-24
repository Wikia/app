<?php

class SevenloadApiWrapper extends NullApiWrapper {
	// inherit all functions from parent

	public static function isHostnameFromProvider( $hostname ) {
		return endsWith($hostname, "SEVENLOAD.COM") ? true : false;
	}

	public static function newFromUrl( $url ) {
		$parsed = explode( "/", $url );
		$id = array_pop( $parsed );
		$parsed_id = explode( "-", $id );
		if( is_array( $parsed_id ) ) {
			return static( $parsed_id[0] );
		}

		return null;
	}

}