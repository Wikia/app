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

	const PROD_ORIGINS = ['.wikia.com'];
	const DEV_ORIGINS = ['.wikia-dev.us', '.wikia-dev.pl'];

	protected $allowValues = [];
	protected $whitelistOrigins = [];
	protected $allowAllOrigins = false;

	public function setAllowAllOrigins() {
		$this->allowAllOrigins = true;

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
		$this->allowValues[self::ALLOW_CREDENTIALS_HEADER_NAME] = (boolean) $value ? 'true' : 'false';

		return $this;
	}

	/**
	 * This method sets all configured CORS related headers
	 *
	 * @param WikiaResponse $response response object to set headers to
	 * @param bool $mergeExisting
	 * @return $this
	 */
	public function setHeaders( WikiaResponse $response, $mergeExisting = true ) {
		foreach ( $this->allowValues as $headerName => $values ) {
			if ( !empty( $values ) ) {
				$valuesToSet = $values;
				$headers = $response->getHeader( $headerName );

				if ( !empty( $headers ) && $mergeExisting ) {
					$response->removeHeader( $headerName );

					foreach ( $headers as $header ) {
						$valuesToSet = $this->mergeValues( $valuesToSet, $header['value'] );
					}
				}

				$this->setResponseHeader( $response, $headerName, $valuesToSet );
			}
		}

		$this->setOriginHeader( $response );

		return $this;
	}

	private function setOriginHeader( WikiaResponse $response ) {
		if ( $this->allowAllOrigins ) {
			$this->setResponseHeader( $response, self::ALLOW_ORIGIN_HEADER_NAME, '*' );
		} else if ( count( $this->whitelistOrigins ) > 0 && isset( $_SERVER['HTTP_ORIGIN'] ) ) {
			$requestOrigin = $_SERVER['HTTP_ORIGIN'];

			foreach ( $this->whitelistOrigins as $origin ) {
				if ( preg_match( '/' . $origin . '$/', $requestOrigin ) ) {
					$this->setResponseHeader( $response, self::ALLOW_ORIGIN_HEADER_NAME, $requestOrigin );
					break;
				}
			}
		}
	}

	private function mergeValues( $mergeTo, $headerValue ) {
		if ( is_array( $mergeTo ) && strpos( $headerValue, self::HEADER_DELIMETER ) !== false ) {
			return array_merge( $mergeTo, explode( self::HEADER_DELIMETER, $headerValue ) );
		}

		return $mergeTo;
	}

	private function setResponseHeader( WikiaResponse $response, $headerName, $values ) {
		if ( is_array( $values ) ) {
			$response->setHeader( $headerName, implode( self::HEADER_DELIMETER, $values ) );
		} else {
			$response->setHeader( $headerName, $values );
		}
	}

	public function allowWhitelistedOrigins( Array $additionalOrigins = [] ) {
		global $wgWikiaEnvironment, $wgCORSAllowOrigin;

		switch ( $wgWikiaEnvironment ) {
			case WIKIA_ENV_DEV:
				$this->whitelistOrigins = self::DEV_ORIGINS;
				break;
			default:
				$this->whitelistOrigins = self::PROD_ORIGINS;
				break;
		}

		if ( !empty( $wgCORSAllowOrigin ) && is_array( $wgCORSAllowOrigin ) ) {
			foreach ( $wgCORSAllowOrigin as $origin ) {
				$this->whitelistOrigins[] = $origin;
			}
		}

		foreach ( $additionalOrigins as $origin ) {
			$this->whitelistOrigins[] = $origin;
		}

		return $this;
	}
}
