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
	const HEADER_DELIMETER = ',';

	protected $allowOriginValues = null;

	public function setAllowOrigin( $values ) {
		$this->allowOriginValue = $values;
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
			$headers = $response->getHeader( self::HEADER_NAME );
			if ( !empty( $headers ) ) {

				if ( $mergeExisting ) {
					$response->removeHeader( self::HEADER_NAME );
					$valuesToSet = [ ];
					foreach ( $headers as $header ) {
						$valuesToSet [] = explode( self::HEADER_DELIMETER, $header['value'] );

					}
				}
			}
			$response->setHeader( self::HEADER_NAME, implode( self::HEADER_DELIMETER, $valuesToSet ) );
		}
	}

	public function readConfig() {
		global $wgCORSAllowOrigin;
		if ( !empty( $wgCORSAllowOrigin ) and is_array( $wgCORSAllowOrigin ) ) {
			$this->allowOriginValues = $wgCORSAllowOrigin;
		}
	}
}
