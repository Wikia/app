<?php

namespace Wikia\CircuitBreaker;

class ExternalCircuitBreaker extends CircuitBreaker {

	const ALLOWED_ENDPOINT = 'http://localhost:8080/allowed?name=%s';
	const UPDATE_ENDPOINT = 'http://localhost:8080/update';
	const CONNECT_TIMEOUT_MS = 20;
	const TIMEOUT_MS = 50;
	protected $uniqueName;

	public function __construct( $uniqueName ) {
		parent::__construct();
		$this->uniqueName = $uniqueName;
	}

	/**
	 * make an http request
	 *
	 * returns false in case of an http error
	 * true or json is returned in case of a success
	 */
	protected function call( $method, $url, $params, $returnJson = false ) {
		$curlHandle = curl_init();

		curl_setopt( $curlHandle, CURLOPT_URL, $url );
		curl_setopt( $curlHandle, CURLOPT_CONNECTTIMEOUT_MS, self::CONNECT_TIMEOUT_MS );
		curl_setopt( $curlHandle, CURLOPT_TIMEOUT_MS, self::TIMEOUT_MS );

		curl_setopt( $curlHandle, CURLOPT_RETURNTRANSFER, true );

		curl_setopt( $curlHandle, CURLOPT_HEADER  , true);  // we want headers


		if ( $method === 'POST ') {
			curl_setopt( $curlHandle, CURLOPT_POST, 1 );
			if ( !$params ) {
				curl_setopt( $curlHandle, CURLOPT_POSTFIELDS,
					http_build_query( $params ));
			}
		}

		$response = @curl_exec( $curlHandle );

		if ( false === $response ) {
			curl_close( $curlHandle );
			// log connection errors
			return false;
		}

		$httpcode = curl_getinfo($curlHandle, CURLINFO_HTTP_CODE);
		curl_close( $curlHandle );

		if ( $httpcode < 200 || $httpcode >= 300 ) {
			// unexpected cb status code - should be logged
			return false;
		}

		if ( !$returnJson ) {
			return true;
		}
		return json_encode( $response );
	}

	public function isAvailable() {
		$url = sprintf( self::ALLOWED_ENDPOINT, urlencode( $this->uniqueName) );
		$resp = $this->call( 'GET', $url, [], true );
		if ( !$resp ) {
			// error while getting the state of the cb
			// proceed with the request
			// @todo: log the error
			return true;
		}
		return $resp['allowed'];
	}

	public function success() {
		$this->call( 'POST', self::UPDATE_ENDPOINT, [
			'name' => $this->uniqueName,
			'success' => true
		]);
		// @todo - report an error if updating cb state failed
	}

	public function failure() {
		$this->call( 'POST', self::UPDATE_ENDPOINT, [
			'name' => $this->uniqueName,
			'success' => false
		]);
		// @todo - report an error if updating cb state failed
	}

}
