<?php

/**
 * Class CrossOriginResourceSharingHeaderHelper
 *
 * used to add CORS header to controllers that use this
 *
 * Use with caution.
 */
class CrossOriginResourceSharingHeaderHelper {
	const ALLOW_ORIGIN_HEADER_NAME = 'Access-Control-Allow-Origin';
	const HEADER_DELIMETER = ',';

	protected $allowOriginValues = [];

	public function setAllowOrigin( Array $values ) {
		$this->allowOriginValues = $values;
	}

	/**
	 * This method sets all configured CORS related headers
	 *
	 * @param WikiaResponse $response response object to set headers to
	 * @param bool $mergeExisting
	 */
	public function setHeaders( WikiaResponse $response, $mergeExisting = true ) {
		if ( !empty( $this->allowOriginValues ) ) {
			$valuesToSet = $this->allowOriginValues;
			$headers = $response->getHeader( self::ALLOW_ORIGIN_HEADER_NAME );

			if ( !empty( $headers ) && $mergeExisting ) {
				$response->removeHeader( self::ALLOW_ORIGIN_HEADER_NAME );
				foreach ( $headers as $header ) {
					$valuesToSet = array_merge( $valuesToSet, explode( self::HEADER_DELIMETER, $header['value'] ) );
				}
			}
			$response->setHeader( self::ALLOW_ORIGIN_HEADER_NAME, implode( self::HEADER_DELIMETER, $valuesToSet ) );
		}
	}

	public function readConfig() {
		global $wgCORSAllowOrigin;
		if ( !empty( $wgCORSAllowOrigin ) and is_array( $wgCORSAllowOrigin ) ) {
			$this->allowOriginValues = $wgCORSAllowOrigin;
		}
	}
}
