<?php

/**
 * Class CrossOriginResourceSharingHeaderHelper
 *
 * used to add CORS header to controllers that use this
 *
 * Use with caution.
 */
class CrossOriginResourceSharingHeaderHelper {
	const HEADER_NAME = 'Access-Control-Allow-Origin';

	protected $configuredHeaderValue = null;

	static public function findExistingHeader( Array $headers ) {
		foreach ( $headers as $header ) {
			if ( preg_match( '/' . self::HEADER_NAME . '/i', $header ) ) {
				return $header; // exists
			}
		}
		return null; // not found
	}

	static public function extractHeaderValue( $header ) {
		$value = null;
		if ( !empty( $header ) ) {
			$parts = explode( ":", $header );
			if ( !empty( $parts[1] ) ) {
				$value = trim( $parts[1] );
			}
		}
		return $value;
	}

	public function setHeader() {
		if ( !empty( $this->configuredHeaderValue ) ) {
			$oldHeaderValue = "";
			$header = $this->findExistingHeader( headers_list() );
			if ( !empty( $header ) ) {
				$oldHeaderValue = $this->extractHeaderValue( $header );
			}
			$values = [ ];
			if ( !empty( $oldHeaderValue ) ) {
				$values [] = $oldHeaderValue;
			}
			$values [] = $this->configuredHeaderValue;

			$header = self::HEADER_NAME . ': ' . implode( ",", $values );
			header( $header );
		}
	}

	public function readConfig() {
		global $wgCORSFor3rdParties;
		if ( !empty( $wgCORSFor3rdParties ) and is_array( $wgCORSFor3rdParties ) ) {
			$this->configuredHeaderValue = implode( ',', $wgCORSFor3rdParties );
		}
	}
}
