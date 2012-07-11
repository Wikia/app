<?php

class SevenloadApiWrapper extends LegacyVideoApiWrapper {
	// inherit all functions from parent

	protected static $aspectRatio = 1.59235669;	// 500 x 314
	
	public static function isMatchingHostname( $hostname ) {
		return endsWith($hostname, "sevenload.com") ? true : false;
	}

	public static function newFromUrl( $url ) {

		wfProfileIn( __METHOD__ );

		$parsed = explode( "/", $url );
		$id = array_pop( $parsed );
		$parsed_id = explode( "-", $id );
		if( is_array( $parsed_id ) ) {
			wfProfileOut( __METHOD__ );
			return new static( $parsed_id[0] );
		}

		wfProfileOut( __METHOD__ );
		return null;
	}

}