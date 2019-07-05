<?php

namespace Wikia\CircuitBreaker;

use GuzzleHttp;
use Wikia\Logger\Loggable;
use Wikia\Util\Statistics\BernoulliTrial;

class ExternalCircuitBreaker implements CircuitBreaker {
	use Loggable;

	/** @var BernoulliTrial */
	private $logSampler;

	const CIRCUIT_BREAKER_SERVICE_URL = 'http://localhost:8080';

	/** @var GuzzleHttp\Client  */
	private $apiClient;

	/**
	 * ExternalCircuitBreaker constructor.
	 * @param BernoulliTrial $logSampler
	 */
	public function __construct( BernoulliTrial $logSampler) {
		$this->logSampler = $logSampler;
		$circuitBreakerUrl = $_ENV['CIRCUIT_BREAKER_SERVICE_URL'] || self::CIRCUIT_BREAKER_SERVICE_URL;
		$this->apiClient = new GuzzleHttp\Client( [ 'base_uri' => $circuitBreakerUrl ] );
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

		if ( !$allowed['Allowed'] && $this->logSampler->shouldSample() ) {
		   $this->warning("[circuit breaker] open", [ 'service_name' => $name, ]);
		}

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
