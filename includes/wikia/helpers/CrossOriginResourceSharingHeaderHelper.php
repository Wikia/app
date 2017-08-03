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
	const ALLOW_METHOD_HEADER_NAME = 'Access-Control-Allow-Method';
	const ALLOW_CREDENTIALS_HEADER_NAME = 'Access-Control-Allow-Credentials';
	const HEADER_DELIMETER = ',';

	protected $allowValues = [];

	/**
	 * @param array $values example [ '*' ]
	 * @return $this
	 */
	public function setAllowOrigin( Array $values ) {
		$this->allowValues[self::ALLOW_ORIGIN_HEADER_NAME] = $values;

		return $this;
	}

	/**
	 * @param array $values example [ 'GET', 'POST' ]
	 * @return $this
	 */
	public function setAllowMethod( Array $values ) {
		$this->allowValues[self::ALLOW_METHOD_HEADER_NAME] = $values;

		return $this;
	}

	/**
	 * @param boolean $value
	 * @return $this
	 */
	public function setAllowCredentials( $value ) {
		$this->allowValues[self::ALLOW_CREDENTIALS_HEADER_NAME] = (boolean)$value ? 'true' : 'false';

		return $this;
	}

	/**
	 * This method sets all configured CORS related headers
	 *
	 * @param WikiaResponse $response response object to set headers to
	 * @param bool $mergeExisting
	 */
	public function setHeaders( WikiaResponse $response, $mergeExisting = true ) {
		foreach( $this->allowValues as $headerName => $values ) {
			if ( !empty( $values ) ) {
				$valuesToSet = $values;
				$headers = $response->getHeader( $headerName );

				if ( !empty( $headers ) && $mergeExisting ) {
					$response->removeHeader( $headerName );

					foreach ( $headers as $header ) {
						if ( strpos( $header['value'], self::HEADER_DELIMETER ) !== false ) {
							$valuesToSet = array_merge( $valuesToSet, explode( self::HEADER_DELIMETER, $header['value'] ) );
						}
					}
				}

				if ( is_array( $valuesToSet ) ) {
					$response->setHeader( $headerName, implode( self::HEADER_DELIMETER, $valuesToSet ) );
				} else {
					$response->setHeader( $headerName, $valuesToSet );
				}
			}
		}

		return $this;
	}

	/**
	 * @return $this
	 */
	public function readConfig() {
		global $wgCORSAllowOrigin;

		if ( !empty( $wgCORSAllowOrigin ) and is_array( $wgCORSAllowOrigin ) ) {
			$this->allowValues[self::ALLOW_ORIGIN_HEADER_NAME] = $wgCORSAllowOrigin;
		}

		return $this;
	}
}
