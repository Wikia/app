<?php

class SevenloadApiWrapper extends NullApiWrapper {
	// inherit all functions from parent

	public static function isMatchingHostname( $hostname ) {
		return endsWith($hostname, "sevenload.com") ? true : false;
	}

	public static function newFromUrl( $url ) {
		$parsed = explode( "/", $url );
		$id = array_pop( $parsed );
		$parsed_id = explode( "-", $id );
		if( is_array( $parsed_id ) ) {
			return new static( $parsed_id[0] );
		}

		return null;
	}

}