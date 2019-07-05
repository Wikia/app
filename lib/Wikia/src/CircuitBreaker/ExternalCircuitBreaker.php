<?php

namespace Wikia\CircuitBreaker;

use GuzzleHttp;

class ExternalCircuitBreaker implements CircuitBreaker {
	const CIRCUIT_BREAKER_SERVICE_URL = 'http://localhost:8080';

	/** @var GuzzleHttp\Client  */
	private $apiClient;

	/**
	 * ExternalCircuitBreaker constructor.
	 */
	public function __construct() {
		$this->apiClient = new GuzzleHttp\Client( [ 'base_uri' => self::CIRCUIT_BREAKER_SERVICE_URL ] );
	}

	/**
	 * @param string $name
	 * @return bool
	 */
	public function OperationAllowed( string $name ) {
		$resp = $this->apiClient->get('/allowed', ['query' => ['name' => $name ]] );
		if ( $resp->getStatusCode() != 200 ) {
			return false;
		}

		$allowed = GuzzleHttp\json_decode($resp->getBody());
		return $allowed['Allowed'];
	}

	/**
	 * @param string $name
	 * @param bool $status
	 * @return bool
	 */
	public function SetOperationStatus( string $name, bool $status ) {
		$resp = $this->apiClient->post( '/update', ['query' => [ 'name' => $name, 'success' => $status ]]);
		return $resp->getStatusCode() == 204;
	}
}
